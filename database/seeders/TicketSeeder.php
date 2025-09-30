<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ticket;
use App\Models\Reparacion;
use App\Models\Cliente;
use App\Models\Equipo;
use App\Models\Tecnico;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class TicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Limpiar datos existentes
        DB::table('tickets')->truncate();
        
        // Crear datos de ejemplo si no existen
        $this->createSampleData();
        
        // Obtener reparaciones existentes
        $reparaciones = Reparacion::with(['equipo.cliente', 'tecnico.user'])->get();
        
        if ($reparaciones->isEmpty()) {
            $this->command->info('No hay reparaciones en la base de datos. Creando datos de ejemplo...');
            $this->createSampleReparaciones();
            $reparaciones = Reparacion::with(['equipo.cliente', 'tecnico.user'])->get();
        }
        
        // Crear tickets de ejemplo
        $this->createTickets($reparaciones);
        
        $this->command->info('✅ Tickets creados exitosamente!');
    }
    
    private function createSampleData()
    {
        // Crear usuario admin si no existe
        if (!User::where('email', 'admin@hdc.com')->exists()) {
            User::create([
                'name' => 'Administrador HDC',
                'email' => 'admin@hdc.com',
                'password' => bcrypt('password'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]);
        }
        
        // Crear técnico si no existe
        if (!Tecnico::where('user_id', 1)->exists()) {
            Tecnico::create([
                'user_id' => 1,
                'especialidad' => 'Reparación General',
                'experiencia_anos' => 5,
                'telefono' => '5555-1234',
                'activo' => true,
            ]);
        }
    }
    
    private function createSampleReparaciones()
    {
        // Crear clientes de ejemplo
        $clientes = [
            [
                'nombres' => 'María Elena',
                'apellidos' => 'González Pérez',
                'telefono' => '5555-0001',
                'email' => 'maria.gonzalez@email.com',
                'direccion' => 'Zona 10, Ciudad de Guatemala',
                'dpi' => '1234567890123',
                'activo' => true,
            ],
            [
                'nombres' => 'Carlos Alberto',
                'apellidos' => 'Rodríguez López',
                'telefono' => '5555-0002',
                'email' => 'carlos.rodriguez@email.com',
                'direccion' => 'Zona 15, Ciudad de Guatemala',
                'dpi' => '2345678901234',
                'activo' => true,
            ],
            [
                'nombres' => 'Ana Lucía',
                'apellidos' => 'Martínez Silva',
                'telefono' => '5555-0003',
                'email' => 'ana.martinez@email.com',
                'direccion' => 'Zona 1, Ciudad de Guatemala',
                'dpi' => '3456789012345',
                'activo' => true,
            ],
            [
                'nombres' => 'Roberto Carlos',
                'apellidos' => 'Hernández García',
                'telefono' => '5555-0004',
                'email' => 'roberto.hernandez@email.com',
                'direccion' => 'Zona 7, Ciudad de Guatemala',
                'dpi' => '4567890123456',
                'activo' => true,
            ],
            [
                'nombres' => 'Lesly Valle',
                'apellidos' => 'Ruiz Morales',
                'telefono' => '5555-0005',
                'email' => 'lesly.valle@email.com',
                'direccion' => 'Zona 12, Ciudad de Guatemala',
                'dpi' => '5678901234567',
                'activo' => true,
            ]
        ];
        
        foreach ($clientes as $clienteData) {
            Cliente::create($clienteData);
        }
        
        // Crear equipos de ejemplo
        $equipos = [
            [
                'cliente_id' => 1,
                'numero_serie' => 'LAP001-2024',
                'marca' => 'HP',
                'modelo' => 'Pavilion Gaming 15',
                'tipo_equipo' => 'Laptop',
                'descripcion' => 'Laptop para gaming con tarjeta gráfica dedicada',
                'fecha_ingreso' => Carbon::now()->subDays(10),
                'cliente_nombre' => 'María Elena González Pérez',
                'cliente_telefono' => '5555-0001',
                'cliente_email' => 'maria.gonzalez@email.com',
                'estado' => 'reparado',
                'costo_estimado' => 250.00,
                'observaciones' => 'Pantalla con rayones, necesita limpieza y mantenimiento'
            ],
            [
                'cliente_id' => 2,
                'numero_serie' => 'DESK002-2024',
                'marca' => 'Dell',
                'modelo' => 'OptiPlex 7090',
                'tipo_equipo' => 'Desktop',
                'descripcion' => 'Computadora de escritorio para oficina',
                'fecha_ingreso' => Carbon::now()->subDays(8),
                'cliente_nombre' => 'Carlos Alberto Rodríguez López',
                'cliente_telefono' => '5555-0002',
                'cliente_email' => 'carlos.rodriguez@email.com',
                'estado' => 'reparado',
                'costo_estimado' => 180.00,
                'observaciones' => 'No enciende, posible problema de fuente de poder'
            ],
            [
                'cliente_id' => 3,
                'numero_serie' => 'LAP003-2024',
                'marca' => 'Lenovo',
                'modelo' => 'ThinkPad E15',
                'tipo_equipo' => 'Laptop',
                'descripcion' => 'Laptop empresarial',
                'fecha_ingreso' => Carbon::now()->subDays(6),
                'cliente_nombre' => 'Ana Lucía Martínez Silva',
                'cliente_telefono' => '5555-0003',
                'cliente_email' => 'ana.martinez@email.com',
                'estado' => 'reparado',
                'costo_estimado' => 320.00,
                'observaciones' => 'Teclado con teclas que no responden'
            ],
            [
                'cliente_id' => 4,
                'numero_serie' => 'LAP004-2024',
                'marca' => 'ASUS',
                'modelo' => 'VivoBook S15',
                'tipo_equipo' => 'Laptop',
                'descripcion' => 'Laptop ultrabook ligero',
                'fecha_ingreso' => Carbon::now()->subDays(4),
                'cliente_nombre' => 'Roberto Carlos Hernández García',
                'cliente_telefono' => '5555-0004',
                'cliente_email' => 'roberto.hernandez@email.com',
                'estado' => 'reparado',
                'costo_estimado' => 280.00,
                'observaciones' => 'Batería no carga, necesita reemplazo'
            ],
            [
                'cliente_id' => 5,
                'numero_serie' => 'LAP005-2024',
                'marca' => 'LG',
                'modelo' => 'Pavilion Gaming',
                'tipo_equipo' => 'Laptop',
                'descripcion' => 'Laptop gaming con pantalla 17 pulgadas',
                'fecha_ingreso' => Carbon::now()->subDays(2),
                'cliente_nombre' => 'Lesly Valle Ruiz Morales',
                'cliente_telefono' => '5555-0005',
                'cliente_email' => 'lesly.valle@email.com',
                'estado' => 'reparado',
                'costo_estimado' => 450.00,
                'observaciones' => 'Sobrecalentamiento, necesita limpieza interna'
            ]
        ];
        
        foreach ($equipos as $equipoData) {
            Equipo::create($equipoData);
        }
        
        // Crear reparaciones de ejemplo
        $reparaciones = [
            [
                'equipo_id' => 1,
                'tecnico_id' => 1,
                'descripcion_problema' => 'Pantalla con rayones y manchas, rendimiento lento',
                'diagnostico' => 'Pantalla con daños físicos, sistema operativo lento por falta de mantenimiento',
                'solucion' => 'Limpieza completa del sistema, desfragmentación, limpieza de pantalla',
                'fecha_inicio' => Carbon::now()->subDays(10),
                'fecha_fin' => Carbon::now()->subDays(8),
                'estado' => 'completada',
                'costo' => 250.00,
                'repuestos_utilizados' => ['Pasta térmica', 'Líquido limpiador'],
                'observaciones' => 'Reparación exitosa, cliente satisfecho',
                'tiempo_estimado_horas' => 4,
                'tiempo_real_horas' => 3
            ],
            [
                'equipo_id' => 2,
                'tecnico_id' => 1,
                'descripcion_problema' => 'Computadora no enciende, sin señal de vida',
                'diagnostico' => 'Fuente de poder dañada, posible problema en placa madre',
                'solucion' => 'Reemplazo de fuente de poder, verificación de componentes',
                'fecha_inicio' => Carbon::now()->subDays(8),
                'fecha_fin' => Carbon::now()->subDays(6),
                'estado' => 'completada',
                'costo' => 180.00,
                'repuestos_utilizados' => ['Fuente de poder 500W'],
                'observaciones' => 'Reparación exitosa, equipo funcionando correctamente',
                'tiempo_estimado_horas' => 6,
                'tiempo_real_horas' => 5
            ],
            [
                'equipo_id' => 3,
                'tecnico_id' => 1,
                'descripcion_problema' => 'Teclado con teclas que no responden, problema de conectividad',
                'diagnostico' => 'Teclado interno dañado, conexión suelta',
                'solucion' => 'Reemplazo de teclado interno, verificación de conexiones',
                'fecha_inicio' => Carbon::now()->subDays(6),
                'fecha_fin' => Carbon::now()->subDays(4),
                'estado' => 'completada',
                'costo' => 320.00,
                'repuestos_utilizados' => ['Teclado interno Lenovo ThinkPad E15'],
                'observaciones' => 'Reparación exitosa, todas las teclas funcionando',
                'tiempo_estimado_horas' => 8,
                'tiempo_real_horas' => 7
            ],
            [
                'equipo_id' => 4,
                'tecnico_id' => 1,
                'descripcion_problema' => 'Batería no carga, se descarga muy rápido',
                'diagnostico' => 'Batería agotada, necesita reemplazo',
                'solucion' => 'Reemplazo de batería, calibración del sistema',
                'fecha_inicio' => Carbon::now()->subDays(4),
                'fecha_fin' => Carbon::now()->subDays(2),
                'estado' => 'completada',
                'costo' => 280.00,
                'repuestos_utilizados' => ['Batería ASUS VivoBook S15'],
                'observaciones' => 'Reparación exitosa, batería funcionando al 100%',
                'tiempo_estimado_horas' => 3,
                'tiempo_real_horas' => 2
            ],
            [
                'equipo_id' => 5,
                'tecnico_id' => 1,
                'descripcion_problema' => 'Sobrecalentamiento excesivo, rendimiento degradado',
                'diagnostico' => 'Acumulación de polvo en ventiladores, pasta térmica seca',
                'solucion' => 'Limpieza completa de ventiladores, reemplazo de pasta térmica',
                'fecha_inicio' => Carbon::now()->subDays(2),
                'fecha_fin' => Carbon::now()->subDay(),
                'estado' => 'completada',
                'costo' => 450.00,
                'repuestos_utilizados' => ['Pasta térmica premium', 'Líquido limpiador'],
                'observaciones' => 'Reparación exitosa, temperatura normal, rendimiento óptimo',
                'tiempo_estimado_horas' => 5,
                'tiempo_real_horas' => 4
            ]
        ];
        
        foreach ($reparaciones as $reparacionData) {
            Reparacion::create($reparacionData);
        }
    }
    
    private function createTickets($reparaciones)
    {
        $tiposTicket = ['ingreso', 'entrega', 'servicio'];
        $estados = ['generado', 'firmado', 'entregado'];
        
        $descripcionesServicio = [
            'Reparación y mantenimiento de equipo informático',
            'Servicio técnico especializado en hardware',
            'Mantenimiento preventivo y correctivo',
            'Reparación de componentes electrónicos',
            'Servicio de limpieza y optimización'
        ];
        
        $observacionesTecnico = [
            'Equipo reparado exitosamente, funcionando correctamente',
            'Mantenimiento preventivo realizado, equipo optimizado',
            'Reparación de componentes, equipo en perfecto estado',
            'Servicio técnico completado, cliente satisfecho',
            'Reparación exitosa, garantía de 30 días'
        ];
        
        $condicionesServicio = [
            'Garantía de 30 días por defectos de fabricación',
            'Servicio técnico con garantía de 60 días',
            'Reparación con garantía extendida de 90 días',
            'Mantenimiento con garantía de 45 días',
            'Servicio especializado con garantía de 30 días'
        ];
        
        foreach ($reparaciones as $index => $reparacion) {
            $tipoTicket = $tiposTicket[array_rand($tiposTicket)];
            $estado = $estados[array_rand($estados)];
            
            // Generar número de ticket
            $numeroTicket = Ticket::generarNumeroTicket($tipoTicket);
            
            // Calcular costos
            $costoServicio = $reparacion->costo * 0.7; // 70% del costo total
            $costoRepuestos = $reparacion->costo * 0.3; // 30% del costo total
            $total = $costoServicio + $costoRepuestos;
            
            // Fechas
            $fechaGeneracion = $reparacion->fecha_fin ?? $reparacion->fecha_inicio;
            $fechaFirma = null;
            $fechaEntrega = null;
            
            if ($estado === 'firmado' || $estado === 'entregado') {
                $fechaFirma = $fechaGeneracion->copy()->addHours(rand(1, 24));
            }
            
            if ($estado === 'entregado') {
                $fechaEntrega = $fechaFirma->copy()->addHours(rand(1, 48));
            }
            
            // Crear ticket
            $ticket = Ticket::create([
                'numero_ticket' => $numeroTicket,
                'tipo_ticket' => $tipoTicket,
                'reparacion_id' => $reparacion->id,
                'descripcion_servicio' => $descripcionesServicio[array_rand($descripcionesServicio)],
                'observaciones_tecnico' => $observacionesTecnico[array_rand($observacionesTecnico)],
                'observaciones_cliente' => 'Cliente satisfecho con el servicio recibido',
                'costo_servicio' => $costoServicio,
                'costo_repuestos' => $costoRepuestos,
                'total' => $total,
                'estado' => $estado,
                'fecha_generacion' => $fechaGeneracion,
                'fecha_firma' => $fechaFirma,
                'fecha_entrega' => $fechaEntrega,
                'nombre_quien_firma' => $reparacion->equipo->cliente_nombre,
                'dpi_quien_firma' => $reparacion->equipo->cliente->dpi ?? '1234567890123',
                'condiciones_servicio' => $condicionesServicio[array_rand($condicionesServicio)],
                'tiempo_garantia_dias' => rand(30, 90),
                'observaciones_generales' => 'Ticket generado automáticamente por el sistema'
            ]);
            
            // Si el estado es firmado o entregado, agregar firma simulada
            if ($estado === 'firmado' || $estado === 'entregado') {
                $ticket->update([
                    'firma_cliente' => base64_encode('firma_simulada_' . $ticket->id)
                ]);
            }
            
            $this->command->info("✅ Ticket creado: {$ticket->numero_ticket} - {$ticket->tipo_ticket_label} - {$ticket->estado_label}");
        }
        
        $this->command->info("🎉 Se crearon " . $reparaciones->count() . " tickets exitosamente!");
    }
}
