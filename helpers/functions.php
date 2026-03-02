<?php
/**
 * Funciones Helper Globales
 * Este archivo contiene funciones auxiliares para uso en todo el sistema
 */

/**
 * Acceso seguro a arrays - Evita warnings de "Undefined array key"
 * 
 * @param array|null $array El array a consultar
 * @param string $key La clave a buscar
 * @param mixed $default Valor por defecto si no existe o está vacío
 * @return mixed El valor encontrado o el valor por defecto
 */
function safe($array, $key, $default = 'No disponible') {
    if (!is_array($array)) {
        return $default;
    }
    return isset($array[$key]) && $array[$key] !== '' && $array[$key] !== null 
        ? $array[$key] 
        : $default;
}

/**
 * Escape seguro de HTML - Previene XSS
 * 
 * @param mixed $value El valor a escapar
 * @return string El valor escapado
 */
function e($value) {
    if ($value === null || $value === '') {
        return 'No disponible';
    }
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

/**
 * Acceso seguro con escape HTML combinado
 * 
 * @param array|null $array El array a consultar
 * @param string $key La clave a buscar
 * @param mixed $default Valor por defecto si no existe o está vacío
 * @return string El valor escapado o el valor por defecto
 */
function safeHtml($array, $key, $default = 'No disponible') {
    return e(safe($array, $key, $default));
}

/**
 * Verifica si un registro existe y tiene datos
 * 
 * @param mixed $registro El registro a verificar
 * @return bool True si el registro existe y tiene datos
 */
function registroValido($registro) {
    return $registro !== null && $registro !== false && !empty($registro);
}
?>
