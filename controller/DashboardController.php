<?php
/**
 * ============================================================
 * DashboardController.php
 * ============================================================
 * Controlador del Dashboard Principal de ProgSENA.
 * Genera estadísticas y datos contextuales según el rol activo
 * del usuario en sesión (Administrador, Coordinador, Instructor).
 *
 * Rutas atendidas:
 *   GET dashboard/index → Panel principal con estadísticas
 *
 * Lógica de roles:
 *   - Instructor  → Solo ve sus propias asignaciones y fichas
 *   - Coordinador → Ve estadísticas globales del sistema
 *   - Administrador → Vista total del sistema
 *
 * @package Controllers
 */

require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../model/ProgramaModel.php';
require_once __DIR__ . '/../model/FichaModel.php';
require_once __DIR__ . '/../model/InstructorModel.php';
require_once __DIR__ . '/../model/AmbienteModel.php';
require_once __DIR__ . '/../model/AsignacionModel.php';

/**
 * Class DashboardController
 *
 * El dashboard adapta su contenido según el rol del usuario autenticado.
 * Carga múltiples modelos para componer los KPIs y tablas del panel.
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
                // Determinar qué instructor estamos viendo
                $view_instructor_id = isset($_GET['view_instructor_id']) ? (int)$_GET['view_instructor_id'] : $instructor_id;
                error_log("DASHBOARD_DEBUG: Instructor Role. session_instructor_id: {$instructor_id}, view_instructor_id: {$view_instructor_id}");
                
                // Obtener la lista de instructores para el selector
                $instructores = $this->instructorModel->getActivos();
                
                if ($view_instructor_id == $instructor_id) {
                    $instructor_info = [
                        'inst_id' => $instructor_id,
                        'inst_nombres' => $_SESSION['usuario_nombre'] ?? $_SESSION['nombre'],
                        'is_owner' => true
                    ];
                } else {
                    $viewed_instructor = $this->instructorModel->getById($view_instructor_id);
                    $instructor_info = [
                        'inst_id' => $view_instructor_id,
                        'inst_nombres' => $viewed_instructor ? $viewed_instructor['inst_nombres'] . ' ' . $viewed_instructor['inst_apellidos'] : 'Instructor Desconocido',
                        'is_owner' => false
                    ];
                }
                
                // Estadísticas filtradas para el instructor visualizado
                $totalFichas = $this->asignacionModel->countFichasByInstructor($view_instructor_id);
                $totalAsignaciones = $this->asignacionModel->countByInstructor($view_instructor_id);
                $asignacionesActivas = $this->asignacionModel->countActivasByInstructor($view_instructor_id);
                $asignacionesFinalizadas = $this->asignacionModel->countFinalizadasByInstructor($view_instructor_id);
                $asignacionesNoActivas = $this->asignacionModel->countNoActivasByInstructor($view_instructor_id);
                
                // Obtener últimas asignaciones del instructor
                $ultimasAsignaciones = $this->asignacionModel->getRecentByInstructor($view_instructor_id, 5);
                
                // Próxima clase (la primera en el futuro)
                $proximaClase = !empty($ultimasAsignaciones) ? $ultimasAsignaciones[0] : null;
                
                // Obtener asignaciones para el calendario (filtradas)
                $asignacionesCalendario = $this->asignacionModel->getForCalendar(null, null, $view_instructor_id);
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
