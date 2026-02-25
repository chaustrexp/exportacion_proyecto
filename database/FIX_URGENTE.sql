-- FIX URGENTE: Verificar y corregir usuario instructor
USE `progsena`;

-- 1. Ver todos los usuarios y su estado
SELECT id, nombre, email, rol, estado, instructor_id 
FROM usuarios;

-- 2. Verificar específicamente el usuario joselop@sena.edu.co
SELECT id, nombre, email, rol, estado, instructor_id, password
FROM usuarios 
WHERE email = 'joselop@sena.edu.co';

-- 3. Si el usuario existe pero está inactivo, activarlo:
UPDATE usuarios 
SET estado = 'Activo' 
WHERE email = 'joselop@sena.edu.co';

-- 4. Si el usuario no existe, crearlo:
INSERT INTO usuarios (nombre, email, password, rol, instructor_id, estado)
SELECT 'Jose Lopez', 'joselop@sena.edu.co', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Instructor', 2, 'Activo'
WHERE NOT EXISTS (SELECT 1 FROM usuarios WHERE email = 'joselop@sena.edu.co');

-- 5. Verificar que el instructor existe en la tabla instructor
SELECT inst_id, inst_nombres, inst_apellidos, inst_correo 
FROM instructor 
WHERE inst_id = 2;

-- 6. Si no existe el instructor, crearlo:
INSERT INTO instructor (inst_id, inst_nombres, inst_apellidos, inst_correo, inst_telefono, centro_formacion_cent_id)
SELECT 2, 'Jose', 'Lopez', 'joselop@sena.edu.co', 3001234567, 1
WHERE NOT EXISTS (SELECT 1 FROM instructor WHERE inst_id = 2);

-- 7. Verificar resultado final
SELECT 
    u.id as usuario_id,
    u.nombre,
    u.email,
    u.rol,
    u.estado,
    u.instructor_id,
    i.inst_nombres,
    i.inst_apellidos
FROM usuarios u
LEFT JOIN instructor i ON u.instructor_id = i.inst_id
WHERE u.email = 'joselop@sena.edu.co';

-- 8. Verificar que exista al menos un centro de formación
SELECT * FROM centro_formacion LIMIT 1;

-- Si no existe, crear uno:
INSERT INTO centro_formacion (cent_id, cent_nombre)
SELECT 1, 'Centro de Formación SENA Cúcuta'
WHERE NOT EXISTS (SELECT 1 FROM centro_formacion WHERE cent_id = 1);

SELECT '✅ Script ejecutado. Verifica los resultados arriba.' as mensaje;
SELECT 'Credenciales: joselop@sena.edu.co / instructor123' as credenciales;
