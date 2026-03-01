<?php
/**
 * ============================================================
 * CentroFormacionModel.php
 * ============================================================
 * Modelo de acceso a datos para la entidad Centro de Formación.
 * Un centro agrupa instructores y coordinaciones.
 *
 * Tabla principal: centro_formacion
 *   - cent_id     INT (PK, AUTO_INCREMENT)
 *   - cent_nombre VARCHAR(100)
 *
 * @package Models
 */

require_once __DIR__ . '/../conexion.php';

/**
 * Class CentroFormacionModel
 *
 * Operaciones CRUD sobre la tabla `centro_formacion`.
 */
class CentroFormacionModel {

    /** @var PDO Conexión activa a la base de datos */
    private $db;

    /**
     * Constructor: obtiene la conexión singleton de la base de datos.
     */
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    
    public function getAll() {
        $stmt = $this->db->query("SELECT * FROM centro_formacion ORDER BY cent_nombre");
        return $stmt->fetchAll();
    }
    
    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM centro_formacion WHERE cent_id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    
    public function create($data) {
        $stmt = $this->db->prepare("INSERT INTO centro_formacion (cent_nombre) VALUES (?)");
        return $stmt->execute([
            $data['cent_nombre']
        ]);
    }
    
    public function update($id, $data) {
        $stmt = $this->db->prepare("UPDATE centro_formacion SET cent_nombre = ? WHERE cent_id = ?");
        return $stmt->execute([
            $data['cent_nombre'],
            $id
        ]);
    }
    
    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM centro_formacion WHERE cent_id = ?");
        return $stmt->execute([$id]);
    }
}
?>
