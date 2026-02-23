-- Tabla de usuarios para el sistema de login
USE dashboard_sena;

CREATE TABLE IF NOT EXISTS usuarios (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(200) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    rol ENUM('Administrador', 'Instructor', 'Coordinador') DEFAULT 'Instructor',
    estado ENUM('Activo', 'Inactivo') DEFAULT 'Activo',
    ultimo_acceso DATETIME,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Insertar usuarios de ejemplo con contraseñas encriptadas
-- ID 1: admin@sena.edu.co - Contraseña: admin123
-- ID 2: juan.perez@sena.edu.co - Contraseña: instructor123
-- ID 3: maria.garcia@sena.edu.co - Contraseña: coordinador123

INSERT INTO usuarios (nombre, email, password, rol, estado) VALUES
('Administrador SENA', 'admin@sena.edu.co', '$2y$10$aq5tzhF7AnWwPdDMRsUYEuVPmFre1rOG7vt2kefFbUasEO50cPBEm', 'Administrador', 'Activo'),
('Juan Pérez', 'juan.perez@sena.edu.co', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Instructor', 'Activo'),
('María García', 'maria.garcia@sena.edu.co', '$2y$10$vI8aWBnW3fID.ZQ4/zo1G.q1lRps.9cGLcZEiGDMVr5yUP1KUOYTa', 'Coordinador', 'Activo');
