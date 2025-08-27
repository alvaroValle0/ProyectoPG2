<?php

namespace App\Helpers;

class PermissionHelper
{
    /**
     * Verificar si el usuario tiene acceso a un módulo específico
     */
    public static function canAccess($module)
    {
        if (!auth()->check()) {
            return false;
        }

        $user = auth()->user();
        
        // Los administradores tienen acceso a todo
        if ($user->esAdmin()) {
            return true;
        }

        // Si el usuario tiene permisos personalizados, verificar esos
        if ($user->permissions) {
            $permissionField = 'access_' . $module;
            return $user->permissions->hasPermission($permissionField);
        }

        // Fallback al sistema de roles (para compatibilidad)
        $permissions = [
            'dashboard' => ['admin', 'tecnico', 'usuario'],
            'clientes' => ['admin', 'tecnico'],
            'equipos' => ['admin', 'tecnico'],
            'reparaciones' => ['admin', 'tecnico'],
            'inventario' => ['admin', 'tecnico'],
            'tickets' => ['admin', 'tecnico'],
            'tecnicos' => ['admin'],
            'usuarios' => ['admin'],
            'configuracion' => ['admin'],
            'reportes' => ['admin', 'tecnico'],
        ];

        return in_array($user->rol, $permissions[$module] ?? []);
    }

    /**
     * Verificar si el usuario puede realizar una acción específica
     */
    public static function can($action)
    {
        if (!auth()->check()) {
            return false;
        }

        $user = auth()->user();
        
        // Los administradores pueden hacer todo
        if ($user->esAdmin()) {
            return true;
        }

        // Si el usuario tiene permisos personalizados, verificar esos
        if ($user->permissions) {
            return $user->permissions->hasPermission($action);
        }

        // Fallback al sistema de roles (para compatibilidad)
        $permissions = [
            'create_equipo' => ['admin', 'tecnico'],
            'edit_equipo' => ['admin', 'tecnico'],
            'delete_equipo' => ['admin'],
            'create_reparacion' => ['admin', 'tecnico'],
            'edit_reparacion' => ['admin', 'tecnico'],
            'delete_reparacion' => ['admin'],
            'create_cliente' => ['admin', 'tecnico'],
            'edit_cliente' => ['admin', 'tecnico'],
            'delete_cliente' => ['admin'],
            'manage_users' => ['admin'],
            'manage_tecnicos' => ['admin'],
            'view_reports' => ['admin', 'tecnico'],
            'manage_inventory' => ['admin', 'tecnico'],
        ];

        return in_array($user->rol, $permissions[$action] ?? []);
    }

    /**
     * Obtener módulos disponibles para el usuario
     */
    public static function getAvailableModules()
    {
        if (!auth()->check()) {
            return [];
        }

        $user = auth()->user();
        
        $allModules = [
            'dashboard' => [
                'name' => 'Dashboard',
                'icon' => 'fas fa-tachometer-alt',
                'route' => 'dashboard',
                'roles' => ['admin', 'tecnico', 'usuario']
            ],
            'clientes' => [
                'name' => 'Clientes',
                'icon' => 'fas fa-users',
                'route' => 'clientes.index',
                'roles' => ['admin', 'tecnico']
            ],
            'equipos' => [
                'name' => 'Gestión de Equipos',
                'icon' => 'fas fa-laptop',
                'route' => 'equipos.index',
                'roles' => ['admin', 'tecnico']
            ],
            'reparaciones' => [
                'name' => 'Gestión de Reparaciones',
                'icon' => 'fas fa-wrench',
                'route' => 'reparaciones.index',
                'roles' => ['admin', 'tecnico']
            ],
            'inventario' => [
                'name' => 'Inventario',
                'icon' => 'fas fa-boxes',
                'route' => 'inventario.index',
                'roles' => ['admin', 'tecnico']
            ],
            'tickets' => [
                'name' => 'Tickets',
                'icon' => 'fas fa-ticket-alt',
                'route' => 'tickets.index',
                'roles' => ['admin', 'tecnico']
            ],
            'tecnicos' => [
                'name' => 'Gestión de Técnicos',
                'icon' => 'fas fa-users-cog',
                'route' => 'tecnicos.index',
                'roles' => ['admin']
            ],
            'usuarios' => [
                'name' => 'Gestión de Usuarios',
                'icon' => 'fas fa-users',
                'route' => 'usuarios.index',
                'roles' => ['admin']
            ],
            'configuracion' => [
                'name' => 'Configuración',
                'icon' => 'fas fa-cog',
                'route' => 'configuracion.index',
                'roles' => ['admin']
            ],
        ];

        $availableModules = [];
        
        foreach ($allModules as $key => $module) {
            if (in_array($user->rol, $module['roles'])) {
                $availableModules[$key] = $module;
            }
        }

        return $availableModules;
    }
}
