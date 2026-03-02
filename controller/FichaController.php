<?php
require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../model/FichaModel.php';
require_once __DIR__ . '/../model/ProgramaModel.php';
require_once __DIR__ . '/../model/InstructorModel.php';
require_once __DIR__ . '/../model/CoordinacionModel.php';

/**
 * Controlador FichaController
 * Coordina las operaciones sobre las fichas de formación, gestionando su ciclo de vida,
 * jornadas y vinculación con programas e instructores.
 */
class FichaController extends BaseController {
    private $programaModel;
    private $instructorModel;
    private $coordinacionModel;
    
    public function __construct() {
        parent::__construct();
        $this->model = new FichaModel();
        $this->programaModel = new ProgramaModel();
        $this->instructorModel = new InstructorModel();
        $this->coordinacionModel = new CoordinacionModel();
        $this->viewPath = 'ficha';
    }
    
    /**
     * Listado de fichas
     */
    public function index() {
        verificarRol(['Administrador', 'Coordinador']);
        try {
            $registros = $this->model->getAll();
            
            // Calcular estadísticas
            $totalFichas = count($registros);
            $fichasActivas = 0;
            $hoy = date('Y-m-d');
            
            foreach ($registros as $ficha) {
                if ($ficha['fich_fecha_ini_lectiva'] && $ficha['fich_fecha_fin_lectiva']) {
                    if ($ficha['fich_fecha_ini_lectiva'] <= $hoy && $ficha['fich_fecha_fin_lectiva'] >= $hoy) {
                        $fichasActivas++;
                    }
                }
            }
            
            $pageTitle = 'Gestión de Fichas';
            $mensaje = $this->getFlashMessage();
            
            $this->loadView('index', compact('pageTitle', 'registros', 'totalFichas', 'fichasActivas', 'mensaje'));
        } catch (Exception $e) {
            $_SESSION['error'] = 'Error al cargar fichas: ' . $e->getMessage();
            $pageTitle = 'Gestión de Fichas';
            $registros = [];
            $totalFichas = 0;
            $fichasActivas = 0;
            $this->loadView('index', compact('pageTitle', 'registros', 'totalFichas', 'fichasActivas'));
        }
    }
    
    /**
     * Formulario de creación
     */
    public function create() {
        try {
            $pageTitle = 'Nueva Ficha';
            $programas = $this->programaModel->getAll();
            $instructores = $this->instructorModel->getAll();
            $coordinaciones = $this->coordinacionModel->getAll();
            
            $this->loadView('crear', compact('pageTitle', 'programas', 'instructores', 'coordinaciones'));
        } catch (Exception $e) {
            $_SESSION['error'] = 'Error al cargar formulario: ' . $e->getMessage();
            $this->redirect(BASE_PATH . 'ficha');
        }
    }
    
    /**
     * Procesa el registro de una nueva ficha.
     * Realiza validaciones estrictas de formato numérico y coherencia de fechas lectivas.
     */
    public function store() {
        if (!$this->isMethod('POST')) {
            $this->redirect(BASE_PATH . 'ficha/create');
            return;
        }
        
        // Validación básica
        $required = ['fich_numero', 'PROGRAMA_prog_id', 'fich_jornada', 'fich_fecha_ini_lectiva', 'fich_fecha_fin_lectiva'];
        $errors = [];
        
        foreach ($required as $field) {
            if (empty($_POST[$field])) {
                $errors[] = "El campo " . str_replace('_', ' ', $field) . " es requerido";
            }
        }
        
        // Validar que el número de ficha sea numérico
        if (!empty($_POST['fich_numero']) && !is_numeric($_POST['fich_numero'])) {
            $errors[] = 'El número de ficha debe ser numérico';
        }
        
        // Validar fechas
        if (!empty($_POST['fich_fecha_ini_lectiva']) && !empty($_POST['fich_fecha_fin_lectiva'])) {
            if (strtotime($_POST['fich_fecha_ini_lectiva']) > strtotime($_POST['fich_fecha_fin_lectiva'])) {
                $errors[] = 'La fecha fin debe ser posterior a la fecha inicio';
            }
        }
        
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old_input'] = $_POST;
            $this->redirect(BASE_PATH . 'ficha/create');
            return;
        }
        
        try {
            $result = $this->model->create($_POST);
            if ($result) {
                $_SESSION['success'] = 'Ficha creada exitosamente';
                $this->redirect(BASE_PATH . 'ficha');
            } else {
                $_SESSION['error'] = 'No se pudo crear la ficha';
                $_SESSION['old_input'] = $_POST;
                $this->redirect(BASE_PATH . 'ficha/create');
            }
        } catch (Exception $e) {
            $_SESSION['error'] = 'Error al crear la ficha: ' . $e->getMessage();
            $_SESSION['old_input'] = $_POST;
            $this->redirect(BASE_PATH . 'ficha/create');
        }
    }
    
    /**
     * Ver detalle de ficha
     */
    public function show($id) {
        try {
            $registro = $this->model->getById($id);
            
            if (!$registro) {
                $_SESSION['error'] = 'Ficha no encontrada';
                $this->redirect(BASE_PATH . 'ficha');
                return;
            }
            
            $pageTitle = 'Ver Ficha #' . ($registro['fich_numero'] ?? $id);
            $this->loadView('ver', compact('pageTitle', 'registro'));
        } catch (Exception $e) {
            $_SESSION['error'] = 'Error al cargar ficha: ' . $e->getMessage();
            $this->redirect(BASE_PATH . 'ficha');
        }
    }
    
    /**
     * Formulario de edición
     */
    public function edit($id) {
        try {
            $registro = $this->model->getById($id);
            
            if (!$registro) {
                $_SESSION['error'] = 'Ficha no encontrada';
                $this->redirect(BASE_PATH . 'ficha');
                return;
            }
            
            $pageTitle = 'Editar Ficha #' . ($registro['fich_numero'] ?? $id);
            $programas = $this->programaModel->getAll();
            $instructores = $this->instructorModel->getAll();
            $coordinaciones = $this->coordinacionModel->getAll();
            
            $this->loadView('editar', compact('pageTitle', 'registro', 'programas', 'instructores', 'coordinaciones'));
        } catch (Exception $e) {
            $_SESSION['error'] = 'Error al cargar ficha: ' . $e->getMessage();
            $this->redirect(BASE_PATH . 'ficha');
        }
    }
    
    /**
     * Actualizar ficha
     */
    public function update($id) {
        if (!$this->isMethod('POST')) {
            $this->redirect(BASE_PATH . "ficha/edit/{$id}");
            return;
        }
        
        // Validación básica
        $required = ['fich_numero', 'PROGRAMA_prog_id', 'fich_jornada', 'fich_fecha_ini_lectiva', 'fich_fecha_fin_lectiva'];
        $errors = [];
        
        foreach ($required as $field) {
            if (empty($_POST[$field])) {
                $errors[] = "El campo " . str_replace('_', ' ', $field) . " es requerido";
            }
        }
        
        // Validar que el número de ficha sea numérico
        if (!empty($_POST['fich_numero']) && !is_numeric($_POST['fich_numero'])) {
            $errors[] = 'El número de ficha debe ser numérico';
        }
        
        // Validar fechas
        if (!empty($_POST['fich_fecha_ini_lectiva']) && !empty($_POST['fich_fecha_fin_lectiva'])) {
            if (strtotime($_POST['fich_fecha_ini_lectiva']) > strtotime($_POST['fich_fecha_fin_lectiva'])) {
                $errors[] = 'La fecha fin debe ser posterior a la fecha inicio';
            }
        }
        
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old_input'] = $_POST;
            $this->redirect(BASE_PATH . "ficha/edit/{$id}");
            return;
        }
        
        try {
            $result = $this->model->update($id, $_POST);
            if ($result) {
                $_SESSION['success'] = 'Ficha actualizada exitosamente';
                $this->redirect(BASE_PATH . 'ficha');
            } else {
                $_SESSION['error'] = 'No se pudo actualizar la ficha';
                $_SESSION['old_input'] = $_POST;
                $this->redirect(BASE_PATH . "ficha/edit/{$id}");
            }
        } catch (Exception $e) {
            $_SESSION['error'] = 'Error al actualizar la ficha: ' . $e->getMessage();
            $_SESSION['old_input'] = $_POST;
            $this->redirect(BASE_PATH . "ficha/edit/{$id}");
        }
    }
    
    /**
     * Eliminar ficha
     */
    public function delete($id) {
        try {
            $this->model->delete($id);
            $_SESSION['success'] = 'Ficha eliminada exitosamente';
        } catch (Exception $e) {
            $_SESSION['error'] = 'Error al eliminar la ficha: ' . $e->getMessage();
        }
        
        $this->redirect(BASE_PATH . 'ficha');
    }
    
    /**
     * Método auxiliar para el renderizado de vistas dentro del layout estándar.
     * @param string $view Nombre del archivo de vista.
     * @param array $data Datos compactados para la vista.
     */
    private function loadView($view, $data = []) {
        extract($data);
        include __DIR__ . '/../views/layout/header.php';
        include __DIR__ . '/../views/layout/sidebar.php';
        include __DIR__ . "/../views/{$this->viewPath}/{$view}.php";
        include __DIR__ . '/../views/layout/footer.php';
    }
}
?>
