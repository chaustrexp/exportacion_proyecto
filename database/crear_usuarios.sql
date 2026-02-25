-- Crear usuarios del sistema con las credenciales correctas
USE `progsena`;

-- 1. Generar hash para la contraseña "password"
-- Hash: $2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi

-- 2. Verificar usuarios existentes
SELECT 'Usuarios actuales:' as info;
SELECT id, nombre, email, rol, estado, instructor_id FROM usuarios;

-- 3. Eliminar usuario instructor@sena.edu.co si existe (para recrearlo limpio)
DELETE FROM usuarios WHERE email = 'instructor@sena.edu.co';

-- 4. Crear usuario instructor con credenciales correctas
INSERT INTO usuarios (nombre, email, password, rol, instructor_id, estado, fecha_creacion)
VALUES (
    'Instructor SENA',
    'instructor@sena.edu.co',
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
    'Instructor',
    2,
    'Activo',
    NOW()
);

-- 5. Verificar que el instructor existe en la tabla instructor
SELECT 'Verificando instructor en tabla instructor:' as info;
SELECT inst_id, inst_nombres, inst_apellidos, inst_correo FROM instructor WHERE inst_id = 2;

-- 6. Si no existe el instructor, crearlo
INSERT INTO instructor (inst_id, inst_nombres, inst_apellidos, inst_correo, inst_telefono, centro_formacion_cent_id)
SELECT 2, 'Instructor', 'SENA', 'instructor@sena.edu.co', 3001234567, 1
WHERE NOT EXISTS (SELECT 1 FROM instructor WHERE inst_id = 2);

-- 7. Verificar que existe al menos un centro de formación
INSERT INTO centro_formacion (cent_id, cent_nombre)
SELECT 1, 'Centro de Formación SENA Cúcuta'
WHERE NOT EXISTS (SELECT 1 FROM centro_formacion WHERE cent_id = 1);

-- 8. Actualizar el centro_formacion_cent_id del instructor si es necesario
UPDATE instructor SET centro_formacion_cent_id = 1 WHERE inst_id = 2 AND centro_formacion_cent_id IS NULL;

-- 9. Verificar resultado final
SELECT '✅ Usuario instructor creado/actualizado:' as info;
SELECT 
    u.id,
    u.nombre,
    u.email,
    u.rol,
    u.estado,
    u.instructor_id,
    i.inst_nombres,
    i.inst_apellidos,
    i.inst_correo
FROM usuarios u
LEFT JOIN instructor i ON u.instructor_id = i.inst_id
WHERE u.email = 'instructor@sena.edu.co';

-- 10. Verificar asignaciones del instructor
SELECT 'Asignaciones del instructor:' as info;
SELECT COUNT(*) as total_asignaciones 
FROM asignacion 
WHERE instructor_inst_id = 2;

-- 11. Resumen de credenciales
SELECT '========================================' as separador;
SELECT '✅ CREDENCIALES ACTUALIZADAS' as titulo;
SELECT '========================================' as separador;
SELECT 'Email: instructor@sena.edu.co' as credencial_1;
SELECT 'Password: password' as credencial_2;
SELECT 'URL Login: http://localhost/exportacion_proyecto/auth/login.php' as url;
SELECT '========================================' as separador;
