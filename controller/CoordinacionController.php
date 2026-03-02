<?php
/**
 * Controlador de Coordinación
 * Maneja la gestión de coordinaciones académicas
 */

require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../model/CoordinacionModel.php';
require_once __DIR__ . '/../model/CentroFormacionModel.php';

class CoordinacionController extends BaseController {
    
    public function __construct() {
        parent::__construct();
        $this->model = new CoordinacionModel();
        $this->viewPath = 'coordinacion';
    }
    
    /**
     * Listar todas las coordinaciones
     */
    public function index() {
        verificarRol(['Administrador', 'Coordinador']);
        $registros = $this->model->getAll();
        
        $this->render('index', [
            'pageTitle' => 'Gestión de Coordinaciones',
            'registros' => $registros
        ]);
    }
    
    /**
     * Mostrar formulario de creación
     */
    public function crear() {
        $centroModel = new CentroFormacionModel();
        $centros = $centroModel->getAll();
        
        $this->render('crear', [
            'pageTitle' => 'Nueva Coordinación',
            'centros' => $centros
        ]);
    }
    
    /**
     * Guardar nueva coordinación
     */
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect(BASE_PATH . 'coordinacion');
            return;
        }
        
        // Validar campos requeridos
        $required = ['coord_nombre', 'centro_formacion_cent_id'];
        $errors = $this->validate($_POST, $required);
        
        if (!empty($errors)) {
            $_SESSION['error'] = 'Por favor complete todos los campos requeridos';
            $this->redirect(BASE_PATH . 'coordinacion/crear');
            return;
        }
        
        // Crear coordinación
        $result = $this->model->create($_POST);
        
        if ($result) {
            $_SESSION['success'] = 'Coordinación creada exitosamente';
        } else {
            $_SESSION['error'] = 'Error al crear la coordinación';
        }
        
        $this->redirect(BASE_PATH . 'coordinacion');
    }
    
    /**
     * Ver detalles de una coordinación
     */
    public function ver($id) {
        $registro = $this->model->getById($id);
        
        if (!$registro) {
            $_SESSION['error'] = 'Coordinación no encontrada';
            $this->redirect(BASE_PATH . 'coordinacion');
            return;
        }
        
        $this->render('ver', [
            'pageTitle' => 'Detalles de Coordinación',
            'registro' => $registro
        ]);
    }
    
    /**
     * Mostrar formulario de edición
     */
    public function editar($id) {
        $registro = $this->model->getById($id);
        
        if (!$registro) {
            $_SESSION['error'] = 'Coordinación no encontrada';
            $this->redirect(BASE_PATH . 'coordinacion');
            return;
        }
        
        $centroModel = new CentroFormacionModel();
        $centros = $centroModel->getAll();
        
        $this->render('editar', [
            'pageTitle' => 'Editar Coordinación',
            'registro' => $registro,
            'centros' => $centros
        ]);
    }
    
    /**
     * Actualizar coordinación
     */
    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect(BASE_PATH . 'coordinacion');
            return;
        }
        
        // Validar campos requeridos
        $required = ['coord_nombre', 'centro_formacion_cent_id'];
        $errors = $this->validate($_POST, $required);
        
        if (!empty($errors)) {
            $_SESSION['error'] = 'Por favor complete todos los campos requeridos';
            $this->redirect(BASE_PATH . 'coordinacion/editar/' . $id);
            return;
        }
        
        // Actualizar coordinación
        $result = $this->model->update($id, $_POST);
        
        if ($result) {
            $_SESSION['success'] = 'Coordinación actualizada exitosamente';
        } else {
            $_SESSION['error'] = 'Error al actualizar la coordinación';
        }
        
        $this->redirect(BASE_PATH . 'coordinacion');
    }
    
    /**
     * Eliminar coordinación
     */
    public function eliminar($id) {
        $result = $this->model->delete($id);
        
        if ($result) {
            $_SESSION['success'] = 'Coordinación eliminada exitosamente';
        } else {
            $_SESSION['error'] = 'Error al eliminar la coordinación';
        }
        
        $this->redirect(BASE_PATH . 'coordinacion');
    }
}
?>
