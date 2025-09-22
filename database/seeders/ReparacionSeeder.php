<?php

namespace Database\Seeders;

use App\Models\Reparacion;
use App\Models\Equipo;
use App\Models\Tecnico;
use App\Models\Inventario;
use Illuminate\Database\Seeder;

class ReparacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener equipos y técnicos existentes
        $equipos = Equipo::all();
        $tecnicos = Tecnico::where('activo', true)->get();
        
        if ($equipos->count() === 0 || $tecnicos->count() === 0) {
            $this->command->info('No hay equipos o técnicos disponibles. Ejecuta primero los seeders de equipos y técnicos.');
            return;
        }

        // Obtener algunos items del inventario para repuestos
        $repuestos = Inventario::whereIn('categoria', ['Componentes', 'Consumibles', 'Herramientas'])
                              ->where('stock_actual', '>', 0)
                              ->take(20)
                              ->get();

        // Problemas comunes y sus soluciones
        $problemas = [
            [
                'problema' => 'La computadora no enciende, pantalla negra',
                'diagnostico' => 'Diagnóstico realizado: Problema en la fuente de poder. Se detectó voltaje irregular en los conectores principales.',
                'solucion' => 'Reemplazada fuente de poder defectuosa. Se instaló nueva fuente EVGA 650W 80+ Bronze. Sistema funcionando correctamente.',
                'repuestos' => ['INV-005'], // Fuente de Poder
                'tiempo_estimado' => 4,
                'tiempo_real' => 3,
                'costo' => 105.00,
                'estado' => 'completada'
            ],
            [
                'problema' => 'Laptop con pantalla rota, no se ve nada',
                'diagnostico' => 'Pantalla LCD dañada por impacto. Se requiere reemplazo completo del panel.',
                'solucion' => 'Instalada nueva pantalla LCD 15.6" Full HD. Calibración de colores realizada. Pantalla funcionando perfectamente.',
                'repuestos' => ['INV-029'], // Pantalla Laptop
                'tiempo_estimado' => 6,
                'tiempo_real' => 5,
                'costo' => 120.00,
                'estado' => 'completada'
            ],
            [
                'problema' => 'Computadora muy lenta, tarda mucho en cargar',
                'diagnostico' => 'Disco duro con sectores dañados y poca memoria RAM. Sistema operativo fragmentado.',
                'solucion' => 'Instalado SSD Samsung 500GB como disco principal y agregada memoria RAM DDR4 8GB. Sistema operativo reinstalado.',
                'repuestos' => ['INV-001', 'INV-002'], // SSD y RAM
                'tiempo_estimado' => 8,
                'tiempo_real' => 7,
                'costo' => 100.00,
                'estado' => 'completada'
            ],
            [
                'problema' => 'Impresora no imprime, muestra error de papel',
                'diagnostico' => 'Sensor de papel sucio y rodillos de alimentación desgastados.',
                'solucion' => 'Limpiados sensores y reemplazados rodillos de alimentación. Impresora funcionando correctamente.',
                'repuestos' => ['INV-017'], // Pasta Térmica (para limpieza)
                'tiempo_estimado' => 2,
                'tiempo_real' => 2,
                'costo' => 35.00,
                'estado' => 'completada'
            ],
            [
                'problema' => 'Laptop se apaga solo, se calienta mucho',
                'diagnostico' => 'Ventilador sucio y pasta térmica seca. Temperatura del procesador muy alta.',
                'solucion' => 'Desarmada laptop, limpiado ventilador y aplicada nueva pasta térmica Arctic MX-4.',
                'repuestos' => ['INV-017'], // Pasta Térmica
                'tiempo_estimado' => 3,
                'tiempo_real' => 4,
                'costo' => 25.00,
                'estado' => 'completada'
            ],
            [
                'problema' => 'Teclado de laptop no responde algunas teclas',
                'diagnostico' => 'Teclado con conexiones sueltas y algunas teclas físicamente dañadas.',
                'solucion' => 'Reemplazado teclado completo. Conexiones verificadas y funcionando correctamente.',
                'repuestos' => ['INV-030'], // Teclado para Laptop
                'tiempo_estimado' => 2,
                'tiempo_real' => 2,
                'costo' => 35.00,
                'estado' => 'completada'
            ],
            [
                'problema' => 'Monitor con líneas verticales en pantalla',
                'diagnostico' => 'Panel LCD con falla interna. Problema en la conexión del cable flex.',
                'solucion' => 'Revisada conexión interna, panel LCD requiere reemplazo. Cotización enviada al cliente.',
                'repuestos' => [],
                'tiempo_estimado' => 4,
                'tiempo_real' => null,
                'costo' => null,
                'estado' => 'pendiente'
            ],
            [
                'problema' => 'Laptop no carga la batería, se agota rápido',
                'diagnostico' => 'Batería con celdas dañadas y circuito de carga defectuoso.',
                'solucion' => 'En proceso de reemplazo de batería y revisión del circuito de carga.',
                'repuestos' => ['INV-028'], // Batería Laptop
                'tiempo_estimado' => 3,
                'tiempo_real' => null,
                'costo' => 50.00,
                'estado' => 'en_proceso'
            ],
            [
                'problema' => 'Desktop no reconoce el mouse ni teclado',
                'diagnostico' => 'Puertos USB dañados en la placa base. Se requiere revisión completa.',
                'solucion' => 'Diagnóstico en proceso. Se está evaluando si se puede reparar o requiere reemplazo de placa base.',
                'repuestos' => [],
                'tiempo_estimado' => 6,
                'tiempo_real' => null,
                'costo' => null,
                'estado' => 'en_proceso'
            ],
            [
                'problema' => 'Impresora láser mancha las hojas',
                'diagnostico' => 'Tóner derramado y rodillo de limpieza desgastado.',
                'solucion' => 'Cancelada por el cliente. El costo de reparación superaba el valor del equipo.',
                'repuestos' => [],
                'tiempo_estimado' => 4,
                'tiempo_real' => 2,
                'costo' => null,
                'estado' => 'cancelada'
            ],
            [
                'problema' => 'Laptop con pantalla azul constante',
                'diagnostico' => 'Error de memoria RAM y posible problema en el disco duro.',
                'solucion' => 'Reemplazada memoria RAM defectuosa y formateado disco duro. Sistema operativo reinstalado.',
                'repuestos' => ['INV-002'], // RAM
                'tiempo_estimado' => 5,
                'tiempo_real' => 6,
                'costo' => 35.00,
                'estado' => 'completada'
            ],
            [
                'problema' => 'Desktop no tiene sonido',
                'diagnostico' => 'Controlador de audio desactualizado y configuración incorrecta.',
                'solucion' => 'Actualizados controladores de audio y configurada salida de audio. Sonido funcionando correctamente.',
                'repuestos' => [],
                'tiempo_estimado' => 1,
                'tiempo_real' => 1,
                'costo' => 15.00,
                'estado' => 'completada'
            ],
            [
                'problema' => 'Laptop con WiFi intermitente',
                'diagnostico' => 'Antena WiFi suelta y controlador desactualizado.',
                'solucion' => 'Reparada conexión de antena WiFi y actualizado controlador de red.',
                'repuestos' => [],
                'tiempo_estimado' => 2,
                'tiempo_real' => 3,
                'costo' => 20.00,
                'estado' => 'completada'
            ],
            [
                'problema' => 'Impresora de inyección de tinta con bandas en la impresión',
                'diagnostico' => 'Cabezales de impresión sucios y cartuchos con poca tinta.',
                'solucion' => 'Limpiados cabezales de impresión y reemplazados cartuchos de tinta.',
                'repuestos' => [],
                'tiempo_estimado' => 1,
                'tiempo_real' => 1,
                'costo' => 25.00,
                'estado' => 'completada'
            ],
            [
                'problema' => 'Laptop con teclas que se repiten al escribir',
                'diagnostico' => 'Teclado con teclas que se quedan presionadas. Problema mecánico.',
                'solucion' => 'Pendiente de confirmación del cliente para proceder con el reemplazo del teclado.',
                'repuestos' => ['INV-030'], // Teclado
                'tiempo_estimado' => 3,
                'tiempo_real' => null,
                'costo' => 35.00,
                'estado' => 'pendiente'
            ],
            [
                'problema' => 'Desktop con pantalla azul al iniciar Windows',
                'diagnostico' => 'Error crítico del sistema. Posible problema de memoria o disco duro corrupto.',
                'solucion' => 'Reemplazada memoria RAM defectuosa y reparado sector de arranque del disco duro.',
                'repuestos' => ['INV-002'], // RAM
                'tiempo_estimado' => 6,
                'tiempo_real' => 5,
                'costo' => 40.00,
                'estado' => 'completada'
            ],
            [
                'problema' => 'Laptop no carga, LED de carga no se enciende',
                'diagnostico' => 'Cargador defectuoso y posible problema en el puerto de carga de la laptop.',
                'solucion' => 'Reemplazado cargador y reparado puerto de carga. Sistema funcionando correctamente.',
                'repuestos' => ['INV-026'], // Cargador Laptop
                'tiempo_estimado' => 3,
                'tiempo_real' => 4,
                'costo' => 45.00,
                'estado' => 'completada'
            ],
            [
                'problema' => 'Impresora láser atasca papel constantemente',
                'diagnostico' => 'Rodillos de alimentación desgastados y sensor de papel defectuoso.',
                'solucion' => 'Reemplazados rodillos de alimentación y limpiado sensor de papel.',
                'repuestos' => [],
                'tiempo_estimado' => 4,
                'tiempo_real' => 3,
                'costo' => 55.00,
                'estado' => 'completada'
            ],
            [
                'problema' => 'Laptop con pantalla que parpadea',
                'diagnostico' => 'Cable de video interno suelto o dañado. Requiere desarme completo.',
                'solucion' => 'Reparada conexión del cable de video LCD. Pantalla funcionando perfectamente.',
                'repuestos' => [],
                'tiempo_estimado' => 5,
                'tiempo_real' => 6,
                'costo' => 60.00,
                'estado' => 'completada'
            ],
            [
                'problema' => 'Desktop con sonido distorsionado',
                'diagnostico' => 'Tarjeta de sonido con interferencias y altavoces con problemas.',
                'solucion' => 'Reemplazada tarjeta de sonido integrada y configurado sistema de audio.',
                'repuestos' => [],
                'tiempo_estimado' => 2,
                'tiempo_real' => 3,
                'costo' => 25.00,
                'estado' => 'completada'
            ],
            [
                'problema' => 'Laptop se reinicia solo cada 10 minutos',
                'diagnostico' => 'Sobrecalentamiento del procesador y ventilador sucio.',
                'solucion' => 'Limpiado sistema de ventilación y aplicada pasta térmica nueva.',
                'repuestos' => ['INV-017'], // Pasta Térmica
                'tiempo_estimado' => 3,
                'tiempo_real' => 2,
                'costo' => 20.00,
                'estado' => 'completada'
            ],
            [
                'problema' => 'Monitor con colores distorsionados',
                'diagnostico' => 'Panel LCD con falla en la matriz de colores. Requiere reemplazo.',
                'solucion' => 'En evaluación del costo de reemplazo del panel LCD.',
                'repuestos' => [],
                'tiempo_estimado' => 4,
                'tiempo_real' => null,
                'costo' => null,
                'estado' => 'pendiente'
            ],
            [
                'problema' => 'Laptop con touchpad que no responde',
                'diagnostico' => 'Driver del touchpad desactualizado y configuración incorrecta.',
                'solucion' => 'Actualizado driver del touchpad y configurado correctamente.',
                'repuestos' => [],
                'tiempo_estimado' => 1,
                'tiempo_real' => 1,
                'costo' => 15.00,
                'estado' => 'completada'
            ],
            [
                'problema' => 'Desktop no reconoce USB 3.0',
                'diagnostico' => 'Controladores USB desactualizados y configuración de BIOS incorrecta.',
                'solucion' => 'Actualizados controladores USB y configurado BIOS correctamente.',
                'repuestos' => [],
                'tiempo_estimado' => 2,
                'tiempo_real' => 2,
                'costo' => 18.00,
                'estado' => 'completada'
            ],
            [
                'problema' => 'Laptop con cámara web que no funciona',
                'diagnostico' => 'Driver de cámara web corrupto y posible problema de hardware.',
                'solucion' => 'Reinstalado driver de cámara web y verificado funcionamiento.',
                'repuestos' => [],
                'tiempo_estimado' => 1,
                'tiempo_real' => 1,
                'costo' => 12.00,
                'estado' => 'completada'
            ],
            [
                'problema' => 'Impresora no imprime en color, solo en blanco y negro',
                'diagnostico' => 'Cartuchos de color vacíos y cabezales de color sucios.',
                'solucion' => 'Reemplazados cartuchos de color y limpiados cabezales de impresión.',
                'repuestos' => [],
                'tiempo_estimado' => 2,
                'tiempo_real' => 2,
                'costo' => 35.00,
                'estado' => 'completada'
            ],
            [
                'problema' => 'Laptop con Bluetooth que no detecta dispositivos',
                'diagnostico' => 'Antena Bluetooth desconectada y driver desactualizado.',
                'solucion' => 'Reparada conexión de antena Bluetooth y actualizado driver.',
                'repuestos' => [],
                'tiempo_estimado' => 2,
                'tiempo_real' => 3,
                'costo' => 22.00,
                'estado' => 'completada'
            ],
            [
                'problema' => 'Desktop con ventilador muy ruidoso',
                'diagnostico' => 'Ventilador de CPU desgastado y sucio. Requiere limpieza y posible reemplazo.',
                'solucion' => 'Limpiado ventilador y aplicado lubricante. Funcionando correctamente.',
                'repuestos' => [],
                'tiempo_estimado' => 2,
                'tiempo_real' => 2,
                'costo' => 15.00,
                'estado' => 'completada'
            ],
            [
                'problema' => 'Laptop con puerto HDMI que no funciona',
                'diagnostico' => 'Puerto HDMI dañado físicamente. Requiere reemplazo del conector.',
                'solucion' => 'En proceso de reemplazo del puerto HDMI.',
                'repuestos' => [],
                'tiempo_estimado' => 4,
                'tiempo_real' => null,
                'costo' => 50.00,
                'estado' => 'en_proceso'
            ],
            [
                'problema' => 'Desktop con error de memoria al ejecutar programas',
                'diagnostico' => 'Memoria RAM con errores y posible problema en los slots de memoria.',
                'solucion' => 'Reemplazada memoria RAM defectuosa y limpiados slots de memoria.',
                'repuestos' => ['INV-002'], // RAM
                'tiempo_estimado' => 3,
                'tiempo_real' => 3,
                'costo' => 35.00,
                'estado' => 'completada'
            ],
            [
                'problema' => 'Laptop con altavoces que no emiten sonido',
                'diagnostico' => 'Altavoces internos desconectados y driver de audio desactualizado.',
                'solucion' => 'Reconectados altavoces internos y actualizado driver de audio.',
                'repuestos' => [],
                'tiempo_estimado' => 2,
                'tiempo_real' => 2,
                'costo' => 20.00,
                'estado' => 'completada'
            ],
            [
                'problema' => 'Impresora de inyección de tinta con líneas en la impresión',
                'diagnostico' => 'Cabezales de impresión sucios y cartuchos con poca tinta.',
                'solucion' => 'Limpiados cabezales de impresión y reemplazados cartuchos de tinta.',
                'repuestos' => [],
                'tiempo_estimado' => 2,
                'tiempo_real' => 2,
                'costo' => 30.00,
                'estado' => 'completada'
            ],
            [
                'problema' => 'Laptop con teclado que no ilumina',
                'diagnostico' => 'LED del teclado defectuoso y configuración de iluminación incorrecta.',
                'solucion' => 'Reparado LED del teclado y configurada iluminación correctamente.',
                'repuestos' => [],
                'tiempo_estimado' => 2,
                'tiempo_real' => 2,
                'costo' => 25.00,
                'estado' => 'completada'
            ],
            [
                'problema' => 'Desktop con red cableada que no funciona',
                'diagnostico' => 'Puerto Ethernet dañado y cable de red defectuoso.',
                'solucion' => 'Reemplazado puerto Ethernet y probado con cable nuevo.',
                'repuestos' => [],
                'tiempo_estimado' => 3,
                'tiempo_real' => 3,
                'costo' => 40.00,
                'estado' => 'completada'
            ],
            [
                'problema' => 'Laptop con disco duro que hace ruido extraño',
                'diagnostico' => 'Disco duro mecánico con sectores dañados. Requiere reemplazo urgente.',
                'solucion' => 'Reemplazado disco duro por SSD y migrados datos importantes.',
                'repuestos' => ['INV-001'], // SSD
                'tiempo_estimado' => 6,
                'tiempo_real' => 8,
                'costo' => 80.00,
                'estado' => 'completada'
            ],
            [
                'problema' => 'Monitor con líneas horizontales en pantalla',
                'diagnostico' => 'Panel LCD con falla en la matriz. Problema irreparable.',
                'solucion' => 'Cancelada reparación. El costo de reemplazo supera el valor del monitor.',
                'repuestos' => [],
                'tiempo_estimado' => 4,
                'tiempo_real' => 2,
                'costo' => null,
                'estado' => 'cancelada'
            ],
            [
                'problema' => 'Laptop con puerto USB que no reconoce dispositivos',
                'diagnostico' => 'Puerto USB dañado físicamente y posible problema en la placa base.',
                'solucion' => 'En evaluación del daño en la placa base para determinar viabilidad de reparación.',
                'repuestos' => [],
                'tiempo_estimado' => 5,
                'tiempo_real' => null,
                'costo' => null,
                'estado' => 'en_proceso'
            ],
            [
                'problema' => 'Desktop con placa base que no reconoce GPU',
                'diagnostico' => 'Slot PCIe dañado y posible problema de alimentación de la tarjeta gráfica.',
                'solucion' => 'Reemplazado slot PCIe y verificado suministro de energía a la GPU.',
                'repuestos' => [],
                'tiempo_estimado' => 4,
                'tiempo_real' => 5,
                'costo' => 70.00,
                'estado' => 'completada'
            ],
            [
                'problema' => 'Laptop con micrófono que no captura audio',
                'diagnostico' => 'Micrófono interno desconectado y configuración de audio incorrecta.',
                'solucion' => 'Reconectado micrófono interno y configurado audio correctamente.',
                'repuestos' => [],
                'tiempo_estimado' => 2,
                'tiempo_real' => 2,
                'costo' => 18.00,
                'estado' => 'completada'
            ],
            [
                'problema' => 'Impresora láser con tóner que se agota muy rápido',
                'diagnostico' => 'Fuga de tóner en el cartucho y rodillo de limpieza defectuoso.',
                'solucion' => 'Reemplazado cartucho de tóner y rodillo de limpieza.',
                'repuestos' => [],
                'tiempo_estimado' => 3,
                'tiempo_real' => 3,
                'costo' => 45.00,
                'estado' => 'completada'
            ],
            [
                'problema' => 'Laptop con pantalla táctil que no responde',
                'diagnostico' => 'Driver de pantalla táctil desactualizado y calibración incorrecta.',
                'solucion' => 'Actualizado driver de pantalla táctil y recalibrada pantalla.',
                'repuestos' => [],
                'tiempo_estimado' => 2,
                'tiempo_real' => 2,
                'costo' => 20.00,
                'estado' => 'completada'
            ],
            [
                'problema' => 'Desktop con fuente de poder que hace ruido',
                'diagnostico' => 'Ventilador de fuente de poder sucio y posible desgaste.',
                'solucion' => 'Limpiado ventilador de fuente de poder y aplicado lubricante.',
                'repuestos' => [],
                'tiempo_estimado' => 2,
                'tiempo_real' => 2,
                'costo' => 15.00,
                'estado' => 'completada'
            ],
            [
                'problema' => 'Laptop con lector de tarjetas que no funciona',
                'diagnostico' => 'Lector de tarjetas SD dañado físicamente. Requiere reemplazo.',
                'solucion' => 'Pendiente de confirmación del cliente para proceder con el reemplazo.',
                'repuestos' => [],
                'tiempo_estimado' => 3,
                'tiempo_real' => null,
                'costo' => 30.00,
                'estado' => 'pendiente'
            ],
            [
                'problema' => 'Desktop con error de placa base al iniciar',
                'diagnostico' => 'Placa base con capacitores hinchados y posible sobrecalentamiento.',
                'solucion' => 'Reemplazados capacitores defectuosos y mejorado sistema de ventilación.',
                'repuestos' => [],
                'tiempo_estimado' => 8,
                'tiempo_real' => 10,
                'costo' => 120.00,
                'estado' => 'completada'
            ]
        ];

        $reparacionesCreadas = 0;
        
        // Crear reparaciones para más equipos (hasta 40 reparaciones)
        foreach ($equipos->take(40) as $equipo) {
            $problema = $problemas[array_rand($problemas)];
            $tecnico = $tecnicos->random();
            
            // Determinar fechas basadas en el estado
            $fechaInicio = now()->subDays(rand(1, 30));
            $fechaFin = null;
            
            if (in_array($problema['estado'], ['completada', 'cancelada'])) {
                $fechaFin = $fechaInicio->copy()->addDays(rand(1, $problema['tiempo_estimado'] ?? 5));
            }
            
            // Crear array de repuestos utilizados
            $repuestosUtilizados = [];
            if (!empty($problema['repuestos'])) {
                foreach ($problema['repuestos'] as $codigoRepuesto) {
                    $repuesto = $repuestos->firstWhere('codigo', $codigoRepuesto);
                    if ($repuesto) {
                        $cantidad = rand(1, 2);
                        $repuestosUtilizados[] = [
                            'codigo' => $repuesto->codigo,
                            'nombre' => $repuesto->nombre,
                            'cantidad' => $cantidad,
                            'precio_unitario' => $repuesto->precio_venta,
                            'subtotal' => $repuesto->precio_venta * $cantidad
                        ];
                    }
                }
            }
            
            // Crear la reparación
            $reparacion = Reparacion::create([
                'equipo_id' => $equipo->id,
                'tecnico_id' => $tecnico->id,
                'descripcion_problema' => $problema['problema'],
                'diagnostico' => $problema['diagnostico'],
                'solucion' => $problema['solucion'],
                'fecha_inicio' => $fechaInicio,
                'fecha_fin' => $fechaFin,
                'estado' => $problema['estado'],
                'costo' => $problema['costo'],
                'repuestos_utilizados' => $repuestosUtilizados,
                'observaciones' => $this->generarObservaciones($problema['estado']),
                'tiempo_estimado_horas' => $problema['tiempo_estimado'],
                'tiempo_real_horas' => $problema['tiempo_real']
            ]);
            
            $reparacionesCreadas++;
        }

        $this->command->info("Reparaciones creadas exitosamente: {$reparacionesCreadas} registros");
    }

    private function generarObservaciones($estado)
    {
        $observaciones = [
            'pendiente' => [
                'Esperando confirmación del cliente para proceder con la reparación.',
                'Cotización enviada, pendiente de aprobación.',
                'Esperando repuestos para continuar con la reparación.',
                'Cliente debe confirmar si desea proceder con la reparación.'
            ],
            'en_proceso' => [
                'Reparación en curso. Se está trabajando en el diagnóstico.',
                'En proceso de reparación. Se espera completar en las próximas horas.',
                'Trabajando en la solución del problema reportado.',
                'Reparación avanzada. Se está aplicando la solución identificada.'
            ],
            'completada' => [
                'Reparación completada exitosamente. Equipo funcionando correctamente.',
                'Trabajo finalizado. Cliente puede recoger el equipo.',
                'Reparación exitosa. Equipo probado y funcionando al 100%.',
                'Servicio completado. Equipo listo para entrega.'
            ],
            'cancelada' => [
                'Reparación cancelada por el cliente.',
                'Cancelada por costo elevado de reparación.',
                'Cliente decidió no proceder con la reparación.',
                'Cancelada por falta de repuestos disponibles.'
            ]
        ];

        return $observaciones[$estado][array_rand($observaciones[$estado])];
    }
}
