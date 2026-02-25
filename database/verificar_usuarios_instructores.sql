-- Script para verificar y corregir datos de instructores
USE `progsena`;

-- 1. Ver usuarios instructores y su instructor_id
SELECT 
    u.id as usuario_id,
    u.nombre,
    u.email,
    u.rol,
    u.instructor_id,
    i.inst_nombres,
    i.inst_apellidos
FROM usuarios u
LEFT JOIN instructor i ON u.instructor_id = i.inst_id
WHERE u.rol = 'Instructor';

-- 2. Ver asignaciones del instructor con ID 2 (Jose Lopez)
SELECT 
    a.asig_id,
    a.instructor_inst_id,
    a.asig_fecha_ini,
    a.asig_fecha_fin,
    f.fich_numero,
    p.prog_denominacion,
    amb.amb_nombre,
    c.comp_nombre_corto
FROM asignacion a
LEFT JOIN ficha f ON a.ficha_fich_id = f.fich_id
LEFT JOIN programa p ON f.programa_prog_id = p.prog_codigo
LEFT JOIN ambiente amb ON a.ambiente_amb_id = amb.amb_id
LEFT JOIN competencia c ON a.competencia_comp_id = c.comp_id
WHERE a.instructor_inst_id = 2;

-- 3. Si no hay asignaciones, crear algunas de prueba
-- Primero verificar que existan los datos necesarios
SELECT 'Verificando datos necesarios...' as mensaje;

SELECT 'Fichas disponibles:' as tipo, fich_id, fich_numero FROM ficha LIMIT 5;
SELECT 'Ambientes disponibles:' as tipo, amb_id, amb_nombre FROM ambiente LIMIT 5;
SELECT 'Competencias disponibles:' as tipo, comp_id, comp_nombre_corto FROM competencia LIMIT 5;

-- 4. Crear asignaciones de prueba (DESCOMENTAR SI ES NECESARIO)
/*
INSERT INTO asignacion (instructor_inst_id, asig_fecha_ini, asig_fecha_fin, ficha_fich_id, ambiente_amb_id, competencia_comp_id)
VALUES 
    (2, '2024-03-01 08:00:00', '2024-03-01 12:00:00', 1, '101', 1),
    (2, '2024-03-02 14:00:00', '2024-03-02 18:00:00', 1, '102', 2),
    (2, '2024-03-05 08:00:00', '2024-03-05 12:00:00', 2, '101', 1);

SELECT 'Asignaciones de prueba creadas' as mensaje;
*/

-- 5. Verificar estructura de tabla asignacion
SHOW COLUMNS FROM asignacion;

-- 6. Contar asignaciones por instructor
SELECT 
    i.inst_id,
    i.inst_nombres,
    i.inst_apellidos,
    COUNT(a.asig_id) as total_asignaciones
FROM instructor i
LEFT JOIN asignacion a ON i.inst_id = a.instructor_inst_id
GROUP BY i.inst_id
ORDER BY total_asignaciones DESC;
