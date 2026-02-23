<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error del Servidor</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #39A900 0%, #007832 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }
        .error-container {
            background: white;
            border-radius: 10px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            padding: 40px;
            max-width: 600px;
            text-align: center;
        }
        .error-icon {
            font-size: 80px;
            color: #39A900;
            margin-bottom: 20px;
        }
        h1 {
            color: #333;
            font-size: 32px;
            margin-bottom: 15px;
        }
        p {
            color: #666;
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 30px;
        }
        .btn {
            display: inline-block;
            background: #39A900;
            color: white;
            padding: 12px 30px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: 600;
            transition: background 0.3s;
        }
        .btn:hover {
            background: #007832;
        }
        .error-code {
            color: #999;
            font-size: 14px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="error-container">
        <div class="error-icon">⚠️</div>
        <h1>Error del Servidor</h1>
        <p>Lo sentimos, ha ocurrido un error inesperado en el sistema. Nuestro equipo ha sido notificado y está trabajando para resolverlo.</p>
        <p>Por favor, intenta nuevamente en unos momentos.</p>
        <a href="<?php echo BASE_PATH; ?>index.php" class="btn">Volver al Inicio</a>
        <div class="error-code">Error 500 - Internal Server Error</div>
    </div>
</body>
</html>
