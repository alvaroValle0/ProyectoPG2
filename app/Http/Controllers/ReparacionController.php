<?php

namespace App\Http\Controllers;

use App\Models\Reparacion;
use App\Models\Equipo;
use App\Models\Tecnico;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReparacionController extends Controller
{
    public function index(Request $request)
    {
        $query = Reparacion::with(['equipo', 'tecnico.user']);

        // Filtros
        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        if ($request->filled('tecnico_id')) {
            $query->where('tecnico_id', $request->tecnico_id);
        }

        if ($request->filled('fecha_desde')) {
            $query->whereDate('fecha_inicio', '>=', $request->fecha_desde);
        }

        if ($request->filled('fecha_hasta')) {
            $query->whereDate('fecha_inicio', '<=', $request->fecha_hasta);
        }

        // Filtro por cliente
        if ($request->filled('cliente')) {
            $query->whereHas('equipo', function($q) use ($request) {
                $q->where('cliente_nombre', 'like', "%{$request->cliente}%");
            });
        }

        // Buscador rápido
        if ($request->filled('buscar')) {
            $buscar = $request->buscar;
            $query->where(function($q) use ($buscar) {
                $q->where('id', 'like', "%{$buscar}%")
                  ->orWhere('descripcion_problema', 'like', "%{$buscar}%")
                  ->orWhere('diagnostico', 'like', "%{$buscar}%")
                  ->orWhere('solucion', 'like', "%{$buscar}%")
                  ->orWhereHas('equipo', function($eq) use ($buscar) {
                      $eq->where('numero_serie', 'like', "%{$buscar}%")
                         ->orWhere('cliente_nombre', 'like', "%{$buscar}%")
                         ->orWhere('marca', 'like', "%{$buscar}%")
                         ->orWhere('modelo', 'like', "%{$buscar}%");
                  })
                  ->orWhereHas('tecnico.user', function($t) use ($buscar) {
                      $t->where('name', 'like', "%{$buscar}%");
                  });
            });
        }

        if ($request->filled('vencidas')) {
            // Lógica para mostrar reparaciones vencidas
            $query->whereIn('estado', ['pendiente', 'en_proceso'])
                ->where('fecha_inicio', '<', now()->subDays(7));
        }

        $reparaciones = $query->orderBy('fecha_inicio', 'desc')->paginate(15);
        $tecnicos = Tecnico::activos()->with('user')->get();

        return view('reparaciones.reparaciones.index', compact('reparaciones', 'tecnicos'));
    }

    public function create(Request $request)
    {
        $equipo = null;
        if ($request->filled('equipo_id')) {
            $equipo = Equipo::findOrFail($request->equipo_id);
        }

        $equipos = Equipo::whereIn('estado', ['recibido', 'en_reparacion'])
            ->orderBy('fecha_ingreso', 'desc')
            ->get();

        $tecnicos = Tecnico::activos()->with('user')->get();

        return view('reparaciones.reparaciones.create', compact('equipo', 'equipos', 'tecnicos'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'equipo_id' => 'required|exists:equipos,id',
            'tecnico_id' => 'required|exists:tecnicos,id',
            'descripcion_problema' => 'required|string',
            'fecha_inicio' => 'required|date',
            'tiempo_estimado_horas' => 'nullable|integer|min:1',
            'observaciones' => 'nullable|string'
        ]);

        try {
            DB::beginTransaction();

            $reparacion = Reparacion::create($validated);
            
            // Actualizar estado del equipo
            $reparacion->equipo->update(['estado' => 'en_reparacion']);

            DB::commit();
            
            return redirect()->route('reparaciones.show', $reparacion)
                ->with('success', 'Reparación creada exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->with('error', 'Error al crear la reparación: ' . $e->getMessage());
        }
    }

    public function show(Reparacion $reparacion)
    {
        $reparacion->load(['equipo', 'tecnico.user']);
        return view('reparaciones.reparaciones.show', compact('reparacion'));
    }

    public function edit(Reparacion $reparacion)
    {
        $tecnicos = Tecnico::activos()->with('user')->get();
        return view('reparaciones.reparaciones.edit', compact('reparacion', 'tecnicos'));
    }

    public function update(Request $request, Reparacion $reparacion)
    {
        $validated = $request->validate([
            'tecnico_id' => 'required|exists:tecnicos,id',
            'descripcion_problema' => 'required|string',
            'diagnostico' => 'nullable|string',
            'solucion' => 'nullable|string',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
            'estado' => 'required|in:pendiente,en_proceso,completada,cancelada',
            'costo' => 'nullable|numeric|min:0',
            'tiempo_estimado_horas' => 'nullable|integer|min:1',
            'tiempo_real_horas' => 'nullable|integer|min:1',
            'observaciones' => 'nullable|string'
        ]);

        // Validar repuestos si se envían
        if ($request->filled('repuestos')) {
            $repuestos = [];
            foreach ($request->repuestos as $repuesto) {
                if (!empty($repuesto['nombre'])) {
                    $repuestos[] = [
                        'nombre' => $repuesto['nombre'],
                        'cantidad' => (int) ($repuesto['cantidad'] ?? 1),
                        'precio' => (float) ($repuesto['precio'] ?? 0)
                    ];
                }
            }
            $validated['repuestos_utilizados'] = $repuestos;
        }

        try {
            $reparacion->update($validated);
            
            return redirect()->route('reparaciones.show', $reparacion)
                ->with('success', 'Reparación actualizada exitosamente.');
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Error al actualizar la reparación: ' . $e->getMessage());
        }
    }

    public function destroy(Reparacion $reparacion)
    {
        try {
            DB::beginTransaction();

            // Si la reparación está en proceso, devolver el equipo a estado recibido
            if ($reparacion->estado === 'en_proceso') {
                $reparacion->equipo->update(['estado' => 'recibido']);
            }

            $reparacion->delete();

            DB::commit();
            
            return redirect()->route('reparaciones.index')
                ->with('success', 'Reparación eliminada exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error al eliminar la reparación: ' . $e->getMessage());
        }
    }

    public function cambiarEstado(Request $request, Reparacion $reparacion)
    {
        $validated = $request->validate([
            'estado' => 'required|in:pendiente,en_proceso,completada,cancelada',
            'observaciones' => 'nullable|string'
        ]);

        try {
            DB::beginTransaction();

            $estadoAnterior = $reparacion->estado;
            
            $reparacion->update($validated);

            // Lógica adicional basada en el cambio de estado
            if ($validated['estado'] === 'completada' && $estadoAnterior !== 'completada') {
                $reparacion->update(['fecha_fin' => now()]);
            }

            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Estado actualizado exitosamente.',
                'nuevo_estado' => $reparacion->estado
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el estado: ' . $e->getMessage()
            ], 422);
        }
    }

    public function asignarTecnico(Request $request, Reparacion $reparacion)
    {
        $validated = $request->validate([
            'tecnico_id' => 'required|exists:tecnicos,id'
        ]);

        try {
            $reparacion->update($validated);
            
            return response()->json([
                'success' => true,
                'message' => 'Técnico asignado exitosamente.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al asignar técnico: ' . $e->getMessage()
            ], 422);
        }
    }

    public function misTareas(Request $request)
    {
        $user = auth()->user();
        
        // Permitir acceso a cualquier usuario autenticado
        $query = Reparacion::with(['equipo', 'tecnico']);

        // Filtros
        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        if ($request->filled('fecha_desde')) {
            $query->whereDate('fecha_inicio', '>=', $request->fecha_desde);
        }

        if ($request->filled('fecha_hasta')) {
            $query->whereDate('fecha_inicio', '<=', $request->fecha_hasta);
        }

        $reparaciones = $query->orderBy('fecha_inicio', 'desc')->paginate(15);

        return view('reparaciones.reparaciones.mis-tareas', compact('reparaciones'));
    }

    public function reportes()
    {
        $estadisticas = [
            'total_reparaciones' => Reparacion::count(),
            'pendientes' => Reparacion::pendientes()->count(),
            'en_proceso' => Reparacion::enProceso()->count(),
            'completadas' => Reparacion::completadas()->count(),
            'canceladas' => Reparacion::canceladas()->count(),
            'vencidas' => Reparacion::whereIn('estado', ['pendiente', 'en_proceso'])
                ->where('fecha_inicio', '<', now()->subDays(7))
                ->count(),
        ];

        // Reparaciones por mes (últimos 6 meses)
        $reparacionesPorMes = Reparacion::select(
                DB::raw('DATE_FORMAT(fecha_inicio, "%Y-%m") as mes'),
                DB::raw('COUNT(*) as total'),
                DB::raw('SUM(CASE WHEN estado = "completada" THEN 1 ELSE 0 END) as completadas')
            )
            ->where('fecha_inicio', '>=', now()->subMonths(6))
            ->groupBy('mes')
            ->orderBy('mes')
            ->get();

        // Top técnicos por reparaciones completadas
        $topTecnicos = Tecnico::with('user')
            ->withCount(['reparacionesCompletadas'])
            ->having('reparaciones_completadas_count', '>', 0)
            ->orderBy('reparaciones_completadas_count', 'desc')
            ->limit(5)
            ->get();

        return view('reparaciones.reparaciones.reportes', compact(
            'estadisticas', 
            'reparacionesPorMes', 
            'topTecnicos'
        ));
    }

    public function buscarEquipos(Request $request)
    {
        $query = $request->get('q');
        
        if (strlen($query) < 2) {
            return response()->json(['equipos' => []]);
        }

        $equipos = Equipo::whereIn('estado', ['recibido', 'en_reparacion'])
            ->where(function($q) use ($query) {
                $q->where('numero_serie', 'like', "%{$query}%")
                  ->orWhere('cliente_nombre', 'like', "%{$query}%")
                  ->orWhere('marca', 'like', "%{$query}%")
                  ->orWhere('modelo', 'like', "%{$query}%");
            })
            ->limit(10)
            ->get(['id', 'numero_serie', 'marca', 'modelo', 'cliente_nombre']);

        return response()->json(['equipos' => $equipos]);
    }

    public function imprimirTicket(Reparacion $reparacion)
    {
        $reparacion->load(['equipo', 'tecnico.user']);
        
        return view('reparaciones.reparaciones.ticket', compact('reparacion'));
    }
}