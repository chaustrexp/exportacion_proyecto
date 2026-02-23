<?php
/**
 * Archivo de Configuración General
 * INSTRUCCIONES: Copia este archivo como 'config.php' y ajusta las rutas según tu entorno
 */

// Detectar si estamos en desarrollo local o producción
$isLocal = (
    $_SERVER['SERVER_NAME'] === 'localhost' || 
    $_SERVER['SERVER_NAME'] === '127.0.0.1' ||
    strpos($_SERVER['SERVER_NAME'], 'local') !== false
);

// Configurar la ruta base según el entorno
if ($isLocal) {
    // En desarrollo local (XAMPP/WAMP)
    // CAMBIA ESTO según la carpeta de tu proyecto
    define('BASE_PATH', '/exportacion_proyecto/');
    define('BASE_URL', 'http://localhost/exportacion_proyecto/');
} else {
    // En producción
    // CAMBIA ESTO según tu dominio y ruta
    define('BASE_PATH', '/');
    define('BASE_URL', 'https://tu-dominio.com/');
}

// Rutas del sistema
define('ROOT_PATH', __DIR__ . '/../');
define('VIEWS_PATH', ROOT_PATH . 'views/');
define('CONTROLLER_PATH', ROOT_PATH . 'controller/');
define('MODEL_PATH', ROOT_PATH . 'model/');

// Configuración de la aplicación
define('APP_NAME', 'ProgSENA');
define('APP_VERSION', '1.0.0');

// Zona horaria
date_default_timezone_set('America/Bogota');

// Configuración de errores (solo en desarrollo)
if ($isLocal) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}
?>
