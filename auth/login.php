<?php
session_start();

// Cargar configuración
require_once __DIR__ . '/../config/config.php';

// Si ya está logueado, redirigir al dashboard
if (isset($_SESSION['usuario_id'])) {
    header('Location: ' . BASE_PATH . 'index.php');
    exit;
}

require_once __DIR__ . '/../conexion.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    
    if (!empty($email) && !empty($password)) {
        try {
            $db = Database::getInstance()->getConnection();
            
            // Verificar si la tabla usuarios existe
            $stmt = $db->query("SHOW TABLES LIKE 'usuarios'");
            $tableExists = $stmt->fetch();
            
            if (!$tableExists) {
                $error = 'La tabla de usuarios no existe. Por favor, ejecute el archivo crear_admin.sql en phpMyAdmin.';
            } else {
                // Buscar usuario en la tabla usuarios
                $stmt = $db->prepare("SELECT * FROM usuarios WHERE email = ? AND estado = 'Activo'");
                $stmt->execute([$email]);
                $usuario = $stmt->fetch();
                
                if ($usuario && password_verify($password, $usuario['password'])) {
                    $_SESSION['usuario_id'] = $usuario['id'];
                    $_SESSION['usuario_nombre'] = $usuario['nombre'];
                    $_SESSION['usuario_email'] = $usuario['email'];
                    $_SESSION['usuario_rol'] = $usuario['rol'];
                    
                    // Actualizar último acceso
                    $stmt = $db->prepare("UPDATE usuarios SET ultimo_acceso = NOW() WHERE id = ?");
                    $stmt->execute([$usuario['id']]);
                    
                    header('Location: ' . BASE_PATH . 'index.php');
                    exit;
                } else {
                    $error = 'Credenciales incorrectas o usuario inactivo';
                }
            }
            
        } catch (PDOException $e) {
            $error = 'Error de conexión: ' . $e->getMessage();
            error_log("Error de login: " . $e->getMessage());
        }
    } else {
        $error = 'Por favor complete todos los campos';
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Dashboard SENA</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background: url('../assets/images/sena%20cucuta%20copia.jpg') center/cover no-repeat fixed;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
        }
        
        body::before {
            content: '';
            position: absolute;
            inset: 0;
            background: rgba(255, 255, 255, 0.50);
            z-index: 1;
        }
        
        .login-container {
            background: white;
            border-radius: 16px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.15);
            overflow: hidden;
            max-width: 480px;
            width: 100%;
            display: flex;
            flex-direction: column;
            position: relative;
            z-index: 10;
        }
        
        .login-left {
            background: #e8f5e9;
            padding: 50px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            color: #1f2937;
        }
        
        .logo-circle {
            width: 90px;
            height: 90px;
            background: linear-gradient(135deg, #39A900 0%, #2d8500 100%);
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 25px;
            box-shadow: 0 2px 8px rgba(57, 169, 0, 0.2);
        }
        
        .logo-circle svg {
            width: 100%;
            height: 100%;
            display: block;
        }
        
        .login-left h1 {
            font-size: 36px;
            margin-bottom: 10px;
            font-weight: 800;
            letter-spacing: 2px;
            color: #1f2937;
        }
        
        .login-left p {
            font-size: 14px;
            opacity: 0.7;
            line-height: 1.4;
            color: #1f2937;
        }
        
        .login-right {
            padding: 45px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        
        .welcome-text {
            margin-bottom: 30px;
        }
        
        .welcome-text h2 {
            color: #1f2937;
            font-size: 24px;
            margin-bottom: 6px;
            font-weight: 700;
        }
        
        .welcome-text p {
            color: #6b7280;
            font-size: 14px;
        }
        
        .alert-error {
            background: #fee;
            color: #c33;
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 13px;
            border-left: 3px solid #c33;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            color: #374151;
            font-weight: 600;
            margin-bottom: 8px;
            font-size: 14px;
        }
        
        .form-group input {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            font-size: 14px;
            font-family: inherit;
            transition: all 0.2s;
            background: white;
        }
        
        .form-group input:focus {
            outline: none;
            border-color: #39A900;
            box-shadow: 0 0 0 3px rgba(57, 169, 0, 0.1);
        }
        
        .options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
            font-size: 13px;
        }
        
        .options label {
            display: flex;
            align-items: center;
            color: #6b7280;
            cursor: pointer;
        }
        
        .options input[type="checkbox"] {
            margin-right: 6px;
            width: 16px;
            height: 16px;
            cursor: pointer;
        }
        
        .options a {
            color: #39A900;
            text-decoration: none;
            font-weight: 600;
        }
        
        .options a:hover {
            color: #2d8700;
        }
        
        .btn-login {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #39A900 0%, #2d8700 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s;
            box-shadow: 0 2px 8px rgba(57, 169, 0, 0.25);
        }
        
        .btn-login:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(57, 169, 0, 0.35);
        }
        
        @media (max-width: 768px) {
            .login-container {
                max-width: 450px;
            }
            
            .login-left {
                padding: 40px 30px;
            }
            
            .login-left h1 {
                font-size: 32px;
            }
            
            .logo-circle {
                width: 80px;
                height: 80px;
            }
            
            .login-right {
                padding: 35px 30px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-left">
            <div class="logo-circle">
                <svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <text x="24" y="34" font-family="Arial, sans-serif" font-size="28" font-weight="bold" fill="white" text-anchor="middle">S</text>
                </svg>
            </div>
            <h1>SENA</h1>
            <p>Sistema de Gestión Académica<br>Servicio Nacional de Aprendizaje</p>
        </div>
        
        <div class="login-right">
            <div class="welcome-text">
                <h2>Bienvenido</h2>
                <p>Ingrese sus credenciales de Administrador</p>
            </div>
            
            <?php if ($error): ?>
                <div class="alert-error">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>
            
            <form method="POST" action="">
                <div class="form-group">
                    <label for="email">Correo Electrónico</label>
                    <input type="email" id="email" name="email" placeholder="usuario@sena.edu.co" required autofocus>
                </div>
                
                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <input type="password" id="password" name="password" placeholder="Ingrese su contraseña" required>
                </div>
                
                <div class="options">
                    <label>
                        <input type="checkbox" name="remember">
                        Recordarme
                    </label>
                    <a href="#">¿Olvidó su contraseña?</a>
                </div>
                
                <button type="submit" class="btn-login">Iniciar Sesión</button>
            </form>
        </div>
    </div>
</body>
</html>
