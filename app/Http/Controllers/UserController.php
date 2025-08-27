<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserPermission;
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

        // Búsqueda por nombre, username o email
        if ($request->filled('buscar')) {
            $buscar = $request->buscar;
            $query->where(function($q) use ($buscar) {
                $q->where('name', 'like', "%{$buscar}%")
                  ->orWhere('username', 'like', "%{$buscar}%")
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
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'rol' => 'required|in:admin,tecnico,usuario',
            'activo' => 'boolean'
        ], [
            'name.required' => 'El nombre es obligatorio.',
            'username.required' => 'El nombre de usuario es obligatorio.',
            'username.unique' => 'Este nombre de usuario ya está en uso.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'Debe ser un correo electrónico válido.',
            'email.unique' => 'Este correo electrónico ya está registrado.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
            'rol.required' => 'El rol es obligatorio.',
            'rol.in' => 'El rol seleccionado no es válido.'
        ]);

        try {
            $validated['password'] = Hash::make($validated['password']);
            $validated['activo'] = $request->has('activo');

            $user = User::create($validated);
            
            // Crear permisos para el usuario basados ÚNICAMENTE en los checkboxes seleccionados
            $permissions = [];
            $modulePermissions = [
                'access_dashboard', 'access_clientes', 'access_equipos', 'access_reparaciones',
                'access_inventario', 'access_tickets', 'access_tecnicos', 'access_usuarios',
                'access_configuracion', 'access_reportes'
            ];

            // Usar ÚNICAMENTE los checkboxes seleccionados por el usuario
            foreach ($modulePermissions as $permission) {
                $permissions[$permission] = $request->has($permission);
            }

            // Validar que al menos un módulo haya sido seleccionado
            if (!in_array(true, $permissions)) {
                return back()->withInput()
                    ->with('error', 'Debe seleccionar al menos un módulo de acceso para el usuario.');
            }

            // Establecer todos los permisos específicos en false (no se usan)
            $specificPermissions = [
                'create_equipo', 'edit_equipo', 'delete_equipo', 'view_equipo',
                'create_reparacion', 'edit_reparacion', 'delete_reparacion', 'view_reparacion',
                'create_cliente', 'edit_cliente', 'delete_cliente', 'view_cliente',
                'create_inventario', 'edit_inventario', 'delete_inventario', 'view_inventario',
                'create_ticket', 'edit_ticket', 'delete_ticket', 'view_ticket',
                'manage_users', 'manage_tecnicos'
            ];

            foreach ($specificPermissions as $permission) {
                $permissions[$permission] = false;
            }

            $permissions['user_id'] = $user->id;
            UserPermission::create($permissions);
            
            return redirect()->route('usuarios.show', $user)
                ->with('success', 'Usuario creado exitosamente con los módulos de acceso seleccionados mediante checkboxes.');
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
            'username' => 'required|string|max:255|unique:users,username,' . $usuario->id,
            'email' => 'required|string|email|max:255|unique:users,email,' . $usuario->id,
            'password' => 'nullable|string|min:8|confirmed',
            'rol' => 'required|in:admin,tecnico,usuario',
            'activo' => 'boolean'
        ], [
            'name.required' => 'El nombre es obligatorio.',
            'username.required' => 'El nombre de usuario es obligatorio.',
            'username.unique' => 'Este nombre de usuario ya está en uso.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'Debe ser un correo electrónico válido.',
            'email.unique' => 'Este correo electrónico ya está registrado.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
            'rol.required' => 'El rol es obligatorio.',
            'rol.in' => 'El rol seleccionado no es válido.'
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

    /**
     * Show the permissions management form for a user.
     */
    public function permissions(User $usuario)
    {
        // Obtener o crear permisos para el usuario
        $permissions = $usuario->permissions ?? UserPermission::create([
            'user_id' => $usuario->id,
            'access_dashboard' => false,
            'access_clientes' => false,
            'access_equipos' => false,
            'access_reparaciones' => false,
            'access_inventario' => false,
            'access_tickets' => false,
            'access_tecnicos' => false,
            'access_usuarios' => false,
            'access_configuracion' => false,
            'access_reportes' => false,
            'create_equipo' => false,
            'edit_equipo' => false,
            'delete_equipo' => false,
            'view_equipo' => false,
            'create_reparacion' => false,
            'edit_reparacion' => false,
            'delete_reparacion' => false,
            'view_reparacion' => false,
            'create_cliente' => false,
            'edit_cliente' => false,
            'delete_cliente' => false,
            'view_cliente' => false,
            'create_inventario' => false,
            'edit_inventario' => false,
            'delete_inventario' => false,
            'view_inventario' => false,
            'create_ticket' => false,
            'edit_ticket' => false,
            'delete_ticket' => false,
            'view_ticket' => false,
            'manage_users' => false,
            'manage_tecnicos' => false,
        ]);

        return view('usuarios.permissions', compact('usuario', 'permissions'));
    }

    /**
     * Update user permissions.
     */
    public function updatePermissions(Request $request, User $usuario)
    {
        try {
            // Obtener o crear permisos para el usuario
            $permissions = $usuario->permissions ?? UserPermission::create([
                'user_id' => $usuario->id
            ]);

            // Lista de módulos principales (solo checkboxes)
            $modulePermissions = [
                'access_dashboard', 'access_clientes', 'access_equipos', 'access_reparaciones',
                'access_inventario', 'access_tickets', 'access_tecnicos', 'access_usuarios',
                'access_configuracion', 'access_reportes'
            ];

            // Validar que al menos un módulo haya sido seleccionado mediante checkboxes
            $hasModuleSelected = false;
            foreach ($modulePermissions as $permission) {
                if ($request->has($permission)) {
                    $hasModuleSelected = true;
                    break;
                }
            }

            if (!$hasModuleSelected) {
                return back()->withInput()
                    ->with('error', 'Debe seleccionar al menos un módulo de acceso mediante checkboxes.');
            }

            // Actualizar ÚNICAMENTE los módulos principales basado en los checkboxes seleccionados
            foreach ($modulePermissions as $permission) {
                $permissions->$permission = $request->has($permission);
            }

            // Establecer todos los permisos específicos en false (no se usan)
            $specificPermissions = [
                'create_equipo', 'edit_equipo', 'delete_equipo', 'view_equipo',
                'create_reparacion', 'edit_reparacion', 'delete_reparacion', 'view_reparacion',
                'create_cliente', 'edit_cliente', 'delete_cliente', 'view_cliente',
                'create_inventario', 'edit_inventario', 'delete_inventario', 'view_inventario',
                'create_ticket', 'edit_ticket', 'delete_ticket', 'view_ticket',
                'manage_users', 'manage_tecnicos'
            ];

            foreach ($specificPermissions as $permission) {
                $permissions->$permission = false;
            }

            $permissions->save();

            return redirect()->route('usuarios.show', $usuario)
                ->with('success', 'Módulos de acceso actualizados exitosamente mediante checkboxes.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al actualizar los módulos: ' . $e->getMessage());
        }
    }


}
