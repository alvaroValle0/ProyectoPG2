<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'username' => 'testuser',
            'email' => 'test@example.com',
            'rol' => 'admin',
            'activo' => true,
        ]);

        // Ejecutar el seeder de permisos para asignar permisos a todos los usuarios
        $this->call([
            UserPermissionsSeeder::class,
        ]);
    }
}
