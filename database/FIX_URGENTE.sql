-- FIX URGENTE - Ejecutar en phpMyAdmin
-- Selecciona la base de datos progsena primero

USE progsena;

-- Eliminar y recrear la tabla programa con AUTO_INCREMENT
DROP TABLE IF EXISTS competxprograma;
DROP TABLE IF EXISTS ficha;
DROP TABLE IF EXISTS programa;

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

-- Recrear competxprograma
CREATE TABLE `competxprograma` (
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

-- Recrear ficha
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

-- Verificar
SHOW CREATE TABLE programa;
