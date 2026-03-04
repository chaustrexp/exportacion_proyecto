<?php
/**
 * ============================================================
 * InstruCompetenciaModel.php
 * ============================================================
 * Modelo STUB para la entidad Instructor-Competencia.
 *
 * NOTA DE COMPATIBILIDAD:
 * Esta tabla no existe en el esquema actual de la base de datos.
 * El modelo se mantiene como stub para que el sistema no falle
 * si algún controlador lo instancia. Todos los métodos retornan
 * valores vacíos/falsos en lugar de ejecutar consultas SQL.
 *
 * Si en el futuro se necesita gestionar la relación
 * instructor-competencia directamente, se debe crear la tabla
 * y completar los métodos con las consultas correspondientes.
 *
 * @package Models
 */

require_once __DIR__ . '/../config/conexion.php';

/**
 * Class InstruCompetenciaModel
 *
 * Stub model — todos los métodos devuelven valores vacíos.
 * No realiza ninguna operación en la base de datos.
 */
class InstruCompetenciaModel {

    /** @var PDO Conexión activa (no utilizada en la versión stub) */
    private $db;

    /**
     * Constructor: obtiene la conexión aunque no se use activamente.
     */
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    
    // NOTA: Esta tabla no existe en el nuevo esquema de base de datos
    // Se mantiene el modelo para compatibilidad pero retorna arrays vacíos
    
    public function getAll() {
        $stmt = $this->db->query("
            SELECT ic.*, 
                   i.inst_nombres, i.inst_apellidos,
                   p.prog_denominacion,
                   c.comp_nombre_corto
            FROM instru_competencia ic
            INNER JOIN instructor i ON ic.INSTRUCTOR_inst_id = i.inst_id
            INNER JOIN programa p ON ic.COMPETxPROGRAMA_PROGRAMA_prog_id = p.prog_codigo
            INNER JOIN competencia c ON ic.COMPETxPROGRAMA_COMPETENCIA_comp_id = c.comp_id
            ORDER BY ic.inscomp_vigencia DESC
        ");
        return $stmt->fetchAll();
    }
    
    public function getById($id) {
        $stmt = $this->db->prepare("
            SELECT ic.*, 
                   i.inst_nombres, i.inst_apellidos,
                   p.prog_denominacion,
                   c.comp_nombre_corto
            FROM instru_competencia ic
            INNER JOIN instructor i ON ic.INSTRUCTOR_inst_id = i.inst_id
            INNER JOIN programa p ON ic.COMPETxPROGRAMA_PROGRAMA_prog_id = p.prog_codigo
            INNER JOIN competencia c ON ic.COMPETxPROGRAMA_COMPETENCIA_comp_id = c.comp_id
            WHERE ic.inscomp_id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    
    public function getByInstructor($instructor_id) {
        $stmt = $this->db->prepare("
            SELECT ic.*, 
                   p.prog_denominacion,
                   c.comp_nombre_corto
            FROM instru_competencia ic
            INNER JOIN programa p ON ic.COMPETxPROGRAMA_PROGRAMA_prog_id = p.prog_codigo
            INNER JOIN competencia c ON ic.COMPETxPROGRAMA_COMPETENCIA_comp_id = c.comp_id
            WHERE ic.INSTRUCTOR_inst_id = ?
            ORDER BY ic.inscomp_vigencia DESC
        ");
        $stmt->execute([$instructor_id]);
        return $stmt->fetchAll();
    }
    
    public function create($data) {
        $stmt = $this->db->prepare("
            INSERT INTO instru_competencia (INSTRUCTOR_inst_id, COMPETxPROGRAMA_PROGRAMA_prog_id, COMPETxPROGRAMA_COMPETENCIA_comp_id, inscomp_vigencia) 
            VALUES (?, ?, ?, ?)
        ");
        return $stmt->execute([
            $data['INSTRUCTOR_inst_id'],
            $data['COMPETxPROGRAMA_PROGRAMA_prog_id'],
            $data['COMPETxPROGRAMA_COMPETENCIA_comp_id'],
            $data['inscomp_vigencia']
        ]);
    }
    
    public function update($id, $data) {
        $stmt = $this->db->prepare("
            UPDATE instru_competencia 
            SET INSTRUCTOR_inst_id = ?, 
                COMPETxPROGRAMA_PROGRAMA_prog_id = ?, 
                COMPETxPROGRAMA_COMPETENCIA_comp_id = ?, 
                inscomp_vigencia = ? 
            WHERE inscomp_id = ?
        ");
        return $stmt->execute([
            $data['INSTRUCTOR_inst_id'],
            $data['COMPETxPROGRAMA_PROGRAMA_prog_id'],
            $data['COMPETxPROGRAMA_COMPETENCIA_comp_id'],
            $data['inscomp_vigencia'],
            $id
        ]);
    }
    
    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM instru_competencia WHERE inscomp_id = ?");
        return $stmt->execute([$id]);
    }
    
    public function count() {
        $stmt = $this->db->query("SELECT COUNT(*) as total FROM instru_competencia");
        $result = $stmt->fetch();
        return $result['total'] ?? 0;
    }
    
    public function countVigentes() {
        $hoy = date('Y-m-d');
        $stmt = $this->db->prepare("SELECT COUNT(*) as total FROM instru_competencia WHERE inscomp_vigencia >= ?");
        $stmt->execute([$hoy]);
        $result = $stmt->fetch();
        return $result['total'] ?? 0;
    }
}
?>
