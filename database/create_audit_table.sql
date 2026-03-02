-- Script de creación de tabla de auditoría y triggers para ASIGNACION

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

-- Trigger para INSERT
DELIMITER //
CREATE TRIGGER trg_asignacion_insert
AFTER INSERT ON asignacion
FOR EACH ROW
BEGIN
    INSERT INTO AUDITORIA_ASIGNACION (
        ASIGNACION_ASIG_ID, 
        audit_accion, 
        datos_nuevos,
        usuario_ejecutor_id,
        usuario_ejecutor_rol
    ) VALUES (
        NEW.asig_id, 
        'INSERT', 
        JSON_OBJECT(
            'instructor_inst_id', NEW.instructor_inst_id,
            'instructor_id', NEW.instructor_id,
            'ficha_fich_id', NEW.ficha_fich_id,
            'ambiente_amb_id', NEW.ambiente_amb_id,
            'competencia_comp_id', NEW.competencia_comp_id,
            'fecha_ini', NEW.asig_fecha_ini,
            'fecha_fin', NEW.asig_fecha_fin
        ),
        @usuario_id, 
        @usuario_rol
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
        datos_nuevos,
        usuario_ejecutor_id,
        usuario_ejecutor_rol
    ) VALUES (
        OLD.asig_id, 
        'UPDATE', 
        JSON_OBJECT(
            'instructor_inst_id', OLD.instructor_inst_id,
            'instructor_id', OLD.instructor_id,
            'ficha_fich_id', OLD.ficha_fich_id,
            'ambiente_amb_id', OLD.ambiente_amb_id,
            'competencia_comp_id', OLD.competencia_comp_id,
            'fecha_ini', OLD.asig_fecha_ini,
            'fecha_fin', OLD.asig_fecha_fin
        ),
        JSON_OBJECT(
            'instructor_inst_id', NEW.instructor_inst_id,
            'instructor_id', NEW.instructor_id,
            'ficha_fich_id', NEW.ficha_fich_id,
            'ambiente_amb_id', NEW.ambiente_amb_id,
            'competencia_comp_id', NEW.competencia_comp_id,
            'fecha_ini', NEW.asig_fecha_ini,
            'fecha_fin', NEW.asig_fecha_fin
        ),
        @usuario_id,
        @usuario_rol
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
        datos_anteriores,
        usuario_ejecutor_id,
        usuario_ejecutor_rol
    ) VALUES (
        OLD.asig_id, 
        'DELETE', 
        JSON_OBJECT(
            'instructor_inst_id', OLD.instructor_inst_id,
            'instructor_id', OLD.instructor_id,
            'ficha_fich_id', OLD.ficha_fich_id,
            'ambiente_amb_id', OLD.ambiente_amb_id,
            'competencia_comp_id', OLD.competencia_comp_id,
            'fecha_ini', OLD.asig_fecha_ini,
            'fecha_fin', OLD.asig_fecha_fin
        ),
        @usuario_id,
        @usuario_rol
    );
END //
DELIMITER ;
