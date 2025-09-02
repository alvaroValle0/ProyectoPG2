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
        
        // Si el usuario no tiene permisos, verificar por rol
        if (!$user->permissions) {
            return self::canAccessByRole($user->rol, $module);
        }

        $permissionKey = 'access_' . $module;
        return $user->permissions->$permissionKey ?? false;
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
        
        // Si el usuario no tiene permisos, verificar por rol
        if (!$user->permissions) {
            return self::canActionByRole($user->rol, $action);
        }

        return $user->permissions->$action ?? false;
    }

    /**
     * Verificar acceso por rol (fallback cuando no hay permisos específicos)
     */
    private static function canAccessByRole($rol, $module)
    {
        $permissionsByRole = [
            'admin' => [
                'dashboard', 'clientes', 'equipos', 'reparaciones', 'inventario', 
                'tickets', 'tecnicos', 'usuarios', 'configuracion', 'reportes'
            ],
            'tecnico' => [
                'dashboard', 'clientes', 'equipos', 'reparaciones', 'inventario', 
                'tickets', 'reportes'
            ],
            'usuario' => [
                'dashboard', 'clientes', 'equipos', 'inventario', 'tickets'
            ]
        ];

        return in_array($module, $permissionsByRole[$rol] ?? []);
    }

    /**
     * Verificar acción por rol (fallback cuando no hay permisos específicos)
     */
    private static function canActionByRole($rol, $action)
    {
        $actionsByRole = [
            'admin' => [
                'create_equipo', 'edit_equipo', 'delete_equipo', 'view_equipo',
                'create_reparacion', 'edit_reparacion', 'delete_reparacion', 'view_reparacion',
                'create_cliente', 'edit_cliente', 'delete_cliente', 'view_cliente',
                'create_inventario', 'edit_inventario', 'delete_inventario', 'view_inventario',
                'create_ticket', 'edit_ticket', 'delete_ticket', 'view_ticket',
                'manage_users', 'manage_tecnicos', 'view_reports'
            ],
            'tecnico' => [
                'create_equipo', 'edit_equipo', 'view_equipo',
                'create_reparacion', 'edit_reparacion', 'view_reparacion',
                'create_cliente', 'edit_cliente', 'view_cliente',
                'create_inventario', 'edit_inventario', 'view_inventario',
                'create_ticket', 'edit_ticket', 'view_ticket',
                'view_reports'
            ],
            'usuario' => [
                'view_equipo', 'create_cliente', 'edit_cliente', 'view_cliente',
                'view_inventario', 'create_ticket', 'view_ticket'
            ]
        ];

        return in_array($action, $actionsByRole[$rol] ?? []);
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
        $availableModules = [];

        $allModules = [
            'dashboard' => [
                'name' => 'Dashboard',
                'icon' => 'fas fa-tachometer-alt',
                'route' => 'dashboard',
            ],
            'clientes' => [
                'name' => 'Clientes',
                'icon' => 'fas fa-users',
                'route' => 'clientes.index',
            ],
            'equipos' => [
                'name' => 'Gestión de Equipos',
                'icon' => 'fas fa-laptop',
                'route' => 'equipos.index',
            ],
            'reparaciones' => [
                'name' => 'Gestión de Reparaciones',
                'icon' => 'fas fa-wrench',
                'route' => 'reparaciones.index',
            ],
            'inventario' => [
                'name' => 'Inventario',
                'icon' => 'fas fa-boxes',
                'route' => 'inventario.index',
            ],
            'tickets' => [
                'name' => 'Tickets',
                'icon' => 'fas fa-ticket-alt',
                'route' => 'tickets.index',
            ],
            'tecnicos' => [
                'name' => 'Gestión de Técnicos',
                'icon' => 'fas fa-users-cog',
                'route' => 'tecnicos.index',
            ],
            'usuarios' => [
                'name' => 'Gestión de Usuarios',
                'icon' => 'fas fa-users',
                'route' => 'usuarios.index',
            ],
            'configuracion' => [
                'name' => 'Configuración',
                'icon' => 'fas fa-cog',
                'route' => 'configuracion.index',
            ],
        ];

        // Verificar cada módulo
        foreach ($allModules as $moduleKey => $moduleInfo) {
            if (self::canAccess($moduleKey)) {
                $availableModules[$moduleKey] = $moduleInfo;
            }
        }

        return $availableModules;
    }
}
