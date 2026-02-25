<?php
require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../model/TituloProgramaModel.php';

/**
 * Controlador de Títulos de Programa
 * Maneja los títulos otorgados por los programas
 */
class TituloProgramaController extends BaseController {
    
    public function __construct() {
        parent::__construct();
        $this->model = new TituloProgramaModel();
        $this->viewPath = 'titulo_programa';
    }
    
    /**
     * Listar todos los títulos
     */
    public function index() {
        verificarRol(['Administrador', 'Coordinador']);
        $registros = $this->model->getAll();
        
        $data = [
            'pageTitle' => 'Títulos de Programa',
            'registros' => $registros,
            'totalTitulos' => count($registros),
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
            'pageTitle' => 'Crear Título de Programa'
        ];
        
        $this->render('crear', $data);
    }
    
    /**
     * Guardar nuevo título
     */
    public function store() {
        // Validar datos requeridos
        $errors = $this->validate($_POST, [
            'titpro_nombre'
        ]);
        
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old_input'] = $_POST;
            $this->redirect(BASE_PATH . 'titulo_programa/crear');
        }
        
        try {
            $this->model->create($_POST);
            $_SESSION['success'] = 'Título creado exitosamente';
            $this->redirect(BASE_PATH . 'titulo_programa');
        } catch (Exception $e) {
            $_SESSION['error'] = 'Error al crear título: ' . $e->getMessage();
            $_SESSION['old_input'] = $_POST;
            $this->redirect(BASE_PATH . 'titulo_programa/crear');
        }
    }
    
    /**
     * Ver detalle de un título
     */
    public function ver() {
        $id = $this->get('id', 0);
        
        if (!$id) {
            $_SESSION['error'] = 'ID no válido';
            $this->redirect(BASE_PATH . 'titulo_programa');
        }
        
        $registro = $this->model->getById($id);
        
        if (!$registro) {
            $_SESSION['error'] = 'Título no encontrado';
            $this->redirect(BASE_PATH . 'titulo_programa');
        }
        
        $data = [
            'pageTitle' => 'Ver Título de Programa',
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
            $this->redirect(BASE_PATH . 'titulo_programa');
        }
        
        // Si es POST, procesar el formulario
        if ($this->isMethod('POST')) {
            $this->update($id);
            return;
        }
        
        // Si es GET, mostrar el formulario
        $registro = $this->model->getById($id);
        
        if (!$registro) {
            $_SESSION['error'] = 'Título no encontrado';
            $this->redirect(BASE_PATH . 'titulo_programa');
        }
        
        $data = [
            'pageTitle' => 'Editar Título de Programa',
            'registro' => $registro
        ];
        
        $this->render('editar', $data);
    }
    
    /**
     * Actualizar título
     */
    public function update($id) {
        // Validar datos requeridos
        $errors = $this->validate($_POST, [
            'titpro_nombre'
        ]);
        
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old_input'] = $_POST;
            $this->redirect(BASE_PATH . 'titulo_programa/editar?id=' . $id);
        }
        
        try {
            $this->model->update($id, $_POST);
            $_SESSION['success'] = 'Título actualizado exitosamente';
            $this->redirect(BASE_PATH . 'titulo_programa');
        } catch (Exception $e) {
            $_SESSION['error'] = 'Error al actualizar título: ' . $e->getMessage();
            $_SESSION['old_input'] = $_POST;
            $this->redirect(BASE_PATH . 'titulo_programa/editar?id=' . $id);
        }
    }
    
    /**
     * Eliminar título
     */
    public function eliminar() {
        $id = $this->get('id', 0);
        
        if (!$id) {
            $_SESSION['error'] = 'ID no válido';
            $this->redirect(BASE_PATH . 'titulo_programa');
        }
        
        try {
            $this->model->delete($id);
            $_SESSION['success'] = 'Título eliminado exitosamente';
        } catch (Exception $e) {
            $_SESSION['error'] = 'Error al eliminar título: ' . $e->getMessage();
        }
        
        $this->redirect(BASE_PATH . 'titulo_programa');
    }
}
?>
