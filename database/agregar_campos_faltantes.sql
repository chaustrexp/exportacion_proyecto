-- Script para agregar campos faltantes a la tabla ficha
-- Ejecutar en phpMyAdmin

USE progsena;

-- Agregar campos faltantes a la tabla ficha
ALTER TABLE `ficha` 
ADD COLUMN `fich_numero` VARCHAR(20) NULL AFTER `fich_id`,
ADD COLUMN `fich_fecha_ini_lectiva` DATE NULL AFTER `fich_jornada`,
ADD COLUMN `fich_fecha_fin_lectiva` DATE NULL AFTER `fich_fecha_ini_lectiva`;

-- Verificar la estructura
DESCRIBE ficha;
