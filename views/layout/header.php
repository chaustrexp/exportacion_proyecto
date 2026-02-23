<?php
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
    
    <!-- Tema Mejorado Encapsulado -->
    <link rel="stylesheet" href="<?php echo BASE_PATH; ?>assets/css/theme-enhanced.css?v=<?php echo $version; ?>">
    
    <script>
        window.BASE_PATH = '<?php echo BASE_PATH; ?>';
    </script>
</head>
<body class="sena-enhanced-theme">
    <!-- Navbar Moderno -->
    <nav class="navbar">
        <!-- Título del Dashboard -->
        <div class="navbar-title">
            <h1><?php echo htmlspecialchars($pageTitle); ?></h1>
        </div>
        
        <!-- Barra de Búsqueda -->
        <div class="navbar-search" style="position: relative;">
            <i data-lucide="search"></i>
            <input type="text" placeholder="Buscar..." class="search-input" id="globalSearch">
            
            <!-- Resultados de Búsqueda -->
            <div class="search-results" id="searchResults"></div>
        </div>
        
        <!-- Acciones del Header -->
        <div class="navbar-actions">
            <!-- Botón Agregar -->
            <div style="position: relative;">
                <button class="navbar-btn" id="addBtn" title="Agregar nuevo">
                    <i data-lucide="plus"></i>
                </button>
                
                <!-- Dropdown Agregar -->
                <div class="add-dropdown" id="addDropdown">
                    <a href="<?php echo BASE_PATH; ?>asignacion/create" class="add-dropdown-item">
                        <i data-lucide="calendar"></i>
                        Nueva Asignación
                    </a>
                    <a href="<?php echo BASE_PATH; ?>instructor/create" class="add-dropdown-item">
                        <i data-lucide="user-plus"></i>
                        Nuevo Instructor
                    </a>
                    <a href="<?php echo BASE_PATH; ?>ficha/create" class="add-dropdown-item">
                        <i data-lucide="file-plus"></i>
                        Nueva Ficha
                    </a>
                    <a href="<?php echo BASE_PATH; ?>programa/create" class="add-dropdown-item">
                        <i data-lucide="book-open"></i>
                        Nuevo Programa
                    </a>
                    <a href="<?php echo BASE_PATH; ?>ambiente/create" class="add-dropdown-item">
                        <i data-lucide="map-pin"></i>
                        Nuevo Ambiente
                    </a>
                </div>
            </div>
            
            <!-- Notificaciones -->
            <div style="position: relative;">
                <button class="navbar-btn navbar-notifications" id="notificationsBtn" title="Notificaciones">
                    <i data-lucide="bell"></i>
                    <span class="notification-badge" id="notificationBadge">3</span>
                </button>
                
                <!-- Dropdown Notificaciones -->
                <div class="notifications-dropdown" id="notificationsDropdown">
                    <div class="notifications-header">
                        <h3>Notificaciones</h3>
                        <a href="#" class="mark-all-read" id="markAllRead">Marcar todas como leídas</a>
                    </div>
                    <div class="notifications-list" id="notificationsList">
                        <!-- Las notificaciones se cargarán aquí dinámicamente -->
                    </div>
                    <div class="notifications-footer">
                        <a href="#" class="view-all-notifications">Ver todas las notificaciones</a>
                    </div>
                </div>
            </div>
            
            <!-- Ayuda -->
            <button class="navbar-btn" id="helpBtn" title="Ayuda">
                <i data-lucide="help-circle"></i>
            </button>
        </div>
        
        <!-- Botón Cerrar Sesión -->
        <div class="navbar-user">
            <a href="<?php echo BASE_PATH; ?>auth/logout.php" class="btn-logout">
                <i data-lucide="log-out"></i>
                <span>Cerrar Sesión</span>
            </a>
        </div>
    </nav>

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
                        <li><a href="<?php echo BASE_PATH; ?>_docs/INSTRUCCIONES_USUARIO.md" target="_blank">Manual de Usuario</a></li>
                        <li><a href="<?php echo BASE_PATH; ?>_docs/ARQUITECTURA_DASHBOARD.md" target="_blank">Arquitectura del Sistema</a></li>
                        <li><a href="<?php echo BASE_PATH; ?>_docs/SISTEMA_ROUTING.md" target="_blank">Sistema de Routing</a></li>
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

