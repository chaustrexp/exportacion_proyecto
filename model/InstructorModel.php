<?php
require_once __DIR__ . '/../conexion.php';

class InstructorModel {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    
    public function getAll() {
        $stmt = $this->db->query("
            SELECT i.*, cf.cent_nombre 
            FROM instructor i
            LEFT JOIN centro_formacion cf ON i.centro_formacion_cent_id = cf.cent_id
            ORDER BY i.inst_apellidos, i.inst_nombres
        ");
        return $stmt->fetchAll();
    }
    
    public function getById($id) {
        $stmt = $this->db->prepare("
            SELECT i.*, cf.cent_nombre 
            FROM instructor i
            LEFT JOIN centro_formacion cf ON i.centro_formacion_cent_id = cf.cent_id
            WHERE i.inst_id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    
    public function create($data) {
        $stmt = $this->db->prepare("
            INSERT INTO instructor (inst_nombres, inst_apellidos, inst_correo, inst_telefono, centro_formacion_cent_id) 
            VALUES (?, ?, ?, ?, ?)
        ");
        return $stmt->execute([
            $data['inst_nombres'],
            $data['inst_apellidos'],
            $data['inst_correo'],
            $data['inst_telefono'],
            $data['centro_formacion_cent_id']
        ]);
    }
    
    public function update($id, $data) {
        $stmt = $this->db->prepare("
            UPDATE instructor 
            SET inst_nombres = ?, inst_apellidos = ?, inst_correo = ?, inst_telefono = ?, centro_formacion_cent_id = ?
            WHERE inst_id = ?
        ");
        return $stmt->execute([
            $data['inst_nombres'],
            $data['inst_apellidos'],
            $data['inst_correo'],
            $data['inst_telefono'],
            $data['centro_formacion_cent_id'],
            $id
        ]);
    }
    
    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM instructor WHERE inst_id = ?");
        return $stmt->execute([$id]);
    }
    
    public function count() {
        $stmt = $this->db->query("SELECT COUNT(*) as total FROM instructor");
        $result = $stmt->fetch();
        return $result['total'];
    }
}
?>
