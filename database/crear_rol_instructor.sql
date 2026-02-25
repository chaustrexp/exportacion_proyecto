-- Script para agregar rol de Instructor
USE `progsena`;

-- Modificar tabla usuarios para soportar múltiples roles
ALTER TABLE `usuarios` 
MODIFY COLUMN `rol` ENUM('Administrador', 'Instructor') NOT NULL DEFAULT 'Administrador';

-- Agregar campo instructor_id para vincular con la tabla instructor
ALTER TABLE `usuarios` 
ADD COLUMN `instructor_id` INT NULL AFTER `rol`,
ADD CONSTRAINT `fk_usuarios_instructor` 
  FOREIGN KEY (`instructor_id`) 
  REFERENCES `instructor` (`inst_id`) 
  ON DELETE SET NULL 
  ON UPDATE CASCADE;

-- Crear usuarios instructores basados en los instructores existentes
-- Contraseña por defecto: instructor123

INSERT INTO `usuarios` (`nombre`, `email`, `password`, `rol`, `instructor_id`, `estado`)
SELECT 
    CONCAT(i.inst_nombres, ' ', i.inst_apellidos) as nombre,
    i.inst_correo as email,
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi' as password, -- instructor123
    'Instructor' as rol,
    i.inst_id as instructor_id,
    'Activo' as estado
FROM instructor i
WHERE i.inst_correo IS NOT NULL 
  AND i.inst_correo != ''
  AND NOT EXISTS (
    SELECT 1 FROM usuarios u WHERE u.email = i.inst_correo
  );

-- Mostrar usuarios creados
SELECT 
    u.id,
    u.nombre,
    u.email,
    u.rol,
    u.instructor_id,
    u.estado,
    'Contraseña: instructor123' as nota
FROM usuarios u
WHERE u.rol = 'Instructor';

SELECT 'Rol de Instructor creado exitosamente' as mensaje;
