-- Crear tabla de usuarios para autenticación
USE `progsena`;

-- Tabla de usuarios del sistema
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(100) NOT NULL,
  `email` VARCHAR(100) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `rol` ENUM('Administrador', 'Coordinador', 'Instructor') NOT NULL,
  `estado` ENUM('Activo', 'Inactivo') DEFAULT 'Activo',
  `ultimo_acceso` DATETIME NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `idx_email` (`email`),
  INDEX `idx_rol` (`rol`)
) ENGINE = InnoDB;

-- Insertar usuarios de prueba
-- Contraseña para todos: admin123
INSERT INTO `usuarios` (`nombre`, `email`, `password`, `rol`, `estado`) VALUES
('Administrador SENA', 'admin@sena.edu.co', '$2y$10$aq5tzhF7AnWwPdDMRsUYEuVPmFre1rOG7vt2kefFbUasEO50cPBEm', 'Administrador', 'Activo'),
('Coordinador Sistemas', 'coordinador@sena.edu.co', '$2y$10$aq5tzhF7AnWwPdDMRsUYEuVPmFre1rOG7vt2kefFbUasEO50cPBEm', 'Coordinador', 'Activo'),
('Juan Pérez', 'instructor@sena.edu.co', '$2y$10$aq5tzhF7AnWwPdDMRsUYEuVPmFre1rOG7vt2kefFbUasEO50cPBEm', 'Instructor', 'Activo');

SELECT 'Tabla de usuarios creada e inicializada' as mensaje;
SELECT id, nombre, email, rol, estado FROM usuarios;
