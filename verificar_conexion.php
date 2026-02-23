<?php
/**
 * Script de Verificación de Conexión
 * Ejecuta este archivo para verificar que la conexión a la base de datos funciona correctamente
 */

// Mostrar errores para debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<!DOCTYPE html>
<html lang='es'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Verificación de Conexión - ProgSENA</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h1 {
            color: #39a900;
            border-bottom: 3px solid #39a900;
            padding-bottom: 10px;
        }
        .success {
            background-color: #d4edda;
            color: #155724;
            padding: 15px;
            border-radius: 5px;
            border-left: 4px solid #28a745;
            margin: 10px 0;
        }
        .error {
            background-color: #f8d7da;
            color: #721c24;
            padding: 15px;
            border-radius: 5px;
            border-left: 4px solid #dc3545;
            margin: 10px 0;
        }
        .info {
            background-color: #d1ecf1;
            color: #0c5460;
            padding: 15px;
            border-radius: 5px;
            border-left: 4px solid #17a2b8;
            margin: 10px 0;
        }
        .warning {
            background-color: #fff3cd;
            color: #856404;
            padding: 15px;
            border-radius: 5px;
            border-left: 4px solid #ffc107;
            margin: 10px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #39a900;
            color: white;
        }
        .check-item {
            margin: 15px 0;
        }
        .check-title {
            font-weight: bold;
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    <div class='container'>
        <h1>🔍 Verificación de Conexión - ProgSENA</h1>";

// 1. Verificar que el archivo de conexión existe
echo "<div class='check-item'>";
echo "<div class='check-title'>1. Verificando archivo de conexión...</div>";
if (file_exists('conexion.php')) {
    echo "<div class='success'>✓ Archivo conexion.php encontrado</div>";
    require_once 'conexion.php';
} else {
    echo "<div class='error'>✗ Error: No se encuentra el archivo conexion.php</div>";
    echo "</div></div></body></html>";
    exit;
}
echo "</div>";

// 2. Verificar constantes de configuración
echo "<div class='check-item'>";
echo "<div class='check-title'>2. Verificando configuración...</div>";
echo "<div class='info'>";
echo "<strong>Host:</strong> " . DB_HOST . "<br>";
echo "<strong>Base de datos:</strong> " . DB_NAME . "<br>";
echo "<strong>Usuario:</strong> " . DB_USER . "<br>";
echo "<strong>Contraseña:</strong> " . (empty(DB_PASS) ? '(vacía)' : '***') . "<br>";
echo "</div>";
echo "</div>";

// 3. Intentar conectar a la base de datos
echo "<div class='check-item'>";
echo "<div class='check-title'>3. Probando conexión a MySQL...</div>";
try {
    $db = Database::getInstance();
    $conn = $db->getConnection();
    echo "<div class='success'>✓ Conexión exitosa a la base de datos</div>";
} catch (Exception $e) {
    echo "<div class='error'>✗ Error de conexión: " . $e->getMessage() . "</div>";
    echo "<div class='warning'>";
    echo "<strong>Posibles soluciones:</strong><br>";
    echo "• Verifica que MySQL esté iniciado en XAMPP/WAMP<br>";
    echo "• Verifica el usuario y contraseña en conexion.php<br>";
    echo "• Asegúrate de que la base de datos 'progsena' exista<br>";
    echo "</div>";
    echo "</div></div></body></html>";
    exit;
}
echo "</div>";

// 4. Verificar que la base de datos existe
echo "<div class='check-item'>";
echo "<div class='check-title'>4. Verificando base de datos 'progsena'...</div>";
try {
    $stmt = $conn->query("SELECT DATABASE() as db");
    $result = $stmt->fetch();
    if ($result['db'] === DB_NAME) {
        echo "<div class='success'>✓ Base de datos 'progsena' seleccionada correctamente</div>";
    } else {
        echo "<div class='error'>✗ Base de datos incorrecta: " . $result['db'] . "</div>";
    }
} catch (Exception $e) {
    echo "<div class='error'>✗ Error: " . $e->getMessage() . "</div>";
}
echo "</div>";

// 5. Verificar tablas
echo "<div class='check-item'>";
echo "<div class='check-title'>5. Verificando tablas de la base de datos...</div>";
try {
    $stmt = $conn->query("SHOW TABLES");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    $expectedTables = [
        'ambiente',
        'asignacion',
        'centro_formacion',
        'competencia',
        'competxprograma',
        'coordinacion',
        'detallexasignacion',
        'ficha',
        'instructor',
        'programa',
        'sede',
        'titulo_programa'
    ];
    
    if (count($tables) === 0) {
        echo "<div class='error'>✗ No se encontraron tablas en la base de datos</div>";
        echo "<div class='warning'>";
        echo "<strong>Acción requerida:</strong><br>";
        echo "Debes importar el archivo <code>database/estructura_completa_ProgSENA.sql</code> en phpMyAdmin<br>";
        echo "1. Abre phpMyAdmin (http://localhost/phpmyadmin)<br>";
        echo "2. Selecciona la base de datos 'progsena'<br>";
        echo "3. Ve a la pestaña 'Importar'<br>";
        echo "4. Selecciona el archivo SQL y haz clic en 'Continuar'<br>";
        echo "</div>";
    } else {
        echo "<div class='success'>✓ Se encontraron " . count($tables) . " tablas</div>";
        
        echo "<table>";
        echo "<tr><th>Tabla Esperada</th><th>Estado</th></tr>";
        
        foreach ($expectedTables as $table) {
            $exists = in_array($table, $tables);
            echo "<tr>";
            echo "<td>" . $table . "</td>";
            echo "<td>" . ($exists ? "✓ Existe" : "✗ Falta") . "</td>";
            echo "</tr>";
        }
        echo "</table>";
        
        $missingTables = array_diff($expectedTables, $tables);
        if (count($missingTables) > 0) {
            echo "<div class='warning'>";
            echo "<strong>Faltan tablas:</strong> " . implode(', ', $missingTables) . "<br>";
            echo "Reimporta el archivo SQL desde phpMyAdmin";
            echo "</div>";
        }
    }
} catch (Exception $e) {
    echo "<div class='error'>✗ Error al verificar tablas: " . $e->getMessage() . "</div>";
}
echo "</div>";

// 6. Verificar versión de PHP y MySQL
echo "<div class='check-item'>";
echo "<div class='check-title'>6. Información del sistema...</div>";
echo "<div class='info'>";
echo "<strong>Versión de PHP:</strong> " . phpversion() . "<br>";
try {
    $stmt = $conn->query("SELECT VERSION() as version");
    $result = $stmt->fetch();
    echo "<strong>Versión de MySQL:</strong> " . $result['version'] . "<br>";
} catch (Exception $e) {
    echo "<strong>Versión de MySQL:</strong> No disponible<br>";
}
echo "<strong>Servidor:</strong> " . $_SERVER['SERVER_SOFTWARE'] . "<br>";
echo "</div>";
echo "</div>";

// Resumen final
echo "<div class='check-item'>";
echo "<h2>📊 Resumen</h2>";
if (isset($conn) && count($tables ?? []) === count($expectedTables)) {
    echo "<div class='success'>";
    echo "<strong>✓ ¡Todo está configurado correctamente!</strong><br><br>";
    echo "Puedes acceder al proyecto en: <a href='index.php'>index.php</a><br>";
    echo "O ir al login: <a href='auth/login.php'>auth/login.php</a>";
    echo "</div>";
} else {
    echo "<div class='warning'>";
    echo "<strong>⚠ Configuración incompleta</strong><br><br>";
    echo "Revisa los mensajes anteriores y sigue las instrucciones para completar la instalación.<br>";
    echo "Consulta el archivo <code>INSTRUCCIONES_INSTALACION.md</code> para más detalles.";
    echo "</div>";
}
echo "</div>";

echo "</div></body></html>";
?>
