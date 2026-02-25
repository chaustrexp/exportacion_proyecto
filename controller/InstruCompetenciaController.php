<?php
require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../model/InstruCompetenciaModel.php';
require_once __DIR__ . '/../model/InstructorModel.php';
require_once __DIR__ . '/../model/ProgramaModel.php';
require_once __DIR__ . '/../model/CompetenciaModel.php';
require_once __DIR__ . '/../model/CompetenciaProgramaModel.php';

/**
 * Controlador de Competencias de Instructores
 * Maneja la asignación de competencias a instructores
 */
class InstruCompetenciaController extends BaseController {
    private $instructorModel;
    private $programaModel;
    private $competenciaModel;
    private $competenciaProgramaModel;
    
    public function __construct() {
        parent::__construct();
        $this->model = new InstruCompetenciaModel();
        $this->instructorModel = new InstructorModel();
        $this->programaModel = new ProgramaModel();
        $this->competenciaModel = new CompetenciaModel();
        $this->competenciaProgramaModel = new CompetenciaProgramaModel();
        $this->viewPath = 'instru_competencia';
    }
    
    /**
     * Listar todas las asignaciones
     */
    public function index() {
        verificarRol(['Administrador', 'Coordinador']);
        $registros = $this->model->getAll();
        
        // Obtener asociaciones válidas de COMPETxPROGRAMA
        require_once __DIR__ . '/../conexion.php';
        $db = Database::getInstance()->getConnection();
        $stmt = $db->query("
            SELECT cp.*, 
                   p.prog_denominacion, 
                   c.comp_nombre_corto
            FROM COMPETxPROGRAMA cp
            LEFT JOIN PROGRAMA p ON cp.PROGRAMA_prog_id = p.prog_codigo
            LEFT JOIN COMPETENCIA c ON cp.COMPETENCIA_comp_id = c.comp_id
            ORDER BY p.prog_denominacion, c.comp_nombre_corto
        ");
        $competenciasPorPrograma = $stmt->fetchAll();
        
        // Calcular vigentes
        $hoy = date('Y-m-d');
        $vigentes = array_filter($registros, function($r) use ($hoy) {
            return $r['inscomp_vigencia'] >= $hoy;
        });
        
        $data = [
            'pageTitle' => 'Competencias de Instructores',
            'registros' => $registros,
            'instructores' => $this->instructorModel->getAll(),
            'programas' => $this->programaModel->getAll(),
            'competencias' => $this->competenciaModel->getAll(),
            'competenciasPorPrograma' => $competenciasPorPrograma,
            'totalAsignaciones' => count($registros),
            'totalVigentes' => count($vigentes),
            'totalVencidas' => count($registros) - count($vigentes),
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
        
        // Obtener asociaciones válidas de COMPETxPROGRAMA
        require_once __DIR__ . '/../conexion.php';
        $db = Database::getInstance()->getConnection();
        $stmt = $db->query("
            SELECT cp.*, 
                   p.prog_denominacion, 
                   c.comp_nombre_corto
            FROM COMPETxPROGRAMA cp
            LEFT JOIN PROGRAMA p ON cp.PROGRAMA_prog_id = p.prog_codigo
            LEFT JOIN COMPETENCIA c ON cp.COMPETENCIA_comp_id = c.comp_id
            ORDER BY p.prog_denominacion, c.comp_nombre_corto
        ");
        $competenciasPorPrograma = $stmt->fetchAll();
        
        // Si es GET, mostrar el formulario
        $data = [
            'pageTitle' => 'Asignar Competencia a Instructor',
            'instructores' => $this->instructorModel->getAll(),
            'competenciasPorPrograma' => $competenciasPorPrograma
        ];
        
        $this->render('crear', $data);
    }
    
    /**
     * Guardar nueva asignación
     */
    public function store() {
        // DEBUG: Ver qué datos están llegando
        error_log('POST Data: ' . print_r($_POST, true));
        
        // Validar datos requeridos
        $errors = $this->validate($_POST, [
            'INSTRUCTOR_inst_id',
            'COMPETxPROGRAMA_PROGRAMA_prog_id',
            'COMPETxPROGRAMA_COMPETENCIA_comp_id',
            'inscomp_vigencia'
        ]);
        
        // DEBUG: Ver errores de validación
        if (!empty($errors)) {
            error_log('Validation Errors: ' . print_r($errors, true));
        }
        
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old_input'] = $_POST;
            $this->redirect(BASE_PATH . 'instru_competencia/crear');
        }
        
        try {
            // Verificar que la combinación programa+competencia existe en COMPETxPROGRAMA
            require_once __DIR__ . '/../conexion.php';
            $db = Database::getInstance()->getConnection();
            $stmt = $db->prepare("
                SELECT COUNT(*) as existe 
                FROM COMPETxPROGRAMA 
                WHERE PROGRAMA_prog_id = ? AND COMPETENCIA_comp_id = ?
            ");
            $stmt->execute([
                $_POST['COMPETxPROGRAMA_PROGRAMA_prog_id'],
                $_POST['COMPETxPROGRAMA_COMPETENCIA_comp_id']
            ]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($result['existe'] == 0) {
                $_SESSION['error'] = 'La combinación de Programa y Competencia seleccionada no está asociada. Por favor, primero asocia la competencia con el programa en la sección "Competencias por Programa".';
                $_SESSION['old_input'] = $_POST;
                $this->redirect(BASE_PATH . 'instru_competencia/crear');
            }
            
            $this->model->create($_POST);
            $_SESSION['success'] = 'Competencia asignada al instructor exitosamente';
            $this->redirect(BASE_PATH . 'instru_competencia');
        } catch (Exception $e) {
            $_SESSION['error'] = 'Error al asignar competencia: ' . $e->getMessage();
            $_SESSION['old_input'] = $_POST;
            $this->redirect(BASE_PATH . 'instru_competencia/crear');
        }
    }
    
    /**
     * Ver detalle de una asignación
     */
    public function ver() {
        $id = $this->get('id', 0);
        
        if (!$id) {
            $_SESSION['error'] = 'ID no válido';
            $this->redirect(BASE_PATH . 'instru_competencia');
        }
        
        $registro = $this->model->getById($id);
        
        if (!$registro) {
            $_SESSION['error'] = 'Asignación no encontrada';
            $this->redirect(BASE_PATH . 'instru_competencia');
        }
        
        $data = [
            'pageTitle' => 'Ver Competencia de Instructor',
            'registro' => $registro
        ];
        
        $this->render('ver', $data);
    }
    
    /**
     * Mostrar formulario de edición
     */
    public function editar() {
        $id = $this->get('id', 0);
        
        if (!$id) {
            $_SESSION['error'] = 'ID no válido';
            $this->redirect(BASE_PATH . 'instru_competencia');
        }
        
        // Si es POST, procesar el formulario
        if ($this->isMethod('POST')) {
            $this->update($id);
            return;
        }
        
        // Si es GET, mostrar el formulario
        $registro = $this->model->getById($id);
        
        if (!$registro) {
            $_SESSION['error'] = 'Asignación no encontrada';
            $this->redirect(BASE_PATH . 'instru_competencia');
        }
        
        // Obtener asociaciones válidas de COMPETxPROGRAMA
        require_once __DIR__ . '/../conexion.php';
        $db = Database::getInstance()->getConnection();
        $stmt = $db->query("
            SELECT cp.*, 
                   p.prog_denominacion, 
                   c.comp_nombre_corto
            FROM COMPETxPROGRAMA cp
            LEFT JOIN PROGRAMA p ON cp.PROGRAMA_prog_id = p.prog_codigo
            LEFT JOIN COMPETENCIA c ON cp.COMPETENCIA_comp_id = c.comp_id
            ORDER BY p.prog_denominacion, c.comp_nombre_corto
        ");
        $competenciasPorPrograma = $stmt->fetchAll();
        
        $data = [
            'pageTitle' => 'Editar Competencia de Instructor',
            'registro' => $registro,
            'instructores' => $this->instructorModel->getAll(),
            'competenciasPorPrograma' => $competenciasPorPrograma
        ];
        
        $this->render('editar', $data);
    }
    
    /**
     * Actualizar asignación
     */
    public function update($id) {
        // Validar datos requeridos
        $errors = $this->validate($_POST, [
            'INSTRUCTOR_inst_id',
            'COMPETxPROGRAMA_PROGRAMA_prog_id',
            'COMPETxPROGRAMA_COMPETENCIA_comp_id',
            'inscomp_vigencia'
        ]);
        
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old_input'] = $_POST;
            $this->redirect(BASE_PATH . "instru_competencia/editar?id={$id}");
        }
        
        try {
            // Verificar que la combinación programa+competencia existe en COMPETxPROGRAMA
            require_once __DIR__ . '/../conexion.php';
            $db = Database::getInstance()->getConnection();
            $stmt = $db->prepare("
                SELECT COUNT(*) as existe 
                FROM COMPETxPROGRAMA 
                WHERE PROGRAMA_prog_id = ? AND COMPETENCIA_comp_id = ?
            ");
            $stmt->execute([
                $_POST['COMPETxPROGRAMA_PROGRAMA_prog_id'],
                $_POST['COMPETxPROGRAMA_COMPETENCIA_comp_id']
            ]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($result['existe'] == 0) {
                $_SESSION['error'] = 'La combinación de Programa y Competencia seleccionada no está asociada.';
                $_SESSION['old_input'] = $_POST;
                $this->redirect(BASE_PATH . "instru_competencia/editar?id={$id}");
            }
            
            $this->model->update($id, $_POST);
            $_SESSION['success'] = 'Competencia actualizada exitosamente';
            $this->redirect(BASE_PATH . 'instru_competencia');
        } catch (Exception $e) {
            $_SESSION['error'] = 'Error al actualizar competencia: ' . $e->getMessage();
            $_SESSION['old_input'] = $_POST;
            $this->redirect(BASE_PATH . "instru_competencia/editar?id={$id}");
        }
    }
    
    /**
     * Eliminar asignación
     */
    public function eliminar() {
        $id = $this->get('id', 0);
        
        if (!$id) {
            $_SESSION['error'] = 'ID no válido';
            $this->redirect(BASE_PATH . 'instru_competencia');
        }
        
        try {
            $this->model->delete($id);
            $_SESSION['success'] = 'Competencia eliminada exitosamente';
        } catch (Exception $e) {
            $_SESSION['error'] = 'Error al eliminar competencia: ' . $e->getMessage();
        }
        
        $this->redirect(BASE_PATH . 'instru_competencia');
    }
}
?>
