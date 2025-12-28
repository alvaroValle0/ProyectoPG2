<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proveedor;
use Illuminate\Support\Facades\DB;

class ProveedorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Proveedor::query();

        // Filtro por estado
        if ($request->filled('estado')) {
            if ($request->estado === 'activo') {
                $query->where('activo', true);
            } elseif ($request->estado === 'inactivo') {
                $query->where('activo', false);
            }
        }

        // Filtro por tipo de proveedor
        if ($request->filled('tipo_proveedor')) {
            $query->where('tipo_proveedor', $request->tipo_proveedor);
        }

        // Filtro por categoría
        if ($request->filled('categoria')) {
            $query->where('categoria_productos', 'like', "%{$request->categoria}%");
        }

        // Búsqueda rápida
        if ($request->filled('buscar')) {
            $termino = $request->buscar;
            $query->buscar($termino);
        }

        // Ordenar por nombre y cargar relaciones
        $proveedores = $query->with(['inventarios', 'reparaciones'])
                           ->orderBy('nombre_empresa', 'asc')
                           ->paginate(15);

        // Estadísticas
        $estadisticas = [
            'total_proveedores' => Proveedor::count(),
            'proveedores_activos' => Proveedor::where('activo', true)->count(),
            'proveedores_fabricantes' => Proveedor::where('tipo_proveedor', 'fabricante')->count(),
            'proveedores_distribuidores' => Proveedor::where('tipo_proveedor', 'distribuidor')->count(),
        ];

        // Tipos de proveedor para filtros
        $tiposProveedor = [
            'fabricante' => 'Fabricante',
            'distribuidor' => 'Distribuidor',
            'mayorista' => 'Mayorista',
            'minorista' => 'Minorista',
            'otro' => 'Otro'
        ];

        return view('proveedores.index', compact('proveedores', 'estadisticas', 'tiposProveedor'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tiposProveedor = [
            'fabricante' => 'Fabricante',
            'distribuidor' => 'Distribuidor',
            'mayorista' => 'Mayorista',
            'minorista' => 'Minorista',
            'otro' => 'Otro'
        ];

        return view('proveedores.create', compact('tiposProveedor'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre_empresa' => 'required|string|max:255',
            'nombre_contacto' => 'nullable|string|max:255',
            'nombre_representante' => 'nullable|string|max:255',
            'telefono' => 'nullable|string|max:20',
            'telefono_fijo' => 'nullable|string|max:20',
            'telefono_movil' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255|unique:proveedores,email',
            'email_alternativo' => 'nullable|email|max:255',
            'direccion' => 'nullable|string',
            'pagina_web' => 'nullable|url|max:255',
            'nit' => 'nullable|string|max:20|unique:proveedores,nit',
            'tipo_proveedor' => 'required|in:fabricante,distribuidor,mayorista,minorista,otro',
            'categoria_productos' => 'nullable|string|max:255',
            'descripcion_general' => 'nullable|string',
            'tiempo_entrega_promedio' => 'nullable|string|max:255',
            'condiciones_pago' => 'nullable|string|max:255',
            'observaciones' => 'nullable|string',
            'activo' => 'boolean'
        ], [
            'nombre_empresa.required' => 'El nombre de la empresa es obligatorio.',
            'tipo_proveedor.required' => 'El tipo de proveedor es obligatorio.',
            'email.email' => 'Debe ser un correo electrónico válido.',
            'email.unique' => 'Este correo electrónico ya está registrado.',
            'email_alternativo.email' => 'El correo alternativo debe ser válido.',
            'nit.unique' => 'Este NIT ya está registrado.',
            'pagina_web.url' => 'La página web debe ser una URL válida.'
        ]);

        try {
            $proveedor = Proveedor::create($validated);
            
            return redirect()->route('proveedores.show', $proveedor)
                           ->with('success', 'Proveedor registrado exitosamente.');
        } catch (\Exception $e) {
            return back()->withInput()
                        ->with('error', 'Error al registrar el proveedor: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Proveedor $proveedor)
    {
        // Cargar relaciones para estadísticas
        $proveedor->load(['inventarios', 'reparaciones.equipo', 'reparaciones.tecnico']);

        $estadisticas = [
            'total_inventarios' => $proveedor->getTotalInventarios(),
            'inventarios_activos' => $proveedor->getInventariosActivos(),
            'total_reparaciones' => $proveedor->getTotalReparaciones(),
            'ultima_compra' => $proveedor->getUltimaCompra()
        ];

        return view('proveedores.show', compact('proveedor', 'estadisticas'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Proveedor $proveedor)
    {
        $tiposServicio = [
            'reparacion' => 'Reparación',
            'mantenimiento' => 'Mantenimiento',
            'suministros' => 'Suministros',
            'software' => 'Software',
            'hardware' => 'Hardware',
            'consultoria' => 'Consultoría',
            'otro' => 'Otro'
        ];

        return view('proveedores.edit', compact('proveedor', 'tiposServicio'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Proveedor $proveedor)
    {
        $validated = $request->validate([
            'nombre_empresa' => 'required|string|max:255',
            'nombre_contacto' => 'nullable|string|max:255',
            'telefono' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255|unique:proveedores,email,' . $proveedor->id,
            'direccion' => 'nullable|string',
            'nit' => 'nullable|string|max:20|unique:proveedores,nit,' . $proveedor->id,
            'tipo_servicio' => 'required|in:reparacion,mantenimiento,suministros,software,hardware,consultoria,otro',
            'descripcion_servicios' => 'nullable|string',
            'tiempo_respuesta' => 'nullable|string|max:255',
            'calificacion' => 'nullable|numeric|min:0|max:5',
            'observaciones' => 'nullable|string',
            'activo' => 'boolean'
        ], [
            'nombre_empresa.required' => 'El nombre de la empresa es obligatorio.',
            'tipo_servicio.required' => 'El tipo de servicio es obligatorio.',
            'email.email' => 'Debe ser un correo electrónico válido.',
            'email.unique' => 'Este correo electrónico ya está registrado.',
            'nit.unique' => 'Este NIT ya está registrado.',
            'calificacion.min' => 'La calificación debe ser entre 0 y 5.',
            'calificacion.max' => 'La calificación debe ser entre 0 y 5.'
        ]);

        try {
            $proveedor->update($validated);
            
            return redirect()->route('proveedores.show', $proveedor)
                           ->with('success', 'Proveedor actualizado exitosamente.');
        } catch (\Exception $e) {
            return back()->withInput()
                        ->with('error', 'Error al actualizar el proveedor: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Proveedor $proveedor)
    {
        try {
            // Verificar si tiene inventarios o reparaciones asociadas
            $totalInventarios = $proveedor->inventarios()->count();
            $totalReparaciones = $proveedor->reparaciones()->count();

            if ($totalInventarios > 0 || $totalReparaciones > 0) {
                return back()->with('error', 
                    "No se puede eliminar el proveedor porque tiene {$totalInventarios} inventarios y {$totalReparaciones} reparaciones asociadas. " .
                    "Puede desactivarlo en su lugar."
                );
            }

            $nombreEmpresa = $proveedor->nombre_empresa;
            $proveedor->delete();

            return redirect()->route('proveedores.index')
                           ->with('success', "Proveedor {$nombreEmpresa} eliminado exitosamente.");
        } catch (\Exception $e) {
            return back()->with('error', 'Error al eliminar el proveedor: ' . $e->getMessage());
        }
    }

    /**
     * Toggle provider status (activate/deactivate)
     */
    public function toggleStatus(Proveedor $proveedor)
    {
        try {
            $proveedor->update(['activo' => !$proveedor->activo]);
            
            $estado = $proveedor->activo ? 'activado' : 'desactivado';
            
            return response()->json([
                'success' => true,
                'message' => "Proveedor {$estado} exitosamente.",
                'activo' => $proveedor->activo,
                'estado_label' => $proveedor->estado_label,
                'estado_color' => $proveedor->estado_color
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al cambiar el estado del proveedor: ' . $e->getMessage()
            ], 422);
        }
    }

    /**
     * Get providers for API/AJAX requests
     */
    public function api(Request $request)
    {
        $query = Proveedor::activos();

        if ($request->filled('q')) {
            $query->buscar($request->q);
        }

        if ($request->filled('tipo_servicio')) {
            $query->where('tipo_servicio', $request->tipo_servicio);
        }

        $proveedores = $query->select('id', 'nombre_empresa', 'nombre_contacto', 'telefono', 'email', 'tipo_servicio')
                           ->limit(10)
                           ->get()
                           ->map(function($proveedor) {
                               return [
                                   'id' => $proveedor->id,
                                   'text' => $proveedor->nombre_completo,
                                   'email' => $proveedor->email,
                                   'telefono' => $proveedor->telefono,
                                   'tipo_servicio' => $proveedor->tipo_servicio_label
                               ];
                           });

        return response()->json($proveedores);
    }

    /**
     * Update provider rating
     */
    public function updateRating(Request $request, Proveedor $proveedor)
    {
        $validated = $request->validate([
            'calificacion' => 'required|numeric|min:0|max:5'
        ], [
            'calificacion.required' => 'La calificación es obligatoria.',
            'calificacion.min' => 'La calificación debe ser entre 0 y 5.',
            'calificacion.max' => 'La calificación debe ser entre 0 y 5.'
        ]);

        try {
            $proveedor->update(['calificacion' => $validated['calificacion']]);
            
            return response()->json([
                'success' => true,
                'message' => 'Calificación actualizada exitosamente.',
                'calificacion' => $proveedor->calificacion,
                'calificacion_estrellas' => $proveedor->calificacion_estrellas
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar la calificación: ' . $e->getMessage()
            ], 422);
        }
    }
}
