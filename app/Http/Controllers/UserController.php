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
            'activo' => 'boolean',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
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
            
            // Manejar carga de avatar
            if ($request->hasFile('avatar')) {
                // Crear directorio si no existe
                $avatarPath = storage_path('app/public/avatars');
                if (!file_exists($avatarPath)) {
                    mkdir($avatarPath, 0755, true);
                }
                
                // Guardar avatar
                $avatar = $request->file('avatar');
                $avatarName = time() . '_avatar.' . $avatar->getClientOriginalExtension();
                $avatar->move($avatarPath, $avatarName);
                $validated['avatar'] = $avatarName;
            }

            $user = User::create($validated);
            
            // Crear permisos basados en el rol y los módulos seleccionados
            $permissions = $this->createPermissionsFromRoleAndModules($request, $validated['rol']);
            
            \Log::info('Permisos creados:', $permissions);
            
            $permissions['user_id'] = $user->id;
            UserPermission::create($permissions);
            
            $rolLabel = $user->rol_label;
            return redirect()->route('usuarios.show', $user)
                ->with('success', "Usuario creado exitosamente como {$rolLabel} con los módulos seleccionados.");
        } catch (\Exception $e) {
            \Log::error('Error al crear usuario: ' . $e->getMessage());
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
        // Cargar permisos del usuario
        $usuario->load('permissions');
        
        // Si no tiene permisos, crear unos por defecto basados en su rol
        if (!$usuario->permissions) {
            $defaultPermissions = $this->getPermissionsByRole($usuario->rol);
            $defaultPermissions['user_id'] = $usuario->id;
            UserPermission::create($defaultPermissions);
            $usuario->load('permissions');
        }
        
        return view('usuarios.edit', compact('usuario'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, User $usuario)
    {
        // Validación básica
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'rol' => 'required|in:admin,tecnico,usuario',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // ACTUALIZAR USUARIO DIRECTAMENTE
        $usuario->name = $request->name;
        $usuario->username = $request->username;
        $usuario->email = $request->email;
        $usuario->rol = $request->rol;
        $usuario->activo = $request->has('activo');
        
        if ($request->filled('password')) {
            $usuario->password = Hash::make($request->password);
        }
        
        // Manejar carga de avatar
        if ($request->hasFile('avatar')) {
            // Eliminar avatar anterior si existe
            if ($usuario->avatar && file_exists(storage_path('app/public/avatars/' . $usuario->avatar))) {
                unlink(storage_path('app/public/avatars/' . $usuario->avatar));
            }
            
            // Crear directorio si no existe
            $avatarPath = storage_path('app/public/avatars');
            if (!file_exists($avatarPath)) {
                mkdir($avatarPath, 0755, true);
            }
            
            // Guardar nuevo avatar
            $avatar = $request->file('avatar');
            $avatarName = time() . '_' . $usuario->id . '.' . $avatar->getClientOriginalExtension();
            $avatar->move($avatarPath, $avatarName);
            $usuario->avatar = $avatarName;
        }
        
        $usuario->save();
        
        // ACTUALIZAR PERMISOS DIRECTAMENTE
        $permissions = [
            'user_id' => $usuario->id,
            'access_dashboard' => $request->has('access_dashboard'),
            'access_clientes' => $request->has('access_clientes'),
            'access_equipos' => $request->has('access_equipos'),
            'access_reparaciones' => $request->has('access_reparaciones'),
            'access_inventario' => $request->has('access_inventario'),
            'access_tickets' => $request->has('access_tickets'),
            'access_tecnicos' => $request->has('access_tecnicos'),
            'access_usuarios' => $request->has('access_usuarios'),
            'access_configuracion' => $request->has('access_configuracion'),
            'access_reportes' => $request->has('access_reportes'),
            'create_equipo' => true,
            'edit_equipo' => true,
            'delete_equipo' => $request->rol === 'admin',
            'view_equipo' => true,
            'create_reparacion' => true,
            'edit_reparacion' => true,
            'delete_reparacion' => $request->rol === 'admin',
            'view_reparacion' => true,
            'create_cliente' => true,
            'edit_cliente' => true,
            'delete_cliente' => $request->rol === 'admin',
            'view_cliente' => true,
            'create_inventario' => true,
            'edit_inventario' => true,
            'delete_inventario' => $request->rol === 'admin',
            'view_inventario' => true,
            'create_ticket' => true,
            'edit_ticket' => true,
            'delete_ticket' => $request->rol === 'admin',
            'view_ticket' => true,
            'manage_users' => $request->rol === 'admin',
            'manage_tecnicos' => $request->rol === 'admin',
        ];
        
        UserPermission::updateOrCreate(['user_id' => $usuario->id], $permissions);
        
        return redirect()->route('usuarios.index')
            ->with('success', 'Usuario actualizado exitosamente.');
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $usuario)
    {
        try {
            \Log::info('=== INICIANDO ELIMINACIÓN DE USUARIO ===');
            \Log::info('Usuario a eliminar: ' . $usuario->name . ' (ID: ' . $usuario->id . ')');
            \Log::info('Rol del usuario: ' . $usuario->rol);
            \Log::info('Estado del usuario: ' . ($usuario->activo ? 'Activo' : 'Inactivo'));
            
            // Verificar que no sea el último administrador
            if ($usuario->rol === 'admin') {
                $adminCount = User::where('rol', 'admin')->where('activo', true)->count();
                if ($adminCount <= 1) {
                    \Log::warning('Intento de eliminar último administrador bloqueado');
                    return back()->with('error', 'No se puede eliminar el último administrador activo del sistema.');
                }
            }
            
            $nombreUsuario = $usuario->name;
            
            // Eliminar permisos del usuario primero
            if ($usuario->permissions) {
                $usuario->permissions->delete();
                \Log::info('✓ Permisos del usuario eliminados');
            }
            
            // Eliminar perfil técnico si existe
            if ($usuario->tecnico) {
                $usuario->tecnico->delete();
                \Log::info('✓ Perfil técnico eliminado');
            }
            
            // Eliminar el usuario
            $usuario->delete();
            \Log::info('✓ Usuario eliminado exitosamente');
            \Log::info('=== ELIMINACIÓN COMPLETADA ===');
            
            return redirect()->route('usuarios.index')
                ->with('success', "Usuario '{$nombreUsuario}' eliminado exitosamente junto con toda su información relacionada.");
        } catch (\Exception $e) {
            \Log::error('❌ ERROR al eliminar usuario: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            return back()->with('error', 'Error al eliminar el usuario: ' . $e->getMessage());
        }
    }

    /**
     * Toggle user active status.
     */
    public function toggleStatus(User $usuario)
    {
        try {
            // Permitir cambiar el estado de cualquier usuario sin restricciones
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
            
            // Asignar permisos básicos según el rol (para creación desde modal)
            $permissions = $this->getPermissionsByRole($validated['rol']);
            $permissions['user_id'] = $user->id;
            UserPermission::create($permissions);
            
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

    /**
     * Obtener permisos según el rol del usuario
     */
    private function getPermissionsByRole($rol)
    {
        switch ($rol) {
            case 'admin':
                return [
                    // Acceso a todos los módulos
                    'access_dashboard' => true,
                    'access_clientes' => true,
                    'access_equipos' => true,
                    'access_reparaciones' => true,
                    'access_inventario' => true,
                    'access_tickets' => true,
                    'access_tecnicos' => true,
                    'access_usuarios' => true,
                    'access_configuracion' => true,
                    'access_reportes' => true,
                    // Permisos completos en todos los módulos
                    'create_equipo' => true,
                    'edit_equipo' => true,
                    'delete_equipo' => true,
                    'view_equipo' => true,
                    'create_reparacion' => true,
                    'edit_reparacion' => true,
                    'delete_reparacion' => true,
                    'view_reparacion' => true,
                    'create_cliente' => true,
                    'edit_cliente' => true,
                    'delete_cliente' => true,
                    'view_cliente' => true,
                    'create_inventario' => true,
                    'edit_inventario' => true,
                    'delete_inventario' => true,
                    'view_inventario' => true,
                    'create_ticket' => true,
                    'edit_ticket' => true,
                    'delete_ticket' => true,
                    'view_ticket' => true,
                    'manage_users' => true,
                    'manage_tecnicos' => true,
                ];
                
            case 'tecnico':
                return [
                    // Acceso a módulos relevantes para técnicos
                    'access_dashboard' => true,
                    'access_clientes' => true,
                    'access_equipos' => true,
                    'access_reparaciones' => true,
                    'access_inventario' => true,
                    'access_tickets' => true,
                    'access_tecnicos' => false, // No pueden gestionar otros técnicos
                    'access_usuarios' => false, // No pueden gestionar usuarios
                    'access_configuracion' => false, // No pueden acceder a configuración
                    'access_reportes' => true,
                    // Permisos específicos para técnicos
                    'create_equipo' => true,
                    'edit_equipo' => true,
                    'delete_equipo' => false, // No pueden eliminar equipos
                    'view_equipo' => true,
                    'create_reparacion' => true,
                    'edit_reparacion' => true,
                    'delete_reparacion' => false, // No pueden eliminar reparaciones
                    'view_reparacion' => true,
                    'create_cliente' => true,
                    'edit_cliente' => true,
                    'delete_cliente' => false, // No pueden eliminar clientes
                    'view_cliente' => true,
                    'create_inventario' => true,
                    'edit_inventario' => true,
                    'delete_inventario' => false, // No pueden eliminar inventario
                    'view_inventario' => true,
                    'create_ticket' => true,
                    'edit_ticket' => true,
                    'delete_ticket' => false, // No pueden eliminar tickets
                    'view_ticket' => true,
                    'manage_users' => false, // No pueden gestionar usuarios
                    'manage_tecnicos' => false, // No pueden gestionar técnicos
                ];
                
            case 'usuario':
                return [
                    // Acceso limitado para usuarios regulares
                    'access_dashboard' => true,
                    'access_clientes' => true,
                    'access_equipos' => true,
                    'access_reparaciones' => false, // No pueden acceder a reparaciones
                    'access_inventario' => true,
                    'access_tickets' => true,
                    'access_tecnicos' => false, // No pueden acceder a gestión de técnicos
                    'access_usuarios' => false, // No pueden acceder a gestión de usuarios
                    'access_configuracion' => false, // No pueden acceder a configuración
                    'access_reportes' => false, // No pueden acceder a reportes
                    // Permisos limitados
                    'create_equipo' => false,
                    'edit_equipo' => false,
                    'delete_equipo' => false,
                    'view_equipo' => true,
                    'create_reparacion' => false,
                    'edit_reparacion' => false,
                    'delete_reparacion' => false,
                    'view_reparacion' => false,
                    'create_cliente' => true,
                    'edit_cliente' => true,
                    'delete_cliente' => false, // No pueden eliminar clientes
                    'view_cliente' => true,
                    'create_inventario' => false,
                    'edit_inventario' => false,
                    'delete_inventario' => false,
                    'view_inventario' => true,
                    'create_ticket' => true,
                    'edit_ticket' => false, // Solo pueden crear tickets, no editarlos
                    'delete_ticket' => false,
                    'view_ticket' => true,
                    'manage_users' => false,
                    'manage_tecnicos' => false,
                ];
                
            default:
                return [
                    // Permisos mínimos por defecto
                    'access_dashboard' => true,
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
                ];
        }
    }

    /**
     * Obtener permisos adicionales desde los checkboxes del formulario
     */
    private function getAdditionalPermissionsFromRequest($request)
    {
        $additionalPermissions = [];
        
        // Lista de permisos que pueden ser modificados por checkboxes
        $checkboxPermissions = [
            'access_dashboard', 'access_clientes', 'access_equipos', 'access_reparaciones',
            'access_inventario', 'access_tickets', 'access_tecnicos', 'access_usuarios',
            'access_configuracion', 'access_reportes'
        ];
        
        // Solo aplicar checkboxes si están explícitamente marcados
        // Si no están marcados, no se incluyen en additionalPermissions, 
        // por lo que se mantienen los permisos del rol
        foreach ($checkboxPermissions as $permission) {
            if ($request->has($permission)) {
                $additionalPermissions[$permission] = true;
            }
            // Si no está marcado, no se incluye en additionalPermissions
            // Esto permite que los permisos del rol se mantengan
        }
        
        return $additionalPermissions;
    }

    /**
     * Crear permisos basados en el rol y los módulos seleccionados
     */
    private function createPermissionsFromRoleAndModules($request, $rol)
    {
        // Lista de módulos que pueden ser seleccionados mediante checkboxes
        $modulePermissions = [
            'access_dashboard', 'access_clientes', 'access_equipos', 'access_reparaciones',
            'access_inventario', 'access_tickets', 'access_tecnicos', 'access_usuarios',
            'access_configuracion', 'access_reportes'
        ];

        $permissions = [];

        // Asignar permisos de módulos basados en checkboxes seleccionados
        foreach ($modulePermissions as $permission) {
            $permissions[$permission] = $request->has($permission);
        }

        // Validar que al menos un módulo haya sido seleccionado
        if (!in_array(true, $permissions)) {
            throw new \Exception('Debe seleccionar al menos un módulo de acceso para el usuario.');
        }

        // Asignar permisos específicos según el rol y los módulos seleccionados
        $permissions = array_merge($permissions, $this->getSpecificPermissionsByRoleAndModules($rol, $permissions));

        return $permissions;
    }

    /**
     * Obtener permisos específicos según el rol y los módulos seleccionados
     */
    private function getSpecificPermissionsByRoleAndModules($rol, $modulePermissions)
    {
        $specificPermissions = [];

        // Permisos base según el rol
        $rolePermissions = $this->getPermissionsByRole($rol);

        // Para cada módulo seleccionado, asignar los permisos específicos correspondientes
        if ($modulePermissions['access_equipos']) {
            $specificPermissions['create_equipo'] = $rolePermissions['create_equipo'];
            $specificPermissions['edit_equipo'] = $rolePermissions['edit_equipo'];
            $specificPermissions['delete_equipo'] = $rolePermissions['delete_equipo'];
            $specificPermissions['view_equipo'] = $rolePermissions['view_equipo'];
        } else {
            $specificPermissions['create_equipo'] = false;
            $specificPermissions['edit_equipo'] = false;
            $specificPermissions['delete_equipo'] = false;
            $specificPermissions['view_equipo'] = false;
        }

        if ($modulePermissions['access_reparaciones']) {
            $specificPermissions['create_reparacion'] = $rolePermissions['create_reparacion'];
            $specificPermissions['edit_reparacion'] = $rolePermissions['edit_reparacion'];
            $specificPermissions['delete_reparacion'] = $rolePermissions['delete_reparacion'];
            $specificPermissions['view_reparacion'] = $rolePermissions['view_reparacion'];
        } else {
            $specificPermissions['create_reparacion'] = false;
            $specificPermissions['edit_reparacion'] = false;
            $specificPermissions['delete_reparacion'] = false;
            $specificPermissions['view_reparacion'] = false;
        }

        if ($modulePermissions['access_clientes']) {
            $specificPermissions['create_cliente'] = $rolePermissions['create_cliente'];
            $specificPermissions['edit_cliente'] = $rolePermissions['edit_cliente'];
            $specificPermissions['delete_cliente'] = $rolePermissions['delete_cliente'];
            $specificPermissions['view_cliente'] = $rolePermissions['view_cliente'];
        } else {
            $specificPermissions['create_cliente'] = false;
            $specificPermissions['edit_cliente'] = false;
            $specificPermissions['delete_cliente'] = false;
            $specificPermissions['view_cliente'] = false;
        }

        if ($modulePermissions['access_inventario']) {
            $specificPermissions['create_inventario'] = $rolePermissions['create_inventario'];
            $specificPermissions['edit_inventario'] = $rolePermissions['edit_inventario'];
            $specificPermissions['delete_inventario'] = $rolePermissions['delete_inventario'];
            $specificPermissions['view_inventario'] = $rolePermissions['view_inventario'];
        } else {
            $specificPermissions['create_inventario'] = false;
            $specificPermissions['edit_inventario'] = false;
            $specificPermissions['delete_inventario'] = false;
            $specificPermissions['view_inventario'] = false;
        }

        if ($modulePermissions['access_tickets']) {
            $specificPermissions['create_ticket'] = $rolePermissions['create_ticket'];
            $specificPermissions['edit_ticket'] = $rolePermissions['edit_ticket'];
            $specificPermissions['delete_ticket'] = $rolePermissions['delete_ticket'];
            $specificPermissions['view_ticket'] = $rolePermissions['view_ticket'];
        } else {
            $specificPermissions['create_ticket'] = false;
            $specificPermissions['edit_ticket'] = false;
            $specificPermissions['delete_ticket'] = false;
            $specificPermissions['view_ticket'] = false;
        }

        // Permisos de gestión (siempre según el rol, independientemente de módulos)
        $specificPermissions['manage_users'] = $rolePermissions['manage_users'];
        $specificPermissions['manage_tecnicos'] = $rolePermissions['manage_tecnicos'];

        return $specificPermissions;
    }


}
