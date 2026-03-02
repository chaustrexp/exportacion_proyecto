# Sistema de Controladores - Dashboard SENA

## Descripción
Sistema de controladores implementado siguiendo el patrón MVC (Modelo-Vista-Controlador) para separar la lógica de negocio de la presentación.

## Estructura

```
dashboard_sena/
├── controller/
│   ├── BaseController.php           # Controlador base (heredado por todos)
│   ├── DashboardController.php      # Dashboard principal
│   ├── AsignacionController.php     # Gestión de asignaciones
│   ├── FichaController.php          # Gestión de fichas
│   ├── InstructorController.php     # Gestión de instructores
│   ├── AmbienteController.php       # Gestión de ambientes
│   ├── ProgramaController.php       # Gestión de programas
│   ├── CompetenciaController.php    # Gestión de competencias
│   └── README_CONTROLADORES.md      # Esta documentación
├── model/                           # Modelos de datos
├── views/                           # Vistas (HTML/PHP)
└── helpers/                         # Funciones auxiliares
```

## BaseController

Clase base que proporciona funcionalidad común a todos los controladores:

### Métodos Disponibles

#### `render($view, $data = [])`
Renderiza una vista con datos.
```php
$this->render('index', ['registros' => $registros]);
```

#### `redirect($url, $message = null)`
Redirige a una URL con mensaje opcional.
```php
$this->redirect('index.php?msg=creado');
```

#### `json($data, $statusCode = 200)`
Devuelve respuesta JSON.
```php
$this->json(['success' => true, 'data' => $data]);
```

#### `validate($data, $required)`
Valida campos requeridos.
```php
$errors = $this->validate($_POST, ['nombre', 'correo']);
```

#### `getFlashMessage()`
Obtiene y elimina mensaje flash de sesión.
```php
$mensaje = $this->getFlashMessage();
```

#### `isMethod($method)`
Verifica el método HTTP.
```php
if ($this->isMethod('POST')) { ... }
```

#### `post($key, $default = null)`
Obtiene dato POST de forma segura.
```php
$nombre = $this->post('nombre', 'Sin nombre');
```

#### `get($key, $default = null)`
Obtiene dato GET de forma segura.
```php
$id = $this->get('id', 0);
```

## Controladores Implementados

### 1. DashboardController
Gestiona el dashboard principal con estadísticas y calendario.

**Métodos:**
- `index()` - Muestra el dashboard con estadísticas

### 2. AsignacionController
Gestiona las asignaciones de instructores, fichas y ambientes.

**Métodos:**
- `index()` - Lista todas las asignaciones
- `crear()` - Muestra formulario de creación
- `store()` - Guarda nueva asignación
- `ver()` - Muestra detalle de asignación
- `editar()` - Muestra formulario de edición
- `update($id)` - Actualiza asignación
- `eliminar()` - Elimina asignación
- `getFormData()` - Obtiene datos para formularios (AJAX)
- `getAsignacion()` - Obtiene detalle de asignación (AJAX)
- `getCalendar()` - Obtiene asignaciones para calendario (AJAX)

### 3. FichaController
Gestiona las fichas de formación.

**Métodos:**
- `index()` - Lista todas las fichas
- `crear()` - Formulario de creación
- `store()` - Guarda nueva ficha
- `ver()` - Detalle de ficha
- `editar()` - Formulario de edición
- `update($id)` - Actualiza ficha
- `eliminar()` - Elimina ficha

### 4. InstructorController
Gestiona los instructores.

**Métodos:**
- `index()` - Lista todos los instructores
- `crear()` - Formulario de creación
- `store()` - Guarda nuevo instructor
- `ver()` - Detalle de instructor
- `editar()` - Formulario de edición
- `update($id)` - Actualiza instructor
- `eliminar()` - Elimina instructor

### 5. AmbienteController
Gestiona los ambientes de formación.

**Métodos estándar CRUD**

### 6. ProgramaController
Gestiona los programas de formación.

**Métodos estándar CRUD**

### 7. CompetenciaController
Gestiona las competencias.

**Métodos estándar CRUD**

## Cómo Usar los Controladores

### Opción 1: Uso Directo en Vistas (Actual)

Las vistas actuales pueden seguir funcionando sin cambios. Los controladores son opcionales.

### Opción 2: Migrar a Controladores

Para migrar una vista a usar controladores:

#### Antes (vista directa):
```php
// views/asignacion/index.php
<?php
require_once __DIR__ . '/../../auth/check_auth.php';
require_once __DIR__ . '/../../model/AsignacionModel.php';

$model = new AsignacionModel();
$registros = $model->getAll();

include __DIR__ . '/../layout/header.php';
// ... resto del código
?>
```

#### Después (con controlador):
```php
// views/asignacion/index.php
<?php
require_once __DIR__ . '/../../controller/AsignacionController.php';

$controller = new AsignacionController();
$controller->index();
?>
```

### Opción 3: Routing Centralizado (Recomendado)

Crear un archivo `router.php` en la raíz:

```php
<?php
// router.php
$module = $_GET['module'] ?? 'dashboard';
$action = $_GET['action'] ?? 'index';

$controllerName = ucfirst($module) . 'Controller';
$controllerFile = __DIR__ . "/controller/{$controllerName}.php";

if (file_exists($controllerFile)) {
    require_once $controllerFile;
    $controller = new $controllerName();
    
    if (method_exists($controller, $action)) {
        $controller->$action();
    } else {
        die("Acción no encontrada: {$action}");
    }
} else {
    die("Controlador no encontrado: {$controllerName}");
}
?>
```

Uso:
```
index.php?module=asignacion&action=index
index.php?module=asignacion&action=crear
index.php?module=asignacion&action=ver&id=1
```

## Ejemplo Completo: Crear un Nuevo Controlador

```php
<?php
require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../model/MiModel.php';

class MiController extends BaseController {
    public function __construct() {
        parent::__construct();
        $this->model = new MiModel();
        $this->viewPath = 'mi_modulo';
    }
    
    public function index() {
        $registros = $this->model->getAll();
        
        $data = [
            'pageTitle' => 'Mi Módulo',
            'registros' => $registros,
            'mensaje' => $this->getFlashMessage()
        ];
        
        $this->render('index', $data);
    }
    
    public function crear() {
        if ($this->isMethod('POST')) {
            return $this->store();
        }
        
        $this->render('crear', ['pageTitle' => 'Nuevo Registro']);
    }
    
    public function store() {
        $errors = $this->validate($_POST, ['campo1', 'campo2']);
        
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old_input'] = $_POST;
            $this->redirect('crear.php');
        }
        
        try {
            $this->model->create($_POST);
            $this->redirect('index.php?msg=creado');
        } catch (Exception $e) {
            $_SESSION['error'] = 'Error: ' . $e->getMessage();
            $this->redirect('crear.php');
        }
    }
}
?>
```

## Ventajas del Sistema de Controladores

1. **Separación de Responsabilidades**: Lógica de negocio separada de la presentación
2. **Reutilización de Código**: Métodos comunes en BaseController
3. **Mantenibilidad**: Código más organizado y fácil de mantener
4. **Testabilidad**: Más fácil de probar unitariamente
5. **Escalabilidad**: Fácil agregar nuevos módulos
6. **Validación Centralizada**: Validaciones consistentes
7. **Manejo de Errores**: Gestión uniforme de errores
8. **Seguridad**: Validación y sanitización centralizada

## Integración con Sistema Actual

Los controladores están diseñados para:
- ✅ Funcionar con el sistema de autenticación existente
- ✅ Usar los modelos actuales sin modificaciones
- ✅ Mantener compatibilidad con vistas existentes
- ✅ Integrar el sistema de manejo de errores global
- ✅ Usar las funciones helper (safe, safeHtml, etc.)

## Próximos Pasos (Opcional)

1. Crear archivo `router.php` para routing centralizado
2. Migrar vistas existentes a usar controladores
3. Implementar middleware para autenticación y autorización
4. Agregar validación de formularios más robusta
5. Implementar sistema de caché
6. Agregar logging de acciones

## Notas Importantes

- Los controladores NO reemplazan las vistas actuales
- Son una capa adicional opcional para mejor organización
- Pueden coexistir con el código actual
- La migración puede ser gradual, módulo por módulo
