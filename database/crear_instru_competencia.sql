CREATE TABLE IF NOT EXISTS `instru_competencia` (
  `inscomp_id` INT NOT NULL AUTO_INCREMENT,
  `INSTRUCTOR_inst_id` INT NOT NULL,
  `COMPETxPROGRAMA_PROGRAMA_prog_id` INT NOT NULL,
  `COMPETxPROGRAMA_COMPETENCIA_comp_id` INT NOT NULL,
  `inscomp_vigencia` DATE NOT NULL,
  PRIMARY KEY (`inscomp_id`),
  FOREIGN KEY (`INSTRUCTOR_inst_id`) REFERENCES `instructor` (`inst_id`)
    ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (`COMPETxPROGRAMA_PROGRAMA_prog_id`, `COMPETxPROGRAMA_COMPETENCIA_comp_id`)
    REFERENCES `compet_programa` (`programa_prog_id`, `competencia_comp_id`)
    ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB;
