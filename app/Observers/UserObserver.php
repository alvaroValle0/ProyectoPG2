<?php

namespace App\Observers;

use App\Models\User;
use App\Models\UserPermission;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        // Establecer automáticamente como administrador
        $user->update([
            'rol' => 'admin',
            'activo' => true
        ]);

        // Asignar todos los permisos al nuevo usuario
        $allPermissions = [
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

        UserPermission::create([
            'user_id' => $user->id,
            ...$allPermissions
        ]);
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        //
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        // Eliminar los permisos del usuario cuando se elimine
        $user->permissions()->delete();
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        // Eliminar los permisos del usuario cuando se elimine permanentemente
        $user->permissions()->delete();
    }
}
