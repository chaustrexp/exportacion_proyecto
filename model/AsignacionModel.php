<?php
require_once __DIR__ . '/../conexion.php';

/**
 * Modelo AsignacionModel
 * Gestiona la lógica de persistencia y consultas relacionadas con las asignaciones de instructores,
 * ambientes y fichas, integrando múltiples relaciones mediante JOINs.
 */
class AsignacionModel {
    /** @var PDO Conexión a la base de datos */
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    
    /**
     * Obtiene el listado completo de asignaciones con detalles legibles.
     * Realiza JOINs con las tablas Ficha, Programa, Instructor, Ambiente y Competencia.
     * @return array Listado de asignaciones.
     */
    public function getAll() {
        $stmt = $this->db->query("
            SELECT a.*,
                   a.asig_id,
                   f.fich_id as ficha_numero,
                   CONCAT(i.inst_nombres, ' ', i.inst_apellidos) as instructor_nombre,
                   amb.amb_nombre as ambiente_nombre,
                   c.comp_nombre_corto as competencia_nombre,
                   p.prog_denominacion as programa_nombre,
                   DATE(a.asig_fecha_ini) as asig_fecha_inicio,
                   DATE(a.asig_fecha_fin) as asig_fecha_fin,
                   DATE(a.asig_fecha_ini) as fecha_inicio,
                   DATE(a.asig_fecha_fin) as fecha_fin
            FROM asignacion a
            LEFT JOIN ficha f ON a.ficha_fich_id = f.fich_id
            LEFT JOIN programa p ON f.programa_prog_id = p.prog_codigo
            LEFT JOIN instructor i ON a.instructor_inst_id = i.inst_id
            LEFT JOIN ambiente amb ON a.ambiente_amb_id = amb.amb_id
            LEFT JOIN competencia c ON a.competencia_comp_id = c.comp_id
            ORDER BY a.asig_fecha_ini DESC
        ");
        return $stmt->fetchAll();
    }
    
    /**
     * Obtiene una asignación específica mediante su identificador único.
     * @param int $id Identificador de la asignación.
     * @return array|false Datos de la asignación o false si no existe.
     */
    public function getById($id) {
        $stmt = $this->db->prepare("
            SELECT a.*,
                   a.asig_id,
                   a.asig_id as id,
                   f.fich_id as ficha_numero,
                   CONCAT(i.inst_nombres, ' ', i.inst_apellidos) as instructor_nombre,
                   amb.amb_nombre as ambiente_nombre,
                   c.comp_nombre_corto as competencia_nombre,
                   p.prog_denominacion as programa_nombre,
                   DATE(a.asig_fecha_ini) as asig_fecha_inicio,
                   DATE(a.asig_fecha_fin) as asig_fecha_fin,
                   DATE(a.asig_fecha_ini) as fecha_inicio,
                   DATE(a.asig_fecha_fin) as fecha_fin,
                   TIME(a.asig_fecha_ini) as asig_hora_inicio,
                   TIME(a.asig_fecha_fin) as asig_hora_fin,
                   TIME(a.asig_fecha_ini) as hora_inicio,
                   TIME(a.asig_fecha_fin) as hora_fin
            FROM asignacion a
            LEFT JOIN ficha f ON a.ficha_fich_id = f.fich_id
            LEFT JOIN programa p ON f.programa_prog_id = p.prog_codigo
            LEFT JOIN instructor i ON a.instructor_inst_id = i.inst_id
            LEFT JOIN ambiente amb ON a.ambiente_amb_id = amb.amb_id
            LEFT JOIN competencia c ON a.competencia_comp_id = c.comp_id
            WHERE a.asig_id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    
    /**
     * Crea un nuevo registro de asignación en la base de datos.
     * @param array $data Conjunto de datos (ID instructor, ficha, fechas, etc.).
     * @return bool True si la operación fue exitosa.
     */
    public function create($data) {
        $stmt = $this->db->prepare("
            INSERT INTO asignacion (instructor_inst_id, instructor_id, asig_fecha_ini, asig_fecha_fin, ficha_fich_id, ambiente_amb_id, competencia_comp_id) 
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");
        
        // Obtener fechas y horas
        $fecha_inicio = $data['fecha_inicio'] ?? $data['asig_fecha_inicio'] ?? date('Y-m-d');
        $fecha_fin = $data['fecha_fin'] ?? $data['asig_fecha_fin'] ?? $fecha_inicio;
        $hora_inicio = $data['hora_inicio'] ?? '06:00';
        $hora_fin = $data['hora_fin'] ?? '22:00';
        
        // Combinar fecha y hora en formato DATETIME
        $fecha_ini = $fecha_inicio . ' ' . $hora_inicio . ':00';
        $fecha_fin_dt = $fecha_fin . ' ' . $hora_fin . ':00';
        
        return $stmt->execute([
            $data['instructor_inst_id'] ?? $data['instructor_id'] ?? null,
            $data['usuario_id'] ?? $data['instructor_id'] ?? null, // Nuevo instructor_id (usuarios.id)
            $fecha_ini,
            $fecha_fin_dt,
            $data['ficha_id'] ?? $data['ficha_fich_id'],
            $data['ambiente_id'] ?? $data['ambiente_amb_id'] ?? null,
            $data['competencia_id'] ?? $data['competencia_comp_id'] ?? null
        ]);
    }
    
    public function update($id, $data) {
        $stmt = $this->db->prepare("
            UPDATE asignacion 
            SET instructor_inst_id = ?, instructor_id = ?, asig_fecha_ini = ?, asig_fecha_fin = ?, ficha_fich_id = ?, ambiente_amb_id = ?, competencia_comp_id = ?
            WHERE asig_id = ?
        ");
        
        // Obtener fechas y horas
        $fecha_inicio = $data['fecha_inicio'] ?? $data['asig_fecha_inicio'] ?? date('Y-m-d');
        $fecha_fin = $data['fecha_fin'] ?? $data['asig_fecha_fin'] ?? $fecha_inicio;
        $hora_inicio = $data['hora_inicio'] ?? '06:00';
        $hora_fin = $data['hora_fin'] ?? '22:00';
        
        // Combinar fecha y hora en formato DATETIME
        $fecha_ini = $fecha_inicio . ' ' . $hora_inicio . ':00';
        $fecha_fin_dt = $fecha_fin . ' ' . $hora_fin . ':00';
        
        return $stmt->execute([
            $data['instructor_inst_id'] ?? $data['instructor_id'] ?? null,
            $data['usuario_id'] ?? $data['instructor_id'] ?? null, // Nuevo instructor_id (usuarios.id)
            $fecha_ini,
            $fecha_fin_dt,
            $data['ficha_id'] ?? $data['ficha_fich_id'],
            $data['ambiente_id'] ?? $data['ambiente_amb_id'] ?? null,
            $data['competencia_id'] ?? $data['competencia_comp_id'] ?? null,
            $id
        ]);
    }
    
    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM asignacion WHERE asig_id = ?");
        return $stmt->execute([$id]);
    }
    
    public function count() {
        $stmt = $this->db->query("SELECT COUNT(*) as total FROM asignacion");
        $result = $stmt->fetch();
        return $result['total'];
    }

    public function countActivas() {
        $hoy = date('Y-m-d H:i:s');
        $stmt = $this->db->prepare("
            SELECT COUNT(*) as total
            FROM asignacion
            WHERE asig_fecha_ini <= ? AND asig_fecha_fin >= ?
        ");
        $stmt->execute([$hoy, $hoy]);
        $result = $stmt->fetch();
        return $result['total'];
    }

    public function countFinalizadas() {
        $hoy = date('Y-m-d H:i:s');
        $stmt = $this->db->prepare("
            SELECT COUNT(*) as total
            FROM asignacion
            WHERE asig_fecha_fin < ?
        ");
        $stmt->execute([$hoy]);
        $result = $stmt->fetch();
        return $result['total'];
    }

    public function countNoActivas() {
        $hoy = date('Y-m-d H:i:s');
        $stmt = $this->db->prepare("
            SELECT COUNT(*) as total
            FROM asignacion
            WHERE asig_fecha_ini > ?
        ");
        $stmt->execute([$hoy]);
        $result = $stmt->fetch();
        return $result['total'];
    }
    
    public function getRecent($limit = 5) {
        $stmt = $this->db->prepare("
            SELECT a.*,
                   a.asig_id,
                   f.fich_id as ficha_numero,
                   CONCAT(i.inst_nombres, ' ', i.inst_apellidos) as instructor_nombre,
                   amb.amb_nombre as ambiente_nombre,
                   c.comp_nombre_corto as competencia_nombre,
                   p.prog_denominacion as programa_nombre,
                   DATE(a.asig_fecha_ini) as fecha_inicio,
                   DATE(a.asig_fecha_fin) as fecha_fin
            FROM asignacion a
            LEFT JOIN ficha f ON a.ficha_fich_id = f.fich_id
            LEFT JOIN programa p ON f.programa_prog_id = p.prog_codigo
            LEFT JOIN instructor i ON a.instructor_inst_id = i.inst_id
            LEFT JOIN ambiente amb ON a.ambiente_amb_id = amb.amb_id
            LEFT JOIN competencia c ON a.competencia_comp_id = c.comp_id
            ORDER BY a.asig_fecha_ini DESC
            LIMIT ?
        ");
        $stmt->execute([$limit]);
        return $stmt->fetchAll();
    }

    public function getForCalendar($month = null, $year = null, $instructor_id = null) {
        if (!$month) $month = date('m');
        if (!$year) $year = date('Y');

        $sql = "
            SELECT a.asig_id as id,
                   f.fich_id as ficha_numero,
                   CONCAT(i.inst_nombres, ' ', i.inst_apellidos) as instructor_nombre,
                   amb.amb_nombre as ambiente_nombre,
                   c.comp_nombre_corto as competencia_nombre,
                   p.prog_denominacion as programa_nombre,
                   a.asig_fecha_ini as fecha_inicio,
                   a.asig_fecha_fin as fecha_fin,
                   TIME(a.asig_fecha_ini) as hora_inicio,
                   TIME(a.asig_fecha_fin) as hora_fin
            FROM asignacion a
            LEFT JOIN ficha f ON a.ficha_fich_id = f.fich_id
            LEFT JOIN programa p ON f.programa_prog_id = p.prog_codigo
            LEFT JOIN instructor i ON a.instructor_inst_id = i.inst_id
            LEFT JOIN ambiente amb ON a.ambiente_amb_id = amb.amb_id
            LEFT JOIN competencia c ON a.competencia_comp_id = c.comp_id
            WHERE (YEAR(a.asig_fecha_ini) = :year OR YEAR(a.asig_fecha_fin) = :year)
        ";

        if ($instructor_id) {
            $sql .= " AND a.instructor_inst_id = :instructor_id";
        }

        $sql .= " ORDER BY a.asig_fecha_ini ASC";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':year', $year);
        if ($instructor_id) {
            $stmt->bindParam(':instructor_id', $instructor_id);
        }
        
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function countFichasByInstructor($instructor_id) {
        $stmt = $this->db->prepare("SELECT COUNT(DISTINCT ficha_fich_id) as total FROM asignacion WHERE instructor_id = ? OR instructor_inst_id = ?");
        $stmt->execute([$instructor_id, $instructor_id]);
        return $stmt->fetch()['total'];
    }

    public function countByInstructor($instructor_id) {
        $stmt = $this->db->prepare("SELECT COUNT(*) as total FROM asignacion WHERE instructor_id = ? OR instructor_inst_id = ?");
        $stmt->execute([$instructor_id, $instructor_id]);
        return $stmt->fetch()['total'];
    }

    public function countActivasByInstructor($instructor_id) {
        $hoy = date('Y-m-d H:i:s');
        $stmt = $this->db->prepare("SELECT COUNT(*) as total FROM asignacion WHERE (instructor_id = ? OR instructor_inst_id = ?) AND asig_fecha_ini <= ? AND asig_fecha_fin >= ?");
        $stmt->execute([$instructor_id, $instructor_id, $hoy, $hoy]);
        return $stmt->fetch()['total'];
    }

    public function countFinalizadasByInstructor($instructor_id) {
        $hoy = date('Y-m-d H:i:s');
        $stmt = $this->db->prepare("SELECT COUNT(*) as total FROM asignacion WHERE (instructor_id = ? OR instructor_inst_id = ?) AND asig_fecha_fin < ?");
        $stmt->execute([$instructor_id, $instructor_id, $hoy]);
        return $stmt->fetch()['total'];
    }

    public function countNoActivasByInstructor($instructor_id) {
        $hoy = date('Y-m-d H:i:s');
        $stmt = $this->db->prepare("SELECT COUNT(*) as total FROM asignacion WHERE (instructor_id = ? OR instructor_inst_id = ?) AND asig_fecha_ini > ?");
        $stmt->execute([$instructor_id, $instructor_id, $hoy]);
        return $stmt->fetch()['total'];
    }

    public function getRecentByInstructor($instructor_id, $limit = 5) {
        $stmt = $this->db->prepare("
            SELECT a.*, f.fich_id as ficha_numero, p.prog_denominacion as programa_nombre,
                   amb.amb_nombre as ambiente_nombre, c.comp_nombre_corto as competencia_nombre,
                   DATE(a.asig_fecha_ini) as fecha_inicio, DATE(a.asig_fecha_fin) as fecha_fin
            FROM asignacion a
            LEFT JOIN ficha f ON a.ficha_fich_id = f.fich_id
            LEFT JOIN programa p ON f.programa_prog_id = p.prog_codigo
            LEFT JOIN ambiente amb ON a.ambiente_amb_id = amb.amb_id
            LEFT JOIN competencia c ON a.competencia_comp_id = c.comp_id
            WHERE a.instructor_id = ? OR a.instructor_inst_id = ?
            ORDER BY a.asig_fecha_ini DESC
            LIMIT ?
        ");
        $stmt->execute([$instructor_id, $instructor_id, $limit]);
        return $stmt->fetchAll();
    }
}
?>
