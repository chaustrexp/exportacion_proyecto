<?php
require_once __DIR__ . '/../conexion.php';

/**
 * Modelo FichaModel
 * Centraliza el acceso a la tabla 'ficha', gestionando la información de fechas de etapa lectiva
 * y vinculación con programas de formación.
 */
class FichaModel {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    
    public function getAll() {
        $stmt = $this->db->query("
            SELECT f.*, 
                   p.prog_denominacion,
                   CONCAT(i.inst_nombres, ' ', i.inst_apellidos) as instructor_lider,
                   c.coord_nombre
            FROM ficha f
            LEFT JOIN programa p ON f.programa_prog_id = p.prog_codigo
            LEFT JOIN instructor i ON f.instructor_inst_id_lider = i.inst_id
            LEFT JOIN coordinacion c ON f.coordinacion_coord_id = c.coord_id
            ORDER BY f.fich_id DESC
        ");
        return $stmt->fetchAll();
    }
    
    public function getById($id) {
        $stmt = $this->db->prepare("
            SELECT f.*, 
                   p.prog_denominacion,
                   p.prog_codigo,
                   CONCAT(i.inst_nombres, ' ', i.inst_apellidos) as instructor_lider,
                   i.inst_id as instructor_id,
                   c.coord_nombre,
                   c.coord_id
            FROM ficha f
            LEFT JOIN programa p ON f.programa_prog_id = p.prog_codigo
            LEFT JOIN instructor i ON f.instructor_inst_id_lider = i.inst_id
            LEFT JOIN coordinacion c ON f.coordinacion_coord_id = c.coord_id
            WHERE f.fich_id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    
    public function create($data) {
        $stmt = $this->db->prepare("
            INSERT INTO ficha (fich_numero, programa_prog_id, instructor_inst_id_lider, fich_jornada, fich_fecha_ini_lectiva, fich_fecha_fin_lectiva, coordinacion_coord_id) 
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");
        return $stmt->execute([
            $data['fich_numero'] ?? null,
            $data['PROGRAMA_prog_id'] ?? $data['programa_prog_id'] ?? null,
            $data['INSTRUCTOR_inst_id_lider'] ?? $data['instructor_inst_id_lider'] ?? null,
            $data['fich_jornada'] ?? null,
            $data['fich_fecha_ini_lectiva'] ?? null,
            $data['fich_fecha_fin_lectiva'] ?? null,
            $data['COORDINACION_coord_id'] ?? $data['coordinacion_coord_id'] ?? null
        ]);
    }
    
    public function update($id, $data) {
        $stmt = $this->db->prepare("
            UPDATE ficha 
            SET fich_numero = ?, programa_prog_id = ?, instructor_inst_id_lider = ?, fich_jornada = ?, fich_fecha_ini_lectiva = ?, fich_fecha_fin_lectiva = ?, coordinacion_coord_id = ?
            WHERE fich_id = ?
        ");
        return $stmt->execute([
            $data['fich_numero'] ?? null,
            $data['PROGRAMA_prog_id'] ?? $data['programa_prog_id'] ?? null,
            $data['INSTRUCTOR_inst_id_lider'] ?? $data['instructor_inst_id_lider'] ?? null,
            $data['fich_jornada'] ?? null,
            $data['fich_fecha_ini_lectiva'] ?? null,
            $data['fich_fecha_fin_lectiva'] ?? null,
            $data['COORDINACION_coord_id'] ?? $data['coordinacion_coord_id'] ?? null,
            $id
        ]);
    }
    
    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM ficha WHERE fich_id = ?");
        return $stmt->execute([$id]);
    }
    
    public function count() {
        $stmt = $this->db->query("SELECT COUNT(*) as total FROM ficha");
        $result = $stmt->fetch();
        return $result['total'];
    }
}
?>
