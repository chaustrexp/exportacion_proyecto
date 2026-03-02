<?php
/**
 * ============================================================
 * AmbienteModel.php
 * ============================================================
 * Modelo de acceso a datos para la entidad Ambiente de Formación.
 * Gestiona los espacios físicos (aulas, laboratorios) donde se
 * imparten las clases, con su sede asociada.
 *
 * Tabla principal: ambiente
 *   - amb_id      VARCHAR(5)  (PK — código alfanumérico del ambiente)
 *   - amb_nombre  VARCHAR(45)
 *   - sede_sede_id INT (FK → sede)
 *
 * @package Models
 */

require_once __DIR__ . '/../conexion.php';

/**
 * Class AmbienteModel
 *
 * Proporciona operaciones CRUD sobre la tabla `ambiente`.
 * Los resultados incluyen el nombre de la sede mediante LEFT JOIN.
 */
class AmbienteModel {

    /** @var PDO Conexión activa a la base de datos */
    private $db;

    /**
     * Constructor: obtiene la conexión singleton de la base de datos.
     */
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    /**
     * Retorna todos los ambientes con su sede correspondiente.
     *
     * @return array Lista de ambientes ordenada por nombre.
     */
    public function getAll() {
        $stmt = $this->db->query("
            SELECT a.*, s.sede_nombre 
            FROM ambiente a
            LEFT JOIN sede s ON a.sede_sede_id = s.sede_id
            ORDER BY a.amb_nombre
        ");
        return $stmt->fetchAll();
    }

    /**
     * Busca un ambiente por su código (ID).
     *
     * @param string $id Código del ambiente (ej: 'A101').
     * @return array|false Datos del ambiente o false si no existe.
     */
    public function getById($id) {
        $stmt = $this->db->prepare("
            SELECT a.*, s.sede_nombre 
            FROM ambiente a
            LEFT JOIN sede s ON a.sede_sede_id = s.sede_id
            WHERE a.amb_id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    /**
     * Crea un nuevo ambiente en la base de datos.
     *
     * @param array $data Datos del formulario:
     *   - 'codigo'   string  Código único del ambiente
     *   - 'nombre'   string  Nombre descriptivo
     *   - 'sede_id'  int     ID de la sede
     * @return bool True si se insertó correctamente.
     */
    public function create($data) {
        $stmt = $this->db->prepare("
            INSERT INTO ambiente (amb_id, amb_nombre, sede_sede_id) 
            VALUES (?, ?, ?)
        ");
        return $stmt->execute([
            $data['codigo'],
            $data['nombre'],
            $data['sede_id']
        ]);
    }

    /**
     * Actualiza el nombre y/o sede de un ambiente existente.
     * Nota: el ID (código) del ambiente no puede modificarse una vez creado.
     *
     * @param string $id   Código del ambiente a actualizar.
     * @param array  $data Nuevos valores ('nombre', 'sede_id').
     * @return bool True si se actualizó correctamente.
     */
    public function update($id, $data) {
        $stmt = $this->db->prepare("
            UPDATE ambiente 
            SET amb_nombre = ?, sede_sede_id = ? 
            WHERE amb_id = ?
        ");
        return $stmt->execute([
            $data['nombre'],
            $data['sede_id'],
            $id
        ]);
    }

    /**
     * Elimina un ambiente de la base de datos.
     * Fallará si el ambiente tiene asignaciones activas (restricción FK).
     *
     * @param string $id Código del ambiente a eliminar.
     * @return bool True si se eliminó correctamente.
     */
    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM ambiente WHERE amb_id = ?");
        return $stmt->execute([$id]);
    }

    /**
     * Cuenta el total de ambientes registrados en el sistema.
     *
     * @return int Total de ambientes.
     */
    public function count() {
        $stmt   = $this->db->query("SELECT COUNT(*) as total FROM ambiente");
        $result = $stmt->fetch();
        return $result['total'];
    }

    // ─── CU-03: Gestión de Ambientes ──────────────────────────────────────────

    /**
     * CU-03: Verifica si un ambiente está disponible en la franja horaria propuesta.
     * Detecta conflictos de reserva comparando con asignaciones existentes que se
     * superpongan con la nueva franja (inicio < fin_existente AND fin > ini_existente).
     *
     * @param string $amb_id     Código del ambiente (ej: 'A101').
     * @param string $fecha_ini  Inicio de la franja propuesta (DATETIME 'Y-m-d H:i:s').
     * @param string $fecha_fin  Fin de la franja propuesta (DATETIME 'Y-m-d H:i:s').
     * @param int    $excluir_id ID de asignación a excluir (para ediciones; 0 si es nueva).
     * @return array Asignaciones conflictivas; vacío si el ambiente está disponible.
     */
    public function checkDisponibilidad($amb_id, $fecha_ini, $fecha_fin, $excluir_id = 0) {
        $stmt = $this->db->prepare("
            SELECT a.asig_id,
                   f.fich_id AS ficha_numero,
                   CONCAT(i.inst_nombres, ' ', i.inst_apellidos) AS instructor_nombre,
                   c.comp_nombre_corto AS competencia_nombre,
                   DATE(a.asig_fecha_ini) AS fecha_inicio,
                   DATE(a.asig_fecha_fin) AS fecha_fin,
                   TIME(a.asig_fecha_ini) AS hora_inicio,
                   TIME(a.asig_fecha_fin) AS hora_fin
            FROM asignacion a
            LEFT JOIN ficha f ON a.ficha_fich_id = f.fich_id
            LEFT JOIN instructor i ON a.instructor_inst_id = i.inst_id
            LEFT JOIN competencia c ON a.competencia_comp_id = c.comp_id
            WHERE a.ambiente_amb_id = ?
              AND a.asig_id != ?
              AND a.asig_fecha_ini < ?
              AND a.asig_fecha_fin > ?
        ");
        $stmt->execute([$amb_id, $excluir_id, $fecha_fin, $fecha_ini]);
        return $stmt->fetchAll();
    }

    /**
     * Retorna todos los ambientes con indicador de disponibilidad en una franja.
     * Útil para mostrar en el formulario de asignación qué ambientes están libres.
     *
     * @param string $fecha_ini Inicio de la franja.
     * @param string $fecha_fin Fin de la franja.
     * @return array Ambientes con campo 'disponible' (1=libre, 0=ocupado).
     */
    public function getAllConDisponibilidad($fecha_ini, $fecha_fin) {
        $stmt = $this->db->prepare("
            SELECT a.amb_id, a.amb_nombre, s.sede_nombre,
                   CASE 
                     WHEN EXISTS (
                       SELECT 1 FROM asignacion asig
                       WHERE asig.ambiente_amb_id = a.amb_id
                         AND asig.asig_fecha_ini < ?
                         AND asig.asig_fecha_fin > ?
                     ) THEN 0 ELSE 1
                   END AS disponible
            FROM ambiente a
            LEFT JOIN sede s ON a.sede_sede_id = s.sede_id
            ORDER BY disponible DESC, a.amb_nombre ASC
        ");
        $stmt->execute([$fecha_fin, $fecha_ini]);
        return $stmt->fetchAll();
    }
}
?>

    

