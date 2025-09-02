-- Script para eliminar el campo CUI de la tabla técnicos
-- Ejecuta este SQL si ya tienes el campo CUI en tu base de datos y quieres eliminarlo

-- Verificar si el campo CUI existe y eliminarlo
SET @sql = IF(
    (SELECT COUNT(*) 
     FROM INFORMATION_SCHEMA.COLUMNS 
     WHERE TABLE_SCHEMA = DATABASE() 
       AND TABLE_NAME = 'tecnicos' 
       AND COLUMN_NAME = 'cui') > 0,
    'ALTER TABLE tecnicos DROP COLUMN cui',
    'SELECT "El campo CUI no existe en la tabla tecnicos" as mensaje'
);

PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- También eliminar el índice del CUI si existe
SET @sql = IF(
    (SELECT COUNT(*) 
     FROM INFORMATION_SCHEMA.STATISTICS 
     WHERE TABLE_SCHEMA = DATABASE() 
       AND TABLE_NAME = 'tecnicos' 
       AND INDEX_NAME = 'idx_cui') > 0,
    'ALTER TABLE tecnicos DROP INDEX idx_cui',
    'SELECT "El índice idx_cui no existe en la tabla tecnicos" as mensaje'
);

PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;
