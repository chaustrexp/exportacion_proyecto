<?php
/**
 * ============================================================
 * TituloProgramaModel.php
 * ============================================================
 * Modelo de acceso a datos para la entidad Título de Programa.
 * Un título es la categoría académica que agrupa programas
 * (ej: Técnico, Tecnólogo, Especialización).
 *
 * Tabla principal: titulo_programa
 *   - titpro_id     INT (PK, AUTO_INCREMENT)
 *   - titpro_nombre VARCHAR(45)
 *
 * @package Models
 */

require_once __DIR__ . '/../conexion.php';

/**
 * Class TituloProgramaModel
 *
 * Operaciones CRUD sobre la tabla `titulo_programa`.
 */
class TituloProgramaModel {

    /** @var PDO Conexión activa a la base de datos */
    private $db;

    /**
     * Constructor: obtiene la conexión singleton.
     */
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
