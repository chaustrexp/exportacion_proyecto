<?php
require_once __DIR__ . '/../model/AsignacionModel.php';
require_once __DIR__ . '/../model/FichaModel.php';
require_once __DIR__ . '/../model/InstructorModel.php';

class InstructorDashboardController {
    private $asignacionModel;
    private $fichaModel;
    private $instructorModel;
    
    public function __construct() {
        $this->asignacionModel = new AsignacionModel();
        $this->fichaModel = new FichaModel();
        $this->instructorModel = new InstructorModel();
    }
    
    public function index() {
        // Verificar que sea instructor
        if ($_SESSION['usuario_rol'] !== 'Instructor') {
            header('Location: ' . BASE_PATH . 'index.php');
            exit;
        }
        
        $instructor_id = $_SESSION['instructor_id'] ?? null;
        
        if (!$instructor_id) {
            die('Error: No se encontró el ID del instructor');
        }
        
        // Obtener información del instructor
        $instructor = $this->instructorModel->getById($instructor_id);
        
        // Obtener fichas asignadas al instructor
        $fichas = $this->getFichasInstructor($instructor_id);
        
        // Obtener asignaciones del instructor
        $asignaciones = $this->getAsignacionesInstructor($instructor_id);
        
        // Obtener estadísticas
        $estadisticas = $this->getEstadisticas($instructor_id);
        
        // Cargar vista
        require_once __DIR__ . '/../views/instructor_dashboard/index.php';
    }
    
    private function getFichasInstructor($instructor_id) {
        $db = Database::getInstance()->getConnection();
        
        $stmt = $db->prepare("
            SELECT DISTINCT
                f.fich_id,
                f.fich_numero,
                f.fich_jornada,
                p.prog_denominacion,
                p.prog_tipo,
                c.coord_nombre,
                COUNT(DISTINCT a.asig_id) as total_asignaciones
            FROM ficha f
            LEFT JOIN programa p ON f.programa_prog_id = p.prog_codigo
            LEFT JOIN coordinacion c ON f.coordinacion_coord_id = c.coord_id
            LEFT JOIN asignacion a ON f.fich_id = a.ficha_fich_id AND a.instructor_inst_id = ?
            WHERE f.instructor_inst_id_lider = ? 
               OR EXISTS (
                   SELECT 1 FROM asignacion a2 
                   WHERE a2.ficha_fich_id = f.fich_id 
                   AND a2.instructor_inst_id = ?
               )
            GROUP BY f.fich_id
            ORDER BY f.fich_numero DESC
        ");
        
        $stmt->execute([$instructor_id, $instructor_id, $instructor_id]);
        return $stmt->fetchAll();
    }
    
    private function getAsignacionesInstructor($instructor_id) {
        $db = Database::getInstance()->getConnection();
        
        $stmt = $db->prepare("
            SELECT 
                a.*,
                f.fich_numero,
                p.prog_denominacion,
                amb.amb_nombre,
                c.comp_nombre_corto,
                c.comp_nombre_unidad_competencia
            FROM asignacion a
            LEFT JOIN ficha f ON a.ficha_fich_id = f.fich_id
            LEFT JOIN programa p ON f.programa_prog_id = p.prog_codigo
            LEFT JOIN ambiente amb ON a.ambiente_amb_id = amb.amb_id
            LEFT JOIN competencia c ON a.competencia_comp_id = c.comp_id
            WHERE a.instructor_inst_id = ?
            AND a.asig_fecha_ini >= CURDATE()
            ORDER BY a.asig_fecha_ini ASC
            LIMIT 10
        ");
        
        $stmt->execute([$instructor_id]);
        return $stmt->fetchAll();
    }
    
    private function getEstadisticas($instructor_id) {
        $db = Database::getInstance()->getConnection();
        
        // Total de fichas
        $stmt = $db->prepare("
            SELECT COUNT(DISTINCT f.fich_id) as total
            FROM ficha f
            WHERE f.instructor_inst_id_lider = ? 
               OR EXISTS (
                   SELECT 1 FROM asignacion a 
                   WHERE a.ficha_fich_id = f.fich_id 
                   AND a.instructor_inst_id = ?
               )
        ");
        $stmt->execute([$instructor_id, $instructor_id]);
        $totalFichas = $stmt->fetch()['total'];
        
        // Total de asignaciones
        $stmt = $db->prepare("
            SELECT COUNT(*) as total
            FROM asignacion
            WHERE instructor_inst_id = ?
        ");
        $stmt->execute([$instructor_id]);
        $totalAsignaciones = $stmt->fetch()['total'];
        
        // Asignaciones hoy
        $stmt = $db->prepare("
            SELECT COUNT(*) as total
            FROM asignacion
            WHERE instructor_inst_id = ?
            AND DATE(asig_fecha_ini) = CURDATE()
        ");
        $stmt->execute([$instructor_id]);
        $asignacionesHoy = $stmt->fetch()['total'];
        
        // Asignaciones esta semana
        $stmt = $db->prepare("
            SELECT COUNT(*) as total
            FROM asignacion
            WHERE instructor_inst_id = ?
            AND YEARWEEK(asig_fecha_ini, 1) = YEARWEEK(CURDATE(), 1)
        ");
        $stmt->execute([$instructor_id]);
        $asignacionesSemana = $stmt->fetch()['total'];
        
        return [
            'total_fichas' => $totalFichas,
            'total_asignaciones' => $totalAsignaciones,
            'asignaciones_hoy' => $asignacionesHoy,
            'asignaciones_semana' => $asignacionesSemana
        ];
    }
    
    public function misFichas() {
        if ($_SESSION['usuario_rol'] !== 'Instructor') {
            header('Location: ' . BASE_PATH . 'index.php');
            exit;
        }
        
        $instructor_id = $_SESSION['instructor_id'] ?? null;
        $fichas = $this->getFichasInstructor($instructor_id);
        
        require_once __DIR__ . '/../views/instructor_dashboard/mis_fichas.php';
    }
    
    public function misAsignaciones() {
        if ($_SESSION['usuario_rol'] !== 'Instructor') {
            header('Location: ' . BASE_PATH . 'index.php');
            exit;
        }
        
        $instructor_id = $_SESSION['instructor_id'] ?? null;
        
        $db = Database::getInstance()->getConnection();
        
        $stmt = $db->prepare("
            SELECT 
                a.*,
                f.fich_numero,
                p.prog_denominacion,
                amb.amb_nombre,
                amb.sede_sede_id,
                s.sede_nombre,
                c.comp_nombre_corto,
                c.comp_nombre_unidad_competencia,
                c.comp_horas
            FROM asignacion a
            LEFT JOIN ficha f ON a.ficha_fich_id = f.fich_id
            LEFT JOIN programa p ON f.programa_prog_id = p.prog_codigo
            LEFT JOIN ambiente amb ON a.ambiente_amb_id = amb.amb_id
            LEFT JOIN sede s ON amb.sede_sede_id = s.sede_id
            LEFT JOIN competencia c ON a.competencia_comp_id = c.comp_id
            WHERE a.instructor_inst_id = ?
            ORDER BY a.asig_fecha_ini DESC
        ");
        
        $stmt->execute([$instructor_id]);
        $asignaciones = $stmt->fetchAll();
        
        require_once __DIR__ . '/../views/instructor_dashboard/mis_asignaciones.php';
    }
}
?>
