<?php
require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../model/InstructorModel.php';
require_once __DIR__ . '/../model/CentroFormacionModel.php';

/**
 * Controlador de Instructores
 */
class InstructorController extends BaseController {
    private $centroModel;
    
    public function __construct() {
        parent::__construct();
        $this->model = new InstructorModel();
        $this->centroModel = new CentroFormacionModel();
        $this->viewPath = 'instructor';
    }
    
    public function index() {
        $registros = $this->model->getAll();
        
        $data = [
            'pageTitle' => 'Gestión de Instructores',
            'registros' => $registros,
            'totalInstructores' => count($registros),
            'mensaje' => $this->getFlashMessage()
        ];
        
        $this->render('index', $data);
    }
    
    public function crear() {
        if ($this->isMethod('POST')) {
            return $this->store();
        }
        
        $data = [
            'pageTitle' => 'Nuevo Instructor',
            'centros' => $this->centroModel->getAll()
        ];
        
        $this->render('crear', $data);
    }
    
    public function store() {
        $errors = $this->validate($_POST, ['inst_nombres', 'inst_apellidos', 'inst_correo', 'centro_formacion_cent_id']);
        
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old_input'] = $_POST;
            $this->redirect(BASE_PATH . 'instructor/crear');
        }
        
        try {
            $this->model->create($_POST);
            $_SESSION['success'] = 'Instructor creado exitosamente';
            $this->redirect(BASE_PATH . 'instructor');
        } catch (Exception $e) {
            $_SESSION['error'] = 'Error al crear el instructor: ' . $e->getMessage();
            $_SESSION['old_input'] = $_POST;
            $this->redirect(BASE_PATH . 'instructor/crear');
        }
    }
    
    public function ver() {
        $id = $this->get('id', 0);
        
        if (!$id) {
            $_SESSION['error'] = 'ID no válido';
            $this->redirect(BASE_PATH . 'instructor');
        }
        
        $registro = $this->model->getById($id);
        
        if (!$registro) {
            $_SESSION['error'] = 'Instructor no encontrado';
            $this->redirect(BASE_PATH . 'instructor');
        }
        
        $data = [
            'pageTitle' => 'Ver Instructor',
            'registro' => $registro
        ];
        
        $this->render('ver', $data);
    }
    
    public function editar() {
        $id = $this->get('id', 0);
        
        if (!$id) {
            $_SESSION['error'] = 'ID no válido';
            $this->redirect(BASE_PATH . 'instructor');
        }
        
        // Si es POST, procesar el formulario
        if ($this->isMethod('POST')) {
            $this->update($id);
            return;
        }
        
        // Si es GET, mostrar el formulario
        $registro = $this->model->getById($id);
        
        if (!$registro) {
            $_SESSION['error'] = 'Instructor no encontrado';
            $this->redirect(BASE_PATH . 'instructor');
        }
        
        $data = [
            'pageTitle' => 'Editar Instructor',
            'registro' => $registro,
            'centros' => $this->centroModel->getAll()
        ];
        
        $this->render('editar', $data);
    }
    
    public function update($id) {
        $errors = $this->validate($_POST, ['inst_nombres', 'inst_apellidos', 'inst_correo', 'centro_formacion_cent_id']);
        
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old_input'] = $_POST;
            $this->redirect(BASE_PATH . "instructor/editar?id={$id}");
        }
        
        try {
            $this->model->update($id, $_POST);
            $_SESSION['success'] = 'Instructor actualizado exitosamente';
            $this->redirect(BASE_PATH . 'instructor');
        } catch (Exception $e) {
            $_SESSION['error'] = 'Error al actualizar el instructor: ' . $e->getMessage();
            $_SESSION['old_input'] = $_POST;
            $this->redirect(BASE_PATH . "instructor/editar?id={$id}");
        }
    }
    
    public function eliminar() {
        $id = $this->get('id', 0);
        
        if (!$id) {
            $_SESSION['error'] = 'ID no válido';
            $this->redirect(BASE_PATH . 'instructor');
        }
        
        try {
            $this->model->delete($id);
            $_SESSION['success'] = 'Instructor eliminado exitosamente';
        } catch (Exception $e) {
            $_SESSION['error'] = 'Error al eliminar el instructor: ' . $e->getMessage();
        }
        
        $this->redirect(BASE_PATH . 'instructor');
    }
}
?>
