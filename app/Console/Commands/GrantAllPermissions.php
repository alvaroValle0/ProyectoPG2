<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\UserPermission;
use Illuminate\Console\Command;

class GrantAllPermissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:grant-all-permissions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Otorga todos los permisos a todos los usuarios del sistema';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Iniciando proceso de otorgamiento de permisos...');

        $users = User::all();
        $this->info("Encontrados {$users->count()} usuarios.");

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

        $bar = $this->output->createProgressBar($users->count());
        $bar->start();

        foreach ($users as $user) {
            UserPermission::updateOrCreate(
                ['user_id' => $user->id],
                $allPermissions
            );
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info('¡Todos los permisos han sido otorgados exitosamente!');
        
        return Command::SUCCESS;
    }
}
