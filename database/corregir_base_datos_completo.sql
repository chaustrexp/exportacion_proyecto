-- Script completo para corregir la base de datos progsena
-- Ejecutar en phpMyAdmin

USE progsena;

-- ============================================
-- PASO 1: Agregar AUTO_INCREMENT a todas las tablas
-- ============================================

-- Tabla titulo_programa
ALTER TABLE `titulo_programa` 
MODIFY COLUMN `titpro_id` INT NOT NULL AUTO_INCREMENT;

-- Tabla programa
ALTER TABLE `programa` 
MODIFY COLUMN `prog_codigo` INT NOT NULL AUTO_INCREMENT;

-- Tabla competencia
ALTER TABLE `competencia` 
MODIFY COLUMN `comp_id` INT NOT NULL AUTO_INCREMENT;

-- Tabla centro_formacion
ALTER TABLE `centro_formacion` 
MODIFY COLUMN `cent_id` INT NOT NULL AUTO_INCREMENT;

-- Tabla instructor
ALTER TABLE `instructor` 
MODIFY COLUMN `inst_id` INT NOT NULL AUTO_INCREMENT;

-- Tabla coordinacion
ALTER TABLE `coordinacion` 
MODIFY COLUMN `coord_id` INT NOT NULL AUTO_INCREMENT;

-- Tabla ficha
ALTER TABLE `ficha` 
MODIFY COLUMN `fich_id` INT NOT NULL AUTO_INCREMENT;

-- Tabla sede
ALTER TABLE `sede` 
MODIFY COLUMN `sede_id` INT NOT NULL AUTO_INCREMENT;

-- ============================================
-- PASO 2: Renombrar tablas a nombres más estándar (OPCIONAL)
-- ============================================
-- Si prefieres nombres sin "x", descomenta estas líneas:

-- RENAME TABLE `competxprograma` TO `competencia_programa`;
-- RENAME TABLE `detallexasignacion` TO `detalle_asignacion`;

-- ============================================
-- VERIFICACIÓN: Mostrar estructura de tablas críticas
-- ============================================

SHOW CREATE TABLE programa;
SHOW CREATE TABLE titulo_programa;
SHOW CREATE TABLE competencia;
SHOW CREATE TABLE centro_formacion;
SHOW CREATE TABLE instructor;
SHOW CREATE TABLE coordinacion;
SHOW CREATE TABLE ficha;
SHOW CREATE TABLE sede;
SHOW CREATE TABLE asignacion;
SHOW CREATE TABLE detallexasignacion;
SHOW CREATE TABLE competxprograma;

-- ============================================
-- VERIFICAR DATOS EXISTENTES
-- ============================================

SELECT 'titulo_programa' as tabla, COUNT(*) as registros FROM titulo_programa
UNION ALL
SELECT 'programa', COUNT(*) FROM programa
UNION ALL
SELECT 'competencia', COUNT(*) FROM competencia
UNION ALL
SELECT 'centro_formacion', COUNT(*) FROM centro_formacion
UNION ALL
SELECT 'instructor', COUNT(*) FROM instructor
UNION ALL
SELECT 'coordinacion', COUNT(*) FROM coordinacion
UNION ALL
SELECT 'ficha', COUNT(*) FROM ficha
UNION ALL
SELECT 'sede', COUNT(*) FROM sede
UNION ALL
SELECT 'asignacion', COUNT(*) FROM asignacion
UNION ALL
SELECT 'detallexasignacion', COUNT(*) FROM detallexasignacion
UNION ALL
SELECT 'competxprograma', COUNT(*) FROM competxprograma;
