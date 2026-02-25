<?php
/**
 * Controlador de Sede
 * Maneja la gestión de sedes
 */

require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../model/SedeModel.php';

class SedeController extends BaseController {
    
    public function __construct() {
        parent::__construct();
        $this->model = new SedeModel();
        $this->viewPath = 'sede';
    }
    
    /**
     * Listar todas las sedes
     */
    public function index() {
        verificarRol(['Administrador', 'Coordinador']);
        $registros = $this->model->getAll();
        
        $this->render('index', [
            'pageTitle' => 'Gestión de Sedes',
            'registros' => $registros
        ]);
    }
    
    /**
     * Mostrar formulario de creación
     */
    public function crear() {
        $this->render('crear', [
            'pageTitle' => 'Nueva Sede'
        ]);
    }
    
    /**
     * Guardar nueva sede
     */
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect(BASE_PATH . 'sede');
            return;
        }
        
        // Validar campos requeridos
        $required = ['sede_nombre'];
        $errors = $this->validate($_POST, $required);
        
        if (!empty($errors)) {
            $_SESSION['error'] = 'Por favor complete todos los campos requeridos';
            $this->redirect(BASE_PATH . 'sede/crear');
            return;
        }
        
        // Crear sede
        $result = $this->model->create($_POST);
        
        if ($result) {
            $_SESSION['success'] = 'Sede creada exitosamente';
        } else {
            $_SESSION['error'] = 'Error al crear la sede';
        }
        
        $this->redirect(BASE_PATH . 'sede');
    }
    
    /**
     * Ver detalles de una sede
     */
    public function ver($id) {
        $registro = $this->model->getById($id);
        
        if (!$registro) {
            $_SESSION['error'] = 'Sede no encontrada';
            $this->redirect(BASE_PATH . 'sede');
            return;
        }
        
        $this->render('ver', [
            'pageTitle' => 'Detalles de la Sede',
            'registro' => $registro
        ]);
    }
    
    /**
     * Mostrar formulario de edición
     */
    public function editar($id) {
        $registro = $this->model->getById($id);
        
        if (!$registro) {
            $_SESSION['error'] = 'Sede no encontrada';
            $this->redirect(BASE_PATH . 'sede');
            return;
        }
        
        $this->render('editar', [
            'pageTitle' => 'Editar Sede',
            'registro' => $registro
        ]);
    }
    
    /**
     * Actualizar sede
     */
    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect(BASE_PATH . 'sede');
            return;
        }
        
        // Validar campos requeridos
        $required = ['sede_nombre'];
        $errors = $this->validate($_POST, $required);
        
        if (!empty($errors)) {
            $_SESSION['error'] = 'Por favor complete todos los campos requeridos';
            $this->redirect(BASE_PATH . 'sede/editar/' . $id);
            return;
        }
        
        // Actualizar sede
        $result = $this->model->update($id, $_POST);
        
        if ($result) {
            $_SESSION['success'] = 'Sede actualizada exitosamente';
        } else {
            $_SESSION['error'] = 'Error al actualizar la sede';
        }
        
        $this->redirect(BASE_PATH . 'sede');
    }
    
    /**
     * Eliminar sede
     */
    public function eliminar($id) {
        $result = $this->model->delete($id);
        
        if ($result) {
            $_SESSION['success'] = 'Sede eliminada exitosamente';
        } else {
            $_SESSION['error'] = 'Error al eliminar la sede';
        }
        
        $this->redirect(BASE_PATH . 'sede');
    }
}
?>
