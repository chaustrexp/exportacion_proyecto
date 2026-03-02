-- ============================================================
-- Migración CU-01: Agregar columna inst_estado a la tabla instructor
-- Ejecutar en phpMyAdmin → Base de datos: progsena
-- ============================================================

ALTER TABLE `instructor` 
  ADD COLUMN `inst_estado` ENUM('Activo', 'Inactivo') NOT NULL DEFAULT 'Activo'
  AFTER `inst_telefono`;

-- Verificar que todos los existentes queden como Activo (ya es el DEFAULT)
UPDATE `instructor` SET `inst_estado` = 'Activo' WHERE `inst_estado` IS NULL;

-- También agregar campo norma y resultado_aprendizaje a competencia si no existen (CU-05)
ALTER TABLE `competencia`
  ADD COLUMN IF NOT EXISTS `comp_norma` VARCHAR(30) NULL AFTER `comp_nombre_corto`,
  ADD COLUMN IF NOT EXISTS `comp_resultado_aprendizaje` TEXT NULL AFTER `comp_norma`;

SELECT 'Migración aplicada correctamente.' AS resultado;
