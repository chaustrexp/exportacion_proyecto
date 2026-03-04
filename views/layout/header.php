<?php
/**
 * Layout Header
 * Parte superior común de la aplicación. Gestiona la inclusión de librerías CSS,
 * fuentes (Lucide, Google Fonts) y la identidad visual del SENA.
 * También verifica la autenticación de sesión en cada carga de página protegida.
 */

// Verificar autenticación
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['usuario_id'])) {
    header('Location: ' . BASE_PATH . 'auth/login.php');
    exit;
}

// Cargar sistema de títulos dinámicos si existe
$helperPath = __DIR__ . '/../../helpers/page_titles.php';
if (file_exists($helperPath)) {
    require_once $helperPath;
    
    // Obtener título de la página
    if (!isset($pageTitle)) {
        $pageTitle = getPageTitle();
    }
    
    // Obtener breadcrumbs automáticos si no están definidos
    if (!isset($breadcrumbs)) {
        $breadcrumbs = getAutoBreadcrumbs();
    }
} else {
    // Si no existe el helper, usar título por defecto
    if (!isset($pageTitle)) {
        $pageTitle = 'Dashboard Principal';
    }
}

// Forzar UTF-8 en la salida
header('Content-Type: text/html; charset=UTF-8');
mb_internal_encoding('UTF-8');

// Deshabilitar caché para desarrollo (comentar en producción)
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');

// Versión para forzar recarga de CSS/JS
$version = time(); // Cambia en cada recarga

// Título del documento
$documentTitle = $pageTitle . ' - Dashboard SENA';

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <title><?php echo htmlspecialchars($documentTitle); ?></title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="<?php echo BASE_PATH; ?>assets/images/favicon.svg">
    <link rel="alternate icon" href="<?php echo BASE_PATH; ?>assets/images/favicon.ico">
    <link rel="apple-touch-icon" href="<?php echo BASE_PATH; ?>assets/images/favicon.svg">
    
    <link rel="stylesheet" href="<?php echo BASE_PATH; ?>assets/css/styles.css?v=<?php echo $version; ?>">
    <link rel="stylesheet" href="<?php echo BASE_PATH; ?>assets/css/theme-enhanced.css?v=<?php echo $version; ?>">
    
    <script>
        window.BASE_PATH = '<?php echo BASE_PATH; ?>';
    </script>
</head>
<?php 
// Determinar clase de rol para el body
$bodyRoleClass = 'role-instr'; // Default
if ($userRole === 'Administrador') $bodyRoleClass = 'role-admin';
if ($userRole === 'Coordinador') $bodyRoleClass = 'role-coord';
?>
<body class="sena-enhanced-theme <?php echo $bodyRoleClass; ?>">
    <!-- Navbar Moderno -->
    <nav class="navbar">
        <!-- Logo y Título -->
        <div class="navbar-logo">
            <div class="navbar-logo-icon">
                <i data-lucide="graduation-cap"></i>
            </div>
            <div class="navbar-logo-text">
                <h2><?php echo htmlspecialchars($pageTitle); ?></h2>
            </div>
        </div>
        
        <!-- Acciones del Header -->
        <div class="navbar-actions">
            <?php if ($userRole === 'Administrador' || $userRole === 'Coordinador'): ?>
                <!-- Botón Agregar -->
                <div style="position: relative;">
                    <button class="navbar-btn" id="addBtn" title="Agregar nuevo">
                        <i data-lucide="plus"></i>
                    </button>
                    
                    <!-- Dropdown Agregar (Personalizado por Rol) -->
                    <div class="add-dropdown" id="addDropdown">
                        <?php if ($userRole === 'Coordinador'): ?>
                            <a href="<?php echo BASE_PATH; ?>asignacion/create" class="add-dropdown-item">
                                <i data-lucide="calendar"></i>
                                Nueva Asignación
                            </a>
                            <a href="<?php echo BASE_PATH; ?>ficha/create" class="add-dropdown-item">
                                <i data-lucide="file-plus"></i>
                                Nueva Ficha
                            </a>
                        <?php elseif ($userRole === 'Administrador'): ?>
                            <a href="<?php echo BASE_PATH; ?>instructor/create" class="add-dropdown-item">
                                <i data-lucide="user-plus"></i>
                                Nuevo Instructor
                            </a>
                            <a href="<?php echo BASE_PATH; ?>ficha/create" class="add-dropdown-item">
                                <i data-lucide="file-plus"></i>
                                Nueva Ficha
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
            
            <!-- Ayuda -->
            <button class="navbar-btn" id="helpBtn" title="Ayuda">
                <i data-lucide="help-circle"></i>
            </button>
            
            <!-- Cerrar Sesión -->
            <a href="<?php echo BASE_PATH; ?>auth/logout" class="navbar-btn" title="Cerrar Sesión" style="color: #ef4444; border-color: #fee2e2;">
                <i data-lucide="log-out"></i>
            </a>
        </div>

        <!-- Perfil de Usuario -->
        <div class="navbar-profile">
            <div class="user-text">
                <span class="user-name"><?php echo $_SESSION['usuario_nombre']; ?></span>
            </div>
            <div class="user-avatar-nav">
                <img src="<?php echo BASE_PATH; ?>assets/images/foto-perfil.jpg" alt="Perfil">
            </div>
        </div>
    </nav>

    <!-- Barra de Breadcrumb y Fecha -->
    <div class="breadcrumb-bar">
        <div class="breadcrumb-list">
            <span class="breadcrumb-item">
                <i data-lucide="home"></i>
                <span>HOME</span>
            </span>
            <span class="breadcrumb-separator">></span>
            <span class="breadcrumb-active"><?php echo strtoupper(htmlspecialchars($pageTitle)); ?></span>
        </div>
        <div class="date-display">
            <i data-lucide="calendar"></i>
            <span><?php echo strtoupper(date('M d, Y')); ?></span>
        </div>
    </div>

    <!-- Modal de Ayuda -->
    <div class="help-modal" id="helpModal">
        <div class="help-modal-content">
            <div class="help-modal-header">
                <h2>Centro de Ayuda</h2>
                <button class="help-modal-close" id="helpModalClose">
                    <i data-lucide="x"></i>
                </button>
            </div>
            <div class="help-modal-body">
                <div class="help-section">
                    <h3><i data-lucide="book"></i> Documentación</h3>
                    <ul>
                        <li><a href="#">Manual de Usuario (Soporte)</a></li>
                    </ul>
                </div>
                
                <div class="help-section">
                    <h3><i data-lucide="help-circle"></i> Preguntas Frecuentes</h3>
                    <ul>
                        <li><strong>¿Cómo crear una asignación?</strong><br>
                            Ve a Asignaciones > Crear Nueva y completa el formulario.</li>
                        <li><strong>¿Cómo agregar un instructor?</strong><br>
                            Ve a Instructores > Nuevo Instructor y llena los datos.</li>
                        <li><strong>¿Cómo gestionar fichas?</strong><br>
                            Accede al módulo de Fichas desde el menú lateral.</li>
                    </ul>
                </div>
                
                <div class="help-section">
                    <h3><i data-lucide="phone"></i> Soporte</h3>
                    <ul>
                        <li>Email: soporte@sena.edu.co</li>
                        <li>Teléfono: (601) 5461500</li>
                        <li>Horario: Lunes a Viernes, 8:00 AM - 5:00 PM</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

