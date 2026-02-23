<?php
/**
 * Punto de entrada principal del Dashboard SENA
 * Redirige al sistema de routing
 */

// Cargar configuración
require_once __DIR__ . '/config/config.php';

// Redirigir al dashboard a través del routing
header('Location: ' . BASE_PATH . 'dashboard/index');
exit;
?>
