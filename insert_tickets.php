<?php

// Script para insertar datos de tickets directamente en la base de datos
// Configuración de la base de datos
$host = 'localhost';
$dbname = 'gestion';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "🚀 Conectado a la base de datos. Iniciando inserción de datos...\n";
    
    // Limpiar datos existentes de tickets
    $pdo->exec("DELETE FROM tickets");
    echo "✅ Tabla de tickets limpiada.\n";
    
    // Verificar si existen reparaciones
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM reparaciones");
    $repairCount = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
    
    if ($repairCount == 0) {
        echo "⚠️ No hay reparaciones en la base de datos. Creando datos de ejemplo...\n";
        
        // Crear usuario admin si no existe
        $pdo->exec("INSERT IGNORE INTO users (name, username, email, password, role, email_verified_at, created_at, updated_at) 
                   VALUES ('Administrador HDC', 'admin', 'admin@hdc.com', '$2y$10\$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', NOW(), NOW(), NOW())");
        
        // Crear técnico si no existe
        $pdo->exec("INSERT IGNORE INTO tecnicos (user_id, especialidad, experiencia_anos, telefono, activo, created_at, updated_at) 
                   VALUES (1, 'Reparación General', 5, '5555-1234', 1, NOW(), NOW())");
        
        // Crear clientes de ejemplo
        $clientes = [
            ['María Elena', 'González Pérez', '5555-0001', 'maria.gonzalez@email.com', 'Zona 10, Ciudad de Guatemala', '1234567890123'],
            ['Carlos Alberto', 'Rodríguez López', '5555-0002', 'carlos.rodriguez@email.com', 'Zona 15, Ciudad de Guatemala', '2345678901234'],
            ['Ana Lucía', 'Martínez Silva', '5555-0003', 'ana.martinez@email.com', 'Zona 1, Ciudad de Guatemala', '3456789012345'],
            ['Roberto Carlos', 'Hernández García', '5555-0004', 'roberto.hernandez@email.com', 'Zona 7, Ciudad de Guatemala', '4567890123456'],
            ['Lesly Valle', 'Ruiz Morales', '5555-0005', 'lesly.valle@email.com', 'Zona 12, Ciudad de Guatemala', '5678901234567']
        ];
        
        foreach ($clientes as $cliente) {
            $pdo->exec("INSERT IGNORE INTO clientes (nombres, apellidos, telefono, email, direccion, dpi, activo, created_at, updated_at) 
                       VALUES ('{$cliente[0]}', '{$cliente[1]}', '{$cliente[2]}', '{$cliente[3]}', '{$cliente[4]}', '{$cliente[5]}', 1, NOW(), NOW())");
        }
        
        // Crear equipos de ejemplo
        $equipos = [
            [1, 'LAP001-2024', 'HP', 'Pavilion Gaming 15', 'Laptop', 'Laptop para gaming con tarjeta gráfica dedicada', 'María Elena González Pérez', '5555-0001', 'maria.gonzalez@email.com', 250.00],
            [2, 'DESK002-2024', 'Dell', 'OptiPlex 7090', 'Desktop', 'Computadora de escritorio para oficina', 'Carlos Alberto Rodríguez López', '5555-0002', 'carlos.rodriguez@email.com', 180.00],
            [3, 'LAP003-2024', 'Lenovo', 'ThinkPad E15', 'Laptop', 'Laptop empresarial', 'Ana Lucía Martínez Silva', '5555-0003', 'ana.martinez@email.com', 320.00],
            [4, 'LAP004-2024', 'ASUS', 'VivoBook S15', 'Laptop', 'Laptop ultrabook ligero', 'Roberto Carlos Hernández García', '5555-0004', 'roberto.hernandez@email.com', 280.00],
            [5, 'LAP005-2024', 'LG', 'Pavilion Gaming', 'Laptop', 'Laptop gaming con pantalla 17 pulgadas', 'Lesly Valle Ruiz Morales', '5555-0005', 'lesly.valle@email.com', 450.00]
        ];
        
        foreach ($equipos as $equipo) {
            $pdo->exec("INSERT IGNORE INTO equipos (cliente_id, numero_serie, marca, modelo, tipo_equipo, descripcion, cliente_nombre, cliente_telefono, cliente_email, costo_estimado, fecha_ingreso, estado, created_at, updated_at) 
                       VALUES ({$equipo[0]}, '{$equipo[1]}', '{$equipo[2]}', '{$equipo[3]}', '{$equipo[4]}', '{$equipo[5]}', '{$equipo[6]}', '{$equipo[7]}', '{$equipo[8]}', {$equipo[9]}, DATE_SUB(NOW(), INTERVAL FLOOR(RAND() * 10) DAY), 'reparado', NOW(), NOW())");
        }
        
        // Crear reparaciones de ejemplo
        $reparaciones = [
            [1, 1, 'Pantalla con rayones y manchas, rendimiento lento', 'Pantalla con daños físicos, sistema operativo lento por falta de mantenimiento', 'Limpieza completa del sistema, desfragmentación, limpieza de pantalla', 250.00, 'completada'],
            [2, 1, 'Computadora no enciende, sin señal de vida', 'Fuente de poder dañada, posible problema en placa madre', 'Reemplazo de fuente de poder, verificación de componentes', 180.00, 'completada'],
            [3, 1, 'Teclado con teclas que no responden, problema de conectividad', 'Teclado interno dañado, conexión suelta', 'Reemplazo de teclado interno, verificación de conexiones', 320.00, 'completada'],
            [4, 1, 'Batería no carga, se descarga muy rápido', 'Batería agotada, necesita reemplazo', 'Reemplazo de batería, calibración del sistema', 280.00, 'completada'],
            [5, 1, 'Sobrecalentamiento excesivo, rendimiento degradado', 'Acumulación de polvo en ventiladores, pasta térmica seca', 'Limpieza completa de ventiladores, reemplazo de pasta térmica', 450.00, 'completada']
        ];
        
        foreach ($reparaciones as $reparacion) {
            $pdo->exec("INSERT IGNORE INTO reparaciones (equipo_id, tecnico_id, descripcion_problema, diagnostico, solucion, costo, estado, fecha_inicio, fecha_fin, created_at, updated_at) 
                       VALUES ({$reparacion[0]}, {$reparacion[1]}, '{$reparacion[2]}', '{$reparacion[3]}', '{$reparacion[4]}', {$reparacion[5]}, '{$reparacion[6]}', DATE_SUB(NOW(), INTERVAL FLOOR(RAND() * 10) DAY), DATE_SUB(NOW(), INTERVAL FLOOR(RAND() * 5) DAY), NOW(), NOW())");
        }
        
        echo "✅ Datos de ejemplo creados (clientes, equipos, reparaciones).\n";
    }
    
    // Obtener reparaciones para crear tickets
    $stmt = $pdo->query("SELECT r.id, r.equipo_id, r.costo, e.cliente_nombre, e.cliente_telefono, e.cliente_email, e.marca, e.modelo 
                        FROM reparaciones r 
                        JOIN equipos e ON r.equipo_id = e.id 
                        WHERE r.estado = 'completada'");
    $reparaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (empty($reparaciones)) {
        echo "❌ No se encontraron reparaciones completadas para crear tickets.\n";
        exit(1);
    }
    
    // Crear tickets
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
    
    $ticketCounter = 1;
    
    foreach ($reparaciones as $reparacion) {
        $tipoTicket = $tiposTicket[array_rand($tiposTicket)];
        $estado = $estados[array_rand($estados)];
        
        // Generar número de ticket
        $fecha = date('ymd');
        $prefijo = match($tipoTicket) {
            'ingreso' => 'ING',
            'entrega' => 'ENT',
            'servicio' => 'SRV',
            default => 'TKT'
        };
        $numeroTicket = sprintf('%s-%s-%04d', $prefijo, $fecha, $ticketCounter++);
        
        // Calcular costos
        $costoServicio = $reparacion['costo'] * 0.7;
        $costoRepuestos = $reparacion['costo'] * 0.3;
        $total = $costoServicio + $costoRepuestos;
        
        // Fechas
        $fechaGeneracion = date('Y-m-d H:i:s', strtotime('-' . rand(1, 10) . ' days'));
        $fechaFirma = null;
        $fechaEntrega = null;
        
        if ($estado === 'firmado' || $estado === 'entregado') {
            $fechaFirma = date('Y-m-d H:i:s', strtotime($fechaGeneracion . ' +' . rand(1, 24) . ' hours'));
        }
        
        if ($estado === 'entregado') {
            $fechaEntrega = date('Y-m-d H:i:s', strtotime($fechaFirma . ' +' . rand(1, 48) . ' hours'));
        }
        
        // Crear ticket
        $sql = "INSERT INTO tickets (
            numero_ticket, tipo_ticket, reparacion_id, descripcion_servicio, 
            observaciones_tecnico, observaciones_cliente, costo_servicio, 
            costo_repuestos, total, estado, fecha_generacion, fecha_firma, 
            fecha_entrega, nombre_quien_firma, dpi_quien_firma, 
            condiciones_servicio, tiempo_garantia_dias, observaciones_generales,
            created_at, updated_at
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            $numeroTicket,
            $tipoTicket,
            $reparacion['id'],
            $descripcionesServicio[array_rand($descripcionesServicio)],
            $observacionesTecnico[array_rand($observacionesTecnico)],
            'Cliente satisfecho con el servicio recibido',
            $costoServicio,
            $costoRepuestos,
            $total,
            $estado,
            $fechaGeneracion,
            $fechaFirma,
            $fechaEntrega,
            $reparacion['cliente_nombre'],
            '1234567890123',
            $condicionesServicio[array_rand($condicionesServicio)],
            rand(30, 90),
            'Ticket generado automáticamente por el sistema'
        ]);
        
        echo "✅ Ticket creado: {$numeroTicket} - {$tipoTicket} - {$estado}\n";
    }
    
    echo "\n🎉 ¡Tickets insertados exitosamente en la base de datos!\n";
    echo "📊 Puedes ver los tickets en: /tickets\n";
    echo "🔢 Total de tickets creados: " . count($reparaciones) . "\n";
    
} catch (PDOException $e) {
    echo "❌ Error de base de datos: " . $e->getMessage() . "\n";
    exit(1);
} catch (Exception $e) {
    echo "❌ Error general: " . $e->getMessage() . "\n";
    exit(1);
}
