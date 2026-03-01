<?php
/**
 * ============================================================
 * CompetenciaProgramaModel.php
 * ============================================================
 * Modelo para la tabla de relación muchos-a-muchos entre
 * Programa y Competencia. Permite asignar múltiples
 * competencias a un programa de formación.
 *
 * Tabla pivot: competxprograma (alias: compet_programa)
 *   - programa_prog_id    INT (FK → programa, PK compuesto)
 *   - competencia_comp_id INT (FK → competencia, PK compuesto)
 *
 * No tiene AUTO_INCREMENT — la PK es la combinación de ambas FKs.
 *
 * @package Models
 */

require_once __DIR__ . '/../conexion.php';

/**
 * Class CompetenciaProgramaModel
 *
 * Gestiona las asignaciones de competencias a programas.
 * Provee consultas con JOIN para enriquecer los datos,
 * y delete() requiere ambas claves de la relación.
 */
class CompetenciaProgramaModel {

    /** @var PDO Conexión activa a la base de datos */
    private $db;

    /**
     * Constructor: obtiene la conexión singleton.
     */
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
