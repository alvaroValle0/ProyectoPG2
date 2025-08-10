<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\Reparacion;
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

        $tickets = $query->orderBy('fecha_generacion', 'desc')->paginate(15);

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
                                  ->whereIn('estado', ['en_proceso', 'completada'])
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
            $ticket->update($validated);
            $ticket->calcularTotal();

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

        return view('tickets.imprimir', compact('ticket'));
    }

    /**
     * Show signature form
     */
    public function firmar(Ticket $ticket)
    {
        if ($ticket->estado !== 'generado') {
            return redirect()->route('tickets.show', $ticket)
                           ->with('error', 'Este ticket ya no puede ser firmado.');
        }

        $ticket->load([
            'reparacion.equipo.cliente', 
            'reparacion.tecnico.user'
        ]);

        return view('tickets.firmar', compact('ticket'));
    }

    /**
     * Process signature
     */
    public function procesarFirma(Request $request, Ticket $ticket)
    {
        $validated = $request->validate([
            'firma_base64' => 'required|string',
            'nombre_firmante' => 'required|string|max:255',
            'dpi_firmante' => 'nullable|string|max:20',
        ], [
            'firma_base64.required' => 'La firma es obligatoria.',
            'nombre_firmante.required' => 'El nombre del firmante es obligatorio.',
        ]);

        try {
            $ticket->firmar(
                $validated['firma_base64'],
                $validated['nombre_firmante'],
                $validated['dpi_firmante'] ?? null
            );

            return redirect()->route('tickets.show', $ticket)
                           ->with('success', 'Ticket firmado exitosamente.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al procesar la firma: ' . $e->getMessage());
        }
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
            $ticket->marcarComoEntregado();

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
}
