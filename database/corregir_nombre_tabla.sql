-- Script para corregir los nombres de las tablas
-- Las tablas tienen nombres con guión bajo pero el código usa nombres con X

USE `progsena`;

-- Renombrar tablas para que coincidan con el código
-- Esto es más fácil que actualizar todo el código PHP

-- 1. Tabla de competencias por programa
RENAME TABLE `compet_programa` TO `competxprograma`;

-- 2. Tabla de detalle de asignación
RENAME TABLE `detalle_asignacion` TO `detallexasignacion`;

-- Verificar que los cambios se aplicaron
SHOW TABLES;

SELECT 'Tablas renombradas correctamente' as mensaje;
