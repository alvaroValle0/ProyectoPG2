<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Str;

class AddUsernameToUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener todos los usuarios que no tienen username
        $users = User::whereNull('username')->orWhere('username', '')->get();
        
        foreach ($users as $user) {
            // Generar un username basado en el nombre
            $baseUsername = Str::slug($user->name, '');
            $username = $baseUsername;
            $counter = 1;
            
            // Verificar que el username sea único
            while (User::where('username', $username)->where('id', '!=', $user->id)->exists()) {
                $username = $baseUsername . $counter;
                $counter++;
            }
            
            // Actualizar el usuario con el username generado
            $user->update(['username' => $username]);
            
            $this->command->info("Usuario {$user->name} actualizado con username: {$username}");
        }
        
        $this->command->info('Proceso completado. Todos los usuarios tienen username.');
    }
}
