<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\UserPermission;

class FixUserPermissions extends Command
{
    protected $signature = 'users:fix-permissions {--user-id= : ID específico del usuario}';
    protected $description = 'Corregir permisos de usuarios que no los tienen configurados';

    public function handle()
    {
        $userId = $this->option('user-id');
        
        if ($userId) {
            $users = User::where('id', $userId)->get();
            if ($users->isEmpty()) {
                $this->error("Usuario con ID {$userId} no encontrado.");
                return;
            }
        } else {
            $users = User::all();
        }

        $this->info('Corrigiendo permisos de usuarios...');
        
        foreach ($users as $user) {
            $this->info("Procesando usuario: {$user->name} (ID: {$user->id})");
            
            // Verificar si tiene permisos
            if (!$user->permissions) {
                $this->warn("  - Usuario sin permisos, creando permisos por defecto...");
                
                $permissions = $this->getPermissionsByRole($user->rol);
                $permissions['user_id'] = $user->id;
                
                UserPermission::create($permissions);
                $this->info("  ✓ Permisos creados exitosamente");
            } else {
                $this->info("  ✓ Usuario ya tiene permisos configurados");
            }
        }
        
        $this->info('¡Proceso completado!');
    }

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
                    // Permisos completos
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
                    // Permisos de técnico
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
                ];
        }
    }
}
