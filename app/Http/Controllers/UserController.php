<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of users with filters.
     */
    public function index(Request $request)
    {
        $query = User::query();

        // Filtro por rol
        if ($request->filled('rol')) {
            $query->where('rol', $request->rol);
        }

        // Filtro por estado
        if ($request->filled('estado')) {
            $activo = $request->estado === 'activo';
            $query->where('activo', $activo);
        }

        // Búsqueda por nombre o email
        if ($request->filled('buscar')) {
            $buscar = $request->buscar;
            $query->where(function($q) use ($buscar) {
                $q->where('name', 'like', "%{$buscar}%")
                  ->orWhere('email', 'like', "%{$buscar}%");
            });
        }

        $usuarios = $query->orderBy('created_at', 'desc')->paginate(15);

        // Estadísticas para el dashboard
        $estadisticas = [
            'total_usuarios' => User::count(),
            'usuarios_activos' => User::where('activo', true)->count(),
            'administradores' => User::where('rol', 'admin')->count(),
            'tecnicos' => User::where('rol', 'tecnico')->count(),
        ];

        return view('usuarios.index', compact('usuarios', 'estadisticas'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        return view('usuarios.create');
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'rol' => 'required|in:admin,tecnico,usuario',
            'activo' => 'boolean'
        ]);

        try {
            $validated['password'] = Hash::make($validated['password']);
            $validated['activo'] = $request->has('activo');

            $user = User::create($validated);
            
            return redirect()->route('usuarios.show', $user)
                ->with('success', 'Usuario creado exitosamente.');
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Error al crear el usuario: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified user.
     */
    public function show(User $usuario)
    {
        $usuario->load('tecnico');
        
        // Estadísticas del usuario si es técnico
        $estadisticas = null;
        if ($usuario->tecnico) {
            $estadisticas = [
                'total_reparaciones' => $usuario->tecnico->total_reparaciones,
                'reparaciones_completadas' => $usuario->tecnico->reparaciones_completadas_count,
                'carga_trabajo' => $usuario->tecnico->carga_trabajo,
                'promedio_tiempo' => $usuario->tecnico->promedio_tiempo_reparacion ? round($usuario->tecnico->promedio_tiempo_reparacion, 1) : null
            ];
        }

        return view('usuarios.show', compact('usuario', 'estadisticas'));
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $usuario)
    {
        return view('usuarios.edit', compact('usuario'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, User $usuario)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $usuario->id,
            'password' => 'nullable|string|min:8|confirmed',
            'rol' => 'required|in:admin,tecnico,usuario',
            'activo' => 'boolean'
        ]);

        try {
            // Solo actualizar contraseña si se proporciona
            if (!empty($validated['password'])) {
                $validated['password'] = Hash::make($validated['password']);
            } else {
                unset($validated['password']);
            }

            $validated['activo'] = $request->has('activo');

            $usuario->update($validated);
            
            return redirect()->route('usuarios.show', $usuario)
                ->with('success', 'Usuario actualizado exitosamente.');
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Error al actualizar el usuario: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $usuario)
    {
        try {
            // Verificar si el usuario tiene un técnico asociado con reparaciones
            if ($usuario->tecnico && $usuario->tecnico->reparaciones()->exists()) {
                return back()->with('error', 'No se puede eliminar un usuario que tiene reparaciones asociadas.');
            }

            // Verificar si es el único administrador
            if ($usuario->rol === 'admin' && User::where('rol', 'admin')->count() <= 1) {
                return back()->with('error', 'No se puede eliminar el último administrador del sistema.');
            }

            $usuario->delete();
            
            return redirect()->route('usuarios.index')
                ->with('success', 'Usuario eliminado exitosamente.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al eliminar el usuario: ' . $e->getMessage());
        }
    }

    /**
     * Toggle user active status.
     */
    public function toggleStatus(User $usuario)
    {
        try {
            // Verificar si es el único administrador activo
            if ($usuario->rol === 'admin' && $usuario->activo && User::where('rol', 'admin')->where('activo', true)->count() <= 1) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se puede desactivar el último administrador activo del sistema.'
                ]);
            }

            $usuario->update(['activo' => !$usuario->activo]);
            
            return response()->json([
                'success' => true,
                'message' => 'Estado del usuario actualizado exitosamente.',
                'estado' => $usuario->activo
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al cambiar el estado del usuario.'
            ]);
        }
    }

    /**
     * API endpoint for creating users from other modules.
     */
    public function storeFromModal(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'rol' => 'required|in:admin,tecnico,usuario',
        ]);

        try {
            $validated['password'] = Hash::make($validated['password']);
            $validated['activo'] = true; // Por defecto activo

            $user = User::create($validated);
            
            return response()->json([
                'success' => true,
                'message' => 'Usuario creado exitosamente.',
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'rol' => $user->rol
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al crear el usuario: ' . $e->getMessage()
            ], 422);
        }
    }
}
