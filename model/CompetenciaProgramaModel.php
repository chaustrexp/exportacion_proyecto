<?php
require_once __DIR__ . '/../conexion.php';

class CompetenciaProgramaModel {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    
    public function getAll() {
        $stmt = $this->db->query("
            SELECT cp.*,
                   p.prog_denominacion,
                   c.comp_nombre_corto
            FROM competxprograma cp
            LEFT JOIN programa p ON cp.programa_prog_id = p.prog_codigo
            LEFT JOIN competencia c ON cp.competencia_comp_id = c.comp_id
            ORDER BY p.prog_denominacion, c.comp_nombre_corto
        ");
        return $stmt->fetchAll();
    }
    
    public function getByPrograma($programa_id) {
        $stmt = $this->db->prepare("
            SELECT cp.*,
                   c.comp_nombre_corto,
                   c.comp_nombre_unidad_competencia,
                   c.comp_horas
            FROM competxprograma cp
            LEFT JOIN competencia c ON cp.competencia_comp_id = c.comp_id
            WHERE cp.programa_prog_id = ?
        ");
        $stmt->execute([$programa_id]);
        return $stmt->fetchAll();
    }
    
    public function create($data) {
        $stmt = $this->db->prepare("
            INSERT INTO competxprograma (programa_prog_id, competencia_comp_id) 
            VALUES (?, ?)
        ");
        return $stmt->execute([
            $data['programa_id'],
            $data['competencia_id']
        ]);
    }
    
    public function delete($programa_id, $competencia_id) {
        $stmt = $this->db->prepare("
            DELETE FROM competxprograma 
            WHERE programa_prog_id = ? AND competencia_comp_id = ?
        ");
        return $stmt->execute([$programa_id, $competencia_id]);
    }
}
?>
