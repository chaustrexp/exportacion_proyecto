<?php
require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../model/DetalleAsignacionModel.php';
require_once __DIR__ . '/../model/AsignacionModel.php';

/**
 * Controlador de Detalles de Asignación
 * Maneja los horarios específicos de cada asignación
 */
class DetalleAsignacionController extends BaseController {
    private $asignacionModel;
    
    public function __construct() {
        parent::__construct();
        $this->model = new DetalleAsignacionModel();
        $this->asignacionModel = new AsignacionModel();
        $this->viewPath = 'detalle_asignacion';
    }
    
    /**
     * Listar todos los detalles
     */
    public function index() {
        $registros = $this->model->getAll();
        
        $data = [
            'pageTitle' => 'Detalles de Asignación',
            'registros' => $registros,
            'totalDetalles' => count($registros),
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
            'pageTitle' => 'Crear Detalle de Asignación',
            'asignaciones' => $this->asignacionModel->getAll()
        ];
        
        $this->render('crear', $data);
    }
    
    /**
     * Guardar nuevo detalle
     */
    public function store() {
        // Validar datos requeridos
        $errors = $this->validate($_POST, [
            'asignacion_id',
            'hora_inicio',
            'hora_fin'
        ]);
        
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old_input'] = $_POST;
            $this->redirect(BASE_PATH . 'detalle_asignacion/crear');
        }
        
        try {
            $this->model->create($_POST);
            $_SESSION['success'] = 'Detalle de asignación creado exitosamente';
            $this->redirect(BASE_PATH . 'detalle_asignacion');
        } catch (Exception $e) {
            $_SESSION['error'] = 'Error al crear detalle: ' . $e->getMessage();
            $_SESSION['old_input'] = $_POST;
            $this->redirect(BASE_PATH . 'detalle_asignacion/crear');
        }
    }
    
    /**
     * Ver detalle
     */
    public function ver() {
        $id = $this->get('id', 0);
        
        if (!$id) {
            $_SESSION['error'] = 'ID no válido';
            $this->redirect(BASE_PATH . 'detalle_asignacion');
        }
        
        $registro = $this->model->getById($id);
        
        if (!$registro) {
            $_SESSION['error'] = 'Detalle no encontrado';
            $this->redirect(BASE_PATH . 'detalle_asignacion');
        }
        
        $data = [
            'pageTitle' => 'Ver Detalle de Asignación',
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
            $this->redirect(BASE_PATH . 'detalle_asignacion');
        }
        
        // Si es POST, procesar el formulario
        if ($this->isMethod('POST')) {
            $this->update($id);
            return;
        }
        
        // Si es GET, mostrar el formulario
        $registro = $this->model->getById($id);
        
        if (!$registro) {
            $_SESSION['error'] = 'Detalle no encontrado';
            $this->redirect(BASE_PATH . 'detalle_asignacion');
        }
        
        $data = [
            'pageTitle' => 'Editar Detalle de Asignación',
            'registro' => $registro,
            'asignaciones' => $this->asignacionModel->getAll()
        ];
        
        $this->render('editar', $data);
    }
    
    /**
     * Actualizar detalle
     */
    public function update($id) {
        // Validar datos requeridos
        $errors = $this->validate($_POST, [
            'asignacion_id',
            'hora_inicio',
            'hora_fin'
        ]);
        
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old_input'] = $_POST;
            $this->redirect(BASE_PATH . "detalle_asignacion/editar?id={$id}");
        }
        
        try {
            $this->model->update($id, $_POST);
            $_SESSION['success'] = 'Detalle actualizado exitosamente';
            $this->redirect(BASE_PATH . 'detalle_asignacion');
        } catch (Exception $e) {
            $_SESSION['error'] = 'Error al actualizar detalle: ' . $e->getMessage();
            $_SESSION['old_input'] = $_POST;
            $this->redirect(BASE_PATH . "detalle_asignacion/editar?id={$id}");
        }
    }
    
    /**
     * Eliminar detalle
     */
    public function eliminar() {
        $id = $this->get('id', 0);
        
        if (!$id) {
            $_SESSION['error'] = 'ID no válido';
            $this->redirect(BASE_PATH . 'detalle_asignacion');
        }
        
        try {
            $this->model->delete($id);
            $_SESSION['success'] = 'Detalle eliminado exitosamente';
        } catch (Exception $e) {
            $_SESSION['error'] = 'Error al eliminar detalle: ' . $e->getMessage();
        }
        
        $this->redirect(BASE_PATH . 'detalle_asignacion');
    }
}
?>
