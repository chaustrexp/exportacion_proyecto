<?php
require_once __DIR__ . '/../conexion.php';

class CoordinacionModel {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    
    public function getAll() {
        $stmt = $this->db->query("
            SELECT c.*, cf.cent_nombre 
            FROM coordinacion c
            LEFT JOIN centro_formacion cf ON c.centro_formacion_cent_id = cf.cent_id
            ORDER BY c.coord_nombre
        ");
        return $stmt->fetchAll();
    }
    
    public function getById($id) {
        $stmt = $this->db->prepare("
            SELECT c.*, cf.cent_nombre 
            FROM coordinacion c
            LEFT JOIN centro_formacion cf ON c.centro_formacion_cent_id = cf.cent_id
            WHERE c.coord_id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    
    public function create($data) {
        $stmt = $this->db->prepare("
            INSERT INTO coordinacion (coord_nombre, centro_formacion_cent_id) 
            VALUES (?, ?)
        ");
        return $stmt->execute([
            $data['coord_nombre'],
            $data['centro_formacion_cent_id']
        ]);
    }
    
    public function update($id, $data) {
        $stmt = $this->db->prepare("
            UPDATE coordinacion 
            SET coord_nombre = ?, centro_formacion_cent_id = ?
            WHERE coord_id = ?
        ");
        return $stmt->execute([
            $data['coord_nombre'],
            $data['centro_formacion_cent_id'],
            $id
        ]);
    }
    
    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM coordinacion WHERE coord_id = ?");
        return $stmt->execute([$id]);
    }
}
?>
