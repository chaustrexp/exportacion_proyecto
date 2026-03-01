<?php
require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../model/CompetenciaModel.php';

class CompetenciaController extends BaseController {
    public function __construct() {
        parent::__construct();
        $this->model = new CompetenciaModel();
        $this->viewPath = 'competencia';
    }
    
    public function index() {
        verificarRol(['Administrador', 'Coordinador']);
        $data = [
            'pageTitle' => 'Gestión de Competencias',
            'registros' => $this->model->getAll(),
            'mensaje' => $this->getFlashMessage()
        ];
        $this->render('index', $data);
    }
    
    public function crear() {
        if ($this->isMethod('POST')) return $this->store();
        $this->render('crear', ['pageTitle' => 'Nueva Competencia']);
    }
    
    public function store() {
        $errors = $this->validate($_POST, ['nombre_corto', 'nombre_unidad_competencia', 'horas']);
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old_input'] = $_POST;
            $this->redirect(BASE_PATH . 'competencia/crear');
        }
        try {
            $this->model->create($_POST);
            $this->redirect(BASE_PATH . 'competencia?msg=creado');
        } catch (Exception $e) {
            $_SESSION['error'] = 'Error: ' . $e->getMessage();
            $this->redirect(BASE_PATH . 'competencia/crear');
        }
    }
    
    public function ver($id = null) {
        if (!$id) $this->redirect(BASE_PATH . 'competencia');
        $registro = $this->model->getById($id);
        if (!$registro) $this->redirect(BASE_PATH . 'competencia?msg=no_encontrado');
        $this->render('ver', ['pageTitle' => 'Ver Competencia', 'registro' => $registro]);
    }
    
    public function editar($id = null) {
        if (!$id) $this->redirect(BASE_PATH . 'competencia');
        if ($this->isMethod('POST')) return $this->update($id);
        $registro = $this->model->getById($id);
        if (!$registro) $this->redirect(BASE_PATH . 'competencia?msg=no_encontrado');
        $this->render('editar', ['pageTitle' => 'Editar Competencia', 'registro' => $registro]);
    }
    
    public function update($id) {
        $errors = $this->validate($_POST, ['nombre_corto', 'nombre_unidad_competencia', 'horas']);
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $this->redirect(BASE_PATH . "competencia/editar/{$id}");
        }
        try {
            $this->model->update($id, $_POST);
            $this->redirect(BASE_PATH . 'competencia?msg=actualizado');
        } catch (Exception $e) {
            $_SESSION['error'] = 'Error: ' . $e->getMessage();
            $this->redirect(BASE_PATH . "competencia/editar/{$id}");
        }
    }
    
    public function eliminar($id = null) {
        if (!$id) $this->redirect(BASE_PATH . 'competencia');
        try {
            $this->model->delete($id);
            $this->redirect(BASE_PATH . 'competencia?msg=eliminado');
        } catch (Exception $e) {
            $_SESSION['error'] = 'No se puede eliminar la competencia porque está siendo usada en otros registros (comprueba programas o asignaciones).';
            $this->redirect(BASE_PATH . 'competencia');
        }
    }
}
?>
