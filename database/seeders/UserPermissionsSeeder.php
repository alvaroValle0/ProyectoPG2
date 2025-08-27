<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserPermission;
use Illuminate\Database\Seeder;

class UserPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        foreach ($users as $user) {
            // Crear permisos según el rol del usuario
            $permissions = $this->getDefaultPermissions($user->rol);
            
            UserPermission::updateOrCreate(
                ['user_id' => $user->id],
                $permissions
            );
        }
    }

    /**
     * Obtener permisos por defecto según el rol
     */
    private function getDefaultPermissions($rol)
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
