<?php
/**
 * Controlador de Autenticación
 */

require_once __DIR__ . '/BaseController.php';

/**
 * Controlador AuthController
 * Gestiona los procesos de autenticación, validación de credenciales,
 * gestión de sesiones y control de acceso al sistema.
 */
class AuthController extends BaseController {
    
    public function __construct() {
        // No llamamos al constructor padre para evitar el check_auth.php
        // Pero necesitamos inicializar las propiedades básicas
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->viewPath = 'auth';
    }

    /**
     * Mostrar formulario de login
     */
    public function index() {
        // Si ya está logueado, redirigir al dashboard
        if (isset($_SESSION['usuario_id'])) {
            $this->redirect(BASE_PATH);
        }

        $error = $_SESSION['login_error'] ?? '';
        unset($_SESSION['login_error']);

        // No usamos $this->render() porque incluye header/sidebar proteguidos
        $this->renderLogin(['error' => $error]);
    }

    /**
     * Procesar inicio de sesión
     */
    /**
     * Muestra la página de inicio de sesión.
     * Si el usuario ya está autenticado, lo redirige al dashboard correspondiente.
     */
    public function login() {
        if (!$this->isMethod('POST')) {
            $this->redirect(BASE_PATH . 'auth/index');
        }

        $email = $this->post('email');
        $password = $this->post('password');
        $rol_seleccionado = $this->post('rol');

        if (empty($email) || empty($password) || empty($rol_seleccionado)) {
            $_SESSION['login_error'] = "Por favor, complete todos los campos incluyendo el rol.";
            $this->redirect(BASE_PATH . 'auth/index');
        }

        try {
            require_once __DIR__ . '/../conexion.php';
            $db = Database::getInstance()->getConnection();
            
            $stmt = $db->prepare("SELECT * FROM usuarios WHERE email = ? AND estado = 'Activo'");
            $stmt->execute([$email]);
            $usuario = $stmt->fetch();
            
            if ($usuario && password_verify($password, $usuario['password'])) {
                // Verificar que el rol coincida
                if ($usuario['rol'] !== $rol_seleccionado) {
                    $_SESSION['login_error'] = "El usuario no tiene permisos de " . htmlspecialchars($rol_seleccionado) . ".";
                    $this->redirect(BASE_PATH . 'auth/index');
                }

                $_SESSION['usuario_id'] = $usuario['id'];
                $_SESSION['usuario_nombre'] = $usuario['nombre'];
                $_SESSION['usuario_email'] = $usuario['email'];
                $_SESSION['usuario_rol'] = $usuario['rol'];
                $_SESSION['instructor_id'] = $usuario['instructor_id'];
                
                // Variables redundantes para compatibilidad
                $_SESSION['id'] = $usuario['id'];
                $_SESSION['nombre'] = $usuario['nombre'];
                $_SESSION['rol'] = $usuario['rol'];
                
                // Actualizar último acceso
                $stmt = $db->prepare("UPDATE usuarios SET ultimo_acceso = NOW() WHERE id = ?");
                $stmt->execute([$usuario['id']]);
                
                $this->redirect(BASE_PATH);
            } else {
                $_SESSION['login_error'] = "Credenciales incorrectas o usuario inactivo.";
                $this->redirect(BASE_PATH . 'auth/index');
            }
        } catch (Exception $e) {
            $_SESSION['login_error'] = "Error del sistema: " . $e->getMessage();
            $this->redirect(BASE_PATH . 'auth/index');
        }
    }

    /**
     * Cerrar sesión
     */
    public function logout() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        session_destroy();
        header('Location: ' . BASE_PATH . 'auth/index');
        exit;
    }

    /**
     * Renderizado especial para login (sin header/sidebar del sistema)
     */
    private function renderLogin($data = []) {
        extract($data);
        $viewFile = __DIR__ . '/../views/auth/login.php';
        if (file_exists($viewFile)) {
            include $viewFile;
        } else {
            die("Vista de login no encontrada.");
        }
    }
}
