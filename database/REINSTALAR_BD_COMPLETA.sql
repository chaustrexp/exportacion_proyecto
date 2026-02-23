-- ============================================
-- REINSTALACIÓN COMPLETA DE LA BASE DE DATOS
-- ============================================
-- Este script elimina TODO y crea la BD desde cero
-- Ejecutar en phpMyAdmin

USE progsena;

-- Desactivar verificación de claves foráneas
SET FOREIGN_KEY_CHECKS = 0;

-- Eliminar TODAS las tablas (todas las variaciones posibles)
DROP TABLE IF EXISTS `detallexasignacion`;
DROP TABLE IF EXISTS `detalle_asignacion`;
DROP TABLE IF EXISTS `asignacion`;
DROP TABLE IF EXISTS `competxprograma`;
DROP TABLE IF EXISTS `competencia_programa`;
DROP TABLE IF EXISTS `compet_programa`;
DROP TABLE IF EXISTS `ficha`;
DROP TABLE IF EXISTS `ambiente`;
DROP TABLE IF EXISTS `sede`;
DROP TABLE IF EXISTS `instructor`;
DROP TABLE IF EXISTS `coordinacion`;
DROP TABLE IF EXISTS `programa`;
DROP TABLE IF EXISTS `competencia`;
DROP TABLE IF EXISTS `centro_formacion`;
DROP TABLE IF EXISTS `titulo_programa`;
DROP TABLE IF EXISTS `usuarios`;

-- Reactivar verificación de claves foráneas
SET FOREIGN_KEY_CHECKS = 1;

-- ============================================
-- CREAR TODAS LAS TABLAS CON AUTO_INCREMENT
-- ============================================

-- Tabla titulo_programa
CREATE TABLE `titulo_programa` (
  `titpro_id` INT NOT NULL AUTO_INCREMENT,
  `titpro_nombre` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`titpro_id`)
) ENGINE = InnoDB;

-- Tabla programa
CREATE TABLE `programa` (
  `prog_codigo` INT NOT NULL AUTO_INCREMENT,
  `prog_denominacion` VARCHAR(100) NOT NULL,
  `titulo_programa_titpro_id` INT NOT NULL,
  `prog_tipo` VARCHAR(30) NOT NULL,
  PRIMARY KEY (`prog_codigo`),
  INDEX `fk_programa_titulo_programa_idx` (`titulo_programa_titpro_id` ASC),
  CONSTRAINT `fk_programa_titulo_programa`
    FOREIGN KEY (`titulo_programa_titpro_id`)
    REFERENCES `titulo_programa` (`titpro_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
) ENGINE = InnoDB;

-- Tabla competencia
CREATE TABLE `competencia` (
  `comp_id` INT NOT NULL AUTO_INCREMENT,
  `comp_nombre_corto` VARCHAR(30) NOT NULL,
  `comp_horas` INT NOT NULL,
  `comp_nombre_unidad_competencia` VARCHAR(150) NOT NULL,
  PRIMARY KEY (`comp_id`)
) ENGINE = InnoDB;

-- Tabla competxprograma (CON X)
CREATE TABLE `compet_programa` (
  `programa_prog_id` INT NOT NULL,
  `competencia_comp_id` INT NOT NULL,
  PRIMARY KEY (`programa_prog_id`, `competencia_comp_id`),
  INDEX `fk_competxprograma_competencia_idx` (`competencia_comp_id` ASC),
  CONSTRAINT `fk_competxprograma_programa`
    FOREIGN KEY (`programa_prog_id`)
    REFERENCES `programa` (`prog_codigo`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_competxprograma_competencia`
    FOREIGN KEY (`competencia_comp_id`)
    REFERENCES `competencia` (`comp_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
) ENGINE = InnoDB;

-- Tabla centro_formacion
CREATE TABLE `centro_formacion` (
  `cent_id` INT NOT NULL AUTO_INCREMENT,
  `cent_nombre` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`cent_id`)
) ENGINE = InnoDB;

-- Tabla instructor
CREATE TABLE `instructor` (
  `inst_id` INT NOT NULL AUTO_INCREMENT,
  `inst_nombres` VARCHAR(45) NULL,
  `inst_apellidos` VARCHAR(45) NULL,
  `inst_correo` VARCHAR(45) NULL,
  `inst_telefono` BIGINT(10) NULL,
  `centro_formacion_cent_id` INT NOT NULL,
  PRIMARY KEY (`inst_id`),
  INDEX `fk_instructor_centro_formacion_idx` (`centro_formacion_cent_id` ASC),
  CONSTRAINT `fk_instructor_centro_formacion`
    FOREIGN KEY (`centro_formacion_cent_id`)
    REFERENCES `centro_formacion` (`cent_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
) ENGINE = InnoDB;

-- Tabla coordinacion
CREATE TABLE `coordinacion` (
  `coord_id` INT NOT NULL AUTO_INCREMENT,
  `coord_nombre` VARCHAR(45) NOT NULL,
  `centro_formacion_cent_id` INT NOT NULL,
  PRIMARY KEY (`coord_id`),
  INDEX `fk_coordinacion_centro_formacion_idx` (`centro_formacion_cent_id` ASC),
  CONSTRAINT `fk_coordinacion_centro_formacion`
    FOREIGN KEY (`centro_formacion_cent_id`)
    REFERENCES `centro_formacion` (`cent_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
) ENGINE = InnoDB;

-- Tabla ficha (CON CAMPOS ADICIONALES)
CREATE TABLE `ficha` (
  `fich_id` INT NOT NULL AUTO_INCREMENT,
  `fich_numero` VARCHAR(20) NULL,
  `programa_prog_id` INT NOT NULL,
  `instructor_inst_id_lider` INT NOT NULL,
  `fich_jornada` VARCHAR(20) NOT NULL,
  `fich_fecha_ini_lectiva` DATE NULL,
  `fich_fecha_fin_lectiva` DATE NULL,
  `coordinacion_coord_id` INT NOT NULL,
  PRIMARY KEY (`fich_id`),
  INDEX `fk_ficha_programa_idx` (`programa_prog_id` ASC),
  INDEX `fk_ficha_instructor_idx` (`instructor_inst_id_lider` ASC),
  INDEX `fk_ficha_coordinacion_idx` (`coordinacion_coord_id` ASC),
  CONSTRAINT `fk_ficha_programa`
    FOREIGN KEY (`programa_prog_id`)
    REFERENCES `programa` (`prog_codigo`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ficha_instructor`
    FOREIGN KEY (`instructor_inst_id_lider`)
    REFERENCES `instructor` (`inst_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ficha_coordinacion`
    FOREIGN KEY (`coordinacion_coord_id`)
    REFERENCES `coordinacion` (`coord_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
) ENGINE = InnoDB;

-- Tabla sede
CREATE TABLE `sede` (
  `sede_id` INT NOT NULL AUTO_INCREMENT,
  `sede_nombre` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`sede_id`)
) ENGINE = InnoDB;

-- Tabla ambiente
CREATE TABLE `ambiente` (
  `amb_id` VARCHAR(5) NOT NULL,
  `amb_nombre` VARCHAR(45) NULL,
  `sede_sede_id` INT NOT NULL,
  PRIMARY KEY (`amb_id`),
  INDEX `fk_ambiente_sede_idx` (`sede_sede_id` ASC),
  CONSTRAINT `fk_ambiente_sede`
    FOREIGN KEY (`sede_sede_id`)
    REFERENCES `sede` (`sede_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
) ENGINE = InnoDB;

-- Tabla asignacion
CREATE TABLE `asignacion` (
  `instructor_inst_id` INT NOT NULL,
  `asig_fecha_ini` DATETIME NOT NULL,
  `asig_fecha_fin` DATETIME NOT NULL,
  `ficha_fich_id` INT NOT NULL,
  `ambiente_amb_id` VARCHAR(5) NOT NULL,
  `competencia_comp_id` INT NOT NULL,
  `asig_id` INT NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`asig_id`),
  INDEX `fk_asignacion_instructor_idx` (`instructor_inst_id` ASC),
  INDEX `fk_asignacion_ficha_idx` (`ficha_fich_id` ASC),
  INDEX `fk_asignacion_ambiente_idx` (`ambiente_amb_id` ASC),
  INDEX `fk_asignacion_competencia_idx` (`competencia_comp_id` ASC),
  CONSTRAINT `fk_asignacion_instructor`
    FOREIGN KEY (`instructor_inst_id`)
    REFERENCES `instructor` (`inst_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_asignacion_ficha`
    FOREIGN KEY (`ficha_fich_id`)
    REFERENCES `ficha` (`fich_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_asignacion_ambiente`
    FOREIGN KEY (`ambiente_amb_id`)
    REFERENCES `ambiente` (`amb_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_asignacion_competencia`
    FOREIGN KEY (`competencia_comp_id`)
    REFERENCES `competencia` (`comp_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
) ENGINE = InnoDB;

-- Tabla detallexasignacion (CON X)
CREATE TABLE `detalle_asignacion` (
  `asignacion_asig_id` INT NOT NULL,
  `detasig_hora_ini` DATETIME NOT NULL,
  `detasig_hora_fin` DATETIME NOT NULL,
  `detasig_id` INT NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`detasig_id`),
  INDEX `fk_detallexasignacion_asignacion_idx` (`asignacion_asig_id` ASC),
  CONSTRAINT `fk_detallexasignacion_asignacion`
    FOREIGN KEY (`asignacion_asig_id`)
    REFERENCES `asignacion` (`asig_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
) ENGINE = InnoDB;

-- Tabla usuarios
CREATE TABLE `usuarios` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(100) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `nombre` VARCHAR(100) NULL,
  `rol` ENUM('Administrador') NOT NULL DEFAULT 'Administrador',
  `activo` TINYINT(1) NOT NULL DEFAULT 1,
  `fecha_creacion` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `email_UNIQUE` (`email` ASC)
) ENGINE = InnoDB;

-- Insertar usuario administrador
INSERT INTO usuarios (email, password, nombre, rol) 
VALUES ('admin@sena.edu.co', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Administrador', 'Administrador');

-- ============================================
-- VERIFICACIÓN
-- ============================================

SELECT 'Base de datos creada correctamente' as resultado;

SHOW TABLES;
