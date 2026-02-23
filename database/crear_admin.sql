-- Crear solo tabla de administradores
USE `progsena`;

-- Eliminar tabla si existe
DROP TABLE IF EXISTS `usuarios`;

-- Crear tabla de usuarios (solo administradores)
CREATE TABLE `usuarios` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(100) NOT NULL,
  `email` VARCHAR(100) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `rol` VARCHAR(20) NOT NULL DEFAULT 'Administrador',
  `estado` VARCHAR(20) NOT NULL DEFAULT 'Activo',
  `ultimo_acceso` DATETIME NULL,
  PRIMARY KEY (`id`)
) ENGINE = InnoDB;

-- Insertar administrador
-- Email: admin@sena.edu.co
-- Contraseña: admin123
INSERT INTO `usuarios` (`nombre`, `email`, `password`, `rol`, `estado`) VALUES
('Administrador SENA', 'admin@sena.edu.co', '$2y$10$aq5tzhF7AnWwPdDMRsUYEuVPmFre1rOG7vt2kefFbUasEO50cPBEm', 'Administrador', 'Activo');

SELECT 'Usuario administrador creado exitosamente' as mensaje;
SELECT * FROM usuarios;
