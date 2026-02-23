-- ============================================
-- SOLUCIÓN COMPLETA PARA LA BASE DE DATOS
-- ============================================
-- Este script soluciona TODOS los problemas:
-- 1. Agrega AUTO_INCREMENT a todas las tablas
-- 2. Agrega campos faltantes a la tabla ficha
-- 3. Verifica la estructura final
--
-- EJECUTAR EN: phpMyAdmin > Base de datos progsena > Pestaña SQL
-- ============================================

USE progsena;

-- ============================================
-- PASO 1: Agregar AUTO_INCREMENT
-- ============================================

ALTER TABLE `titulo_programa` 
MODIFY COLUMN `titpro_id` INT NOT NULL AUTO_INCREMENT;

ALTER TABLE `programa` 
MODIFY COLUMN `prog_codigo` INT NOT NULL AUTO_INCREMENT;

ALTER TABLE `competencia` 
MODIFY COLUMN `comp_id` INT NOT NULL AUTO_INCREMENT;

ALTER TABLE `centro_formacion` 
MODIFY COLUMN `cent_id` INT NOT NULL AUTO_INCREMENT;

ALTER TABLE `instructor` 
MODIFY COLUMN `inst_id` INT NOT NULL AUTO_INCREMENT;

ALTER TABLE `coordinacion` 
MODIFY COLUMN `coord_id` INT NOT NULL AUTO_INCREMENT;

ALTER TABLE `sede` 
MODIFY COLUMN `sede_id` INT NOT NULL AUTO_INCREMENT;

-- ============================================
-- PASO 2: Agregar campos faltantes a ficha
-- ============================================

-- Verificar si los campos ya existen antes de agregarlos
SET @dbname = 'progsena';
SET @tablename = 'ficha';

-- Agregar fich_numero si no existe
SET @col_exists = (SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS 
    WHERE TABLE_SCHEMA = @dbname AND TABLE_NAME = @tablename AND COLUMN_NAME = 'fich_numero');

SET @sql = IF(@col_exists = 0, 
    'ALTER TABLE ficha ADD COLUMN fich_numero VARCHAR(20) NULL AFTER fich_id', 
    'SELECT "Campo fich_numero ya existe" as mensaje');
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- Agregar fich_fecha_ini_lectiva si no existe
SET @col_exists = (SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS 
    WHERE TABLE_SCHEMA = @dbname AND TABLE_NAME = @tablename AND COLUMN_NAME = 'fich_fecha_ini_lectiva');

SET @sql = IF(@col_exists = 0, 
    'ALTER TABLE ficha ADD COLUMN fich_fecha_ini_lectiva DATE NULL AFTER fich_jornada', 
    'SELECT "Campo fich_fecha_ini_lectiva ya existe" as mensaje');
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- Agregar fich_fecha_fin_lectiva si no existe
SET @col_exists = (SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS 
    WHERE TABLE_SCHEMA = @dbname AND TABLE_NAME = @tablename AND COLUMN_NAME = 'fich_fecha_fin_lectiva');

SET @sql = IF(@col_exists = 0, 
    'ALTER TABLE ficha ADD COLUMN fich_fecha_fin_lectiva DATE NULL AFTER fich_fecha_ini_lectiva', 
    'SELECT "Campo fich_fecha_fin_lectiva ya existe" as mensaje');
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- Modificar ficha para agregar AUTO_INCREMENT
ALTER TABLE `ficha` 
MODIFY COLUMN `fich_id` INT NOT NULL AUTO_INCREMENT;

-- ============================================
-- PASO 3: Verificar estructura de tablas
-- ============================================

SELECT '=== VERIFICACIÓN DE AUTO_INCREMENT ===' as info;

SELECT 
    TABLE_NAME as tabla,
    COLUMN_NAME as columna,
    COLUMN_TYPE as tipo,
    EXTRA as extra
FROM INFORMATION_SCHEMA.COLUMNS
WHERE TABLE_SCHEMA = 'progsena'
    AND COLUMN_KEY = 'PRI'
ORDER BY TABLE_NAME;

-- ============================================
-- PASO 4: Verificar campos de ficha
-- ============================================

SELECT '=== ESTRUCTURA DE TABLA FICHA ===' as info;

DESCRIBE ficha;

-- ============================================
-- PASO 5: Contar registros
-- ============================================

SELECT '=== CONTEO DE REGISTROS ===' as info;

SELECT 'titulo_programa' as tabla, COUNT(*) as registros FROM titulo_programa
UNION ALL SELECT 'programa', COUNT(*) FROM programa
UNION ALL SELECT 'competencia', COUNT(*) FROM competencia
UNION ALL SELECT 'centro_formacion', COUNT(*) FROM centro_formacion
UNION ALL SELECT 'instructor', COUNT(*) FROM instructor
UNION ALL SELECT 'coordinacion', COUNT(*) FROM coordinacion
UNION ALL SELECT 'ficha', COUNT(*) FROM ficha
UNION ALL SELECT 'sede', COUNT(*) FROM sede
UNION ALL SELECT 'asignacion', COUNT(*) FROM asignacion
UNION ALL SELECT 'detallexasignacion', COUNT(*) FROM detallexasignacion
UNION ALL SELECT 'competxprograma', COUNT(*) FROM competxprograma;

-- ============================================
-- FIN DEL SCRIPT
-- ============================================

SELECT '✓ Script ejecutado correctamente' as resultado;
