<?php
/**
 * Controlador de Centro de Formación
 * Maneja la gestión de centros de formación
 */

require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../model/CentroFormacionModel.php';

class CentroFormacionController extends BaseController {
    
    public function __construct() {
        parent::__construct();
        $this->model = new CentroFormacionModel();
        $this->viewPath = 'centro_formacion';
    }
    
    /**
     * Listar todos los centros de formación
     */
    public function index() {
        verificarRol(['Administrador', 'Coordinador']);
        $registros = $this->model->getAll();
        
        $this->render('index', [
            'pageTitle' => 'Gestión de Centros de Formación',
            'registros' => $registros
        ]);
    }
    
    /**
     * Mostrar formulario de creación
     */
    public function crear() {
        $this->render('crear', [
            'pageTitle' => 'Nuevo Centro de Formación'
        ]);
    }
    
    /**
     * Guardar nuevo centro de formación
     */
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect(BASE_PATH . 'centro_formacion');
            return;
        }
        
        // Validar campos requeridos
        $required = ['cent_nombre'];
        $errors = $this->validate($_POST, $required);
        
        if (!empty($errors)) {
            $_SESSION['error'] = 'Por favor complete todos los campos requeridos';
            $this->redirect(BASE_PATH . 'centro_formacion/crear');
            return;
        }
        
        // Crear centro
        $result = $this->model->create($_POST);
        
        if ($result) {
            $_SESSION['success'] = 'Centro de formación creado exitosamente';
        } else {
            $_SESSION['error'] = 'Error al crear el centro de formación';
        }
        
        $this->redirect(BASE_PATH . 'centro_formacion');
    }
    
    /**
     * Ver detalles de un centro de formación
     */
    public function ver($id) {
        $registro = $this->model->getById($id);
        
        if (!$registro) {
            $_SESSION['error'] = 'Centro de formación no encontrado';
            $this->redirect(BASE_PATH . 'centro_formacion');
            return;
        }
        
        $this->render('ver', [
            'pageTitle' => 'Detalles del Centro de Formación',
            'registro' => $registro
        ]);
    }
    
    /**
     * Mostrar formulario de edición
     */
    public function editar($id) {
        $registro = $this->model->getById($id);
        
        if (!$registro) {
            $_SESSION['error'] = 'Centro de formación no encontrado';
            $this->redirect(BASE_PATH . 'centro_formacion');
            return;
        }
        
        $this->render('editar', [
            'pageTitle' => 'Editar Centro de Formación',
            'registro' => $registro
        ]);
    }
    
    /**
     * Actualizar centro de formación
     */
    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect(BASE_PATH . 'centro_formacion');
            return;
        }
        
        // Validar campos requeridos
        $required = ['cent_nombre'];
        $errors = $this->validate($_POST, $required);
        
        if (!empty($errors)) {
            $_SESSION['error'] = 'Por favor complete todos los campos requeridos';
            $this->redirect(BASE_PATH . 'centro_formacion/editar/' . $id);
            return;
        }
        
        // Actualizar centro
        $result = $this->model->update($id, $_POST);
        
        if ($result) {
            $_SESSION['success'] = 'Centro de formación actualizado exitosamente';
        } else {
            $_SESSION['error'] = 'Error al actualizar el centro de formación';
        }
        
        $this->redirect(BASE_PATH . 'centro_formacion');
    }
    
    /**
     * Eliminar centro de formación
     */
    public function eliminar($id) {
        $result = $this->model->delete($id);
        
        if ($result) {
            $_SESSION['success'] = 'Centro de formación eliminado exitosamente';
        } else {
            $_SESSION['error'] = 'Error al eliminar el centro de formación';
        }
        
        $this->redirect(BASE_PATH . 'centro_formacion');
    }
}
?>
