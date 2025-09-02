<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\UserPermission;
use Illuminate\Console\Command;

class UpdateUserPermissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:update-permissions {--user-id= : ID específico del usuario} {--all : Actualizar todos los usuarios}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Actualizar permisos de usuarios según su rol';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $userId = $this->option('user-id');
        $updateAll = $this->option('all');

        if ($userId) {
            $user = User::find($userId);
            if (!$user) {
                $this->error("Usuario con ID {$userId} no encontrado.");
                return 1;
            }
            $this->updateUserPermissions($user);
        } elseif ($updateAll) {
            $users = User::all();
            $this->info("Actualizando permisos para {$users->count()} usuarios...");
            
            $bar = $this->output->createProgressBar($users->count());
            $bar->start();
            
            foreach ($users as $user) {
                $this->updateUserPermissions($user, false);
                $bar->advance();
            }
            
            $bar->finish();
            $this->newLine();
            $this->info('Permisos actualizados para todos los usuarios.');
        } else {
            $this->error('Debe especificar --user-id o --all');
            return 1;
        }

        return 0;
    }

    /**
     * Actualizar permisos de un usuario específico
     */
    private function updateUserPermissions(User $user, bool $showOutput = true)
    {
        $permissions = $this->getPermissionsByRole($user->rol);
        $permissions['user_id'] = $user->id;

        UserPermission::updateOrCreate(
            ['user_id' => $user->id],
            $permissions
        );

        if ($showOutput) {
            $this->info("Permisos actualizados para usuario: {$user->name} ({$user->rol})");
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
                    'access_tecnicos' => false,
                    'access_usuarios' => false,
                    'access_configuracion' => false,
                    'access_reportes' => true,
                    // Permisos específicos para técnicos
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
                    // Acceso limitado para usuarios regulares
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
}
