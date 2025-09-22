<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Tecnico;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TecnicoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Datos de técnicos con información completa
        $tecnicos = [
            [
                'user_data' => [
                    'name' => 'Carlos Eduardo',
                    'username' => 'carlos.mendez',
                    'email' => 'carlos.mendez@empresa.com',
                    'password' => Hash::make('password123'),
                    'rol' => 'tecnico',
                    'activo' => true,
                ],
                'tecnico_data' => [
                    'nombres' => 'Carlos Eduardo',
                    'apellidos' => 'Méndez García',
                    'telefono' => '+502 5555-1234',
                    'email_personal' => 'carlos.mendez.personal@gmail.com',
                    'dpi' => '1234567890123',
                    'direccion' => 'Zona 10, Ciudad de Guatemala, Guatemala',
                    'fecha_nacimiento' => '1985-03-15',
                    'genero' => 'masculino',
                    'estado_civil' => 'Casado',
                    'contacto_emergencia' => 'María García - Esposa - +502 5555-5678',
                    'especialidad' => 'Reparación de Hardware y Software',
                    'activo' => true,
                    'descripcion' => 'Técnico especializado en reparación de equipos de cómputo con más de 15 años de experiencia. Experto en diagnóstico y reparación de laptops, desktops y equipos de red.',
                ]
            ],
            [
                'user_data' => [
                    'name' => 'Ana Sofía',
                    'username' => 'ana.rodriguez',
                    'email' => 'ana.rodriguez@empresa.com',
                    'password' => Hash::make('password123'),
                    'rol' => 'tecnico',
                    'activo' => true,
                ],
                'tecnico_data' => [
                    'nombres' => 'Ana Sofía',
                    'apellidos' => 'Rodríguez López',
                    'telefono' => '+502 5555-2345',
                    'email_personal' => 'ana.rodriguez.personal@hotmail.com',
                    'dpi' => '2345678901234',
                    'direccion' => 'Zona 15, Ciudad de Guatemala, Guatemala',
                    'fecha_nacimiento' => '1990-07-22',
                    'genero' => 'femenino',
                    'estado_civil' => 'Soltera',
                    'contacto_emergencia' => 'José López - Padre - +502 5555-6789',
                    'especialidad' => 'Reparación de Laptops y Tablets',
                    'activo' => true,
                    'descripcion' => 'Especialista en reparación de dispositivos móviles y laptops. Experta en recuperación de datos y reparación de pantallas.',
                ]
            ],
            [
                'user_data' => [
                    'name' => 'Miguel Ángel',
                    'username' => 'miguel.torres',
                    'email' => 'miguel.torres@empresa.com',
                    'password' => Hash::make('password123'),
                    'rol' => 'tecnico',
                    'activo' => true,
                ],
                'tecnico_data' => [
                    'nombres' => 'Miguel Ángel',
                    'apellidos' => 'Torres Morales',
                    'telefono' => '+502 5555-3456',
                    'email_personal' => 'miguel.torres.personal@yahoo.com',
                    'dpi' => '3456789012345',
                    'direccion' => 'Zona 7, Ciudad de Guatemala, Guatemala',
                    'fecha_nacimiento' => '1988-11-08',
                    'genero' => 'masculino',
                    'estado_civil' => 'Casado',
                    'contacto_emergencia' => 'Carmen Morales - Madre - +502 5555-7890',
                    'especialidad' => 'Redes y Sistemas',
                    'activo' => true,
                    'descripcion' => 'Ingeniero en sistemas especializado en redes y configuración de servidores. Experto en troubleshooting de problemas de conectividad.',
                ]
            ],
            [
                'user_data' => [
                    'name' => 'Patricia Elena',
                    'username' => 'patricia.vargas',
                    'email' => 'patricia.vargas@empresa.com',
                    'password' => Hash::make('password123'),
                    'rol' => 'tecnico',
                    'activo' => true,
                ],
                'tecnico_data' => [
                    'nombres' => 'Patricia Elena',
                    'apellidos' => 'Vargas Jiménez',
                    'telefono' => '+502 5555-4567',
                    'email_personal' => 'patricia.vargas.personal@gmail.com',
                    'dpi' => '4567890123456',
                    'direccion' => 'Zona 12, Ciudad de Guatemala, Guatemala',
                    'fecha_nacimiento' => '1992-04-12',
                    'genero' => 'femenino',
                    'estado_civil' => 'Soltera',
                    'contacto_emergencia' => 'Roberto Jiménez - Hermano - +502 5555-8901',
                    'especialidad' => 'Software y Sistemas Operativos',
                    'activo' => true,
                    'descripcion' => 'Técnica especializada en instalación y configuración de software. Experta en sistemas operativos Windows y Linux.',
                ]
            ],
            [
                'user_data' => [
                    'name' => 'Roberto Carlos',
                    'username' => 'roberto.martinez',
                    'email' => 'roberto.martinez@empresa.com',
                    'password' => Hash::make('password123'),
                    'rol' => 'tecnico',
                    'activo' => true,
                ],
                'tecnico_data' => [
                    'nombres' => 'Roberto Carlos',
                    'apellidos' => 'Martínez Sánchez',
                    'telefono' => '+502 5555-5678',
                    'email_personal' => 'roberto.martinez.personal@outlook.com',
                    'dpi' => '5678901234567',
                    'direccion' => 'Zona 9, Ciudad de Guatemala, Guatemala',
                    'fecha_nacimiento' => '1987-12-03',
                    'genero' => 'masculino',
                    'estado_civil' => 'Divorciado',
                    'contacto_emergencia' => 'Lucía Sánchez - Madre - +502 5555-9012',
                    'especialidad' => 'Reparación de Impresoras y Periféricos',
                    'activo' => true,
                    'descripcion' => 'Especialista en reparación de impresoras, scanners y periféricos. Experto en mantenimiento preventivo de equipos de oficina.',
                ]
            ],
            [
                'user_data' => [
                    'name' => 'María José',
                    'username' => 'maria.gonzalez',
                    'email' => 'maria.gonzalez@empresa.com',
                    'password' => Hash::make('password123'),
                    'rol' => 'tecnico',
                    'activo' => true,
                ],
                'tecnico_data' => [
                    'nombres' => 'María José',
                    'apellidos' => 'González Pérez',
                    'telefono' => '+502 5555-6789',
                    'email_personal' => 'maria.gonzalez.personal@gmail.com',
                    'dpi' => '6789012345678',
                    'direccion' => 'Zona 14, Ciudad de Guatemala, Guatemala',
                    'fecha_nacimiento' => '1991-08-18',
                    'genero' => 'femenino',
                    'estado_civil' => 'Casada',
                    'contacto_emergencia' => 'Juan Pérez - Esposo - +502 5555-0123',
                    'especialidad' => 'Diagnóstico y Reparación General',
                    'activo' => true,
                    'descripcion' => 'Técnica generalista con experiencia en diagnóstico y reparación de diversos tipos de equipos. Especializada en atención al cliente.',
                ]
            ],
            [
                'user_data' => [
                    'name' => 'Luis Fernando',
                    'username' => 'luis.herrera',
                    'email' => 'luis.herrera@empresa.com',
                    'password' => Hash::make('password123'),
                    'rol' => 'tecnico',
                    'activo' => true,
                ],
                'tecnico_data' => [
                    'nombres' => 'Luis Fernando',
                    'apellidos' => 'Herrera Díaz',
                    'telefono' => '+502 5555-7890',
                    'email_personal' => 'luis.herrera.personal@hotmail.com',
                    'dpi' => '7890123456789',
                    'direccion' => 'Zona 11, Ciudad de Guatemala, Guatemala',
                    'fecha_nacimiento' => '1989-06-25',
                    'genero' => 'masculino',
                    'estado_civil' => 'Soltero',
                    'contacto_emergencia' => 'Isabel Díaz - Madre - +502 5555-1234',
                    'especialidad' => 'Hardware y Componentes',
                    'activo' => true,
                    'descripcion' => 'Técnico junior especializado en reparación de hardware y reemplazo de componentes. En proceso de capacitación continua.',
                ]
            ],
            [
                'user_data' => [
                    'name' => 'Gabriela Andrea',
                    'username' => 'gabriela.ramirez',
                    'email' => 'gabriela.ramirez@empresa.com',
                    'password' => Hash::make('password123'),
                    'rol' => 'tecnico',
                    'activo' => true,
                ],
                'tecnico_data' => [
                    'nombres' => 'Gabriela Andrea',
                    'apellidos' => 'Ramírez Castro',
                    'telefono' => '+502 5555-8901',
                    'email_personal' => 'gabriela.ramirez.personal@yahoo.com',
                    'dpi' => '8901234567890',
                    'direccion' => 'Zona 16, Ciudad de Guatemala, Guatemala',
                    'fecha_nacimiento' => '1993-10-14',
                    'genero' => 'femenino',
                    'estado_civil' => 'Soltera',
                    'contacto_emergencia' => 'Pedro Castro - Padre - +502 5555-2345',
                    'especialidad' => 'Dispositivos Móviles',
                    'activo' => true,
                    'descripcion' => 'Especialista en reparación de smartphones y tablets. Experta en reparación de pantallas y baterías.',
                ]
            ]
        ];

        // Crear usuarios y técnicos
        foreach ($tecnicos as $tecnico) {
            // Crear el usuario primero
            $user = User::create($tecnico['user_data']);
            
            // Crear el técnico asociado al usuario
            $tecnico['tecnico_data']['user_id'] = $user->id;
            Tecnico::create($tecnico['tecnico_data']);
        }

        $this->command->info('Técnicos creados exitosamente: ' . count($tecnicos) . ' registros');
    }
}
