<?php

require_once 'vendor/autoload.php';

// Inicializar Laravel
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use App\Models\UserPermission;

echo "=== PRUEBA DE PERMISOS POR ROL ===\n\n";

// Función para obtener permisos según el rol (copiada del controlador)
function getPermissionsByRole($rol)
{
    switch ($rol) {
        case 'admin':
            return [
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
                'access_dashboard' => true,
                'access_clientes' => true,
                'access_equipos' => true,
                'access_reparaciones' => true,
                'access_inventario' => true,
                'access_tickets' => true,
                'access_tecnicos' => false,
                'access_usuarios' => false,
                'access_configuracion' => false,
                'access_reportes' => true,
                'create_equipo' => true,
                'edit_equipo' => true,
                'delete_equipo' => false,
                'view_equipo' => true,
                'create_reparacion' => true,
                'edit_reparacion' => true,
                'delete_reparacion' => false,
                'view_reparacion' => true,
                'create_cliente' => true,
                'edit_cliente' => true,
                'delete_cliente' => false,
                'view_cliente' => true,
                'create_inventario' => true,
                'edit_inventario' => true,
                'delete_inventario' => false,
                'view_inventario' => true,
                'create_ticket' => true,
                'edit_ticket' => true,
                'delete_ticket' => false,
                'view_ticket' => true,
                'manage_users' => false,
                'manage_tecnicos' => false,
            ];
            
        case 'usuario':
            return [
                'access_dashboard' => true,
                'access_clientes' => true,
                'access_equipos' => true,
                'access_reparaciones' => false,
                'access_inventario' => true,
                'access_tickets' => true,
                'access_tecnicos' => false,
                'access_usuarios' => false,
                'access_configuracion' => false,
                'access_reportes' => false,
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
                'delete_cliente' => false,
                'view_cliente' => true,
                'create_inventario' => false,
                'edit_inventario' => false,
                'delete_inventario' => false,
                'view_inventario' => true,
                'create_ticket' => true,
                'edit_ticket' => false,
                'delete_ticket' => false,
                'view_ticket' => true,
                'manage_users' => false,
                'manage_tecnicos' => false,
            ];
            
        default:
            return [
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

// Probar cada rol
$roles = ['admin', 'tecnico', 'usuario'];

foreach ($roles as $rol) {
    echo "=== ROL: {$rol} ===\n";
    $permissions = getPermissionsByRole($rol);
    
    echo "Módulos de acceso:\n";
    $accessModules = [
        'access_dashboard' => 'Dashboard',
        'access_clientes' => 'Clientes',
        'access_equipos' => 'Equipos',
        'access_reparaciones' => 'Reparaciones',
        'access_inventario' => 'Inventario',
        'access_tickets' => 'Tickets',
        'access_tecnicos' => 'Técnicos',
        'access_usuarios' => 'Usuarios',
        'access_configuracion' => 'Configuración',
        'access_reportes' => 'Reportes'
    ];
    
    foreach ($accessModules as $key => $name) {
        $status = $permissions[$key] ? '✅' : '❌';
        echo "  {$status} {$name}\n";
    }
    
    echo "\nPermisos específicos:\n";
    $specificPermissions = [
        'create_equipo' => 'Crear Equipos',
        'edit_equipo' => 'Editar Equipos',
        'delete_equipo' => 'Eliminar Equipos',
        'create_reparacion' => 'Crear Reparaciones',
        'edit_reparacion' => 'Editar Reparaciones',
        'delete_reparacion' => 'Eliminar Reparaciones',
        'create_cliente' => 'Crear Clientes',
        'edit_cliente' => 'Editar Clientes',
        'delete_cliente' => 'Eliminar Clientes',
        'manage_users' => 'Gestionar Usuarios',
        'manage_tecnicos' => 'Gestionar Técnicos'
    ];
    
    foreach ($specificPermissions as $key => $name) {
        $status = $permissions[$key] ? '✅' : '❌';
        echo "  {$status} {$name}\n";
    }
    
    echo "\n";
}

echo "=== FIN DE PRUEBA ===\n";
