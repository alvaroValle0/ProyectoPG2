-- Script SQL para agregar la columna username a la tabla users
-- Ejecuta este script en tu base de datos MySQL

-- Agregar la columna username después de la columna name
ALTER TABLE `users` ADD COLUMN `username` VARCHAR(255) UNIQUE AFTER `name`;

-- Verificar que la columna se agregó correctamente
DESCRIBE `users`;

-- Opcional: Agregar un índice para mejorar el rendimiento
CREATE INDEX `users_username_index` ON `users` (`username`);

-- Mensaje de confirmación
SELECT 'Columna username agregada exitosamente' AS mensaje;
