<?php

namespace App\Http\Controllers;

use App\Models\Tecnico;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TecnicoController extends Controller
{
    public function index()
    {
        $tecnicos = Tecnico::with(['user', 'reparacionesActivas'])
            ->orderBy('activo', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('reparaciones.tecnicos.index', compact('tecnicos'));
    }

    public function create()
    {
        // Usuarios que no son técnicos aún
        $usuarios = User::whereDoesntHave('tecnico')->get();
        
        return view('reparaciones.tecnicos.create', compact('usuarios'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id|unique:tecnicos,user_id',
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'telefono' => 'nullable|string|max:20',
            'email_personal' => 'nullable|email|max:255',
            'dpi' => 'nullable|string|max:20|unique:tecnicos,dpi',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'direccion' => 'nullable|string',
            'fecha_nacimiento' => 'nullable|date|before:today',
            'genero' => 'nullable|in:masculino,femenino,otro',
            'estado_civil' => 'nullable|string|max:255',
            'contacto_emergencia' => 'nullable|string',
            'fecha_contratacion' => 'nullable|date|before_or_equal:today',
            'nivel_experiencia' => 'nullable|in:principiante,intermedio,avanzado,experto',
            'especialidad' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'activo' => 'boolean'
        ]);

        try {
            // Manejar la carga de foto
            if ($request->hasFile('foto')) {
                $foto = $request->file('foto');
                
                // Verificación completa del archivo
                if ($foto && $foto->isValid() && $foto->getSize() > 0 && !empty($foto->getClientOriginalName())) {
                    $nombre = $request->nombres ?? 'tecnico';
                    $nombreSlug = Str::slug($nombre);
                    if (empty($nombreSlug)) {
                        $nombreSlug = 'tecnico';
                    }
                    
                    $extension = $foto->getClientOriginalExtension();
                    if (empty($extension)) {
                        $extension = $foto->guessExtension() ?: 'jpg';
                    }
                    
                    $nombreFoto = time() . '_' . $nombreSlug . '.' . $extension;
                    
                    // Crear directorio físico si no existe
                    $destinationPath = storage_path('app/public/tecnicos/fotos');
                    if (!file_exists($destinationPath)) {
                        mkdir($destinationPath, 0755, true);
                    }
                    
                    // Usar move en lugar de Storage para evitar problemas
                    if ($foto->move($destinationPath, $nombreFoto)) {
                        $validated['foto'] = $nombreFoto;
                    } else {
                        unset($validated['foto']);
                    }
                } else {
                    unset($validated['foto']);
                }
            }

            $tecnico = Tecnico::create($validated);
            
            return redirect()->route('tecnicos.show', $tecnico)
                ->with('success', 'Técnico registrado exitosamente con toda su información personal.');
        } catch (\Exception $e) {
            // Si hay error y se subió una foto, eliminarla
            if (isset($validated['foto']) && file_exists(storage_path('app/public/tecnicos/fotos/' . $validated['foto']))) {
                unlink(storage_path('app/public/tecnicos/fotos/' . $validated['foto']));
            }
            
            return back()->withInput()
                ->with('error', 'Error al registrar el técnico: ' . $e->getMessage());
        }
    }

    public function show(Tecnico $tecnico)
    {
        $tecnico->load([
            'user',
            'reparacionesActivas.equipo',
            'reparaciones' => function($query) {
                $query->latest()->limit(10);
            }
        ]);

        // Estadísticas del técnico
        $estadisticas = [
            'total_reparaciones' => $tecnico->total_reparaciones,
            'reparaciones_completadas' => $tecnico->reparaciones_completadas_count,
            'promedio_tiempo' => round($tecnico->promedio_tiempo_reparacion, 1)
        ];

        return view('reparaciones.tecnicos.show', compact('tecnico', 'estadisticas'));
    }

    public function edit(Tecnico $tecnico)
    {
        return view('reparaciones.tecnicos.edit', compact('tecnico'));
    }

    public function update(Request $request, Tecnico $tecnico)
    {
        $validated = $request->validate([
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'telefono' => 'nullable|string|max:20',
            'email_personal' => 'nullable|email|max:255',
            'dpi' => 'nullable|string|max:20|unique:tecnicos,dpi,' . $tecnico->id,
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'direccion' => 'nullable|string',
            'fecha_nacimiento' => 'nullable|date|before:today',
            'genero' => 'nullable|in:masculino,femenino,otro',
            'estado_civil' => 'nullable|string|max:255',
            'contacto_emergencia' => 'nullable|string',
            'fecha_contratacion' => 'nullable|date|before_or_equal:today',
            'nivel_experiencia' => 'nullable|in:principiante,intermedio,avanzado,experto',
            'especialidad' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'activo' => 'boolean'
        ]);

        try {
            $fotoAnterior = $tecnico->foto;
            
            // Manejar la carga de nueva foto
            if ($request->hasFile('foto')) {
                $foto = $request->file('foto');
                
                // Verificación completa del archivo
                if ($foto && $foto->isValid() && $foto->getSize() > 0 && !empty($foto->getClientOriginalName())) {
                    // Eliminar foto anterior si existe
                    if ($fotoAnterior && !empty($fotoAnterior)) {
                        $oldImagePath = storage_path('app/public/tecnicos/fotos/' . $fotoAnterior);
                        if (file_exists($oldImagePath)) {
                            unlink($oldImagePath);
                        }
                    }

                    $nombre = $request->nombres ?? 'tecnico';
                    $nombreSlug = Str::slug($nombre);
                    if (empty($nombreSlug)) {
                        $nombreSlug = 'tecnico';
                    }
                    
                    $extension = $foto->getClientOriginalExtension();
                    if (empty($extension)) {
                        $extension = $foto->guessExtension() ?: 'jpg';
                    }
                    
                    $nombreFoto = time() . '_' . $nombreSlug . '.' . $extension;
                    
                    // Crear directorio físico si no existe
                    $destinationPath = storage_path('app/public/tecnicos/fotos');
                    if (!file_exists($destinationPath)) {
                        mkdir($destinationPath, 0755, true);
                    }
                    
                    // Usar move en lugar de Storage para evitar problemas
                    if ($foto->move($destinationPath, $nombreFoto)) {
                        $validated['foto'] = $nombreFoto;
                    } else {
                        unset($validated['foto']);
                    }
                } else {
                    unset($validated['foto']);
                }
            }

            $tecnico->update($validated);
            
            return redirect()->route('tecnicos.show', $tecnico)
                ->with('success', 'Información del técnico actualizada exitosamente.');
        } catch (\Exception $e) {
            // Si hay error y se subió una nueva foto, eliminarla
            if (isset($validated['foto']) && file_exists(storage_path('app/public/tecnicos/fotos/' . $validated['foto']))) {
                unlink(storage_path('app/public/tecnicos/fotos/' . $validated['foto']));
            }
            
            return back()->withInput()
                ->with('error', 'Error al actualizar el técnico: ' . $e->getMessage());
        }
    }

    public function destroy(Tecnico $tecnico)
    {
        try {
            // Verificar si tiene reparaciones activas
            if ($tecnico->reparacionesActivas()->exists()) {
                return back()->with('error', 'No se puede eliminar un técnico con reparaciones activas.');
            }

            // Eliminar foto si existe
            if ($tecnico->foto && !empty($tecnico->foto)) {
                try {
                    $imagePath = storage_path('app/public/tecnicos/fotos/' . $tecnico->foto);
                    if (file_exists($imagePath)) {
                        unlink($imagePath);
                    }
                } catch (\Exception $e) {
                    // Log del error pero continuar con la eliminación
                }
            }

            $tecnico->delete();
            
            return redirect()->route('tecnicos.index')
                ->with('success', 'Técnico eliminado exitosamente.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al eliminar el técnico: ' . $e->getMessage());
        }
    }

    public function activar(Tecnico $tecnico)
    {
        try {
            $tecnico->update(['activo' => true]);
            
            return response()->json([
                'success' => true,
                'message' => 'Técnico activado exitosamente.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al activar el técnico: ' . $e->getMessage()
            ], 422);
        }
    }

    public function desactivar(Tecnico $tecnico)
    {
        try {
            // Verificar si tiene reparaciones activas
            if ($tecnico->reparacionesActivas()->exists()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se puede desactivar un técnico con reparaciones activas.'
                ], 422);
            }

            $tecnico->update(['activo' => false]);
            
            return response()->json([
                'success' => true,
                'message' => 'Técnico desactivado exitosamente.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al desactivar el técnico: ' . $e->getMessage()
            ], 422);
        }
    }



    public function rendimiento(Tecnico $tecnico)
    {
        $meses = 6;
        
        $rendimiento = $tecnico->reparacionesCompletadas()
            ->select([
                \DB::raw('DATE_FORMAT(fecha_fin, "%Y-%m") as mes'),
                \DB::raw('COUNT(*) as total'),
                \DB::raw('AVG(tiempo_real_horas) as promedio_tiempo'),
                \DB::raw('SUM(costo) as ingresos_total')
            ])
            ->where('fecha_fin', '>=', now()->subMonths($meses))
            ->groupBy('mes')
            ->orderBy('mes')
            ->get();

        return view('reparaciones.tecnicos.rendimiento', compact('tecnico', 'rendimiento'));
    }
}