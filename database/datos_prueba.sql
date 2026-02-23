-- Datos de Prueba para ProgSENA
-- Ejecuta este archivo después de importar la estructura

USE `progsena`;

-- Insertar Centros de Formación
INSERT INTO `centro_formacion` (`cent_id`, `cent_nombre`) VALUES
(1, 'Centro de Formación Cúcuta'),
(2, 'Centro de Formación Bucaramanga');

-- Insertar Sedes
INSERT INTO `sede` (`sede_id`, `sede_nombre`) VALUES
(1, 'Sede Principal'),
(2, 'Sede Norte');

-- Insertar Ambientes
INSERT INTO `ambiente` (`amb_id`, `amb_nombre`, `sede_sede_id`) VALUES
('A101', 'Laboratorio de Sistemas', 1),
('A102', 'Aula Múltiple', 1),
('B201', 'Taller de Mecánica', 2);

-- Insertar Títulos de Programa
INSERT INTO `titulo_programa` (`titpro_id`, `titpro_nombre`) VALUES
(1, 'Técnico'),
(2, 'Tecnólogo'),
(3, 'Especialización');

-- Insertar Programas
INSERT INTO `programa` (`prog_codigo`, `prog_denominacion`, `titulo_programa_titpro_id`, `prog_tipo`) VALUES
(228106, 'Análisis y Desarrollo de Software', 2, 'Tecnólogo'),
(228120, 'Gestión de Redes de Datos', 2, 'Tecnólogo'),
(123456, 'Sistemas', 1, 'Técnico');

-- Insertar Competencias
INSERT INTO `competencia` (`comp_id`, `comp_nombre_corto`, `comp_horas`, `comp_nombre_unidad_competencia`) VALUES
(1, 'Programación', 200, 'Desarrollar software aplicando técnicas de programación'),
(2, 'Bases de Datos', 150, 'Diseñar e implementar bases de datos'),
(3, 'Redes', 180, 'Configurar y administrar redes de datos');

-- Relacionar Competencias con Programas
INSERT INTO `competxprograma` (`programa_prog_id`, `competencia_comp_id`) VALUES
(228106, 1),
(228106, 2),
(228120, 3);

-- Insertar Instructores
INSERT INTO `instructor` (`inst_id`, `inst_nombres`, `inst_apellidos`, `inst_correo`, `inst_telefono`, `centro_formacion_cent_id`) VALUES
(1, 'Juan Carlos', 'Pérez García', 'juan.perez@sena.edu.co', 3001234567, 1),
(2, 'María Fernanda', 'González López', 'maria.gonzalez@sena.edu.co', 3009876543, 1),
(3, 'Pedro Antonio', 'Martínez Ruiz', 'pedro.martinez@sena.edu.co', 3005551234, 2);

-- Insertar Coordinaciones
INSERT INTO `coordinacion` (`coord_id`, `coord_nombre`, `centro_formacion_cent_id`) VALUES
(1, 'Coordinación de Sistemas', 1),
(2, 'Coordinación de Redes', 1);

-- Insertar Fichas
INSERT INTO `ficha` (`fich_id`, `programa_prog_id`, `instructor_inst_id_lider`, `fich_jornada`, `coordinacion_coord_id`) VALUES
(2567890, 228106, 1, 'Diurna', 1),
(2567891, 228120, 2, 'Nocturna', 2),
(2567892, 228106, 3, 'Mixta', 1);

-- Insertar Asignaciones
INSERT INTO `asignacion` (`instructor_inst_id`, `asig_fecha_ini`, `asig_fecha_fin`, `ficha_fich_id`, `ambiente_amb_id`, `competencia_comp_id`) VALUES
(1, '2026-02-01 08:00:00', '2026-02-01 12:00:00', 2567890, 'A101', 1),
(2, '2026-02-01 14:00:00', '2026-02-01 18:00:00', 2567891, 'A102', 3),
(3, '2026-02-02 08:00:00', '2026-02-02 12:00:00', 2567892, 'B201', 1);

SELECT 'Datos de prueba insertados correctamente' as mensaje;
