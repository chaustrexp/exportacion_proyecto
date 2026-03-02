<?php
/**
 * Punto de entrada principal (Front Controller)
 * Este archivo inicia el entorno y redirige el flujo hacia el sistema de enrutamiento central.
 */

// Cargar configuración
require_once __DIR__ . '/config/config.php';

// Redirigir al dashboard a través del routing
header('Location: ' . BASE_PATH . 'dashboard/index');
exit;
?>
