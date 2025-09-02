-- Agregar campos faltantes a la tabla técnicos
-- Ejecuta este SQL en tu base de datos MySQL

ALTER TABLE tecnicos 
ADD COLUMN nombres VARCHAR(255) NULL AFTER user_id,
ADD COLUMN apellidos VARCHAR(255) NULL AFTER nombres,
ADD COLUMN telefono VARCHAR(20) NULL AFTER apellidos,
ADD COLUMN email_personal VARCHAR(255) NULL AFTER telefono,
ADD COLUMN dpi VARCHAR(20) NULL AFTER email_personal,
ADD COLUMN foto VARCHAR(255) NULL AFTER dpi,
ADD COLUMN direccion TEXT NULL AFTER foto,
ADD COLUMN fecha_nacimiento DATE NULL AFTER direccion,
ADD COLUMN genero ENUM('masculino', 'femenino', 'otro') NULL AFTER fecha_nacimiento,
ADD COLUMN estado_civil VARCHAR(255) NULL AFTER genero,
ADD COLUMN contacto_emergencia TEXT NULL AFTER estado_civil,
ADD COLUMN fecha_contratacion DATE NULL AFTER contacto_emergencia,
ADD COLUMN nivel_experiencia ENUM('principiante', 'intermedio', 'avanzado', 'experto') NULL AFTER fecha_contratacion;

-- Agregar índices para mejorar el rendimiento
ALTER TABLE tecnicos 
ADD INDEX idx_dpi (dpi),
ADD INDEX idx_especialidad (especialidad),
ADD INDEX idx_activo (activo);
