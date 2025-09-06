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
        // NO hacer nada automáticamente - dejar que el controlador maneje los permisos
        // Los permisos se crean desde el UserController según el rol y módulos seleccionados
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
