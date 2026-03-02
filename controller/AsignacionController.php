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
     * Muestra el listado principal de asignaciones.
     * Carga datos de todas las entidades relacionadas para los filtros y el calendario.
     * Realiza cálculos de estadísticas en tiempo real (activas vs totales).
     */
    public function index() {
        verificarRol(['Administrador', 'Coordinador']);
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
        verificarRol(['Administrador', 'Coordinador']);
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
     * Procesa y persiste una nueva asignación.
     * Aplica validaciones CU-01 (instructor activo y sin cruce), CU-02 (competencia pendiente),
     * CU-03 (ambiente disponible) antes de guardar.
     */
    public function store() {
        verificarRol(['Administrador', 'Coordinador']);
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

        // Construir DATETIME para validaciones
        $fecha_ini_dt = ($_POST['fecha_inicio'] ?? date('Y-m-d')) . ' ' . ($_POST['hora_inicio'] ?? '06:00') . ':00';
        $fecha_fin_dt = ($_POST['fecha_fin']    ?? date('Y-m-d')) . ' ' . ($_POST['hora_fin']    ?? '22:00') . ':00';
        $inst_id      = $_POST['instructor_inst_id'] ?? $_POST['instructor_id'] ?? null;

        // ── CU-01: Verificar que el instructor esté Activo ─────────────────────
        if ($inst_id) {
            $estadoInst = $this->instructorModel->getEstado($inst_id);
            if ($estadoInst && ($estadoInst['inst_estado'] ?? '') !== 'Activo') {
                $_SESSION['error'] = 'CU-01: El instructor seleccionado está Inactivo y no puede recibir nuevas asignaciones.';
                $_SESSION['old_input'] = $_POST;
                $this->redirect(BASE_PATH . 'asignacion/crear');
                return;
            }

            // ── CU-01: Verificar cruces de horario ─────────────────────────────
            $cruces = $this->instructorModel->checkCruceHorario($inst_id, $fecha_ini_dt, $fecha_fin_dt);
            if (!empty($cruces)) {
                $detalle = $cruces[0];
                $_SESSION['error'] = 'CU-01: El instructor ya tiene una asignación en ese horario '
                    . '(Ficha ' . ($detalle['ficha_numero'] ?? '?') . ', '
                    . ($detalle['fecha_inicio'] ?? '') . ' ' . ($detalle['hora_inicio'] ?? '') . ' – '
                    . ($detalle['hora_fin'] ?? '') . '). Seleccione otro horario.';
                $_SESSION['old_input'] = $_POST;
                $this->redirect(BASE_PATH . 'asignacion/crear');
                return;
            }
        }

        // ── CU-02: Verificar que la competencia sea pendiente para la ficha ───
        $ficha_id      = $_POST['ficha_id'] ?? $_POST['ficha_fich_id'] ?? null;
        $competencia_id = $_POST['competencia_id'] ?? $_POST['competencia_comp_id'] ?? null;
        if ($ficha_id && $competencia_id) {
            $pendientes = $this->fichaModel->getCompetenciasPendientes($ficha_id);
            $idsPendientes = array_column($pendientes, 'comp_id');
            if (!empty($pendientes) && !in_array($competencia_id, $idsPendientes)) {
                $_SESSION['warning'] = 'CU-02: La competencia seleccionada ya tiene una asignación activa o futura para esta ficha.';
            }
        }

        // ── CU-03: Verificar disponibilidad del ambiente ───────────────────────
        $amb_id = $_POST['ambiente_id'] ?? $_POST['ambiente_amb_id'] ?? null;
        if ($amb_id) {
            $conflictos = $this->ambienteModel->checkDisponibilidad($amb_id, $fecha_ini_dt, $fecha_fin_dt);
            if (!empty($conflictos)) {
                $det = $conflictos[0];
                $_SESSION['error'] = 'CU-03: El ambiente ya está reservado en esa franja '
                    . '(Ficha ' . ($det['ficha_numero'] ?? '?') . ', '
                    . ($det['hora_inicio'] ?? '') . ' – ' . ($det['hora_fin'] ?? '') . '). '
                    . 'Elija otro ambiente u horario.';
                $_SESSION['old_input'] = $_POST;
                $this->redirect(BASE_PATH . 'asignacion/crear');
                return;
            }
        }

        try {
            $this->model->create($_POST);
            
            $redirectUrl = BASE_PATH . 'asignacion?msg=creado';
            if ($this->post('redirect_to')) {
                $redirectUrl .= '&tab=' . $this->post('redirect_to');
            }
            
            $this->redirect($redirectUrl);
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
        verificarRol(['Administrador', 'Coordinador']);
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
     * Actualizar asignación — aplica mismas validaciones CU-01/02/03 que store()
     */
    public function update($id) {
        verificarRol(['Administrador', 'Coordinador']);
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

        $fecha_ini_dt = ($_POST['fecha_inicio'] ?? date('Y-m-d')) . ' ' . ($_POST['hora_inicio'] ?? '06:00') . ':00';
        $fecha_fin_dt = ($_POST['fecha_fin']    ?? date('Y-m-d')) . ' ' . ($_POST['hora_fin']    ?? '22:00') . ':00';
        $inst_id      = $_POST['instructor_inst_id'] ?? $_POST['instructor_id'] ?? null;

        // CU-01: instructor activo
        if ($inst_id) {
            $estadoInst = $this->instructorModel->getEstado($inst_id);
            if ($estadoInst && ($estadoInst['inst_estado'] ?? '') !== 'Activo') {
                $_SESSION['error'] = 'CU-01: El instructor está Inactivo y no puede ser asignado.';
                $_SESSION['old_input'] = $_POST;
                $this->redirect(BASE_PATH . "asignacion/editar?id={$id}");
                return;
            }
            // CU-01: cruce de horario (excluir la asignación actual)
            $cruces = $this->instructorModel->checkCruceHorario($inst_id, $fecha_ini_dt, $fecha_fin_dt, $id);
            if (!empty($cruces)) {
                $det = $cruces[0];
                $_SESSION['error'] = 'CU-01: El instructor tiene cruce de horario '
                    . '(Ficha ' . ($det['ficha_numero'] ?? '?') . ', ' . ($det['hora_inicio'] ?? '') . '–' . ($det['hora_fin'] ?? '') . ').';
                $_SESSION['old_input'] = $_POST;
                $this->redirect(BASE_PATH . "asignacion/editar?id={$id}");
                return;
            }
        }

        // CU-02: competencia pendiente
        $ficha_id       = $_POST['ficha_id'] ?? null;
        $competencia_id = $_POST['competencia_id'] ?? null;
        if ($ficha_id && $competencia_id) {
            $pendientes    = $this->fichaModel->getCompetenciasPendientes($ficha_id);
            $idsPendientes = array_column($pendientes, 'comp_id');
            if (!empty($pendientes) && !in_array($competencia_id, $idsPendientes)) {
                $_SESSION['warning'] = 'CU-02: La competencia ya tiene asignación activa para esta ficha.';
            }
        }

        // CU-03: disponibilidad del ambiente
        $amb_id = $_POST['ambiente_id'] ?? null;
        if ($amb_id) {
            $conflictos = $this->ambienteModel->checkDisponibilidad($amb_id, $fecha_ini_dt, $fecha_fin_dt, $id);
            if (!empty($conflictos)) {
                $det = $conflictos[0];
                $_SESSION['error'] = 'CU-03: El ambiente está reservado en esa franja '
                    . '(' . ($det['hora_inicio'] ?? '') . '–' . ($det['hora_fin'] ?? '') . ').';
                $_SESSION['old_input'] = $_POST;
                $this->redirect(BASE_PATH . "asignacion/editar?id={$id}");
                return;
            }
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
        verificarRol(['Administrador', 'Coordinador']);
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
     * Recupera los detalles de una asignación específica mediante AJAX.
     * Formatea fechas y calcula estados con colores para el componente del calendario.
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
        
        // Determinar si filtrar por instructor
        $instructor_id = null;
        $rol = $_SESSION['rol'] ?? $_SESSION['usuario_rol'] ?? '';
        
        if ($rol === 'Instructor') {
            $instructor_id = $_SESSION['id'] ?? $_SESSION['usuario_id'] ?? null;
        }
        
        try {
            $asignaciones = $this->model->getForCalendar($month, $year, $instructor_id);
            $this->json($asignaciones);
        } catch (Exception $e) {
            $this->json(['error' => 'Error al cargar el calendario: ' . $e->getMessage()], 500);
        }
    }

    // ──────────────────────────────────────────────────────────
    //  ENDPOINTS AJAX – Validaciones en tiempo real (CU-01/02/03)
    // ──────────────────────────────────────────────────────────

    /**
     * CU-01 AJAX: Valida si un instructor está activo y sin cruces de horario.
     * Recibe via GET: instructor_id, fecha_inicio, fecha_fin, hora_inicio, hora_fin, excluir_id
     * Devuelve JSON con campos: activo (bool), cruces (array), mensaje (string)
     */
    public function validarInstructor() {
        $inst_id    = $this->get('instructor_id', 0);
        $fecha_ini  = $this->get('fecha_inicio', date('Y-m-d')) . ' ' . $this->get('hora_inicio', '06:00') . ':00';
        $fecha_fin  = $this->get('fecha_fin',    date('Y-m-d')) . ' ' . $this->get('hora_fin',    '22:00') . ':00';
        $excluir_id = (int)$this->get('excluir_id', 0);

        try {
            $instructor = $this->instructorModel->getEstado($inst_id);

            if (!$instructor) {
                $this->json(['ok' => false, 'mensaje' => 'Instructor no encontrado.']);
                return;
            }

            $activo = ($instructor['inst_estado'] ?? '') === 'Activo';

            $cruces = [];
            if ($activo) {
                $cruces = $this->instructorModel->checkCruceHorario($inst_id, $fecha_ini, $fecha_fin, $excluir_id);
            }

            $this->json([
                'ok'       => $activo && empty($cruces),
                'activo'   => $activo,
                'nombre'   => $instructor['inst_nombres'] . ' ' . $instructor['inst_apellidos'],
                'estado'   => $instructor['inst_estado'] ?? 'Desconocido',
                'cruces'   => $cruces,
                'mensaje'  => !$activo
                    ? 'El instructor está ' . ($instructor['inst_estado'] ?? 'Inactivo') . ' y no puede ser asignado.'
                    : (count($cruces) > 0
                        ? 'El instructor tiene ' . count($cruces) . ' cruce(s) de horario.'
                        : 'Instructor disponible.')
            ]);
        } catch (Exception $e) {
            $this->json(['ok' => false, 'mensaje' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    /**
     * CU-02 AJAX: Retorna las competencias pendientes (no asignadas) de una ficha.
     * Recibe via GET: ficha_id
     * Devuelve JSON: array de competencias { comp_id, comp_nombre_corto, comp_norma, ya_asignada }
     */
    public function getCompetenciasPendientes() {
        $ficha_id = (int)$this->get('ficha_id', 0);

        if (!$ficha_id) {
            $this->json(['error' => 'ID de ficha requerido.'], 400);
            return;
        }

        try {
            // Retorna todas con estado para que el frontend pueda marcarlas
            $competencias = $this->fichaModel->getCompetenciasConEstado($ficha_id);
            $this->json(['ok' => true, 'competencias' => $competencias]);
        } catch (Exception $e) {
            $this->json(['error' => 'Error al obtener competencias: ' . $e->getMessage()], 500);
        }
    }

    /**
     * CU-03 AJAX: Verifica disponibilidad de un ambiente en una franja horaria.
     * Recibe via GET: ambiente_id, fecha_inicio, fecha_fin, hora_inicio, hora_fin, excluir_id
     * Devuelve JSON: { ok (bool), conflictos (array), mensaje (string) }
     */
    public function checkAmbiente() {
        $amb_id     = $this->get('ambiente_id', '');
        $fecha_ini  = $this->get('fecha_inicio', date('Y-m-d')) . ' ' . $this->get('hora_inicio', '06:00') . ':00';
        $fecha_fin  = $this->get('fecha_fin',    date('Y-m-d')) . ' ' . $this->get('hora_fin',    '22:00') . ':00';
        $excluir_id = (int)$this->get('excluir_id', 0);

        if (!$amb_id) {
            $this->json(['ok' => false, 'mensaje' => 'ID de ambiente requerido.'], 400);
            return;
        }

        try {
            $conflictos = $this->ambienteModel->checkDisponibilidad($amb_id, $fecha_ini, $fecha_fin, $excluir_id);
            $disponible = empty($conflictos);

            $this->json([
                'ok'         => $disponible,
                'disponible' => $disponible,
                'conflictos' => $conflictos,
                'mensaje'    => $disponible
                    ? 'Ambiente disponible en esa franja.'
                    : 'El ambiente tiene ' . count($conflictos) . ' reserva(s) que se cruzan con la franja seleccionada.'
            ]);
        } catch (Exception $e) {
            $this->json(['ok' => false, 'mensaje' => 'Error: ' . $e->getMessage()], 500);
        }
    }
}
?>

