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
        // Definir título de la página ANTES de cargar el header
        $pageTitle = 'Dashboard Principal';
        
        try {
            // Obtener estadísticas
            $totalProgramas = $this->programaModel->count();
            $totalFichas = $this->fichaModel->count();
            $totalInstructores = $this->instructorModel->count();
            $totalAmbientes = $this->ambienteModel->count();
            $totalAsignaciones = $this->asignacionModel->count();
            $asignacionesActivas = $this->asignacionModel->countActivas();
            $asignacionesFinalizadas = $this->asignacionModel->countFinalizadas();
            $asignacionesNoActivas = $this->asignacionModel->countNoActivas();
            
            // Obtener últimas asignaciones
            $ultimasAsignaciones = $this->asignacionModel->getRecent(5);
            
            // Obtener asignaciones para el calendario
            $asignacionesCalendario = $this->asignacionModel->getForCalendar();
            
            // Datos para la vista
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
