<?php
require_once __DIR__ . '/../conexion.php';

class SedeModel {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    
    public function getAll() {
        $stmt = $this->db->query("SELECT * FROM sede ORDER BY sede_nombre");
        return $stmt->fetchAll();
    }
    
    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM sede WHERE sede_id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    
    public function create($data) {
        $stmt = $this->db->prepare("INSERT INTO sede (sede_nombre) VALUES (?)");
        return $stmt->execute([
            $data['sede_nombre']
        ]);
    }
    
    public function update($id, $data) {
        $stmt = $this->db->prepare("UPDATE sede SET sede_nombre = ? WHERE sede_id = ?");
        return $stmt->execute([
            $data['sede_nombre'],
            $id
        ]);
    }
    
    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM sede WHERE sede_id = ?");
        return $stmt->execute([$id]);
    }
}
?>
