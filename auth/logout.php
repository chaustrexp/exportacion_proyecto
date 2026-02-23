<?php
session_start();

// Cargar configuración
require_once __DIR__ . '/../config/config.php';

// Destruir todas las variables de sesión
$_SESSION = array();

// Destruir la cookie de sesión
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time()-3600, '/');
}

// Destruir la sesión
session_destroy();

// Redirigir al login
header('Location: ' . BASE_PATH . 'auth/login.php');
exit;
?>
