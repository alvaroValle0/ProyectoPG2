<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use Illuminate\Support\Facades\DB;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Cliente::query();

        // Filtro por estado
        if ($request->filled('estado')) {
            if ($request->estado === 'activo') {
                $query->where('activo', true);
            } elseif ($request->estado === 'inactivo') {
                $query->where('activo', false);
            }
        }

        // Búsqueda rápida
        if ($request->filled('buscar')) {
            $termino = $request->buscar;
            $query->buscar($termino);
        }

        // Filtro por ubicación (si hay dirección)
        if ($request->filled('con_direccion')) {
            if ($request->con_direccion === 'si') {
                $query->whereNotNull('direccion');
            } elseif ($request->con_direccion === 'no') {
                $query->whereNull('direccion');
            }
        }

        // Ordenar por nombre completo
        $clientes = $query->orderBy('nombres', 'asc')
                         ->orderBy('apellidos', 'asc')
                         ->paginate(15);

        // Estadísticas
        $estadisticas = [
            'total_clientes' => Cliente::count(),
            'clientes_activos' => Cliente::where('activo', true)->count(),
            'clientes_con_email' => Cliente::whereNotNull('email')->count(),
            'clientes_con_telefono' => Cliente::whereNotNull('telefono')->count(),
        ];

        return view('clientes.index', compact('clientes', 'estadisticas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('clientes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'telefono' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255|unique:clientes,email',
            'direccion' => 'nullable|string',
            'dpi' => 'nullable|string|max:20|unique:clientes,dpi',
            'observaciones' => 'nullable|string',
            'activo' => 'boolean'
        ], [
            'nombres.required' => 'El nombre es obligatorio.',
            'apellidos.required' => 'Los apellidos son obligatorios.',
            'email.email' => 'Debe ser un correo electrónico válido.',
            'email.unique' => 'Este correo electrónico ya está registrado.',
            'dpi.unique' => 'Este DPI ya está registrado.',
            'telefono.max' => 'El teléfono no puede tener más de 20 caracteres.',
            'dpi.max' => 'El DPI no puede tener más de 20 caracteres.'
        ]);

        try {
            $cliente = Cliente::create($validated);
            
            return redirect()->route('clientes.show', $cliente)
                           ->with('success', 'Cliente registrado exitosamente.');
        } catch (\Exception $e) {
            return back()->withInput()
                        ->with('error', 'Error al registrar el cliente: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Cliente $cliente)
    {
        // Cargar relaciones para estadísticas
        $cliente->load(['reparaciones.equipo', 'equipos']);

        $estadisticas = [
            'total_reparaciones' => $cliente->getTotalReparaciones(),
            'reparaciones_pendientes' => $cliente->getReparacionesPendientes(),
            'total_equipos' => $cliente->equipos()->count(),
            'ultima_reparacion' => $cliente->getUltimaReparacion()
        ];

        return view('clientes.show', compact('cliente', 'estadisticas'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cliente $cliente)
    {
        return view('clientes.edit', compact('cliente'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cliente $cliente)
    {
        $validated = $request->validate([
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'telefono' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255|unique:clientes,email,' . $cliente->id,
            'direccion' => 'nullable|string',
            'dpi' => 'nullable|string|max:20|unique:clientes,dpi,' . $cliente->id,
            'observaciones' => 'nullable|string',
            'activo' => 'boolean'
        ], [
            'nombres.required' => 'El nombre es obligatorio.',
            'apellidos.required' => 'Los apellidos son obligatorios.',
            'email.email' => 'Debe ser un correo electrónico válido.',
            'email.unique' => 'Este correo electrónico ya está registrado.',
            'dpi.unique' => 'Este DPI ya está registrado.',
            'telefono.max' => 'El teléfono no puede tener más de 20 caracteres.',
            'dpi.max' => 'El DPI no puede tener más de 20 caracteres.'
        ]);

        try {
            $cliente->update($validated);
            
            return redirect()->route('clientes.show', $cliente)
                           ->with('success', 'Cliente actualizado exitosamente.');
        } catch (\Exception $e) {
            return back()->withInput()
                        ->with('error', 'Error al actualizar el cliente: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cliente $cliente)
    {
        try {
            // Verificar si tiene reparaciones o equipos asociados
            $totalReparaciones = $cliente->reparaciones()->count();
            $totalEquipos = $cliente->equipos()->count();

            if ($totalReparaciones > 0 || $totalEquipos > 0) {
                return back()->with('error', 
                    "No se puede eliminar el cliente porque tiene {$totalReparaciones} reparaciones y {$totalEquipos} equipos asociados. " .
                    "Puede desactivarlo en su lugar."
                );
            }

            $nombreCompleto = $cliente->nombre_completo;
            $cliente->delete();

            return redirect()->route('clientes.index')
                           ->with('success', "Cliente {$nombreCompleto} eliminado exitosamente.");
        } catch (\Exception $e) {
            return back()->with('error', 'Error al eliminar el cliente: ' . $e->getMessage());
        }
    }

    /**
     * Toggle client status (activate/deactivate)
     */
    public function toggleStatus(Cliente $cliente)
    {
        try {
            $cliente->update(['activo' => !$cliente->activo]);
            
            $estado = $cliente->activo ? 'activado' : 'desactivado';
            
            return response()->json([
                'success' => true,
                'message' => "Cliente {$estado} exitosamente.",
                'activo' => $cliente->activo,
                'estado_label' => $cliente->estado_label,
                'estado_color' => $cliente->estado_color
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al cambiar el estado del cliente: ' . $e->getMessage()
            ], 422);
        }
    }

    /**
     * Get clients for API/AJAX requests
     */
    public function api(Request $request)
    {
        $query = Cliente::activos();

        if ($request->filled('q')) {
            $query->buscar($request->q);
        }

        $clientes = $query->select('id', 'nombres', 'apellidos', 'telefono', 'email')
                         ->limit(10)
                         ->get()
                         ->map(function($cliente) {
                             return [
                                 'id' => $cliente->id,
                                 'text' => $cliente->nombre_completo,
                                 'email' => $cliente->email,
                                 'telefono' => $cliente->telefono
                             ];
                         });

        return response()->json($clientes);
    }
}
