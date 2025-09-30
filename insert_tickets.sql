-- Script SQL para insertar datos de tickets directamente en la base de datos

-- Limpiar datos existentes de tickets
DELETE FROM tickets;

-- Crear usuario admin si no existe
INSERT IGNORE INTO users (name, username, email, password, role, email_verified_at, created_at, updated_at) 
VALUES ('Administrador HDC', 'admin', 'admin@hdc.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', NOW(), NOW(), NOW());

-- Crear técnico si no existe
INSERT IGNORE INTO tecnicos (user_id, especialidad, experiencia_anos, telefono, activo, created_at, updated_at) 
VALUES (1, 'Reparación General', 5, '5555-1234', 1, NOW(), NOW());

-- Crear clientes de ejemplo
INSERT IGNORE INTO clientes (nombres, apellidos, telefono, email, direccion, dpi, activo, created_at, updated_at) VALUES
('María Elena', 'González Pérez', '5555-0001', 'maria.gonzalez@email.com', 'Zona 10, Ciudad de Guatemala', '1234567890123', 1, NOW(), NOW()),
('Carlos Alberto', 'Rodríguez López', '5555-0002', 'carlos.rodriguez@email.com', 'Zona 15, Ciudad de Guatemala', '2345678901234', 1, NOW(), NOW()),
('Ana Lucía', 'Martínez Silva', '5555-0003', 'ana.martinez@email.com', 'Zona 1, Ciudad de Guatemala', '3456789012345', 1, NOW(), NOW()),
('Roberto Carlos', 'Hernández García', '5555-0004', 'roberto.hernandez@email.com', 'Zona 7, Ciudad de Guatemala', '4567890123456', 1, NOW(), NOW()),
('Lesly Valle', 'Ruiz Morales', '5555-0005', 'lesly.valle@email.com', 'Zona 12, Ciudad de Guatemala', '5678901234567', 1, NOW(), NOW());

-- Crear equipos de ejemplo
INSERT IGNORE INTO equipos (cliente_id, numero_serie, marca, modelo, tipo_equipo, descripcion, cliente_nombre, cliente_telefono, cliente_email, costo_estimado, fecha_ingreso, estado, created_at, updated_at) VALUES
(1, 'LAP001-2024', 'HP', 'Pavilion Gaming 15', 'Laptop', 'Laptop para gaming con tarjeta gráfica dedicada', 'María Elena González Pérez', '5555-0001', 'maria.gonzalez@email.com', 250.00, DATE_SUB(NOW(), INTERVAL 10 DAY), 'reparado', NOW(), NOW()),
(2, 'DESK002-2024', 'Dell', 'OptiPlex 7090', 'Desktop', 'Computadora de escritorio para oficina', 'Carlos Alberto Rodríguez López', '5555-0002', 'carlos.rodriguez@email.com', 180.00, DATE_SUB(NOW(), INTERVAL 8 DAY), 'reparado', NOW(), NOW()),
(3, 'LAP003-2024', 'Lenovo', 'ThinkPad E15', 'Laptop', 'Laptop empresarial', 'Ana Lucía Martínez Silva', '5555-0003', 'ana.martinez@email.com', 320.00, DATE_SUB(NOW(), INTERVAL 6 DAY), 'reparado', NOW(), NOW()),
(4, 'LAP004-2024', 'ASUS', 'VivoBook S15', 'Laptop', 'Laptop ultrabook ligero', 'Roberto Carlos Hernández García', '5555-0004', 'roberto.hernandez@email.com', 280.00, DATE_SUB(NOW(), INTERVAL 4 DAY), 'reparado', NOW(), NOW()),
(5, 'LAP005-2024', 'LG', 'Pavilion Gaming', 'Laptop', 'Laptop gaming con pantalla 17 pulgadas', 'Lesly Valle Ruiz Morales', '5555-0005', 'lesly.valle@email.com', 450.00, DATE_SUB(NOW(), INTERVAL 2 DAY), 'reparado', NOW(), NOW());

-- Crear reparaciones de ejemplo
INSERT IGNORE INTO reparaciones (equipo_id, tecnico_id, descripcion_problema, diagnostico, solucion, costo, estado, fecha_inicio, fecha_fin, created_at, updated_at) VALUES
(1, 1, 'Pantalla con rayones y manchas, rendimiento lento', 'Pantalla con daños físicos, sistema operativo lento por falta de mantenimiento', 'Limpieza completa del sistema, desfragmentación, limpieza de pantalla', 250.00, 'completada', DATE_SUB(NOW(), INTERVAL 10 DAY), DATE_SUB(NOW(), INTERVAL 8 DAY), NOW(), NOW()),
(2, 1, 'Computadora no enciende, sin señal de vida', 'Fuente de poder dañada, posible problema en placa madre', 'Reemplazo de fuente de poder, verificación de componentes', 180.00, 'completada', DATE_SUB(NOW(), INTERVAL 8 DAY), DATE_SUB(NOW(), INTERVAL 6 DAY), NOW(), NOW()),
(3, 1, 'Teclado con teclas que no responden, problema de conectividad', 'Teclado interno dañado, conexión suelta', 'Reemplazo de teclado interno, verificación de conexiones', 320.00, 'completada', DATE_SUB(NOW(), INTERVAL 6 DAY), DATE_SUB(NOW(), INTERVAL 4 DAY), NOW(), NOW()),
(4, 1, 'Batería no carga, se descarga muy rápido', 'Batería agotada, necesita reemplazo', 'Reemplazo de batería, calibración del sistema', 280.00, 'completada', DATE_SUB(NOW(), INTERVAL 4 DAY), DATE_SUB(NOW(), INTERVAL 2 DAY), NOW(), NOW()),
(5, 1, 'Sobrecalentamiento excesivo, rendimiento degradado', 'Acumulación de polvo en ventiladores, pasta térmica seca', 'Limpieza completa de ventiladores, reemplazo de pasta térmica', 450.00, 'completada', DATE_SUB(NOW(), INTERVAL 2 DAY), DATE_SUB(NOW(), INTERVAL 1 DAY), NOW(), NOW());

-- Crear tickets de ejemplo
INSERT INTO tickets (
    numero_ticket, 
    tipo_ticket, 
    reparacion_id, 
    descripcion_servicio, 
    observaciones_tecnico, 
    observaciones_cliente, 
    costo_servicio, 
    costo_repuestos, 
    total, 
    estado, 
    fecha_generacion, 
    fecha_firma, 
    fecha_entrega, 
    nombre_quien_firma, 
    dpi_quien_firma, 
    condiciones_servicio, 
    tiempo_garantia_dias, 
    observaciones_generales,
    created_at, 
    updated_at
) VALUES
-- Ticket 1 - HP Pavilion Gaming
('ENT-250923-0001', 'entrega', 1, 'Reparación y mantenimiento de equipo informático', 'Equipo reparado exitosamente, funcionando correctamente', 'Cliente satisfecho con el servicio recibido', 175.00, 75.00, 250.00, 'generado', DATE_SUB(NOW(), INTERVAL 8 DAY), NULL, NULL, 'María Elena González Pérez', '1234567890123', 'Garantía de 30 días por defectos de fabricación', 30, 'Ticket generado automáticamente por el sistema', NOW(), NOW()),

-- Ticket 2 - Dell OptiPlex
('ING-250923-0002', 'ingreso', 2, 'Servicio técnico especializado en hardware', 'Mantenimiento preventivo realizado, equipo optimizado', 'Cliente satisfecho con el servicio recibido', 126.00, 54.00, 180.00, 'firmado', DATE_SUB(NOW(), INTERVAL 6 DAY), DATE_SUB(NOW(), INTERVAL 5 DAY), NULL, 'Carlos Alberto Rodríguez López', '2345678901234', 'Servicio técnico con garantía de 60 días', 60, 'Ticket generado automáticamente por el sistema', NOW(), NOW()),

-- Ticket 3 - Lenovo ThinkPad
('SRV-250923-0003', 'servicio', 3, 'Mantenimiento preventivo y correctivo', 'Reparación de componentes, equipo en perfecto estado', 'Cliente satisfecho con el servicio recibido', 224.00, 96.00, 320.00, 'entregado', DATE_SUB(NOW(), INTERVAL 4 DAY), DATE_SUB(NOW(), INTERVAL 3 DAY), DATE_SUB(NOW(), INTERVAL 2 DAY), 'Ana Lucía Martínez Silva', '3456789012345', 'Reparación con garantía extendida de 90 días', 90, 'Ticket generado automáticamente por el sistema', NOW(), NOW()),

-- Ticket 4 - ASUS VivoBook
('ENT-250923-0004', 'entrega', 4, 'Reparación de componentes electrónicos', 'Servicio técnico completado, cliente satisfecho', 'Cliente satisfecho con el servicio recibido', 196.00, 84.00, 280.00, 'firmado', DATE_SUB(NOW(), INTERVAL 2 DAY), DATE_SUB(NOW(), INTERVAL 1 DAY), NULL, 'Roberto Carlos Hernández García', '4567890123456', 'Mantenimiento con garantía de 45 días', 45, 'Ticket generado automáticamente por el sistema', NOW(), NOW()),

-- Ticket 5 - LG Pavilion Gaming
('ING-250923-0005', 'ingreso', 5, 'Servicio de limpieza y optimización', 'Reparación exitosa, garantía de 30 días', 'Cliente satisfecho con el servicio recibido', 315.00, 135.00, 450.00, 'generado', DATE_SUB(NOW(), INTERVAL 1 DAY), NULL, NULL, 'Lesly Valle Ruiz Morales', '5678901234567', 'Servicio especializado con garantía de 30 días', 30, 'Ticket generado automáticamente por el sistema', NOW(), NOW());

-- Mostrar resumen
SELECT 'Tickets creados exitosamente' as mensaje;
SELECT COUNT(*) as total_tickets FROM tickets;
SELECT estado, COUNT(*) as cantidad FROM tickets GROUP BY estado;
SELECT tipo_ticket, COUNT(*) as cantidad FROM tickets GROUP BY tipo_ticket;
