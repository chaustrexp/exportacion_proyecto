<?php
/**
 * ============================================================
 * InstructorController.php
 * ============================================================
 * Controlador para la gestión CRUD de Instructores del sistema.
 * Solo accesible por los roles Administrador y Coordinador.
 *
 * Rutas atendidas (definidas en routing.php):
 *   GET  instructor/index    → Listado de instructores
 *   GET  instructor/crear    → Formulario de creación
 *   POST instructor/crear    → Guardar nuevo instructor
 *   GET  instructor/ver      → Detalle de un instructor
 *   GET  instructor/editar   → Formulario de edición
 *   POST instructor/editar   → Guardar cambios
 *   GET  instructor/eliminar → Eliminar instructor
 *
 * @package Controllers
 */

require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../model/InstructorModel.php';
require_once __DIR__ . '/../model/CentroFormacionModel.php';

/**
 * Class InstructorController
 *
 * Gestiona el ciclo de vida completo de los instructores:
 * listado, creación, visualización, edición y eliminación.
 * Extiende BaseController para aprovechar render(), redirect(),
 * validate() y demás utilidades comunes.
 */
class InstructorController extends BaseController {

    /** @var CentroFormacionModel Modelo para obtener centros de formación en formularios */
    private $centroModel;

    /**
     * Constructor: inicializa modelos y define la subcarpeta de vistas.
     */
    public function __construct() {
        parent::__construct(); // Ejecuta check_auth.php → protege todas las acciones
        $this->model       = new InstructorModel();
        $this->centroModel = new CentroFormacionModel();
        $this->viewPath    = 'instructor'; // Vistas en views/instructor/
    }

    // ──────────────────────────────────────────────────────────
    //  LISTADO
    // ──────────────────────────────────────────────────────────

    /**
     * Muestra el listado completo de instructores.
     * Solo accesible por Administrador y Coordinador.
     */
    public function index() {
        verificarRol(['Administrador', 'Coordinador']); // Restringir acceso por rol
        $registros = $this->model->getAll(); // Obtener todos los instructores con su centro

        $data = [
            'pageTitle'         => 'Gestión de Instructores',
            'registros'         => $registros,
            'totalInstructores' => count($registros),
            'mensaje'           => $this->getFlashMessage() // Mensaje de operación anterior
        ];

        $this->render('index', $data);
    }

    // ──────────────────────────────────────────────────────────
    //  CREAR
    // ──────────────────────────────────────────────────────────

    /**
     * Muestra el formulario de creación o procesa el envío (POST).
     * En GET renderiza el formulario con la lista de centros disponibles.
     * En POST delega a store().
     */
    public function crear() {
        if ($this->isMethod('POST')) {
            return $this->store(); // Si es POST, procesar guardado
        }

        // GET: mostrar formulario vacío con centros de formación
        $data = [
            'pageTitle' => 'Nuevo Instructor',
            'centros'   => $this->centroModel->getAll()
        ];

        $this->render('crear', $data);
    }

    /**
     * Valida y guarda un nuevo instructor en la base de datos.
     * Redirige con mensaje de éxito o error según el resultado.
     */
    public function store() {
        // Validar campos obligatorios del formulario
        $errors = $this->validate($_POST, [
            'inst_nombres',
            'inst_apellidos',
            'inst_correo',
            'centro_formacion_cent_id'
        ]);

        if (!empty($errors)) {
            // Guardar errores y datos anteriores en sesión para repoblar el formulario
            $_SESSION['errors']    = $errors;
            $_SESSION['old_input'] = $_POST;
            $this->redirect(BASE_PATH . 'instructor/crear');
        }

        try {
            $this->model->create($_POST);
            $_SESSION['success'] = 'Instructor creado exitosamente';
            $this->redirect(BASE_PATH . 'instructor');
        } catch (Exception $e) {
            $_SESSION['error']     = 'Error al crear el instructor: ' . $e->getMessage();
            $_SESSION['old_input'] = $_POST;
            $this->redirect(BASE_PATH . 'instructor/crear');
        }
    }

    // ──────────────────────────────────────────────────────────
    //  VER
    // ──────────────────────────────────────────────────────────

    /**
     * Muestra el detalle de un instructor específico.
     *
     * @uses $_GET['id'] ID del instructor a consultar.
     */
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
            'registro'  => $registro
        ];

        $this->render('ver', $data);
    }

    // ──────────────────────────────────────────────────────────
    //  EDITAR
    // ──────────────────────────────────────────────────────────

    /**
     * Muestra el formulario de edición (GET) o procesa los cambios (POST).
     *
     * @uses $_GET['id'] ID del instructor a editar.
     */
    public function editar() {
        $id = $this->get('id', 0);

        if (!$id) {
            $_SESSION['error'] = 'ID no válido';
            $this->redirect(BASE_PATH . 'instructor');
        }

        if ($this->isMethod('POST')) {
            $this->update($id); // Procesar actualización
            return;
        }

        // GET: cargar datos actuales del instructor y lista de centros
        $registro = $this->model->getById($id);

        if (!$registro) {
            $_SESSION['error'] = 'Instructor no encontrado';
            $this->redirect(BASE_PATH . 'instructor');
        }

        $data = [
            'pageTitle' => 'Editar Instructor',
            'registro'  => $registro,
            'centros'   => $this->centroModel->getAll()
        ];

        $this->render('editar', $data);
    }

    /**
     * Valida y actualiza los datos de un instructor existente.
     *
     * @param int $id ID del instructor a actualizar.
     */
    public function update($id) {
        $errors = $this->validate($_POST, [
            'inst_nombres',
            'inst_apellidos',
            'inst_correo',
            'centro_formacion_cent_id'
        ]);

        if (!empty($errors)) {
            $_SESSION['errors']    = $errors;
            $_SESSION['old_input'] = $_POST;
            $this->redirect(BASE_PATH . "instructor/editar?id={$id}");
        }

        try {
            $this->model->update($id, $_POST);
            $_SESSION['success'] = 'Instructor actualizado exitosamente';
            $this->redirect(BASE_PATH . 'instructor');
        } catch (Exception $e) {
            $_SESSION['error']     = 'Error al actualizar el instructor: ' . $e->getMessage();
            $_SESSION['old_input'] = $_POST;
            $this->redirect(BASE_PATH . "instructor/editar?id={$id}");
        }
    }

    // ──────────────────────────────────────────────────────────
    //  ELIMINAR
    // ──────────────────────────────────────────────────────────

    /**
     * Elimina un instructor de la base de datos previa confirmación en el frontend.
     *
     * @uses $_GET['id'] ID del instructor a eliminar.
     */
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
            // Puede fallar si el instructor tiene fichas u otras relaciones activas
            $_SESSION['error'] = 'Error al eliminar el instructor: ' . $e->getMessage();
        }

        $this->redirect(BASE_PATH . 'instructor');
    }
}
?>

    
    public function index() {
        verificarRol(['Administrador', 'Coordinador']);
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
