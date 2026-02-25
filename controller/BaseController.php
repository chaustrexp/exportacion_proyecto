<?php
/**
 * Controlador Base
 * Clase base para todos los controladores del sistema
 */

abstract class BaseController {
    protected $model;
    protected $viewPath;
    
    /**
     * Constructor
     */
    public function __construct() {
        // Cargar sistema de autenticación y helpers
        require_once __DIR__ . '/../auth/check_auth.php';
    }
    
    /**
     * Renderizar una vista
     * @param string $view Nombre de la vista
     * @param array $data Datos a pasar a la vista
     */
    protected function render($view, $data = []) {
        // Extraer datos para usar en la vista
        extract($data);
        
        // Incluir header y sidebar
        $pageTitle = $data['pageTitle'] ?? 'Dashboard SENA';
        include __DIR__ . '/../views/layout/header.php';
        include __DIR__ . '/../views/layout/sidebar.php';
        
        // Incluir la vista específica
        $viewFile = __DIR__ . '/../views/' . $this->viewPath . '/' . $view . '.php';
        if (file_exists($viewFile)) {
            include $viewFile;
        } else {
            die("Vista no encontrada: {$viewFile}");
        }
        
        // Incluir footer
        include __DIR__ . '/../views/layout/footer.php';
    }
    
    /**
     * Redirigir a una URL
     * @param string $url URL de destino
     * @param string $message Mensaje opcional
     */
    protected function redirect($url, $message = null) {
        if ($message) {
            $_SESSION['flash_message'] = $message;
        }
        header("Location: {$url}");
        exit;
    }
    
    /**
     * Devolver respuesta JSON
     * @param mixed $data Datos a devolver
     * @param int $statusCode Código de estado HTTP
     */
    protected function json($data, $statusCode = 200) {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
    
    /**
     * Validar datos requeridos
     * @param array $data Datos a validar
     * @param array $required Campos requeridos
     * @return array Errores encontrados
     */
    protected function validate($data, $required) {
        $errors = [];
        foreach ($required as $field) {
            // Usar isset y verificar que no sea string vacío
            // Permite 0 como valor válido
            if (!isset($data[$field]) || (is_string($data[$field]) && trim($data[$field]) === '')) {
                $errors[$field] = "El campo {$field} es requerido";
            }
        }
        return $errors;
    }
    
    /**
     * Obtener mensaje flash y eliminarlo
     * @return string|null
     */
    protected function getFlashMessage() {
        if (isset($_SESSION['flash_message'])) {
            $message = $_SESSION['flash_message'];
            unset($_SESSION['flash_message']);
            return $message;
        }
        return null;
    }
    
    /**
     * Verificar método HTTP
     * @param string $method Método esperado (GET, POST, etc.)
     * @return bool
     */
    protected function isMethod($method) {
        return $_SERVER['REQUEST_METHOD'] === strtoupper($method);
    }
    
    /**
     * Obtener datos POST de forma segura
     * @param string $key Clave del dato
     * @param mixed $default Valor por defecto
     * @return mixed
     */
    protected function post($key, $default = null) {
        return $_POST[$key] ?? $default;
    }
    
    /**
     * Obtener datos GET de forma segura
     * @param string $key Clave del dato
     * @param mixed $default Valor por defecto
     * @return mixed
     */
    protected function get($key, $default = null) {
        return $_GET[$key] ?? $default;
    }
}
?>
