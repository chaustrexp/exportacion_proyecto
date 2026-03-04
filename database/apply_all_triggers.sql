-- Script combinado: Auditoría y Validación de Horas
USE `progsena`;

-- 1. Crear tabla de auditoría si no existe
CREATE TABLE IF NOT EXISTS AUDITORIA_ASIGNACION (
    audit_id INT AUTO_INCREMENT PRIMARY KEY,
    ASIGNACION_ASIG_ID INT,
    audit_accion VARCHAR(20) NOT NULL,
    audit_fecha_hora DATETIME DEFAULT CURRENT_TIMESTAMP,
    usuario_ejecutor_id INT NULL,
    usuario_ejecutor_rol VARCHAR(50) NULL,
    datos_anteriores JSON NULL,
    datos_nuevos JSON NULL,
    audit_ip VARCHAR(45) NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Limpieza de triggers previos para evitar errores de duplicado
DROP TRIGGER IF EXISTS before_asignacion_insert_check;
DROP TRIGGER IF EXISTS trg_asignacion_insert;
DROP TRIGGER IF EXISTS trg_asignacion_update;
DROP TRIGGER IF EXISTS trg_asignacion_delete;

DELIMITER //

-- 2. Trigger de Validación de Horas (Opción 2: Basado en Competencia)
-- Este trigger evita que se asigne una competencia que supere las 20 horas
CREATE TRIGGER before_asignacion_insert_check
BEFORE INSERT ON asignacion
FOR EACH ROW
BEGIN
    DECLARE v_horas INT;
    
    -- Buscamos las horas de la competencia que se intenta asignar
    -- Se usa un IF NULL por si la competencia no tiene el campo definido
    SELECT comp_horas INTO v_horas 
    FROM competencia 
    WHERE comp_id = NEW.competencia_comp_id;
    
    -- Si la competencia tiene más de 180 horas, bloqueamos el registro
    IF v_horas > 180 THEN
        SIGNAL SQLSTATE '45000' 
        SET MESSAGE_TEXT = 'Error: La competencia seleccionada supera el límite de 180 horas permitidas para una asignación individual.';
    END IF;
END //

-- 3. Triggers de Auditoría (Capturan quién hizo qué)

-- Trigger para INSERT
CREATE TRIGGER trg_asignacion_insert
AFTER INSERT ON asignacion
FOR EACH ROW
BEGIN
    INSERT INTO AUDITORIA_ASIGNACION (
        ASIGNACION_ASIG_ID, 
        audit_accion, 
        datos_nuevos
    ) VALUES (
        NEW.asig_id, 
        'INSERT', 
        JSON_OBJECT(
            'instructor_inst_id', NEW.instructor_inst_id,
            'ficha_fich_id', NEW.ficha_fich_id,
            'ambiente_amb_id', NEW.ambiente_amb_id,
            'competencia_comp_id', NEW.competencia_comp_id,
            'fecha_ini', NEW.asig_fecha_ini,
            'fecha_fin', NEW.asig_fecha_fin
        )
    );
END //

-- Trigger para UPDATE
CREATE TRIGGER trg_asignacion_update
BEFORE UPDATE ON asignacion
FOR EACH ROW
BEGIN
    INSERT INTO AUDITORIA_ASIGNACION (
        ASIGNACION_ASIG_ID, 
        audit_accion, 
        datos_anteriores, 
        datos_nuevos
    ) VALUES (
        OLD.asig_id, 
        'UPDATE', 
        JSON_OBJECT(
            'instructor_inst_id', OLD.instructor_inst_id,
            'ficha_fich_id', OLD.ficha_fich_id,
            'ambiente_amb_id', OLD.ambiente_amb_id,
            'competencia_comp_id', OLD.competencia_comp_id,
            'fecha_ini', OLD.asig_fecha_ini,
            'fecha_fin', OLD.asig_fecha_fin
        ),
        JSON_OBJECT(
            'instructor_inst_id', NEW.instructor_inst_id,
            'ficha_fich_id', NEW.ficha_fich_id,
            'ambiente_amb_id', NEW.ambiente_amb_id,
            'competencia_comp_id', NEW.competencia_comp_id,
            'fecha_ini', NEW.asig_fecha_ini,
            'fecha_fin', NEW.asig_fecha_fin
        )
    );
END //

-- Trigger para DELETE
CREATE TRIGGER trg_asignacion_delete
BEFORE DELETE ON asignacion
FOR EACH ROW
BEGIN
    INSERT INTO AUDITORIA_ASIGNACION (
        ASIGNACION_ASIG_ID, 
        audit_accion, 
        datos_anteriores
    ) VALUES (
        OLD.asig_id, 
        'DELETE', 
        JSON_OBJECT(
            'instructor_inst_id', OLD.instructor_inst_id,
            'ficha_fich_id', OLD.ficha_fich_id,
            'ambiente_amb_id', OLD.ambiente_amb_id,
            'competencia_comp_id', OLD.competencia_comp_id,
            'fecha_ini', OLD.asig_fecha_ini,
            'fecha_fin', OLD.asig_fecha_fin
        )
    );
END //

DELIMITER ;
