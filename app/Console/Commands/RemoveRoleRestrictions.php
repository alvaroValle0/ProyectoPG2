<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class RemoveRoleRestrictions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:remove-role-restrictions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Elimina todas las restricciones de roles y establece todos los usuarios como administradores';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Iniciando proceso de eliminación de restricciones de roles...');

        $users = User::all();
        $this->info("Encontrados {$users->count()} usuarios.");

        $bar = $this->output->createProgressBar($users->count());
        $bar->start();

        foreach ($users as $user) {
            // Establecer todos los usuarios como administradores
            $user->update([
                'rol' => 'admin',
                'activo' => true
            ]);
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info('¡Todas las restricciones de roles han sido eliminadas!');
        $this->info('Todos los usuarios ahora tienen rol de administrador.');
        
        return Command::SUCCESS;
    }
}
