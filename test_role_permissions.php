<?php

require_once 'vendor/autoload.php';

// Inicializar Laravel
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use App\Models\UserPermission;
use Illuminate\Support\Facades\Hash;

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

// Casos de prueba
$testCases = [
    [
        'name' => 'Administrador Test',
        'username' => 'admin_test',
        'email' => 'admin@test.com',
        'password' => 'password123',
        'rol' => 'admin'
    ],
    [
        'name' => 'Técnico Test',
        'username' => 'tecnico_test',
        'email' => 'tecnico@test.com',
        'password' => 'password123',
        'rol' => 'tecnico'
    ],
    [
        'name' => 'Usuario Test',
        'username' => 'usuario_test',
        'email' => 'usuario@test.com',
        'password' => 'password123',
        'rol' => 'usuario'
    ]
];

echo "Eliminando usuarios de prueba existentes...\n";
foreach ($testCases as $testUser) {
    $existingUser = User::where('email', $testUser['email'])->first();
    if ($existingUser) {
        $existingUser->delete();
        echo "Usuario {$testUser['email']} eliminado.\n";
    }
}

echo "\nCreando usuarios de prueba...\n";

foreach ($testCases as $testUser) {
    try {
        // Crear usuario
        $user = User::create([
            'name' => $testUser['name'],
            'username' => $testUser['username'],
            'email' => $testUser['email'],
            'password' => Hash::make($testUser['password']),
            'rol' => $testUser['rol'],
            'activo' => true
        ]);
        
        // Asignar permisos según el rol
        $permissions = getPermissionsByRole($testUser['rol']);
        $permissions['user_id'] = $user->id;
        
        UserPermission::create($permissions);
        
        echo "✅ Usuario creado: {$testUser['name']} ({$testUser['rol']})\n";
        echo "   Email: {$testUser['email']}\n";
        echo "   Password: {$testUser['password']}\n";
        
        // Mostrar permisos asignados
        echo "   Módulos de acceso:\n";
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
            echo "     {$status} {$name}\n";
        }
        
        echo "   Permisos específicos:\n";
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
            echo "     {$status} {$name}\n";
        }
        
        echo "\n";
        
    } catch (\Exception $e) {
        echo "❌ Error creando usuario {$testUser['email']}: " . $e->getMessage() . "\n";
    }
}

echo "=== FIN DE PRUEBA ===\n";
echo "\nUsuarios de prueba creados:\n";
echo "- Administrador: admin@test.com / password123\n";
echo "- Técnico: tecnico@test.com / password123\n";
echo "- Usuario: usuario@test.com / password123\n";
