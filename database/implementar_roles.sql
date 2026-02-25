-- Script para implementar roles: Coordinador e Instructor
USE `progsena`;

-- 1. Modificar la tabla usuarios para incluir el rol 'Coordinador'
-- Primero verificamos si el enum ya lo contiene o lo agregamos
ALTER TABLE `usuarios` 
MODIFY COLUMN `rol` ENUM('Administrador', 'Coordinador', 'Instructor') NOT NULL;

-- 2. Asegurar que existe el campo instructor_id (por si no se ejecutó crear_rol_instructor.sql anteriormente)
SET @dbname = DATABASE();
SET @tablename = "usuarios";
SET @columnname = "instructor_id";
SET @preparedStatement = (SELECT IF(
  (SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
   WHERE TABLE_SCHEMA = @dbname
     AND TABLE_NAME = @tablename
     AND COLUMN_NAME = @columnname) > 0,
  "SELECT 1",
  "ALTER TABLE usuarios ADD COLUMN instructor_id INT NULL AFTER rol, ADD CONSTRAINT fk_usuarios_instructor FOREIGN KEY (instructor_id) REFERENCES instructor (inst_id) ON DELETE SET NULL ON UPDATE CASCADE"
));
PREPARE stmt FROM @preparedStatement;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- 3. Insertar/Actualizar usuarios de prueba
-- Contraseña: admin123 para el coordinador
-- Contraseña: instructor123 para el instructor

-- Insertar Coordinador si no existe
INSERT INTO `usuarios` (`nombre`, `email`, `password`, `rol`, `estado`) 
SELECT 'Coordinador Académico', 'coordinador@sena.edu.co', '$2y$10$aq5tzhF7AnWwPdDMRsUYEuVPmFre1rOG7vt2kefFbUasEO50cPBEm', 'Coordinador', 'Activo'
WHERE NOT EXISTS (SELECT 1 FROM usuarios WHERE email = 'coordinador@sena.edu.co');

-- Actualizar si ya existe pero tiene otro rol
UPDATE `usuarios` SET `rol` = 'Coordinador' WHERE email = 'coordinador@sena.edu.co';

-- Asegurar que el instructor de prueba existe vinculandolo a un id real de la tabla instructor si es posible
-- Si no, simplemente lo creamos como el script anterior
INSERT INTO `usuarios` (`nombre`, `email`, `password`, `rol`, `estado`)
SELECT 'Instructor de Prueba', 'instructor@sena.edu.co', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Instructor', 'Activo'
WHERE NOT EXISTS (SELECT 1 FROM usuarios WHERE email = 'instructor@sena.edu.co');

SELECT 'Base de datos actualizada con éxito' as mensaje;
