<?php

namespace App\Http\Controllers;

use App\Models\Inventario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class InventarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Inventario::query();

        // Filtros
        if ($request->filled('buscar')) {
            $query->buscar($request->buscar);
        }

        if ($request->filled('categoria')) {
            $query->porCategoria($request->categoria);
        }

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        if ($request->filled('stock_status')) {
            switch ($request->stock_status) {
                case 'agotado':
                    $query->agotados();
                    break;
                case 'bajo':
                    $query->stockBajo();
                    break;
                case 'normal':
                    $query->whereRaw('stock_actual > stock_minimo');
                    break;
            }
        }

        // Ordenamiento
        $orden = $request->get('orden', 'nombre');
        $direccion = $request->get('direccion', 'asc');
        $query->orderBy($orden, $direccion);

        $inventario = $query->paginate(15);

        // Estadísticas
        $estadisticas = [
            'total_items' => Inventario::count(),
            'items_activos' => Inventario::activos()->count(),
            'items_agotados' => Inventario::agotados()->count(),
            'items_stock_bajo' => Inventario::stockBajo()->count(),
            'valor_total' => Inventario::sum(\DB::raw('stock_actual * precio_compra')),
            'categorias' => Inventario::distinct()->pluck('categoria')->count()
        ];

        // Categorías para filtros
        $categorias = Inventario::distinct()->pluck('categoria')->sort();

        return view('inventario.index', compact('inventario', 'estadisticas', 'categorias'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categorias = [
            'Componentes' => 'Componentes',
            'Periféricos' => 'Periféricos',
            'Software' => 'Software',
            'Herramientas' => 'Herramientas',
            'Consumibles' => 'Consumibles',
            'Equipos' => 'Equipos',
            'Repuestos' => 'Repuestos',
            'Otros' => 'Otros'
        ];

        return view('inventario.create', compact('categorias'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'codigo' => 'required|unique:inventario,codigo|max:50',
            'nombre' => 'required|max:255',
            'descripcion' => 'nullable|max:1000',
            'categoria' => 'required|max:100',
            'marca' => 'nullable|max:100',
            'modelo' => 'nullable|max:100',
            'serie' => 'nullable|max:100',
            'stock_minimo' => 'required|integer|min:0',
            'stock_actual' => 'required|integer|min:0',
            'precio_compra' => 'nullable|numeric|min:0',
            'precio_venta' => 'nullable|numeric|min:0',
            'proveedor' => 'nullable|max:255',
            'ubicacion' => 'nullable|max:255',
            'estado' => 'required|in:activo,inactivo,agotado,discontinuado',
            'fecha_compra' => 'nullable|date',
            'fecha_vencimiento' => 'nullable|date|after_or_equal:fecha_compra',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'notas' => 'nullable|max:1000'
        ]);

        $data = $request->all();

        // Manejo de imagen
        if ($request->hasFile('imagen')) {
            $imagen = $request->file('imagen');
            $nombreImagen = time() . '_' . Str::slug($request->nombre) . '.' . $imagen->getClientOriginalExtension();
            $imagen->storeAs('public/inventario', $nombreImagen);
            $data['imagen'] = $nombreImagen;
        }

        // Generar código automático si no se proporciona
        if (empty($data['codigo'])) {
            $data['codigo'] = 'INV-' . strtoupper(Str::random(8));
        }

        Inventario::create($data);

        return redirect()->route('inventario.index')
            ->with('success', 'Item de inventario creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Inventario $inventario)
    {
        return view('inventario.show', compact('inventario'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Inventario $inventario)
    {
        $categorias = [
            'Componentes' => 'Componentes',
            'Periféricos' => 'Periféricos',
            'Software' => 'Software',
            'Herramientas' => 'Herramientas',
            'Consumibles' => 'Consumibles',
            'Equipos' => 'Equipos',
            'Repuestos' => 'Repuestos',
            'Otros' => 'Otros'
        ];

        return view('inventario.edit', compact('inventario', 'categorias'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Inventario $inventario)
    {
        $request->validate([
            'codigo' => 'required|max:50|unique:inventario,codigo,' . $inventario->id,
            'nombre' => 'required|max:255',
            'descripcion' => 'nullable|max:1000',
            'categoria' => 'required|max:100',
            'marca' => 'nullable|max:100',
            'modelo' => 'nullable|max:100',
            'serie' => 'nullable|max:100',
            'stock_minimo' => 'required|integer|min:0',
            'stock_actual' => 'required|integer|min:0',
            'precio_compra' => 'nullable|numeric|min:0',
            'precio_venta' => 'nullable|numeric|min:0',
            'proveedor' => 'nullable|max:255',
            'ubicacion' => 'nullable|max:255',
            'estado' => 'required|in:activo,inactivo,agotado,discontinuado',
            'fecha_compra' => 'nullable|date',
            'fecha_vencimiento' => 'nullable|date|after_or_equal:fecha_compra',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'notas' => 'nullable|max:1000'
        ]);

        $data = $request->all();

        // Manejo de imagen
        if ($request->hasFile('imagen')) {
            // Eliminar imagen anterior si existe
            if ($inventario->imagen) {
                Storage::delete('public/inventario/' . $inventario->imagen);
            }

            $imagen = $request->file('imagen');
            $nombreImagen = time() . '_' . Str::slug($request->nombre) . '.' . $imagen->getClientOriginalExtension();
            $imagen->storeAs('public/inventario', $nombreImagen);
            $data['imagen'] = $nombreImagen;
        }

        $inventario->update($data);

        return redirect()->route('inventario.index')
            ->with('success', 'Item de inventario actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Inventario $inventario)
    {
        // Eliminar imagen si existe
        if ($inventario->imagen) {
            Storage::delete('public/inventario/' . $inventario->imagen);
        }

        $inventario->delete();

        return redirect()->route('inventario.index')
            ->with('success', 'Item de inventario eliminado exitosamente.');
    }

    /**
     * Cambiar estado del item
     */
    public function cambiarEstado(Request $request, Inventario $inventario)
    {
        $request->validate([
            'estado' => 'required|in:activo,inactivo,agotado,discontinuado'
        ]);

        $inventario->update(['estado' => $request->estado]);

        return response()->json([
            'success' => true,
            'message' => 'Estado actualizado exitosamente',
            'estado' => $inventario->estado,
            'estado_label' => $inventario->estado_label,
            'estado_color' => $inventario->estado_color
        ]);
    }

    /**
     * Ajustar stock
     */
    public function ajustarStock(Request $request, Inventario $inventario)
    {
        $request->validate([
            'tipo' => 'required|in:entrada,salida',
            'cantidad' => 'required|integer|min:1',
            'motivo' => 'required|max:255'
        ]);

        $cantidad = $request->cantidad;
        $tipo = $request->tipo;
        $motivo = $request->motivo;

        if ($tipo === 'entrada') {
            $inventario->incrementarStock($cantidad);
            $mensaje = "Stock incrementado en {$cantidad} unidades";
        } else {
            if ($inventario->decrementarStock($cantidad)) {
                $mensaje = "Stock decrementado en {$cantidad} unidades";
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Stock insuficiente para realizar la operación'
                ], 400);
            }
        }

        // Aquí podrías registrar el movimiento en una tabla de movimientos
        // MovimientoInventario::create([...]);

        return response()->json([
            'success' => true,
            'message' => $mensaje,
            'stock_actual' => $inventario->stock_actual,
            'stock_status' => $inventario->stock_status,
            'stock_status_label' => $inventario->stock_status_label,
            'stock_status_color' => $inventario->stock_status_color
        ]);
    }

    /**
     * API para búsquedas AJAX
     */
    public function api(Request $request)
    {
        $query = Inventario::activos();

        if ($request->filled('q')) {
            $query->buscar($request->q);
        }

        if ($request->filled('categoria')) {
            $query->porCategoria($request->categoria);
        }

        $items = $query->limit(10)->get(['id', 'codigo', 'nombre', 'stock_actual', 'precio_venta']);

        return response()->json($items);
    }

    /**
     * Reportes de inventario
     */
    public function reportes()
    {
        $estadisticas = [
            'total_items' => Inventario::count(),
            'items_activos' => Inventario::activos()->count(),
            'items_agotados' => Inventario::agotados()->count(),
            'items_stock_bajo' => Inventario::stockBajo()->count(),
            'valor_total' => Inventario::sum(\DB::raw('stock_actual * precio_compra')),
            'categorias' => Inventario::distinct()->pluck('categoria')->count()
        ];

        $itemsPorCategoria = Inventario::selectRaw('categoria, COUNT(*) as total')
            ->groupBy('categoria')
            ->orderBy('total', 'desc')
            ->get();

        $itemsAgotados = Inventario::agotados()->orderBy('nombre')->get();
        $itemsStockBajo = Inventario::stockBajo()->orderBy('nombre')->get();

        return view('inventario.reportes', compact('estadisticas', 'itemsPorCategoria', 'itemsAgotados', 'itemsStockBajo'));
    }

    /**
     * Exportar inventario
     */
    public function exportar(Request $request)
    {
        $query = Inventario::query();

        // Aplicar filtros si existen
        if ($request->filled('categoria')) {
            $query->porCategoria($request->categoria);
        }

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        $inventario = $query->get();

        // Generar CSV
        $filename = 'inventario_' . date('Y-m-d_H-i-s') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($inventario) {
            $file = fopen('php://output', 'w');
            
            // Headers del CSV
            fputcsv($file, [
                'Código', 'Nombre', 'Categoría', 'Marca', 'Modelo', 'Stock Actual',
                'Stock Mínimo', 'Precio Compra', 'Precio Venta', 'Proveedor',
                'Ubicación', 'Estado', 'Fecha Compra'
            ]);

            // Datos
            foreach ($inventario as $item) {
                fputcsv($file, [
                    $item->codigo,
                    $item->nombre,
                    $item->categoria,
                    $item->marca,
                    $item->modelo,
                    $item->stock_actual,
                    $item->stock_minimo,
                    $item->precio_compra,
                    $item->precio_venta,
                    $item->proveedor,
                    $item->ubicacion,
                    $item->estado_label,
                    $item->fecha_compra ? $item->fecha_compra->format('d/m/Y') : ''
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
