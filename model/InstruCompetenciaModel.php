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

require_once __DIR__ . '/../conexion.php';

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
