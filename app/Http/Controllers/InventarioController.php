<?php

namespace App\Http\Controllers;

use App\Models\Inventario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
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
            'codigo' => 'nullable|unique:inventario,codigo|max:50',
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

        // Limpiar campos vacíos que puedan causar problemas
        $data = array_filter($data, function($value) {
            return $value !== '' && $value !== null;
        });

        // Manejo de imagen - simplificado para evitar errores
        if ($request->hasFile('imagen')) {
            $imagen = $request->file('imagen');
            
            // Verificación completa del archivo
            if ($imagen && $imagen->isValid() && $imagen->getSize() > 0 && !empty($imagen->getClientOriginalName())) {
                try {
                    $nombre = $request->nombre ?? 'inventario';
                    $nombreSlug = Str::slug($nombre);
                    if (empty($nombreSlug)) {
                        $nombreSlug = 'inventario';
                    }
                    
                    $extension = $imagen->getClientOriginalExtension();
                    if (empty($extension)) {
                        $extension = $imagen->guessExtension() ?: 'jpg';
                    }
                    
                    $nombreImagen = time() . '_' . $nombreSlug . '.' . $extension;
                    
                    // Crear directorio físico si no existe
                    $destinationPath = storage_path('app/public/inventario');
                    if (!file_exists($destinationPath)) {
                        mkdir($destinationPath, 0755, true);
                    }
                    
                    // Usar move en lugar de Storage para evitar problemas
                    if ($imagen->move($destinationPath, $nombreImagen)) {
                        $data['imagen'] = $nombreImagen;
                        Log::info('Imagen guardada exitosamente: ' . $nombreImagen);
                    } else {
                        Log::warning('No se pudo mover la imagen');
                        unset($data['imagen']);
                    }
                } catch (\Exception $e) {
                    Log::error('Error al procesar imagen: ' . $e->getMessage());
                    // Si hay error con la imagen, continuar sin ella
                    unset($data['imagen']);
                }
            } else {
                // Archivo no válido o vacío
                Log::warning('Archivo de imagen no válido, vacío o sin nombre');
                unset($data['imagen']);
            }
        } else {
            // No hay archivo de imagen
            unset($data['imagen']);
        }

        // Generar código automático si no se proporciona
        if (empty($data['codigo'])) {
            $intentos = 0;
            do {
                $codigo = 'INV-' . strtoupper(Str::random(8));
                $intentos++;
                if ($intentos > 10) {
                    $codigo = 'INV-' . time() . '-' . rand(1000, 9999);
                    break;
                }
            } while (Inventario::where('codigo', $codigo)->exists());
            $data['codigo'] = $codigo;
        }
        
        // Asegurar que los campos de fecha sean null si están vacíos
        if (empty($data['fecha_compra'])) {
            $data['fecha_compra'] = null;
        }
        if (empty($data['fecha_vencimiento'])) {
            $data['fecha_vencimiento'] = null;
        }
        
        // Asegurar que los campos numéricos sean null si están vacíos
        if (empty($data['precio_compra'])) {
            $data['precio_compra'] = null;
        }
        if (empty($data['precio_venta'])) {
            $data['precio_venta'] = null;
        }

        // Validar que los datos estén completos antes de crear
        if (empty($data['codigo']) || empty($data['nombre']) || empty($data['categoria']) || 
            !isset($data['stock_minimo']) || !isset($data['stock_actual']) || empty($data['estado'])) {
            return back()->withErrors(['error' => 'Faltan campos obligatorios'])->withInput();
        }

        // Asegurar que el código sea único
        if (Inventario::where('codigo', $data['codigo'])->exists()) {
            return back()->withErrors(['codigo' => 'El código ya existe en el sistema'])->withInput();
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

        // Limpiar campos vacíos que puedan causar problemas
        $data = array_filter($data, function($value) {
            return $value !== '' && $value !== null;
        });

        // Manejo de imagen - simplificado para evitar errores
        if ($request->hasFile('imagen')) {
            $imagen = $request->file('imagen');
            
            // Verificación completa del archivo
            if ($imagen && $imagen->isValid() && $imagen->getSize() > 0 && !empty($imagen->getClientOriginalName())) {
                try {
                    // Eliminar imagen anterior si existe
                    if ($inventario->imagen && !empty($inventario->imagen)) {
                        $oldImagePath = storage_path('app/public/inventario/' . $inventario->imagen);
                        if (file_exists($oldImagePath)) {
                            unlink($oldImagePath);
                            Log::info('Imagen anterior eliminada: ' . $inventario->imagen);
                        }
                    }

                    $nombre = $request->nombre ?? 'inventario';
                    $nombreSlug = Str::slug($nombre);
                    if (empty($nombreSlug)) {
                        $nombreSlug = 'inventario';
                    }
                    
                    $extension = $imagen->getClientOriginalExtension();
                    if (empty($extension)) {
                        $extension = $imagen->guessExtension() ?: 'jpg';
                    }
                    
                    $nombreImagen = time() . '_' . $nombreSlug . '.' . $extension;
                    
                    // Crear directorio físico si no existe
                    $destinationPath = storage_path('app/public/inventario');
                    if (!file_exists($destinationPath)) {
                        mkdir($destinationPath, 0755, true);
                    }
                    
                    // Usar move en lugar de Storage para evitar problemas
                    if ($imagen->move($destinationPath, $nombreImagen)) {
                        $data['imagen'] = $nombreImagen;
                        Log::info('Imagen actualizada exitosamente: ' . $nombreImagen);
                    } else {
                        Log::warning('No se pudo mover la imagen en update');
                        unset($data['imagen']);
                    }
                } catch (\Exception $e) {
                    Log::error('Error al procesar imagen en update: ' . $e->getMessage());
                    // Si hay error con la imagen, no modificar el campo
                    unset($data['imagen']);
                }
            } else {
                // Archivo no válido o vacío
                Log::warning('Archivo de imagen no válido, vacío o sin nombre en update');
                unset($data['imagen']);
            }
        } else {
            // No modificar el campo imagen si no se sube una nueva
            unset($data['imagen']);
        }

        // Asegurar que los campos de fecha sean null si están vacíos
        if (empty($data['fecha_compra'])) {
            $data['fecha_compra'] = null;
        }
        if (empty($data['fecha_vencimiento'])) {
            $data['fecha_vencimiento'] = null;
        }
        
        // Asegurar que los campos numéricos sean null si están vacíos
        if (empty($data['precio_compra'])) {
            $data['precio_compra'] = null;
        }
        if (empty($data['precio_venta'])) {
            $data['precio_venta'] = null;
        }

        // Validar que los datos estén completos antes de actualizar
        if (empty($data['codigo']) || empty($data['nombre']) || empty($data['categoria']) || 
            !isset($data['stock_minimo']) || !isset($data['stock_actual']) || empty($data['estado'])) {
            return back()->withErrors(['error' => 'Faltan campos obligatorios'])->withInput();
        }

        // Asegurar que el código sea único (excluyendo el item actual)
        if (Inventario::where('codigo', $data['codigo'])->where('id', '!=', $inventario->id)->exists()) {
            return back()->withErrors(['codigo' => 'El código ya existe en el sistema'])->withInput();
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
        if ($inventario->imagen && !empty($inventario->imagen)) {
            try {
                $imagePath = storage_path('app/public/inventario/' . $inventario->imagen);
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                    Log::info('Imagen eliminada: ' . $inventario->imagen);
                }
            } catch (\Exception $e) {
                // Log del error pero continuar con la eliminación
                Log::warning('No se pudo eliminar la imagen: ' . $e->getMessage());
            }
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
        try {
            $query = Inventario::query();

            // Aplicar filtros si existen
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

            $inventario = $query->orderBy('nombre')->get();

            // Generar CSV con codificación UTF-8 BOM para Excel
            $filename = 'inventario_' . now()->format('Y-m-d_H-i-s') . '.csv';
            
            // Crear contenido CSV
            $csvContent = '';
            
            // BOM para UTF-8 (para que Excel reconozca los caracteres especiales)
            $csvContent .= "\xEF\xBB\xBF";
            
            // Headers del CSV
            $headers = [
                'Código', 'Nombre', 'Categoría', 'Marca', 'Modelo', 'Serie',
                'Stock Actual', 'Stock Mínimo', 'Estado Stock', 
                'Precio Compra (Q)', 'Precio Venta (Q)', 'Margen (%)',
                'Proveedor', 'Ubicación', 'Estado', 'Fecha Compra', 'Fecha Vencimiento',
                'Descripción', 'Notas'
            ];
            
            $csvContent .= '"' . implode('","', $headers) . '"' . "\n";

            // Datos
            foreach ($inventario as $item) {
                $row = [
                    $item->codigo ?? '',
                    $item->nombre ?? '',
                    $item->categoria ?? '',
                    $item->marca ?? '',
                    $item->modelo ?? '',
                    $item->serie ?? '',
                    $item->stock_actual ?? 0,
                    $item->stock_minimo ?? 0,
                    $item->stock_status_label ?? '',
                    $item->precio_compra ? number_format((float)$item->precio_compra, 2) : '',
                    $item->precio_venta ? number_format((float)$item->precio_venta, 2) : '',
                    $item->margen_ganancia ? number_format((float)$item->margen_ganancia, 1) . '%' : '',
                    $item->proveedor ?? '',
                    $item->ubicacion ?? '',
                    $item->estado_label ?? '',
                    $item->fecha_compra ? \Carbon\Carbon::parse($item->fecha_compra)->format('d/m/Y') : '',
                    $item->fecha_vencimiento ? \Carbon\Carbon::parse($item->fecha_vencimiento)->format('d/m/Y') : '',
                    $item->descripcion ?? '',
                    $item->notas ?? ''
                ];
                
                // Escapar comillas dobles en los valores
                $row = array_map(function($value) {
                    return str_replace('"', '""', $value);
                }, $row);
                
                $csvContent .= '"' . implode('","', $row) . '"' . "\n";
            }

            // Configurar headers para descarga
            $headers = [
                'Content-Type' => 'text/csv; charset=UTF-8',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
                'Content-Length' => strlen($csvContent),
                'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
                'Pragma' => 'public'
            ];

            return response($csvContent, 200, $headers);

        } catch (\Exception $e) {
            Log::error('Error al exportar inventario: ' . $e->getMessage());
            
            return back()->with('error', 'Error al exportar el inventario. Por favor, inténtelo nuevamente.');
        }
    }
}
