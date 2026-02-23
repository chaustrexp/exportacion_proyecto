-- Script para agregar AUTO_INCREMENT a las tablas existentes
-- Ejecutar este script en phpMyAdmin para corregir el problema

USE progsena;

-- Modificar tabla titulo_programa
ALTER TABLE `titulo_programa` 
MODIFY COLUMN `titpro_id` INT NOT NULL AUTO_INCREMENT;

-- Modificar tabla programa
ALTER TABLE `programa` 
MODIFY COLUMN `prog_codigo` INT NOT NULL AUTO_INCREMENT;

-- Modificar tabla competencia
ALTER TABLE `competencia` 
MODIFY COLUMN `comp_id` INT NOT NULL AUTO_INCREMENT;

-- Modificar tabla centro_formacion
ALTER TABLE `centro_formacion` 
MODIFY COLUMN `cent_id` INT NOT NULL AUTO_INCREMENT;

-- Modificar tabla instructor
ALTER TABLE `instructor` 
MODIFY COLUMN `inst_id` INT NOT NULL AUTO_INCREMENT;

-- Modificar tabla coordinacion
ALTER TABLE `coordinacion` 
MODIFY COLUMN `coord_id` INT NOT NULL AUTO_INCREMENT;

-- Modificar tabla ficha
ALTER TABLE `ficha` 
MODIFY COLUMN `fich_id` INT NOT NULL AUTO_INCREMENT;

-- Modificar tabla sede
ALTER TABLE `sede` 
MODIFY COLUMN `sede_id` INT NOT NULL AUTO_INCREMENT;

-- Verificar los cambios
SHOW CREATE TABLE programa;
SHOW CREATE TABLE titulo_programa;
SHOW CREATE TABLE competencia;
SHOW CREATE TABLE centro_formacion;
SHOW CREATE TABLE instructor;
SHOW CREATE TABLE coordinacion;
SHOW CREATE TABLE ficha;
SHOW CREATE TABLE sede;
