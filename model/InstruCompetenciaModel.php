<?php
require_once __DIR__ . '/../conexion.php';

class InstruCompetenciaModel {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    
    // NOTA: Esta tabla no existe en el nuevo esquema de base de datos
    // Se mantiene el modelo para compatibilidad pero retorna arrays vacíos
    
    public function getAll() {
        return [];
    }
    
    public function getById($id) {
        return null;
    }
    
    public function getByInstructor($instructor_id) {
        return [];
    }
    
    public function create($data) {
        return false;
    }
    
    public function update($id, $data) {
        return false;
    }
    
    public function delete($id) {
        return false;
    }
    
    public function count() {
        return 0;
    }
    
    public function countVigentes() {
        return 0;
    }
}
?>
