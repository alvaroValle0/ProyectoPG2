<?php

require_once 'vendor/autoload.php';

// Inicializar Laravel
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use App\Models\UserPermission;
use Illuminate\Support\Facades\Hash;

echo "=== PRUEBA DEL NUEVO SISTEMA DE PERMISOS ===\n\n";

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

// Función para crear permisos basados en checkboxes (simulada)
function createPermissionsFromCheckboxes($selectedModules, $rol)
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
        $permissions[$permission] = in_array($permission, $selectedModules);
    }

    // Asignar permisos específicos según el rol y los módulos seleccionados
    $permissions = array_merge($permissions, getSpecificPermissionsByRoleAndModules($rol, $permissions));

    return $permissions;
}

// Función para obtener permisos específicos según el rol y los módulos seleccionados
function getSpecificPermissionsByRoleAndModules($rol, $modulePermissions)
{
    $specificPermissions = [];

    // Permisos base según el rol
    $rolePermissions = getPermissionsByRole($rol);

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

// Casos de prueba
$testCases = [
    [
        'name' => 'Admin Completo',
        'rol' => 'admin',
        'modules' => ['access_dashboard', 'access_clientes', 'access_equipos', 'access_reparaciones', 'access_inventario', 'access_tickets', 'access_tecnicos', 'access_usuarios', 'access_configuracion', 'access_reportes']
    ],
    [
        'name' => 'Admin Limitado',
        'rol' => 'admin',
        'modules' => ['access_dashboard', 'access_clientes', 'access_equipos']
    ],
    [
        'name' => 'Técnico Completo',
        'rol' => 'tecnico',
        'modules' => ['access_dashboard', 'access_clientes', 'access_equipos', 'access_reparaciones', 'access_inventario', 'access_tickets', 'access_reportes']
    ],
    [
        'name' => 'Técnico Solo Equipos',
        'rol' => 'tecnico',
        'modules' => ['access_dashboard', 'access_equipos']
    ],
    [
        'name' => 'Usuario Básico',
        'rol' => 'usuario',
        'modules' => ['access_dashboard', 'access_clientes', 'access_equipos', 'access_inventario', 'access_tickets']
    ],
    [
        'name' => 'Usuario Solo Dashboard',
        'rol' => 'usuario',
        'modules' => ['access_dashboard']
    ]
];

echo "Ejecutando casos de prueba...\n\n";

foreach ($testCases as $index => $testCase) {
    echo "=== CASO DE PRUEBA " . ($index + 1) . ": {$testCase['name']} ===\n";
    echo "Rol: {$testCase['rol']}\n";
    echo "Módulos seleccionados: " . implode(', ', $testCase['modules']) . "\n\n";
    
    // Crear permisos
    $permissions = createPermissionsFromCheckboxes($testCase['modules'], $testCase['rol']);
    
    echo "Permisos resultantes:\n";
    
    // Mostrar módulos de acceso
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

echo "=== FIN DE PRUEBAS ===\n";
