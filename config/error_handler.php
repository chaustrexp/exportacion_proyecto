<?php
/**
 * Configuración Global de Manejo de Errores
 * Este archivo debe ser incluido en TODAS las páginas del sistema
 */

// Configuración de errores
error_reporting(E_ALL);
ini_set('display_errors', 0);  // No mostrar errores en pantalla
ini_set('log_errors', 1);      // Registrar errores en log
ini_set('error_log', __DIR__ . '/../logs/php_errors.log');

// Manejador personalizado de errores
set_error_handler(function($errno, $errstr, $errfile, $errline) {
    // No procesar errores suprimidos con @
    if (!(error_reporting() & $errno)) {
        return false;
    }
    
    // Registrar el error en el log
    $error_message = date('[Y-m-d H:i:s] ') . "Error [$errno]: $errstr en $errfile línea $errline\n";
    error_log($error_message, 3, __DIR__ . '/../logs/php_errors.log');
    
    // En desarrollo, puedes descomentar esto para ver errores
    // echo "<div style='background:#fee;padding:10px;border:1px solid #c00;margin:10px;'>Error: $errstr</div>";
    
    return true;
});

// Manejador de excepciones no capturadas
set_exception_handler(function($exception) {
    $error_message = date('[Y-m-d H:i:s] ') . "Exception: " . $exception->getMessage() . 
                     " en " . $exception->getFile() . " línea " . $exception->getLine() . "\n";
    error_log($error_message, 3, __DIR__ . '/../logs/php_errors.log');
    
    // Mostrar página de error amigable
    http_response_code(500);
    include __DIR__ . '/../views/errors/500.php';
    exit;
});

// Manejador de errores fatales
register_shutdown_function(function() {
    $error = error_get_last();
    if ($error !== null && in_array($error['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR])) {
        $error_message = date('[Y-m-d H:i:s] ') . "Fatal Error: {$error['message']} en {$error['file']} línea {$error['line']}\n";
        error_log($error_message, 3, __DIR__ . '/../logs/php_errors.log');
        
        // Limpiar buffer de salida
        if (ob_get_level()) ob_end_clean();
        
        // Mostrar página de error amigable
        http_response_code(500);
        include __DIR__ . '/../views/errors/500.php';
        exit;
    }
});
?>
