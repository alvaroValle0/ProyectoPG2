-- Script SQL para asignar usernames a usuarios existentes
-- Ejecuta este script DESPUÉS de agregar la columna username

-- Actualizar usuarios existentes con usernames basados en su nombre
-- Este script asigna usernames únicos basados en el nombre del usuario

-- Usuario 1 (si existe)
UPDATE `users` 
SET `username` = 'admin' 
WHERE `id` = 1 AND (`username` IS NULL OR `username` = '');

-- Usuario 2 (si existe)
UPDATE `users` 
SET `username` = 'usuario2' 
WHERE `id` = 2 AND (`username` IS NULL OR `username` = '');

-- Usuario 3 (si existe)
UPDATE `users` 
SET `username` = 'usuario3' 
WHERE `id` = 3 AND (`username` IS NULL OR `username` = '');

-- Para usuarios con nombres específicos, puedes usar:
-- UPDATE `users` SET `username` = LOWER(REPLACE(REPLACE(`name`, ' ', ''), '.', '')) WHERE `username` IS NULL OR `username` = '';

-- Verificar los usuarios actualizados
SELECT `id`, `name`, `username`, `email` FROM `users`;

-- Mensaje de confirmación
SELECT 'Usuarios actualizados exitosamente' AS mensaje;
