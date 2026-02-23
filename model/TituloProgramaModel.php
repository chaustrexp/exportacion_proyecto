<?php
require_once __DIR__ . '/../conexion.php';

class TituloProgramaModel {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    
    public function getAll() {
        $stmt = $this->db->query("SELECT * FROM titulo_programa ORDER BY titpro_nombre");
        return $stmt->fetchAll();
    }
    
    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM titulo_programa WHERE titpro_id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    
    public function create($data) {
        $stmt = $this->db->prepare("INSERT INTO titulo_programa (titpro_nombre) VALUES (?)");
        return $stmt->execute([
            $data['titpro_nombre']
        ]);
    }
    
    public function update($id, $data) {
        $stmt = $this->db->prepare("UPDATE titulo_programa SET titpro_nombre = ? WHERE titpro_id = ?");
        return $stmt->execute([
            $data['titpro_nombre'],
            $id
        ]);
    }
    
    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM titulo_programa WHERE titpro_id = ?");
        return $stmt->execute([$id]);
    }
}
?>
