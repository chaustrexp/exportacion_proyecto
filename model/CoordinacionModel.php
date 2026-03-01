<?php
/**
 * ============================================================
 * CoordinacionModel.php
 * ============================================================
 * Modelo de acceso a datos para la entidad Coordinación.
 * Representa las dependencias organizativas del SENA a nivel
 * nacional (Dirección de Formación, Secretaría General, etc.)
 * y por centro de formación (Coordinación Académica, etc.).
 *
 * Tabla principal: coordinacion
 *   - coord_id                 INT (PK, AUTO_INCREMENT)
 *   - coord_nombre             VARCHAR(45)
 *   - centro_formacion_cent_id INT (FK → centro_formacion)
 *
 * @package Models
 */

require_once __DIR__ . '/../conexion.php';

/**
 * Class CoordinacionModel
 *
 * Proporciona operaciones CRUD sobre la tabla `coordinacion`.
 * Incluye el nombre del centro de formación via LEFT JOIN en consultas.
 */
class CoordinacionModel {

    /** @var PDO Conexión activa a la base de datos */
    private $db;

    /**
     * Constructor: obtiene la conexión singleton de la base de datos.
     */
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
