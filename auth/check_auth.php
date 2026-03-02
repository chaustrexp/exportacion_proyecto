<?php
// Cargar configuración
require_once __DIR__ . '/../config/config.php';

// Cargar sistema de manejo de errores global
require_once __DIR__ . '/../config/error_handler.php';

// Cargar funciones helper globales
require_once __DIR__ . '/../helpers/functions.php';

// Archivo para proteger páginas - incluir al inicio de cada página protegida
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verificar si el usuario está logueado
if (!isset($_SESSION['usuario_id'])) {
    header('Location: ' . BASE_PATH . 'auth/index');
    exit;
}

// Función para verificar rol
function verificarRol($rolesPermitidos) {
    $rol = $_SESSION['rol'] ?? $_SESSION['usuario_rol'] ?? '';
    if (!in_array($rol, $rolesPermitidos)) {
        header('Location: ' . BASE_PATH . 'index.php?error=acceso_denegado');
        exit;
    }
}

// Función para obtener nombre del usuario
function getNombreUsuario() {
    return $_SESSION['nombre'] ?? $_SESSION['usuario_nombre'] ?? 'Usuario';
}

// Función para obtener rol del usuario
function getRolUsuario() {
    return $_SESSION['rol'] ?? $_SESSION['usuario_rol'] ?? 'Usuario';
}
?>
