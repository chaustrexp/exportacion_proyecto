<?php
/**
 * Sistema de Routing Centralizado
 * Maneja todas las rutas y redirige a los controladores correspondientes
 */

// Cargar configuración
require_once __DIR__ . '/config/config.php';

// Proteger con autenticación
require_once __DIR__ . '/auth/check_auth.php';

// Obtener la ruta solicitada
$request = $_SERVER['REQUEST_URI'];
$basePath = BASE_PATH;

// Limpiar la ruta
$route = str_replace($basePath, '', $request);
$route = strtok($route, '?'); // Remover query string
$route = trim($route, '/');

// Si la ruta está vacía o es 'index.php', redirigir según el rol
if (empty($route) || $route === 'index.php') {
    // Redirigir según el rol del usuario
    if ($_SESSION['usuario_rol'] === 'Instructor') {
        $route = 'instructor_dashboard';
    } else {
        $route = 'dashboard';
    }
}

// Parsear la ruta
$parts = explode('/', $route);
$module = $parts[0] ?? 'dashboard';
$action = $parts[1] ?? 'index';
$id = $parts[2] ?? null;

// Limpiar .php del módulo si existe
if (str_ends_with($module, '.php')) {
    $module = str_replace('.php', '', $module);
}

// Limpiar .php de la acción si existe (crear.php, editar.php, index.php, etc.)
if (str_ends_with($action, '.php')) {
    $action = str_replace('.php', '', $action);
}

// Si solo viene el módulo sin acción, redirigir a módulo/index
if (empty($parts[1]) && !empty($module) && $module !== 'dashboard') {
    header("Location: {$basePath}{$module}/index");
    exit;
}

// Si es dashboard sin acción, redirigir a dashboard/index
if ($module === 'dashboard' && empty($parts[1])) {
    header("Location: {$basePath}dashboard/index");
    exit;
}

// Manejar acciones POST especiales
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Si viene de un formulario de crear, la acción es store
    if ($action === 'create' || (isset($_POST['_action']) && $_POST['_action'] === 'store')) {
        $action = 'store';
        $id = null;
    }
    // Si viene de un formulario de editar, la acción es update
    elseif ($action === 'edit' || (isset($_POST['_action']) && $_POST['_action'] === 'update')) {
        $action = 'update';
        // El ID viene en la URL o en el POST
        $id = $id ?? ($_POST['id'] ?? null);
    }
}

// Mapeo de rutas a controladores
$routes = [
    'dashboard' => [
        'controller' => 'DashboardController',
        'file' => 'controller/DashboardController.php',
        'actions' => ['index'],
        'default_action' => 'index' // Siempre redirigir a index
    ],
    'instructor_dashboard' => [
        'controller' => 'InstructorDashboardController',
        'file' => 'controller/InstructorDashboardController.php',
        'actions' => ['index', 'misFichas', 'misAsignaciones'],
        'default_action' => 'index'
    ],
    'asignacion' => [
        'controller' => 'AsignacionController',
        'file' => 'controller/AsignacionController.php',
        'actions' => ['index', 'crear', 'store', 'ver', 'editar', 'update', 'eliminar'],
        'action_map' => [
            'create' => 'crear',
            'show' => 'ver',
            'edit' => 'editar',
            'delete' => 'eliminar'
        ]
    ],
    'ficha' => [
        'controller' => 'FichaController',
        'file' => 'controller/FichaController.php',
        'actions' => ['index', 'create', 'store', 'show', 'edit', 'update', 'delete']
    ],
    'instructor' => [
        'controller' => 'InstructorController',
        'file' => 'controller/InstructorController.php',
        'actions' => ['index', 'crear', 'store', 'ver', 'editar', 'update', 'eliminar'],
        'action_map' => [
            'create' => 'crear',
            'show' => 'ver',
            'edit' => 'editar',
            'delete' => 'eliminar'
        ]
    ],
    'ambiente' => [
        'controller' => 'AmbienteController',
        'file' => 'controller/AmbienteController.php',
        'actions' => ['index', 'crear', 'store', 'ver', 'editar', 'update', 'eliminar'],
        'action_map' => [
            'create' => 'crear',
            'show' => 'ver',
            'edit' => 'editar',
            'delete' => 'eliminar'
        ]
    ],
    'programa' => [
        'controller' => 'ProgramaController',
        'file' => 'controller/ProgramaController.php',
        'actions' => ['index', 'create', 'store', 'show', 'edit', 'update', 'delete']
    ],
    'competencia' => [
        'controller' => 'CompetenciaController',
        'file' => 'controller/CompetenciaController.php',
        'actions' => ['index', 'crear', 'store', 'ver', 'editar', 'update', 'eliminar'],
        'action_map' => [
            'create' => 'crear',
            'show' => 'ver',
            'edit' => 'editar',
            'delete' => 'eliminar'
        ]
    ],
    'competencia_programa' => [
        'controller' => 'CompetenciaProgramaController',
        'file' => 'controller/CompetenciaProgramaController.php',
        'actions' => ['index', 'crear', 'store', 'eliminar'],
        'action_map' => [
            'create' => 'crear',
            'delete' => 'eliminar'
        ]
    ],
    'titulo_programa' => [
        'controller' => 'TituloProgramaController',
        'file' => 'controller/TituloProgramaController.php',
        'actions' => ['index', 'crear', 'store', 'ver', 'editar', 'update', 'eliminar'],
        'action_map' => [
            'create' => 'crear',
            'show' => 'ver',
            'edit' => 'editar',
            'delete' => 'eliminar'
        ]
    ],
    'instru_competencia' => [
        'controller' => 'InstruCompetenciaController',
        'file' => 'controller/InstruCompetenciaController.php',
        'actions' => ['index', 'crear', 'store', 'ver', 'editar', 'update', 'eliminar'],
        'action_map' => [
            'create' => 'crear',
            'show' => 'ver',
            'edit' => 'editar',
            'delete' => 'eliminar'
        ]
    ],
    'detalle_asignacion' => [
        'controller' => 'DetalleAsignacionController',
        'file' => 'controller/DetalleAsignacionController.php',
        'actions' => ['index', 'crear', 'store', 'ver', 'editar', 'update', 'eliminar'],
        'action_map' => [
            'create' => 'crear',
            'show' => 'ver',
            'edit' => 'editar',
            'delete' => 'eliminar'
        ]
    ],
    'centro_formacion' => [
        'controller' => 'CentroFormacionController',
        'file' => 'controller/CentroFormacionController.php',
        'actions' => ['index', 'crear', 'store', 'ver', 'editar', 'update', 'eliminar'],
        'action_map' => [
            'create' => 'crear',
            'show' => 'ver',
            'edit' => 'editar',
            'delete' => 'eliminar'
        ]
    ],
    'coordinacion' => [
        'controller' => 'CoordinacionController',
        'file' => 'controller/CoordinacionController.php',
        'actions' => ['index', 'crear', 'store', 'ver', 'editar', 'update', 'eliminar'],
        'action_map' => [
            'create' => 'crear',
            'show' => 'ver',
            'edit' => 'editar',
            'delete' => 'eliminar'
        ]
    ],
    'sede' => [
        'controller' => 'SedeController',
        'file' => 'controller/SedeController.php',
        'actions' => ['index', 'crear', 'store', 'ver', 'editar', 'update', 'eliminar'],
        'action_map' => [
            'create' => 'crear',
            'show' => 'ver',
            'edit' => 'editar',
            'delete' => 'eliminar'
        ]
    ]
];

// Verificar si el módulo existe
if (!isset($routes[$module])) {
    http_response_code(404);
    die("Módulo no encontrado: $module");
}

$routeConfig = $routes[$module];

// Mapear acción si existe un mapeo (inglés -> español)
if (isset($routeConfig['action_map'][$action])) {
    $action = $routeConfig['action_map'][$action];
}

// Si el módulo tiene una acción por defecto y la acción solicitada no es válida, usar la por defecto
if (isset($routeConfig['default_action']) && !in_array($action, $routeConfig['actions'])) {
    $action = $routeConfig['default_action'];
    $id = null;
}

// Verificar si la acción es válida
if (!in_array($action, $routeConfig['actions'])) {
    http_response_code(404);
    die("Acción no encontrada: $action en módulo $module");
}

// Cargar el controlador
$controllerFile = __DIR__ . '/' . $routeConfig['file'];
if (!file_exists($controllerFile)) {
    http_response_code(500);
    die("Archivo del controlador no encontrado: {$routeConfig['file']}");
}

require_once $controllerFile;

$controllerClass = $routeConfig['controller'];
if (!class_exists($controllerClass)) {
    http_response_code(500);
    die("Clase del controlador no encontrada: $controllerClass");
}

// Instanciar el controlador
$controller = new $controllerClass();

// Verificar que el método existe
if (!method_exists($controller, $action)) {
    http_response_code(500);
    die("Método no encontrado en el controlador: $action");
}

// Ejecutar la acción
try {
    if ($id !== null) {
        // Acción con ID (show, edit, update, delete)
        $controller->$action($id);
    } else {
        // Acción sin ID (index, create, store)
        $controller->$action();
    }
} catch (Exception $e) {
    http_response_code(500);
    error_log("Error en routing: " . $e->getMessage());
    
    // Mostrar página de error
    $pageTitle = "Error del Sistema";
    include __DIR__ . '/views/layout/header.php';
    include __DIR__ . '/views/layout/sidebar.php';
    ?>
    <div class="main-content">
        <div style="max-width: 600px; margin: 100px auto; text-align: center;">
            <div style="font-size: 72px; margin-bottom: 24px;">⚠️</div>
            <h1 style="font-size: 32px; color: #1f2937; margin-bottom: 16px;">Error del Sistema</h1>
            <p style="font-size: 16px; color: #6b7280; margin-bottom: 32px;">
                Ha ocurrido un error al procesar tu solicitud.
            </p>
            <div style="background: #fee2e2; border-left: 4px solid #ef4444; padding: 16px; text-align: left; margin-bottom: 24px;">
                <strong style="color: #991b1b;">Detalles del error:</strong>
                <p style="color: #dc2626; margin: 8px 0 0; font-family: monospace; font-size: 14px;">
                    <?php echo htmlspecialchars($e->getMessage()); ?>
                </p>
            </div>
            <a href="<?php echo BASE_PATH; ?>" class="btn btn-primary">Volver al Dashboard</a>
        </div>
    </div>
    <?php
    include __DIR__ . '/views/layout/footer.php';
}
?>
