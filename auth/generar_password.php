<?php
/**
 * Generador de Hash de Contraseñas
 * Utilidad para generar hashes seguros para la tabla usuarios
 */

// Configuración
$password = 'instructor123'; // Cambia esto por la contraseña que desees

// Generar hash
$hash = password_hash($password, PASSWORD_DEFAULT);

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generador de Hash - SENA</title>
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
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .container {
            background: white;
            border-radius: 16px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            max-width: 800px;
            width: 100%;
            padding: 40px;
        }
        
        h1 {
            color: #333;
            margin-bottom: 10px;
            font-size: 28px;
        }
        
        .subtitle {
            color: #666;
            margin-bottom: 30px;
            font-size: 14px;
        }
        
        .info-box {
            background: #f8f9fa;
            border-left: 4px solid #39A900;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
        }
        
        .info-box h3 {
            color: #39A900;
            margin-bottom: 10px;
            font-size: 16px;
        }
        
        .info-box p {
            color: #555;
            line-height: 1.6;
            margin-bottom: 8px;
        }
        
        .result-box {
            background: #e8f5e9;
            border: 2px solid #39A900;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
        }
        
        .result-box h3 {
            color: #2d8500;
            margin-bottom: 15px;
            font-size: 18px;
        }
        
        .password-display {
            background: white;
            padding: 15px;
            border-radius: 6px;
            border: 1px solid #ddd;
            margin-bottom: 15px;
        }
        
        .password-display label {
            display: block;
            color: #666;
            font-size: 12px;
            font-weight: 600;
            margin-bottom: 8px;
            text-transform: uppercase;
        }
        
        .password-display .value {
            color: #333;
            font-family: 'Courier New', monospace;
            font-size: 14px;
            word-break: break-all;
            background: #f8f9fa;
            padding: 10px;
            border-radius: 4px;
        }
        
        .hash-display {
            background: white;
            padding: 15px;
            border-radius: 6px;
            border: 1px solid #ddd;
        }
        
        .hash-display label {
            display: block;
            color: #666;
            font-size: 12px;
            font-weight: 600;
            margin-bottom: 8px;
            text-transform: uppercase;
        }
        
        .hash-display .value {
            color: #d32f2f;
            font-family: 'Courier New', monospace;
            font-size: 13px;
            word-break: break-all;
            background: #fff3f3;
            padding: 10px;
            border-radius: 4px;
        }
        
        .sql-box {
            background: #263238;
            color: #aed581;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            position: relative;
        }
        
        .sql-box h3 {
            color: #fff;
            margin-bottom: 15px;
            font-size: 16px;
        }
        
        .sql-box pre {
            margin: 0;
            font-family: 'Courier New', monospace;
            font-size: 13px;
            line-height: 1.6;
            overflow-x: auto;
        }
        
        .btn-copy {
            background: #39A900;
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        
        .btn-copy:hover {
            background: #2d8500;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(57, 169, 0, 0.3);
        }
        
        .instructions {
            background: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 20px;
            border-radius: 8px;
            margin-top: 20px;
        }
        
        .instructions h3 {
            color: #856404;
            margin-bottom: 10px;
            font-size: 16px;
        }
        
        .instructions ol {
            margin-left: 20px;
            color: #856404;
        }
        
        .instructions li {
            margin-bottom: 8px;
            line-height: 1.6;
        }
        
        .instructions code {
            background: #fff;
            padding: 2px 6px;
            border-radius: 3px;
            font-family: 'Courier New', monospace;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔐 Generador de Hash de Contraseñas</h1>
        <p class="subtitle">Sistema de Gestión SENA - Utilidad para crear usuarios</p>
        
        <div class="info-box">
            <h3>ℹ️ Información</h3>
            <p><strong>Contraseña configurada:</strong> <?php echo htmlspecialchars($password); ?></p>
            <p><strong>Algoritmo:</strong> bcrypt (PASSWORD_DEFAULT)</p>
            <p><strong>Uso:</strong> Para crear usuarios en la tabla 'usuarios'</p>
        </div>
        
        <div class="result-box">
            <h3>✅ Hash Generado</h3>
            
            <div class="password-display">
                <label>Contraseña Original:</label>
                <div class="value"><?php echo htmlspecialchars($password); ?></div>
            </div>
            
            <div class="hash-display">
                <label>Hash Generado (Copiar este valor):</label>
                <div class="value" id="hashValue"><?php echo $hash; ?></div>
            </div>
            
            <button class="btn-copy" onclick="copyHash()">
                📋 Copiar Hash
            </button>
        </div>
        
        <div class="sql-box">
            <h3>📝 Consulta SQL de Ejemplo</h3>
            <pre>INSERT INTO `usuarios` (`nombre`, `email`, `password`, `rol`, `instructor_id`, `estado`) 
VALUES (
    'Jose Lopez',                    -- Nombre del usuario
    'joselop@sena.edu.co',          -- Email
    '<?php echo $hash; ?>',  -- Hash generado
    'Instructor',                    -- Rol: 'Administrador' o 'Instructor'
    2,                               -- ID del instructor (NULL si es admin)
    'Activo'                         -- Estado
);</pre>
        </div>
        
        <div class="instructions">
            <h3>📋 Instrucciones de Uso</h3>
            <ol>
                <li>Edita el archivo <code>generar_password.php</code> y cambia la variable <code>$password</code> por la contraseña que desees</li>
                <li>Recarga esta página para generar un nuevo hash</li>
                <li>Copia el hash generado usando el botón "Copiar Hash"</li>
                <li>Abre phpMyAdmin: <code>http://localhost/phpmyadmin</code></li>
                <li>Selecciona la base de datos <code>progsena</code></li>
                <li>Ve a la pestaña "SQL"</li>
                <li>Pega la consulta SQL de ejemplo (modificando los datos según necesites)</li>
                <li>Haz clic en "Continuar" para ejecutar</li>
            </ol>
        </div>
        
        <div class="info-box" style="margin-top: 20px; border-left-color: #2196F3;">
            <h3>💡 Consejos</h3>
            <p><strong>Para Administradores:</strong> Usa <code>rol = 'Administrador'</code> y <code>instructor_id = NULL</code></p>
            <p><strong>Para Instructores:</strong> Usa <code>rol = 'Instructor'</code> y asigna el <code>instructor_id</code> correspondiente</p>
            <p><strong>Seguridad:</strong> Cada vez que ejecutes este script, se genera un hash diferente (incluso para la misma contraseña)</p>
        </div>
    </div>
    
    <script>
        function copyHash() {
            const hashValue = document.getElementById('hashValue').textContent;
            navigator.clipboard.writeText(hashValue).then(() => {
                const btn = document.querySelector('.btn-copy');
                const originalText = btn.innerHTML;
                btn.innerHTML = '✅ ¡Copiado!';
                btn.style.background = '#4caf50';
                
                setTimeout(() => {
                    btn.innerHTML = originalText;
                    btn.style.background = '#39A900';
                }, 2000);
            }).catch(err => {
                alert('Error al copiar: ' + err);
            });
        }
    </script>
</body>
</html>
```
