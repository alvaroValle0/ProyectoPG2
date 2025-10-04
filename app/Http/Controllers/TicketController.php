<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\TicketHistory;
use App\Models\Reparacion;
use App\Helpers\DatabaseHelper;
use App\Models\Cliente;
use App\Models\Equipo;
use App\Models\Tecnico;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Ticket::with(['reparacion.equipo.cliente', 'reparacion.tecnico']);

        // Filtro por estado
        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        // Filtro por tipo de ticket
        if ($request->filled('tipo')) {
            $query->where('tipo_ticket', $request->tipo);
        }

        // Filtro por fecha
        if ($request->filled('fecha_inicio')) {
            $query->whereDate('fecha_generacion', '>=', $request->fecha_inicio);
        }
        if ($request->filled('fecha_fin')) {
            $query->whereDate('fecha_generacion', '<=', $request->fecha_fin);
        }

        // Búsqueda rápida
        if ($request->filled('buscar')) {
            $termino = $request->buscar;
            $query->where(function($q) use ($termino) {
                $q->where('numero_ticket', 'like', "%{$termino}%")
                  ->orWhereHas('reparacion.equipo.cliente', function($sq) use ($termino) {
                      $sq->where('nombres', 'like', "%{$termino}%")
                         ->orWhere('apellidos', 'like', "%{$termino}%");
                  });
            });
        }

        $tickets = $query->with(['reparacion.equipo.cliente', 'reparacion.tecnico.user'])
                         ->orderBy('fecha_generacion', 'desc')
                         ->paginate(15);

        // Estadísticas
        $estadisticas = [
            'total_tickets' => Ticket::count(),
            'tickets_generados' => Ticket::where('estado', 'generado')->count(),
            'tickets_firmados' => Ticket::where('estado', 'firmado')->count(),
            'tickets_entregados' => Ticket::where('estado', 'entregado')->count(),
        ];

        return view('tickets.index', compact('tickets', 'estadisticas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $reparacionId = $request->get('reparacion_id');
        $reparacion = null;
        
        if ($reparacionId) {
            $reparacion = Reparacion::with(['equipo.cliente', 'tecnico'])->find($reparacionId);
        }

        $reparaciones = Reparacion::with(['equipo.cliente', 'tecnico'])
                                  ->whereDoesntHave('tickets')
                                  ->whereIn('estado', ['pendiente', 'en_proceso', 'completada'])
                                  ->orderBy('fecha_inicio', 'desc')
                                  ->get();

        return view('tickets.create', compact('reparacion', 'reparaciones'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'reparacion_id' => 'required|exists:reparaciones,id',
            'tipo_ticket' => 'required|in:ingreso,entrega,servicio',
            'descripcion_servicio' => 'nullable|string',
            'observaciones_tecnico' => 'nullable|string',
            'observaciones_cliente' => 'nullable|string',
            'costo_servicio' => 'nullable|numeric|min:0',
            'costo_repuestos' => 'nullable|numeric|min:0',
            'condiciones_servicio' => 'nullable|string',
            'tiempo_garantia_dias' => 'nullable|integer|min:0|max:365',
            'observaciones_generales' => 'nullable|string',
        ], [
            'reparacion_id.required' => 'Debe seleccionar una reparación.',
            'reparacion_id.exists' => 'La reparación seleccionada no existe.',
            'tipo_ticket.required' => 'Debe seleccionar el tipo de ticket.',
            'tipo_ticket.in' => 'El tipo de ticket seleccionado no es válido.',
            'costo_servicio.numeric' => 'El costo de servicio debe ser un número.',
            'costo_repuestos.numeric' => 'El costo de repuestos debe ser un número.',
            'tiempo_garantia_dias.integer' => 'El tiempo de garantía debe ser un número entero.',
            'tiempo_garantia_dias.max' => 'El tiempo de garantía no puede exceder 365 días.',
        ]);

        try {
            DB::beginTransaction();

            $ticket = Ticket::create($validated);
            
            // Calcular total automáticamente
            $ticket->calcularTotal();

            // Registrar en el historial
            TicketHistory::recordCreated($ticket, auth()->user(), $validated);

            DB::commit();

            return redirect()->route('tickets.show', $ticket)
                           ->with('success', 'Ticket generado exitosamente.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withInput()
                        ->with('error', 'Error al generar el ticket: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Ticket $ticket)
    {
        $ticket->load([
            'reparacion.equipo.cliente', 
            'reparacion.tecnico.user'
        ]);

        return view('tickets.show', compact('ticket'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ticket $ticket)
    {
        if ($ticket->estado !== 'generado') {
            return redirect()->route('tickets.show', $ticket)
                           ->with('error', 'Solo se pueden editar tickets en estado "Generado".');
        }

        $ticket->load(['reparacion.equipo.cliente', 'reparacion.tecnico']);
        
        return view('tickets.edit', compact('ticket'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ticket $ticket)
    {
        if ($ticket->estado !== 'generado') {
            return redirect()->route('tickets.show', $ticket)
                           ->with('error', 'Solo se pueden editar tickets en estado "Generado".');
        }

        $validated = $request->validate([
            'descripcion_servicio' => 'nullable|string',
            'observaciones_tecnico' => 'nullable|string',
            'observaciones_cliente' => 'nullable|string',
            'costo_servicio' => 'nullable|numeric|min:0',
            'costo_repuestos' => 'nullable|numeric|min:0',
            'condiciones_servicio' => 'nullable|string',
            'tiempo_garantia_dias' => 'nullable|integer|min:0|max:365',
            'observaciones_generales' => 'nullable|string',
        ]);

        try {
            // Guardar datos anteriores para el historial
            $oldData = $ticket->only(array_keys($validated));
            
            $ticket->update($validated);
            $ticket->calcularTotal();

            // Registrar en el historial
            TicketHistory::recordUpdated($ticket, auth()->user(), $oldData, $validated);

            return redirect()->route('tickets.show', $ticket)
                           ->with('success', 'Ticket actualizado exitosamente.');
        } catch (\Exception $e) {
            return back()->withInput()
                        ->with('error', 'Error al actualizar el ticket: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ticket $ticket)
    {
        if ($ticket->estado !== 'generado') {
            return back()->with('error', 'Solo se pueden eliminar tickets en estado "Generado".');
        }

        try {
            $numeroTicket = $ticket->numero_ticket;
            $ticket->delete();

            return redirect()->route('tickets.index')
                           ->with('success', "Ticket {$numeroTicket} eliminado exitosamente.");
        } catch (\Exception $e) {
            return back()->with('error', 'Error al eliminar el ticket: ' . $e->getMessage());
        }
    }

    /**
     * Generate ticket from reparacion
     */
    public function generarDesdeReparacion(Reparacion $reparacion)
    {
        // Verificar que la reparación no tenga ticket ya
        if ($reparacion->tickets()->exists()) {
            return back()->with('error', 'Esta reparación ya tiene un ticket generado.');
        }

        try {
            $ticket = Ticket::create([
                'reparacion_id' => $reparacion->id,
                'tipo_ticket' => 'servicio',
                'descripcion_servicio' => $reparacion->descripcion_problema,
                'observaciones_tecnico' => $reparacion->diagnostico,
                'costo_servicio' => $reparacion->costo ?? 0,
                'tiempo_garantia_dias' => 30,
            ]);

            return redirect()->route('tickets.show', $ticket)
                           ->with('success', 'Ticket generado automáticamente desde la reparación.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al generar ticket: ' . $e->getMessage());
        }
    }

    /**
     * Show ticket for printing
     */
    public function imprimir(Ticket $ticket)
    {
        $ticket->load([
            'reparacion.equipo.cliente', 
            'reparacion.tecnico.user'
        ]);

        // Registrar en el historial que se está imprimiendo (solo si la tabla existe)
        try {
            // Asegurar que la tabla existe
            DatabaseHelper::ensureTicketHistoriesTable();
            
            if (DatabaseHelper::tableExists('ticket_histories')) {
                TicketHistory::recordPrinted($ticket, auth()->user());
            }
        } catch (\Exception $e) {
            // Si hay error al registrar el historial, continuar con la impresión
            \Log::warning('No se pudo registrar el historial de impresión: ' . $e->getMessage());
        }

        return view('tickets.imprimir', compact('ticket'));
    }


    /**
     * Mark ticket as delivered
     */
    public function marcarEntregado(Ticket $ticket)
    {
        if ($ticket->estado !== 'firmado') {
            return back()->with('error', 'Solo se pueden marcar como entregados los tickets firmados.');
        }

        try {
            $oldStatus = $ticket->estado;
            $ticket->marcarComoEntregado();

            // Registrar en el historial
            TicketHistory::recordDelivered($ticket, auth()->user());

            return back()->with('success', 'Ticket marcado como entregado exitosamente.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al marcar como entregado: ' . $e->getMessage());
        }
    }

    /**
     * Cancel ticket
     */
    public function anular(Request $request, Ticket $ticket)
    {
        if ($ticket->estado === 'anulado') {
            return back()->with('error', 'Este ticket ya está anulado.');
        }

        $motivo = $request->input('motivo', 'Sin especificar');

        try {
            $ticket->anular($motivo);

            // Registrar en el historial
            TicketHistory::recordCancelled($ticket, auth()->user(), $motivo);

            return back()->with('success', 'Ticket anulado exitosamente.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al anular ticket: ' . $e->getMessage());
        }
    }

    /**
     * Get tickets for API/AJAX requests
     */
    public function api(Request $request)
    {
        $query = Ticket::with(['reparacion.equipo.cliente']);

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        if ($request->filled('q')) {
            $termino = $request->q;
            $query->where(function($q) use ($termino) {
                $q->where('numero_ticket', 'like', "%{$termino}%")
                  ->orWhereHas('reparacion.equipo.cliente', function($sq) use ($termino) {
                      $sq->where('nombres', 'like', "%{$termino}%")
                         ->orWhere('apellidos', 'like', "%{$termino}%");
                  });
            });
        }

        $tickets = $query->limit(10)
                        ->get()
                        ->map(function($ticket) {
                            return [
                                'id' => $ticket->id,
                                'numero_ticket' => $ticket->numero_ticket,
                                'tipo' => $ticket->tipo_ticket_label,
                                'estado' => $ticket->estado_label,
                                'cliente' => $ticket->reparacion->equipo->cliente->nombre_completo ?? 'N/A',
                                'fecha' => $ticket->fecha_generacion->format('d/m/Y')
                            ];
                        });

        return response()->json($tickets);
    }

    /**
     * Show ticket history
     */
    public function history(Request $request)
    {
        $query = TicketHistory::with(['ticket', 'user']);

        // Filtro por ticket específico
        if ($request->filled('ticket_id')) {
            $query->where('ticket_id', $request->ticket_id);
        }

        // Filtro por usuario
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        // Filtro por acción
        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }

        // Filtro por fecha
        if ($request->filled('fecha_inicio')) {
            $query->whereDate('created_at', '>=', $request->fecha_inicio);
        }
        if ($request->filled('fecha_fin')) {
            $query->whereDate('created_at', '<=', $request->fecha_fin);
        }

        // Búsqueda rápida
        if ($request->filled('buscar')) {
            $termino = $request->buscar;
            $query->where(function($q) use ($termino) {
                $q->where('description', 'like', "%{$termino}%")
                  ->orWhereHas('ticket', function($sq) use ($termino) {
                      $sq->where('numero_ticket', 'like', "%{$termino}%");
                  })
                  ->orWhereHas('user', function($sq) use ($termino) {
                      $sq->where('name', 'like', "%{$termino}%");
                  });
            });
        }

        $historial = $query->orderBy('created_at', 'desc')
                          ->paginate(20);

        // Estadísticas del historial
        $estadisticas = [
            'total_acciones' => TicketHistory::count(),
            'acciones_hoy' => TicketHistory::whereDate('created_at', today())->count(),
            'acciones_esta_semana' => TicketHistory::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count(),
            'acciones_este_mes' => TicketHistory::whereMonth('created_at', now()->month)->count(),
        ];

        // Acciones más comunes
        $acciones_comunes = TicketHistory::select('action', DB::raw('count(*) as total'))
                                       ->groupBy('action')
                                       ->orderBy('total', 'desc')
                                       ->limit(5)
                                       ->get();

        return view('tickets.history', compact('historial', 'estadisticas', 'acciones_comunes'));
    }

    /**
     * Show specific ticket history
     */
    public function ticketHistory(Ticket $ticket)
    {
        $historial = $ticket->history()->with('user')->get();
        
        return view('tickets.ticket-history', compact('ticket', 'historial'));
    }
}
