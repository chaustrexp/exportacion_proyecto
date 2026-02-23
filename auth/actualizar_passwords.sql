USE dashboard_sena;

-- Actualizar contraseñas con el hash correcto
-- ID 1: admin@sena.edu.co - Contraseña: admin123
UPDATE usuarios SET password = '$2y$10$aq5tzhF7AnWwPdDMRsUYEuVPmFre1rOG7vt2kefFbUasEO50cPBEm' WHERE id = 1;

-- ID 2: juan.perez@sena.edu.co - Contraseña: instructor123
UPDATE usuarios SET password = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi' WHERE id = 2;

-- ID 3: maria.garcia@sena.edu.co - Contraseña: coordinador123
UPDATE usuarios SET password = '$2y$10$vI8aWBnW3fID.ZQ4/zo1G.q1lRps.9cGLcZEiGDMVr5yUP1KUOYTa' WHERE id = 3;

SELECT 'Contraseñas actualizadas correctamente' as mensaje;
SELECT id, nombre, email, rol, estado FROM usuarios;
