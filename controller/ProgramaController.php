<?php
require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../model/ProgramaModel.php';
require_once __DIR__ . '/../model/TituloProgramaModel.php';

class ProgramaController extends BaseController {
    private $tituloModel;
    
    public function __construct() {
        parent::__construct();
        $this->model = new ProgramaModel();
        $this->tituloModel = new TituloProgramaModel();
        $this->viewPath = 'programa';
    }
    
    /**
     * Listar todos los programas
     */
    public function index() {
        verificarRol(['Administrador', 'Coordinador']);
        $pageTitle = 'Gestión de Programas';
        $registros = $this->model->getAll();
        $mensaje = $this->getFlashMessage();
        
        $this->loadView('index', compact('pageTitle', 'registros', 'mensaje'));
    }
    
    /**
     * Mostrar formulario de creación
     */
    public function create() {
        $pageTitle = 'Nuevo Programa';
        $titulos = $this->tituloModel->getAll();
        
        $this->loadView('crear', compact('pageTitle', 'titulos'));
    }
    
    /**
     * Guardar nuevo programa
     */
    public function store() {
        if (!$this->isMethod('POST')) {
            $this->redirect(BASE_PATH . 'programa/create');
            return;
        }
        
        // Validar campos requeridos
        $required = ['prog_denominacion', 'titulo_programa_titpro_id'];
        $errors = [];
        
        foreach ($required as $field) {
            if (empty($_POST[$field])) {
                $errors[] = "El campo " . str_replace('_', ' ', $field) . " es requerido";
            }
        }
        
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old_input'] = $_POST;
            $this->redirect(BASE_PATH . 'programa/create');
            return;
        }
        
        try {
            $result = $this->model->create($_POST);
            if ($result) {
                $_SESSION['success'] = 'Programa creado exitosamente';
                $this->redirect(BASE_PATH . 'programa');
            } else {
                $_SESSION['error'] = 'No se pudo crear el programa';
                $_SESSION['old_input'] = $_POST;
                $this->redirect(BASE_PATH . 'programa/create');
            }
        } catch (Exception $e) {
            $_SESSION['error'] = 'Error: ' . $e->getMessage();
            $_SESSION['old_input'] = $_POST;
            $this->redirect(BASE_PATH . 'programa/create');
        }
    }
    
    /**
     * Ver detalle de un programa
     */
    public function show($id) {
        $registro = $this->model->getById($id);
        if (!$registro) {
            $_SESSION['error'] = 'Programa no encontrado';
            $this->redirect(BASE_PATH . 'programa');
            return;
        }
        
        $pageTitle = 'Ver Programa';
        $this->loadView('ver', compact('pageTitle', 'registro'));
    }
    
    /**
     * Mostrar formulario de edición
     */
    public function edit($id) {
        $registro = $this->model->getById($id);
        if (!$registro) {
            $_SESSION['error'] = 'Programa no encontrado';
            $this->redirect(BASE_PATH . 'programa');
            return;
        }
        
        $pageTitle = 'Editar Programa';
        $titulos = $this->tituloModel->getAll();
        
        $this->loadView('editar', compact('pageTitle', 'registro', 'titulos'));
    }
    
    /**
     * Actualizar programa
     */
    public function update($id) {
        if (!$this->isMethod('POST')) {
            $this->redirect(BASE_PATH . "programa/edit/{$id}");
            return;
        }
        
        $errors = $this->validate($_POST, ['prog_denominacion', 'titulo_programa_titpro_id', 'prog_tipo']);
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old_input'] = $_POST;
            $this->redirect(BASE_PATH . "programa/edit/{$id}");
            return;
        }
        
        try {
            $this->model->update($id, $_POST);
                $_SESSION['success'] = 'Programa actualizado exitosamente';
                $this->redirect(BASE_PATH . 'programa');
        } catch (Exception $e) {
            $_SESSION['error'] = 'Error: ' . $e->getMessage();
            $this->redirect(BASE_PATH . "programa/edit/{$id}");
        }
    }
    
    /**
     * Eliminar programa
     */
    public function delete($id) {
        try {
            $this->model->delete($id);
            $_SESSION['success'] = 'Programa eliminado exitosamente';
        } catch (Exception $e) {
            $_SESSION['error'] = 'Error: ' . $e->getMessage();
        }
        
        $this->redirect(BASE_PATH . 'programa');
    }
    
    // Métodos auxiliares para cargar vistas
    private function loadView($view, $data = []) {
        extract($data);
        include __DIR__ . '/../views/layout/header.php';
        include __DIR__ . '/../views/layout/sidebar.php';
        include __DIR__ . "/../views/{$this->viewPath}/{$view}.php";
        include __DIR__ . '/../views/layout/footer.php';
    }
}
?>
