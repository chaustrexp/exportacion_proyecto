<?php
require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../model/ProgramaModel.php';
require_once __DIR__ . '/../model/FichaModel.php';
require_once __DIR__ . '/../model/InstructorModel.php';
require_once __DIR__ . '/../model/AmbienteModel.php';
require_once __DIR__ . '/../model/AsignacionModel.php';

/**
 * Controlador del Dashboard Principal
 */
class DashboardController extends BaseController {
    private $programaModel;
    private $fichaModel;
    private $instructorModel;
    private $ambienteModel;
    private $asignacionModel;
    
    public function __construct() {
        parent::__construct();
        $this->programaModel = new ProgramaModel();
        $this->fichaModel = new FichaModel();
        $this->instructorModel = new InstructorModel();
        $this->ambienteModel = new AmbienteModel();
        $this->asignacionModel = new AsignacionModel();
        $this->viewPath = '';
    }
    
    /**
     * Página principal del dashboard
     */
    public function index() {
        // Obtener rol e ID de sesión
        $rol = $_SESSION['usuario_rol'] ?? $_SESSION['rol'] ?? '';
        $usuario_id = $_SESSION['usuario_id'] ?? $_SESSION['id'] ?? null;
        $instructor_id = $_SESSION['instructor_id'] ?? null;
        $esInstructor = ($rol === 'Instructor');

        // Definir título de la página
        $pageTitle = 'Dashboard Principal';
        if ($rol === 'Instructor') $pageTitle = 'Mi Dashboard - Instructor';
        if ($rol === 'Coordinador') $pageTitle = 'Panel de Coordinación Académica';
        
        try {
            if ($rol === 'Instructor') {
                // Estadísticas filtradas para el instructor
                $totalFichas = $this->asignacionModel->countFichasByInstructor($instructor_id);
                $totalAsignaciones = $this->asignacionModel->countByInstructor($instructor_id);
                $asignacionesActivas = $this->asignacionModel->countActivasByInstructor($instructor_id);
                $asignacionesFinalizadas = $this->asignacionModel->countFinalizadasByInstructor($instructor_id);
                $asignacionesNoActivas = $this->asignacionModel->countNoActivasByInstructor($instructor_id);
                
                // Obtener últimas asignaciones del instructor
                $ultimasAsignaciones = $this->asignacionModel->getRecentByInstructor($instructor_id, 5);
                
                // Próxima clase (la primera en el futuro)
                $proximaClase = !empty($ultimasAsignaciones) ? $ultimasAsignaciones[0] : null;
                
                // Obtener asignaciones para el calendario (filtradas)
                $asignacionesCalendario = $this->asignacionModel->getForCalendar(null, null, $instructor_id);
            } elseif ($rol === 'Coordinador') {
                // Estadísticas globales pero con enfoque en gestión para el Coordinador
                $totalProgramas = $this->programaModel->count();
                $totalFichas = $this->fichaModel->count();
                $totalInstructores = $this->instructorModel->count();
                $totalAmbientes = $this->ambienteModel->count();
                
                $totalAsignaciones = $this->asignacionModel->count();
                $asignacionesActivas = $this->asignacionModel->countActivas();
                $asignacionesFinalizadas = $this->asignacionModel->countFinalizadas();
                
                $ultimasAsignaciones = $this->asignacionModel->getRecent(5);
                $asignacionesCalendario = $this->asignacionModel->getForCalendar();
            } else {
                // Administrador: Vista total del sistema
                $totalProgramas = $this->programaModel->count();
                $totalFichas = $this->fichaModel->count();
                $totalInstructores = $this->instructorModel->count();
                $totalAmbientes = $this->ambienteModel->count();
                
                $totalAsignaciones = $this->asignacionModel->count();
                $asignacionesActivas = $this->asignacionModel->countActivas();
                $asignacionesFinalizadas = $this->asignacionModel->countFinalizadas();
                $asignacionesNoActivas = $this->asignacionModel->countNoActivas();
                
                $ultimasAsignaciones = $this->asignacionModel->getRecent(5);
                $asignacionesCalendario = $this->asignacionModel->getForCalendar();
            }
            
            $totalCompetenciasInstructor = 0;
            $competenciasVigentes = 0;
            
        } catch (Exception $e) {
            // En caso de error, mostrar valores por defecto
            $totalProgramas = 0;
            $totalFichas = 0;
            $totalInstructores = 0;
            $totalAmbientes = 0;
            $totalAsignaciones = 0;
            $asignacionesActivas = 0;
            $asignacionesFinalizadas = 0;
            $asignacionesNoActivas = 0;
            $totalCompetenciasInstructor = 0;
            $competenciasVigentes = 0;
            $ultimasAsignaciones = [];
            $asignacionesCalendario = [];
        }
        
        // Renderizar vista del dashboard
        include __DIR__ . '/../views/layout/header.php';
        include __DIR__ . '/../views/layout/sidebar.php';
        include __DIR__ . '/../views/dashboard/index.php';
        include __DIR__ . '/../views/layout/footer.php';
    }
}
?>
