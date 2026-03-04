<?php
/**
 * ============================================================
 * InstructorModel.php
 * ============================================================
 * Modelo de acceso a datos para la entidad Instructor.
 * Interactúa con la tabla `instructor` y realiza JOINs con
 * `centro_formacion` para enriquecer los resultados.
 *
 * Tabla principal: instructor
 *   - inst_id                 (PK, AUTO_INCREMENT)
 *   - inst_nombres            VARCHAR(45)
 *   - inst_apellidos          VARCHAR(45)
 *   - inst_correo             VARCHAR(45)
 *   - inst_telefono           BIGINT(10)
 *   - centro_formacion_cent_id (FK → centro_formacion)
 *
 * @package Models
 */

require_once __DIR__ . '/../config/conexion.php';

/**
 * Class InstructorModel
 *
 * Proporciona operaciones CRUD sobre la tabla `instructor`.
 * Utiliza PDO con sentencias preparadas para prevenir inyección SQL.
 */
class InstructorModel {

    /** @var PDO Conexión activa a la base de datos */
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    
    public function getAll() {
        $stmt = $this->db->query("
            SELECT i.*, cf.cent_nombre 
            FROM instructor i
            LEFT JOIN centro_formacion cf ON i.centro_formacion_cent_id = cf.cent_id
            ORDER BY i.inst_apellidos, i.inst_nombres
        ");
        return $stmt->fetchAll();
    }
    
    public function getById($id) {
        $stmt = $this->db->prepare("
            SELECT i.*, cf.cent_nombre 
            FROM instructor i
            LEFT JOIN centro_formacion cf ON i.centro_formacion_cent_id = cf.cent_id
            WHERE i.inst_id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    
    public function create($data) {
        $stmt = $this->db->prepare("
            INSERT INTO instructor (inst_nombres, inst_apellidos, inst_correo, inst_telefono, centro_formacion_cent_id, inst_estado) 
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        return $stmt->execute([
            $data['inst_nombres'],
            $data['inst_apellidos'],
            $data['inst_correo'],
            $data['inst_telefono'],
            $data['centro_formacion_cent_id'],
            $data['inst_estado'] ?? 'Activo'
        ]);
    }
    
    public function update($id, $data) {
        $stmt = $this->db->prepare("
            UPDATE instructor 
            SET inst_nombres = ?, inst_apellidos = ?, inst_correo = ?, inst_telefono = ?, centro_formacion_cent_id = ?, inst_estado = ?
            WHERE inst_id = ?
        ");
        return $stmt->execute([
            $data['inst_nombres'],
            $data['inst_apellidos'],
            $data['inst_correo'],
            $data['inst_telefono'],
            $data['centro_formacion_cent_id'],
            $data['inst_estado'] ?? 'Activo',
            $id
        ]);
    }
    
    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM instructor WHERE inst_id = ?");
        return $stmt->execute([$id]);
    }
    
    public function count() {
        $stmt = $this->db->query("SELECT COUNT(*) as total FROM instructor");
        $result = $stmt->fetch();
        return $result['total'];
    }

    // ─── CU-01: Gestión de Instructores ───────────────────────────────────────

    /**
     * CU-01: Retorna solo los instructores con estado 'Activo'.
     * El Coordinador solo debería poder asignar instructores activos.
     *
     * @return array Lista de instructores activos con su centro de formación.
     */
    public function getActivos() {
        $stmt = $this->db->query("
            SELECT i.*, cf.cent_nombre 
            FROM instructor i
            LEFT JOIN centro_formacion cf ON i.centro_formacion_cent_id = cf.cent_id
            WHERE i.inst_estado = 'Activo'
            ORDER BY i.inst_apellidos, i.inst_nombres
        ");
        return $stmt->fetchAll();
    }

    /**
     * CU-01: Verifica si un instructor tiene cruces de horario con una franja propuesta.
     * Un cruce ocurre cuando la nueva asignación se superpone con una existente del mismo instructor.
     *
     * @param int    $inst_id      ID del instructor.
     * @param string $fecha_ini    Inicio de la franja propuesta (DATETIME 'Y-m-d H:i:s').
     * @param string $fecha_fin    Fin de la franja propuesta (DATETIME 'Y-m-d H:i:s').
     * @param int    $excluir_id   ID de asignación a excluir (para ediciones; 0 si es nueva).
     * @return array Asignaciones que se cruzan con la franja; vacío si no hay cruces.
     */
    public function checkCruceHorario($inst_id, $fecha_ini, $fecha_fin, $excluir_id = 0) {
        $stmt = $this->db->prepare("
            SELECT a.asig_id,
                   f.fich_id AS ficha_numero,
                   amb.amb_nombre AS ambiente_nombre,
                   c.comp_nombre_corto AS competencia_nombre,
                   DATE(a.asig_fecha_ini) AS fecha_inicio,
                   DATE(a.asig_fecha_fin) AS fecha_fin,
                   TIME(a.asig_fecha_ini) AS hora_inicio,
                   TIME(a.asig_fecha_fin) AS hora_fin
            FROM asignacion a
            LEFT JOIN ficha f ON a.ficha_fich_id = f.fich_id
            LEFT JOIN ambiente amb ON a.ambiente_amb_id = amb.amb_id
            LEFT JOIN competencia c ON a.competencia_comp_id = c.comp_id
            WHERE a.instructor_inst_id = ?
              AND a.asig_id != ?
              AND a.asig_fecha_ini < ?
              AND a.asig_fecha_fin > ?
        ");
        $stmt->execute([$inst_id, $excluir_id, $fecha_fin, $fecha_ini]);
        return $stmt->fetchAll();
    }

    /**
     * Retorna el estado (Activo/Inactivo) y datos básicos de un instructor.
     *
     * @param int $inst_id ID del instructor.
     * @return array|false Datos del instructor con estado, o false si no existe.
     */
    public function getEstado($inst_id) {
        $stmt = $this->db->prepare("
            SELECT inst_id, inst_nombres, inst_apellidos, inst_correo, inst_estado
            FROM instructor
            WHERE inst_id = ?
        ");
        $stmt->execute([$inst_id]);
        return $stmt->fetch();
    }
}
?>
