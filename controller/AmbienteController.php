<?php
require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../model/AmbienteModel.php';
require_once __DIR__ . '/../model/SedeModel.php';

class AmbienteController extends BaseController {
    private $sedeModel;
    
    public function __construct() {
        parent::__construct();
        $this->model = new AmbienteModel();
        $this->sedeModel = new SedeModel();
        $this->viewPath = 'ambiente';
    }
    
    public function index() {
        verificarRol(['Administrador', 'Coordinador']);
        $registros = $this->model->getAll();
        
        $data = [
            'pageTitle' => 'Gestión de Ambientes',
            'registros' => $registros,
            'totalAmbientes' => count($registros),
            'mensaje' => $this->getFlashMessage()
        ];
        
        $this->render('index', $data);
    }
    
    public function crear() {
        // Si es POST, procesar el formulario
        if ($this->isMethod('POST')) {
            $this->store();
            return;
        }
        
        // Si es GET, mostrar el formulario
        $data = [
            'pageTitle' => 'Nuevo Ambiente',
            'sedes' => $this->sedeModel->getAll()
        ];
        
        $this->render('crear', $data);
    }
    
    public function store() {
        $errors = $this->validate($_POST, ['codigo', 'nombre', 'sede_id']);
        
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old_input'] = $_POST;
            $this->redirect(BASE_PATH . 'ambiente/crear');
        }
        
        try {
            // Verificar si el código ya existe
            if ($this->model->getById($_POST['codigo'])) {
                $_SESSION['error'] = 'El código de ambiente "' . $_POST['codigo'] . '" ya está en uso.';
                $_SESSION['old_input'] = $_POST;
                $this->redirect(BASE_PATH . 'ambiente/crear');
                return;
            }

            $this->model->create($_POST);
            $_SESSION['success'] = 'Ambiente creado exitosamente';
            $this->redirect(BASE_PATH . 'ambiente');
        } catch (Exception $e) {
            $_SESSION['error'] = 'Error al crear ambiente: ' . $e->getMessage();
            $_SESSION['old_input'] = $_POST;
            $this->redirect(BASE_PATH . 'ambiente/crear');
        }
    }
    
    public function ver() {
        $id = $this->get('id', 0);
        
        if (!$id) {
            $_SESSION['error'] = 'ID no válido';
            $this->redirect(BASE_PATH . 'ambiente');
        }
        
        $registro = $this->model->getById($id);
        
        if (!$registro) {
            $_SESSION['error'] = 'Ambiente no encontrado';
            $this->redirect(BASE_PATH . 'ambiente');
        }
        
        $data = [
            'pageTitle' => 'Ver Ambiente',
            'registro' => $registro
        ];
        
        $this->render('ver', $data);
    }
    
    public function editar() {
        $id = $this->get('id', 0);
        
        if (!$id) {
            $_SESSION['error'] = 'ID no válido';
            $this->redirect(BASE_PATH . 'ambiente');
        }
        
        // Si es POST, procesar el formulario
        if ($this->isMethod('POST')) {
            $this->update($id);
            return;
        }
        
        // Si es GET, mostrar el formulario
        $registro = $this->model->getById($id);
        
        if (!$registro) {
            $_SESSION['error'] = 'Ambiente no encontrado';
            $this->redirect(BASE_PATH . 'ambiente');
        }
        
        $data = [
            'pageTitle' => 'Editar Ambiente',
            'registro' => $registro,
            'sedes' => $this->sedeModel->getAll()
        ];
        
        $this->render('editar', $data);
    }
    
    public function update($id) {
        $errors = $this->validate($_POST, ['nombre', 'sede_id']);
        
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old_input'] = $_POST;
            $this->redirect(BASE_PATH . "ambiente/editar?id={$id}");
        }
        
        try {
            $this->model->update($id, $_POST);
            $_SESSION['success'] = 'Ambiente actualizado exitosamente';
            $this->redirect(BASE_PATH . 'ambiente');
        } catch (Exception $e) {
            $_SESSION['error'] = 'Error al actualizar ambiente: ' . $e->getMessage();
            $_SESSION['old_input'] = $_POST;
            $this->redirect(BASE_PATH . "ambiente/editar?id={$id}");
        }
    }
    
    public function eliminar() {
        $id = $this->get('id', 0);
        
        if (!$id) {
            $_SESSION['error'] = 'ID no válido';
            $this->redirect(BASE_PATH . 'ambiente');
        }
        
        try {
            $this->model->delete($id);
            $_SESSION['success'] = 'Ambiente eliminado exitosamente';
        } catch (Exception $e) {
            $_SESSION['error'] = 'Error al eliminar ambiente: ' . $e->getMessage();
        }
        
        $this->redirect(BASE_PATH . 'ambiente');
    }
}
?>
