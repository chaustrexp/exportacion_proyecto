<?php
require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../model/CompetenciaProgramaModel.php';
require_once __DIR__ . '/../model/ProgramaModel.php';
require_once __DIR__ . '/../model/CompetenciaModel.php';

/**
 * Controlador de Competencias por Programa
 * Maneja la relación entre competencias y programas
 */
class CompetenciaProgramaController extends BaseController {
    private $programaModel;
    private $competenciaModel;
    
    public function __construct() {
        parent::__construct();
        $this->model = new CompetenciaProgramaModel();
        $this->programaModel = new ProgramaModel();
        $this->competenciaModel = new CompetenciaModel();
        $this->viewPath = 'competencia_programa';
    }
    
    /**
     * Listar todas las relaciones competencia-programa
     */
    public function index() {
        $registros = $this->model->getAll();
        
        $data = [
            'pageTitle' => 'Competencias por Programa',
            'registros' => $registros,
            'totalRelaciones' => count($registros),
            'mensaje' => $this->getFlashMessage()
        ];
        
        $this->render('index', $data);
    }
    
    /**
     * Mostrar formulario de creación
     */
    public function crear() {
        // Si es POST, procesar el formulario
        if ($this->isMethod('POST')) {
            $this->store();
            return;
        }
        
        // Si es GET, mostrar el formulario
        $data = [
            'pageTitle' => 'Asignar Competencia a Programa',
            'programas' => $this->programaModel->getAll(),
            'competencias' => $this->competenciaModel->getAll()
        ];
        
        $this->render('crear', $data);
    }
    
    /**
     * Guardar nueva relación
     */
    public function store() {
        // Validar datos requeridos
        $errors = $this->validate($_POST, [
            'programa_id',
            'competencia_id'
        ]);
        
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old_input'] = $_POST;
            $this->redirect(BASE_PATH . 'competencia_programa/crear');
        }
        
        try {
            $this->model->create($_POST);
            $_SESSION['success'] = 'Competencia asignada al programa exitosamente';
            $this->redirect(BASE_PATH . 'competencia_programa');
        } catch (Exception $e) {
            $_SESSION['error'] = 'Error al asignar competencia: ' . $e->getMessage();
            $_SESSION['old_input'] = $_POST;
            $this->redirect(BASE_PATH . 'competencia_programa/crear');
        }
    }
    
    /**
     * Eliminar relación
     */
    public function eliminar() {
        $programa_id = $this->get('programa_id', 0);
        $competencia_id = $this->get('competencia_id', 0);
        
        if (!$programa_id || !$competencia_id) {
            $_SESSION['error'] = 'Parámetros inválidos';
            $this->redirect(BASE_PATH . 'competencia_programa');
        }
        
        try {
            $this->model->delete($programa_id, $competencia_id);
            $_SESSION['success'] = 'Relación eliminada exitosamente';
        } catch (Exception $e) {
            $_SESSION['error'] = 'Error al eliminar: ' . $e->getMessage();
        }
        
        $this->redirect(BASE_PATH . 'competencia_programa');
    }
}
?>
