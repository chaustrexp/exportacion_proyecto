<?php
require_once __DIR__ . '/../conexion.php';

class ProgramaModel {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    
    public function getAll() {
        $stmt = $this->db->query("
            SELECT p.*, tp.titpro_nombre,
                   GROUP_CONCAT(DISTINCT f.fich_numero ORDER BY f.fich_numero SEPARATOR ', ') as fichas_numeros
            FROM programa p
            LEFT JOIN titulo_programa tp ON p.titulo_programa_titpro_id = tp.titpro_id
            LEFT JOIN ficha f ON f.PROGRAMA_prog_id = p.prog_codigo
            GROUP BY p.prog_codigo
            ORDER BY p.prog_denominacion
        ");
        return $stmt->fetchAll();
    }
    
    public function getById($id) {
        $stmt = $this->db->prepare("
            SELECT p.*, tp.titpro_nombre 
            FROM programa p
            LEFT JOIN titulo_programa tp ON p.titulo_programa_titpro_id = tp.titpro_id
            WHERE p.prog_codigo = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    
    public function create($data) {
        $stmt = $this->db->prepare("
            INSERT INTO programa (prog_denominacion, titulo_programa_titpro_id, prog_tipo) 
            VALUES (?, ?, ?)
        ");
        return $stmt->execute([
            $data['prog_denominacion'],
            $data['titulo_programa_titpro_id'],
            $data['prog_tipo'] ?? null
        ]);
    }
    
    public function update($id, $data) {
        $stmt = $this->db->prepare("
            UPDATE programa 
            SET prog_denominacion = ?, titulo_programa_titpro_id = ?, prog_tipo = ?
            WHERE prog_codigo = ?
        ");
        return $stmt->execute([
            $data['prog_denominacion'],
            $data['titulo_programa_titpro_id'],
            $data['prog_tipo'],
            $id
        ]);
    }
    
    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM programa WHERE prog_codigo = ?");
        return $stmt->execute([$id]);
    }
    
    public function count() {
        $stmt = $this->db->query("SELECT COUNT(*) as total FROM programa");
        $result = $stmt->fetch();
        return $result['total'];
    }
}
?>
