<?php
require_once __DIR__ . '/../conexion.php';

class DetalleAsignacionModel {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    
    public function getAll() {
        $stmt = $this->db->query("
            SELECT da.*,
                   a.asig_id,
                   f.fich_id as ficha_numero,
                   CONCAT(i.inst_nombres, ' ', i.inst_apellidos) as instructor_nombre
            FROM detallexasignacion da
            LEFT JOIN asignacion a ON da.asignacion_asig_id = a.asig_id
            LEFT JOIN ficha f ON a.ficha_fich_id = f.fich_id
            LEFT JOIN instructor i ON a.instructor_inst_id = i.inst_id
            ORDER BY da.detasig_hora_ini DESC
        ");
        return $stmt->fetchAll();
    }
    
    public function getByAsignacion($asignacion_id) {
        $stmt = $this->db->prepare("
            SELECT * FROM detallexasignacion 
            WHERE asignacion_asig_id = ?
            ORDER BY detasig_hora_ini
        ");
        $stmt->execute([$asignacion_id]);
        return $stmt->fetchAll();
    }
    
    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM detallexasignacion WHERE detasig_id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    
    public function create($data) {
        $stmt = $this->db->prepare("
            INSERT INTO detallexasignacion (asignacion_asig_id, detasig_hora_ini, detasig_hora_fin) 
            VALUES (?, ?, ?)
        ");
        return $stmt->execute([
            $data['asignacion_asig_id'],
            $data['detasig_hora_ini'],
            $data['detasig_hora_fin']
        ]);
    }
    
    public function update($id, $data) {
        $stmt = $this->db->prepare("
            UPDATE detallexasignacion 
            SET asignacion_asig_id = ?, detasig_hora_ini = ?, detasig_hora_fin = ?
            WHERE detasig_id = ?
        ");
        return $stmt->execute([
            $data['asignacion_asig_id'],
            $data['detasig_hora_ini'],
            $data['detasig_hora_fin'],
            $id
        ]);
    }
    
    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM detallexasignacion WHERE detasig_id = ?");
        return $stmt->execute([$id]);
    }
}
?>
