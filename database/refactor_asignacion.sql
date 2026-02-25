-- Refactorización de tabla asignaciones para vincular con usuarios
USE `progsena`;

-- 1. Agregar columna instructor_id si no existe
SET @dbname = DATABASE();
SET @tablename = "asignacion";
SET @columnname = "instructor_id";
SET @preparedStatement = (SELECT IF(
  (SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
   WHERE TABLE_SCHEMA = @dbname
     AND TABLE_NAME = @tablename
     AND COLUMN_NAME = @columnname) > 0,
  "SELECT 1",
  "ALTER TABLE asignacion ADD COLUMN instructor_id INT NULL AFTER instructor_inst_id"
));
PREPARE stmt FROM @preparedStatement;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- 2. Migrar datos: Intentar vincular asignaciones existentes a usuarios basados en el instructor_id antiguo
-- Esto busca usuarios que tengan el mismo instructor_id que la asignación
UPDATE asignacion a
JOIN usuarios u ON a.instructor_inst_id = u.instructor_id
SET a.instructor_id = u.id
WHERE a.instructor_id IS NULL;

-- 3. Agregar clave foránea
-- Primero quitamos una si existe (opcional si sabemos que no hay)
-- ALTER TABLE asignacion DROP FOREIGN KEY fk_asignacion_usuario;
ALTER TABLE asignacion 
ADD CONSTRAINT fk_asignacion_usuario 
FOREIGN KEY (instructor_id) REFERENCES usuarios(id) 
ON DELETE SET NULL ON UPDATE CASCADE;

-- 4. Mostrar estado
SELECT 'Refactorización de asignaciones completada' as mensaje;
SELECT asig_id, instructor_inst_id, instructor_id FROM asignacion LIMIT 10;
