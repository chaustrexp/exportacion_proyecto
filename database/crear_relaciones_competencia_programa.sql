-- Script para crear relaciones entre Competencias y Programas
-- Ejecuta este script si no tienes relaciones en la tabla competxprograma

-- Primero, verifica qué programas y competencias tienes
SELECT 'PROGRAMAS DISPONIBLES:' as info;
SELECT prog_codigo, prog_denominacion FROM programa;

SELECT 'COMPETENCIAS DISPONIBLES:' as info;
SELECT comp_id, comp_nombre_corto FROM competencia;

-- Ejemplo: Crear relaciones entre programas y competencias
-- IMPORTANTE: Ajusta los IDs según los datos de tu base de datos

-- Ejemplo 1: Asociar competencia 1 con programa 122
-- INSERT INTO competxprograma (PROGRAMA_prog_id, COMPETENCIA_comp_id) 
-- VALUES (122, 1);

-- Ejemplo 2: Asociar competencia 2 con programa 122
-- INSERT INTO competxprograma (PROGRAMA_prog_id, COMPETENCIA_comp_id) 
-- VALUES (122, 2);

-- Ejemplo 3: Asociar competencia 1 con programa 123
-- INSERT INTO competxprograma (PROGRAMA_prog_id, COMPETENCIA_comp_id) 
-- VALUES (123, 1);

-- INSTRUCCIONES:
-- 1. Ejecuta la primera parte para ver qué programas y competencias tienes
-- 2. Descomenta y ajusta los INSERT según tus necesidades
-- 3. Ejecuta los INSERT para crear las relaciones

-- Verificar las relaciones creadas
SELECT 'RELACIONES CREADAS:' as info;
SELECT cp.*, 
       p.prog_denominacion as programa,
       c.comp_nombre_corto as competencia
FROM competxprograma cp
LEFT JOIN programa p ON cp.PROGRAMA_prog_id = p.prog_codigo
LEFT JOIN competencia c ON cp.COMPETENCIA_comp_id = c.comp_id;
