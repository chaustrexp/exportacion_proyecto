<?php
require_once __DIR__ . '/../conexion.php';

class AmbienteModel {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    
    public function getAll() {
        $stmt = $this->db->query("
            SELECT a.*, s.sede_nombre 
            FROM ambiente a
            LEFT JOIN sede s ON a.sede_sede_id = s.sede_id
            ORDER BY a.amb_nombre
        ");
        return $stmt->fetchAll();
    }
    
    public function getById($id) {
        $stmt = $this->db->prepare("
            SELECT a.*, s.sede_nombre 
            FROM ambiente a
            LEFT JOIN sede s ON a.sede_sede_id = s.sede_id
            WHERE a.amb_id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    
    public function create($data) {
        $stmt = $this->db->prepare("
            INSERT INTO ambiente (amb_id, amb_nombre, sede_sede_id) 
            VALUES (?, ?, ?)
        ");
        return $stmt->execute([
            $data['codigo'],
            $data['nombre'],
            $data['sede_id']
        ]);
    }
    
    public function update($id, $data) {
        $stmt = $this->db->prepare("
            UPDATE ambiente 
            SET amb_nombre = ?, sede_sede_id = ? 
            WHERE amb_id = ?
        ");
        return $stmt->execute([
            $data['nombre'],
            $data['sede_id'],
            $id
        ]);
    }
    
    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM ambiente WHERE amb_id = ?");
        return $stmt->execute([$id]);
    }
    
    public function count() {
        $stmt = $this->db->query("SELECT COUNT(*) as total FROM ambiente");
        $result = $stmt->fetch();
        return $result['total'];
    }
}
?>
