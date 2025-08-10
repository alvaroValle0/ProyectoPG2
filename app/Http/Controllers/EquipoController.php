<?php

namespace App\Http\Controllers;

use App\Models\Equipo;
use App\Models\Tecnico;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EquipoController extends Controller
{
    public function index(Request $request)
    {
        $query = Equipo::with(['reparacionActual.tecnico.user']);

        // Filtros
        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        if ($request->filled('cliente')) {
            $query->porCliente($request->cliente);
        }

        if ($request->filled('numero_serie')) {
            $query->where('numero_serie', 'like', "%{$request->numero_serie}%");
        }

        if ($request->filled('fecha_desde')) {
            $query->whereDate('fecha_ingreso', '>=', $request->fecha_desde);
        }

        if ($request->filled('fecha_hasta')) {
            $query->whereDate('fecha_ingreso', '<=', $request->fecha_hasta);
        }

        $equipos = $query->orderBy('fecha_ingreso', 'desc')->paginate(15);

        return view('reparaciones.equipos.index', compact('equipos'));
    }

    public function create()
    {
        return view('reparaciones.equipos.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'numero_serie' => 'required|string|unique:equipos,numero_serie',
            'marca' => 'required|string|max:255',
            'modelo' => 'required|string|max:255',
            'tipo_equipo' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'fecha_ingreso' => 'required|date',
            'cliente_nombre' => 'required|string|max:255',
            'cliente_telefono' => 'nullable|string|max:20',
            'cliente_email' => 'nullable|email|max:255',
            'costo_estimado' => 'nullable|numeric|min:0',
            'observaciones' => 'nullable|string'
        ]);

        try {
            $equipo = Equipo::create($validated);
            
            return redirect()->route('equipos.show', $equipo)
                ->with('success', 'Equipo registrado exitosamente.');
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Error al registrar el equipo: ' . $e->getMessage());
        }
    }

    public function show(Equipo $equipo)
    {
        $equipo->load(['reparaciones.tecnico.user']);
        return view('reparaciones.equipos.show', compact('equipo'));
    }

    public function edit(Equipo $equipo)
    {
        return view('reparaciones.equipos.edit', compact('equipo'));
    }

    public function update(Request $request, Equipo $equipo)
    {
        $validated = $request->validate([
            'numero_serie' => 'required|string|unique:equipos,numero_serie,' . $equipo->id,
            'marca' => 'required|string|max:255',
            'modelo' => 'required|string|max:255',
            'tipo_equipo' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'cliente_nombre' => 'required|string|max:255',
            'cliente_telefono' => 'nullable|string|max:20',
            'cliente_email' => 'nullable|email|max:255',
            'estado' => 'required|in:recibido,en_reparacion,reparado,entregado',
            'costo_estimado' => 'nullable|numeric|min:0',
            'observaciones' => 'nullable|string'
        ]);

        try {
            $equipo->update($validated);
            
            return redirect()->route('equipos.show', $equipo)
                ->with('success', 'Equipo actualizado exitosamente.');
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Error al actualizar el equipo: ' . $e->getMessage());
        }
    }

    public function destroy(Equipo $equipo)
    {
        try {
            // Verificar si tiene reparaciones activas
            if ($equipo->reparaciones()->whereIn('estado', ['pendiente', 'en_proceso'])->exists()) {
                return back()->with('error', 'No se puede eliminar un equipo con reparaciones activas.');
            }

            $equipo->delete();
            
            return redirect()->route('equipos.index')
                ->with('success', 'Equipo eliminado exitosamente.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al eliminar el equipo: ' . $e->getMessage());
        }
    }

    public function cambiarEstado(Request $request, Equipo $equipo)
    {
        $validated = $request->validate([
            'estado' => 'required|in:recibido,en_reparacion,reparado,entregado',
            'observaciones' => 'nullable|string'
        ]);

        try {
            $equipo->update($validated);
            
            return response()->json([
                'success' => true,
                'message' => 'Estado actualizado exitosamente.',
                'nuevo_estado' => $equipo->estado
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el estado: ' . $e->getMessage()
            ], 422);
        }
    }

    public function buscar(Request $request)
    {
        $query = $request->get('q');
        
        if (strlen($query) < 2) {
            return response()->json(['equipos' => []]);
        }

        $equipos = Equipo::where('numero_serie', 'like', "%{$query}%")
            ->orWhere('cliente_nombre', 'like', "%{$query}%")
            ->orWhere('marca', 'like', "%{$query}%")
            ->orWhere('modelo', 'like', "%{$query}%")
            ->limit(10)
            ->get(['id', 'numero_serie', 'marca', 'modelo', 'cliente_nombre', 'estado']);

        return response()->json(['equipos' => $equipos]);
    }

    public function reportes()
    {
        $estadisticas = [
            'total_equipos' => Equipo::count(),
            'recibidos' => Equipo::recibidos()->count(),
            'en_reparacion' => Equipo::enReparacion()->count(),
            'reparados' => Equipo::reparados()->count(),
            'entregados' => Equipo::entregados()->count(),
        ];

        // Equipos por mes (últimos 6 meses)
        $equiposPorMes = Equipo::select(
                DB::raw('DATE_FORMAT(fecha_ingreso, "%Y-%m") as mes'),
                DB::raw('COUNT(*) as total')
            )
            ->where('fecha_ingreso', '>=', now()->subMonths(6))
            ->groupBy('mes')
            ->orderBy('mes')
            ->get();

        return view('reparaciones.equipos.reportes', compact('estadisticas', 'equiposPorMes'));
    }
}