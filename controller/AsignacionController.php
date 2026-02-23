<?php
require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../model/AsignacionModel.php';
require_once __DIR__ . '/../model/FichaModel.php';
require_once __DIR__ . '/../model/InstructorModel.php';
require_once __DIR__ . '/../model/AmbienteModel.php';
require_once __DIR__ . '/../model/CompetenciaModel.php';

/**
 * Controlador de Asignaciones
 * Maneja todas las operaciones CRUD de asignaciones
 */
class AsignacionController extends BaseController {
    private $fichaModel;
    private $instructorModel;
    private $ambienteModel;
    private $competenciaModel;
    
    public function __construct() {
        parent::__construct();
        $this->model = new AsignacionModel();
        $this->fichaModel = new FichaModel();
        $this->instructorModel = new InstructorModel();
        $this->ambienteModel = new AmbienteModel();
        $this->competenciaModel = new CompetenciaModel();
        $this->viewPath = 'asignacion';
    }
    
    /**
     * Listar todas las asignaciones
     */
    public function index() {
        $registros = $this->model->getAll();
        $fichas = $this->fichaModel->getAll();
        $instructores = $this->instructorModel->getAll();
        $ambientes = $this->ambienteModel->getAll();
        $competencias = $this->competenciaModel->getAll();
        
        // Calcular estadísticas
        $hoy = date('Y-m-d');
        $activas = array_filter($registros, function($r) use ($hoy) {
            $inicio = $r['asig_fecha_inicio'] ?? '';
            $fin = $r['asig_fecha_fin'] ?? '';
            return $inicio <= $hoy && $fin >= $hoy;
        });
        
        $data = [
            'pageTitle' => 'Gestión de Asignaciones',
            'registros' => $registros,
            'fichas' => $fichas,
            'instructores' => $instructores,
            'ambientes' => $ambientes,
            'competencias' => $competencias,
            'totalAsignaciones' => count($registros),
            'asignacionesActivas' => count($activas),
            'mensaje' => $this->getFlashMessage()
        ];
        
        $this->render('index', $data);
    }
    
    /**
     * Mostrar formulario de creación
     */
    public function crear() {
        if ($this->isMethod('POST')) {
            return $this->store();
        }
        
        $data = [
            'pageTitle' => 'Nueva Asignación',
            'fichas' => $this->fichaModel->getAll(),
            'instructores' => $this->instructorModel->getAll(),
            'ambientes' => $this->ambienteModel->getAll(),
            'competencias' => $this->competenciaModel->getAll()
        ];
        
        $this->render('crear', $data);
    }
    
    /**
     * Guardar nueva asignación
     */
    public function store() {
        // Validar datos requeridos
        $errors = $this->validate($_POST, [
            'instructor_id',
            'fecha_inicio',
            'fecha_fin',
            'ficha_id'
        ]);
        
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old_input'] = $_POST;
            $this->redirect(BASE_PATH . 'asignacion/crear');
        }
        
        try {
            $this->model->create($_POST);
            $this->redirect(BASE_PATH . 'asignacion?msg=creado');
        } catch (Exception $e) {
            $_SESSION['error'] = 'Error al crear la asignación: ' . $e->getMessage();
            $_SESSION['old_input'] = $_POST;
            $this->redirect(BASE_PATH . 'asignacion/crear');
        }
    }
    
    /**
     * Ver detalle de una asignación
     */
    public function ver() {
        $id = $this->get('id', 0);
        
        if (!$id) {
            $this->redirect(BASE_PATH . 'asignacion');
        }
        
        $registro = $this->model->getById($id);
        
        if (!$registro) {
            $this->redirect(BASE_PATH . 'asignacion?msg=no_encontrado');
        }
        
        $data = [
            'pageTitle' => 'Ver Asignación',
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
            $this->redirect(BASE_PATH . 'asignacion');
        }
        
        if ($this->isMethod('POST')) {
            return $this->update($id);
        }
        
        $registro = $this->model->getById($id);
        
        if (!$registro) {
            $this->redirect(BASE_PATH . 'asignacion?msg=no_encontrado');
        }
        
        $data = [
            'pageTitle' => 'Editar Asignación',
            'registro' => $registro,
            'fichas' => $this->fichaModel->getAll(),
            'instructores' => $this->instructorModel->getAll(),
            'ambientes' => $this->ambienteModel->getAll(),
            'competencias' => $this->competenciaModel->getAll()
        ];
        
        $this->render('editar', $data);
    }
    
    /**
     * Actualizar asignación
     */
    public function update($id) {
        // Validar datos requeridos
        $errors = $this->validate($_POST, [
            'instructor_id',
            'fecha_inicio',
            'fecha_fin',
            'ficha_id'
        ]);
        
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old_input'] = $_POST;
            $this->redirect(BASE_PATH . "asignacion/editar/{$id}");
        }
        
        try {
            $this->model->update($id, $_POST);
            $this->redirect(BASE_PATH . 'asignacion?msg=actualizado');
        } catch (Exception $e) {
            $_SESSION['error'] = 'Error al actualizar la asignación: ' . $e->getMessage();
            $_SESSION['old_input'] = $_POST;
            $this->redirect(BASE_PATH . "asignacion/editar/{$id}");
        }
    }
    
    /**
     * Eliminar asignación
     */
    public function eliminar() {
        $id = $this->get('id', 0);
        
        if (!$id) {
            $this->redirect(BASE_PATH . 'asignacion');
        }
        
        try {
            $this->model->delete($id);
            $this->redirect(BASE_PATH . 'asignacion?msg=eliminado');
        } catch (Exception $e) {
            $_SESSION['error'] = 'Error al eliminar la asignación: ' . $e->getMessage();
            $this->redirect(BASE_PATH . 'asignacion');
        }
    }
    
    /**
     * Obtener datos del formulario (AJAX)
     */
    public function getFormData() {
        try {
            $data = [
                'fichas' => array_map(function($f) {
                    return [
                        'id' => $f['fich_id'] ?? $f['id'],
                        'numero' => $f['fich_id'] ?? $f['numero'] ?? 'N/A'
                    ];
                }, $this->fichaModel->getAll()),
                'instructores' => array_map(function($i) {
                    return [
                        'id' => $i['inst_id'] ?? $i['id'],
                        'nombre' => ($i['inst_nombres'] ?? '') . ' ' . ($i['inst_apellidos'] ?? '')
                    ];
                }, $this->instructorModel->getAll()),
                'ambientes' => array_map(function($a) {
                    return [
                        'id' => $a['amb_id'] ?? $a['id'],
                        'nombre' => $a['amb_nombre'] ?? $a['nombre'] ?? 'N/A'
                    ];
                }, $this->ambienteModel->getAll()),
                'competencias' => array_map(function($c) {
                    return [
                        'id' => $c['comp_id'] ?? $c['id'],
                        'nombre' => $c['comp_nombre_corto'] ?? $c['nombre'] ?? 'N/A'
                    ];
                }, $this->competenciaModel->getAll())
            ];
            
            $this->json($data);
        } catch (Exception $e) {
            $this->json(['error' => 'Error al cargar los datos: ' . $e->getMessage()], 500);
        }
    }
    
    /**
     * Obtener detalle de asignación (AJAX)
     */
    public function getAsignacion() {
        $id = $this->get('id', 0);
        
        if (!$id) {
            $this->json(['error' => 'ID no proporcionado'], 400);
        }
        
        try {
            $asignacion = $this->model->getById($id);
            
            if (!$asignacion || empty($asignacion)) {
                $this->json(['error' => 'Asignación no encontrada'], 404);
            }
            
            // Formatear datos para el frontend
            $response = [
                'id' => $asignacion['asig_id'] ?? $asignacion['ASIG_ID'] ?? $id,
                'ficha_numero' => $asignacion['ficha_numero'] ?? 'N/A',
                'instructor_nombre' => $asignacion['instructor_nombre'] ?? 'N/A',
                'ambiente_nombre' => $asignacion['ambiente_nombre'] ?? 'No disponible',
                'competencia_nombre' => $asignacion['competencia_nombre'] ?? 'No disponible',
                'fecha_inicio' => $asignacion['fecha_inicio'] ?? $asignacion['asig_fecha_inicio'] ?? date('Y-m-d'),
                'fecha_fin' => $asignacion['fecha_fin'] ?? $asignacion['asig_fecha_fin'] ?? date('Y-m-d'),
            ];
            
            // Formatear fechas
            $response['fecha_inicio_formatted'] = date('d/m/Y', strtotime($response['fecha_inicio']));
            $response['fecha_fin_formatted'] = date('d/m/Y', strtotime($response['fecha_fin']));
            
            // Extraer horas
            $fecha_ini_completa = $asignacion['asig_fecha_ini'] ?? $asignacion['ASIG_FECHA_INI'] ?? date('Y-m-d H:i:s');
            $fecha_fin_completa = $asignacion['asig_fecha_fin'] ?? $asignacion['ASIG_FECHA_FIN'] ?? date('Y-m-d H:i:s');
            
            $response['hora_inicio'] = date('H:i', strtotime($fecha_ini_completa));
            $response['hora_fin'] = date('H:i', strtotime($fecha_fin_completa));
            
            // Calcular estado
            $hoy = date('Y-m-d');
            if ($response['fecha_fin'] < $hoy) {
                $response['estado'] = 'Finalizada';
                $response['estado_color'] = '#DC2626';
                $response['estado_bg'] = '#FEE2E2';
            } elseif ($response['fecha_inicio'] > $hoy) {
                $response['estado'] = 'Pendiente';
                $response['estado_color'] = '#D97706';
                $response['estado_bg'] = '#FEF3C7';
            } else {
                $response['estado'] = 'Activa';
                $response['estado_color'] = '#39A900';
                $response['estado_bg'] = '#E8F5E8';
            }
            
            $this->json($response);
        } catch (Exception $e) {
            $this->json(['error' => 'Error al cargar la asignación: ' . $e->getMessage()], 500);
        }
    }
    
    /**
     * Obtener asignaciones para el calendario
     */
    public function getCalendar() {
        $month = $this->get('month', date('m'));
        $year = $this->get('year', date('Y'));
        
        try {
            $asignaciones = $this->model->getForCalendar($month, $year);
            $this->json($asignaciones);
        } catch (Exception $e) {
            $this->json(['error' => 'Error al cargar el calendario: ' . $e->getMessage()], 500);
        }
    }
}
?>
