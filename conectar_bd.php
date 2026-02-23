<?php
/**
 * Script de Conexión y Configuración de Base de Datos
 * Este script te guiará para conectar la base de datos ProgSENA
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conectar Base de Datos - ProgSENA</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }
        .container {
            max-width: 900px;
            margin: 0 auto;
            background: white;
            border-radius: 15px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            overflow: hidden;
        }
        .header {
            background: #39a900;
            color: white;
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            font-size: 2em;
            margin-bottom: 10px;
        }
        .content {
            padding: 40px;
        }
        .step {
            background: #f8f9fa;
            border-left: 4px solid #39a900;
            padding: 20px;
            margin: 20px 0;
            border-radius: 5px;
        }
        .step h3 {
            color: #39a900;
            margin-bottom: 15px;
            font-size: 1.3em;
        }
        .step-number {
            display: inline-block;
            background: #39a900;
            color: white;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            text-align: center;
            line-height: 30px;
            margin-right: 10px;
            font-weight: bold;
        }
        .code-block {
            background: #2d2d2d;
            color: #f8f8f2;
            padding: 15px;
            border-radius: 5px;
            font-family: 'Courier New', monospace;
            overflow-x: auto;
            margin: 10px 0;
        }
        .btn {
            display: inline-block;
            background: #39a900;
            color: white;
            padding: 12px 30px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            transition: background 0.3s;
            border: none;
            cursor: pointer;
            font-size: 1em;
        }
        .btn:hover {
            background: #2d8000;
        }
        .btn-secondary {
            background: #6c757d;
        }
        .btn-secondary:hover {
            background: #5a6268;
        }
        .alert {
            padding: 15px;
            border-radius: 5px;
            margin: 15px 0;
        }
        .alert-info {
            background: #d1ecf1;
            border-left: 4px solid #17a2b8;
            color: #0c5460;
        }
        .alert-warning {
            background: #fff3cd;
            border-left: 4px solid #ffc107;
            color: #856404;
        }
        .alert-success {
            background: #d4edda;
            border-left: 4px solid #28a745;
            color: #155724;
        }
        .alert-danger {
            background: #f8d7da;
            border-left: 4px solid #dc3545;
            color: #721c24;
        }
        .config-info {
            background: #e7f3ff;
            padding: 15px;
            border-radius: 5px;
            margin: 15px 0;
        }
        .config-info strong {
            color: #0056b3;
        }
        ul {
            margin: 10px 0 10px 20px;
        }
        li {
            margin: 8px 0;
            line-height: 1.6;
        }
        .button-group {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }
        .status-box {
            display: inline-block;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.9em;
            font-weight: bold;
        }
        .status-pending {
            background: #fff3cd;
            color: #856404;
        }
        .status-ok {
            background: #d4edda;
            color: #155724;
        }
        .status-error {
            background: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🔌 Conectar Base de Datos</h1>
            <p>Sistema de Gestión SENA - ProgSENA</p>
        </div>
        
        <div class="content">
            <?php
            // Verificar conexión actual
            $connectionStatus = false;
            $dbExists = false;
            $tablesExist = false;
            $errorMessage = '';
            
            try {
                require_once 'conexion.php';
                $db = Database::getInstance();
                $conn = $db->getConnection();
                $connectionStatus = true;
                
                // Verificar base de datos
                $stmt = $conn->query("SELECT DATABASE() as db");
                $result = $stmt->fetch();
                $dbExists = ($result['db'] === 'progsena');
                
                // Verificar tablas
                $stmt = $conn->query("SHOW TABLES");
                $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
                $tablesExist = (count($tables) >= 12);
                
            } catch (Exception $e) {
                $errorMessage = $e->getMessage();
            }
            ?>
            
            <!-- Estado actual -->
            <div class="alert alert-info">
                <h3>📊 Estado Actual de la Conexión</h3>
                <p style="margin-top: 10px;">
                    <strong>Conexión MySQL:</strong> 
                    <span class="status-box <?php echo $connectionStatus ? 'status-ok' : 'status-error'; ?>">
                        <?php echo $connectionStatus ? '✓ Conectado' : '✗ No conectado'; ?>
                    </span>
                </p>
                <p>
                    <strong>Base de datos 'progsena':</strong> 
                    <span class="status-box <?php echo $dbExists ? 'status-ok' : 'status-error'; ?>">
                        <?php echo $dbExists ? '✓ Existe' : '✗ No existe'; ?>
                    </span>
                </p>
                <p>
                    <strong>Tablas:</strong> 
                    <span class="status-box <?php echo $tablesExist ? 'status-ok' : 'status-error'; ?>">
                        <?php echo $tablesExist ? '✓ Instaladas (' . count($tables) . ')' : '✗ No instaladas'; ?>
                    </span>
                </p>
                <?php if ($errorMessage): ?>
                <p style="margin-top: 10px; color: #721c24;">
                    <strong>Error:</strong> <?php echo htmlspecialchars($errorMessage); ?>
                </p>
                <?php endif; ?>
            </div>

            <?php if ($connectionStatus && $dbExists && $tablesExist): ?>
                <!-- Todo está bien -->
                <div class="alert alert-success">
                    <h3>✅ ¡Base de datos conectada correctamente!</h3>
                    <p style="margin-top: 10px;">Tu base de datos está configurada y lista para usar.</p>
                </div>
                
                <div class="button-group">
                    <a href="index.php" class="btn">Ir al Sistema</a>
                    <a href="auth/login.php" class="btn btn-secondary">Ir al Login</a>
                    <a href="verificar_conexion.php" class="btn btn-secondary">Ver Detalles</a>
                </div>
                
            <?php else: ?>
                <!-- Instrucciones paso a paso -->
                <h2 style="color: #39a900; margin-bottom: 20px;">📋 Pasos para Conectar la Base de Datos</h2>
                
                <!-- Paso 1 -->
                <div class="step">
                    <h3><span class="step-number">1</span>Iniciar MySQL</h3>
                    <p>Asegúrate de que MySQL esté corriendo en tu servidor local:</p>
                    <ul>
                        <li><strong>XAMPP:</strong> Abre el panel de control y haz clic en "Start" en MySQL</li>
                        <li><strong>WAMP:</strong> Inicia todos los servicios desde el icono de la bandeja</li>
                        <li><strong>MAMP:</strong> Haz clic en "Start Servers"</li>
                    </ul>
                    <div class="alert alert-warning">
                        <strong>⚠ Importante:</strong> El indicador de MySQL debe estar en verde antes de continuar.
                    </div>
                </div>

                <!-- Paso 2 -->
                <div class="step">
                    <h3><span class="step-number">2</span>Crear la Base de Datos</h3>
                    <p>Abre phpMyAdmin en tu navegador:</p>
                    <div class="code-block">
                        http://localhost/phpmyadmin
                    </div>
                    <p style="margin-top: 15px;">Luego ejecuta este comando SQL en la pestaña "SQL":</p>
                    <div class="code-block">
CREATE DATABASE IF NOT EXISTS progsena 
CHARACTER SET utf8mb4 
COLLATE utf8mb4_unicode_ci;
                    </div>
                </div>

                <!-- Paso 3 -->
                <div class="step">
                    <h3><span class="step-number">3</span>Importar la Estructura</h3>
                    <p>En phpMyAdmin:</p>
                    <ol style="margin-left: 20px;">
                        <li>Selecciona la base de datos <strong>progsena</strong> en el panel izquierdo</li>
                        <li>Haz clic en la pestaña <strong>"Importar"</strong></li>
                        <li>Haz clic en <strong>"Seleccionar archivo"</strong></li>
                        <li>Busca y selecciona el archivo:</li>
                    </ol>
                    <div class="code-block">
                        database/estructura_completa_ProgSENA.sql
                    </div>
                    <p style="margin-top: 10px;">5. Haz clic en <strong>"Continuar"</strong> al final de la página</p>
                    <div class="alert alert-info">
                        <strong>💡 Tip:</strong> Este archivo creará todas las tablas necesarias (12 tablas en total).
                    </div>
                </div>

                <!-- Paso 4 -->
                <div class="step">
                    <h3><span class="step-number">4</span>Crear Usuario Administrador</h3>
                    <p>Importa los datos iniciales para crear el usuario admin:</p>
                    <ol style="margin-left: 20px;">
                        <li>En phpMyAdmin, con la base de datos <strong>progsena</strong> seleccionada</li>
                        <li>Ve a la pestaña <strong>"Importar"</strong></li>
                        <li>Importa el archivo:</li>
                    </ol>
                    <div class="code-block">
                        database/crear_admin.sql
                    </div>
                    <div class="config-info">
                        <strong>Credenciales de acceso:</strong><br>
                        Usuario: <code>admin</code><br>
                        Contraseña: <code>admin123</code>
                    </div>
                </div>

                <!-- Paso 5 -->
                <div class="step">
                    <h3><span class="step-number">5</span>Verificar Configuración</h3>
                    <p>Revisa que los datos de conexión sean correctos en el archivo <code>conexion.php</code>:</p>
                    <div class="config-info">
                        <strong>Host:</strong> localhost<br>
                        <strong>Base de datos:</strong> progsena<br>
                        <strong>Usuario:</strong> root<br>
                        <strong>Contraseña:</strong> (vacía por defecto en XAMPP)
                    </div>
                    <p style="margin-top: 10px;">Si usas credenciales diferentes, edita el archivo <code>conexion.php</code></p>
                </div>

                <!-- Botones de acción -->
                <div class="button-group">
                    <button onclick="location.reload()" class="btn">🔄 Verificar Conexión</button>
                    <a href="verificar_conexion.php" class="btn btn-secondary">Ver Diagnóstico Completo</a>
                </div>

                <!-- Ayuda adicional -->
                <div class="alert alert-info" style="margin-top: 30px;">
                    <h3>❓ ¿Necesitas ayuda?</h3>
                    <ul>
                        <li>Consulta el archivo <code>INSTRUCCIONES_INSTALACION.md</code> para más detalles</li>
                        <li>Verifica que MySQL esté corriendo en el puerto 3306</li>
                        <li>Asegúrate de tener permisos de escritura en la carpeta del proyecto</li>
                    </ul>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
