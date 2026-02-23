<?php
/**
 * Script para Importar Datos de Prueba
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'conexion.php';

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Importar Datos - ProgSENA</title>
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
            max-width: 800px;
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
        .alert {
            padding: 15px;
            border-radius: 5px;
            margin: 15px 0;
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
            margin: 5px;
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
        .btn-danger {
            background: #dc3545;
        }
        .btn-danger:hover {
            background: #c82333;
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
            background: #f8f9fa;
            font-weight: bold;
        }
        .count {
            font-size: 2em;
            font-weight: bold;
            color: #39a900;
        }
        .button-group {
            display: flex;
            gap: 10px;
            margin-top: 20px;
            flex-wrap: wrap;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📦 Importar Datos de Prueba</h1>
            <p>Sistema de Gestión SENA - ProgSENA</p>
        </div>
        
        <div class="content">
            <?php
            try {
                $db = Database::getInstance()->getConnection();
                
                // Verificar nombres de tablas
                $stmt = $db->query("SHOW TABLES");
                $tablasExistentes = $stmt->fetchAll(PDO::FETCH_COLUMN);
                
                // Detectar problema de nombres
                $problemaNombres = false;
                if (in_array('compet_programa', $tablasExistentes) || in_array('detalle_asignacion', $tablasExistentes)) {
                    $problemaNombres = true;
                    echo "<div class='alert alert-danger'>";
                    echo "<strong>❌ Error de Nombres de Tablas</strong><br>";
                    echo "Las tablas tienen nombres incorrectos que no coinciden con el código.<br><br>";
                    echo "<strong>Solución:</strong> Ejecuta este SQL en phpMyAdmin:<br>";
                    echo "<pre style='background: #2d2d2d; color: #f8f8f2; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
                    echo "USE progsena;\n";
                    if (in_array('compet_programa', $tablasExistentes)) {
                        echo "RENAME TABLE `compet_programa` TO `competxprograma`;\n";
                    }
                    if (in_array('detalle_asignacion', $tablasExistentes)) {
                        echo "RENAME TABLE `detalle_asignacion` TO `detallexasignacion`;\n";
                    }
                    echo "</pre>";
                    echo "<a href='http://localhost/phpmyadmin' target='_blank' class='btn btn-danger'>Abrir phpMyAdmin</a> ";
                    echo "<a href='SOLUCION_NOMBRES_TABLAS.md' target='_blank' class='btn btn-secondary'>Ver Guía Completa</a>";
                    echo "</div>";
                }
                
                if ($problemaNombres) {
                    echo "<hr style='margin: 30px 0;'>";
                    echo "<div class='alert alert-warning'>";
                    echo "⚠ Corrige los nombres de las tablas antes de continuar.";
                    echo "</div>";
                    echo "</div></div></body></html>";
                    exit;
                }
                
                // Verificar datos actuales
                $tablas = [
                    'centro_formacion' => 'Centros de Formación',
                    'sede' => 'Sedes',
                    'ambiente' => 'Ambientes',
                    'titulo_programa' => 'Títulos de Programa',
                    'programa' => 'Programas',
                    'competencia' => 'Competencias',
                    'competxprograma' => 'Competencias por Programa',
                    'instructor' => 'Instructores',
                    'coordinacion' => 'Coordinaciones',
                    'ficha' => 'Fichas',
                    'asignacion' => 'Asignaciones'
                ];
                
                echo "<h2>📊 Estado Actual de la Base de Datos</h2>";
                echo "<table>";
                echo "<tr><th>Tabla</th><th>Registros</th></tr>";
                
                $totalRegistros = 0;
                foreach ($tablas as $tabla => $nombre) {
                    $stmt = $db->query("SELECT COUNT(*) as total FROM `$tabla`");
                    $result = $stmt->fetch();
                    $count = $result['total'];
                    $totalRegistros += $count;
                    echo "<tr>";
                    echo "<td>$nombre</td>";
                    echo "<td class='count'>$count</td>";
                    echo "</tr>";
                }
                echo "</table>";
                
                if ($totalRegistros == 0) {
                    echo "<div class='alert alert-warning'>";
                    echo "<strong>⚠ Base de datos vacía</strong><br>";
                    echo "No hay datos en la base de datos. Necesitas importar los datos de prueba.";
                    echo "</div>";
                    
                    echo "<div class='alert alert-info'>";
                    echo "<h3>📋 Instrucciones para Importar Datos</h3>";
                    echo "<ol style='margin-left: 20px; margin-top: 10px;'>";
                    echo "<li>Abre phpMyAdmin: <code>http://localhost/phpmyadmin</code></li>";
                    echo "<li>Selecciona la base de datos <strong>progsena</strong></li>";
                    echo "<li>Ve a la pestaña <strong>Importar</strong></li>";
                    echo "<li>Selecciona el archivo: <code>database/datos_prueba.sql</code></li>";
                    echo "<li>Haz clic en <strong>Continuar</strong></li>";
                    echo "</ol>";
                    echo "</div>";
                    
                    echo "<div class='button-group'>";
                    echo "<a href='http://localhost/phpmyadmin' target='_blank' class='btn'>Abrir phpMyAdmin</a>";
                    echo "<button onclick='location.reload()' class='btn btn-secondary'>🔄 Verificar Datos</button>";
                    echo "</div>";
                    
                } else {
                    echo "<div class='alert alert-success'>";
                    echo "<strong>✅ Base de datos con datos</strong><br>";
                    echo "Se encontraron <strong>$totalRegistros registros</strong> en total.";
                    echo "</div>";
                    
                    // Verificar competencias por programa específicamente
                    $stmt = $db->query("SELECT COUNT(*) as total FROM `competxprograma`");
                    $result = $stmt->fetch();
                    $competxprograma = $result['total'];
                    
                    if ($competxprograma == 0) {
                        echo "<div class='alert alert-danger'>";
                        echo "<strong>❌ Falta configuración crítica</strong><br>";
                        echo "No hay asociaciones de <strong>Competencias por Programa</strong>.<br>";
                        echo "Esto es necesario para crear asignaciones de instructores.";
                        echo "</div>";
                        
                        echo "<div class='alert alert-info'>";
                        echo "<h3>🔧 Solución Rápida</h3>";
                        echo "<p>Puedes crear asociaciones manualmente o importar datos de prueba completos.</p>";
                        echo "</div>";
                        
                        echo "<div class='button-group'>";
                        echo "<a href='index.php?controller=competencia_programa&action=create' class='btn'>Crear Asociación Manual</a>";
                        echo "<a href='http://localhost/phpmyadmin' target='_blank' class='btn btn-secondary'>Importar datos_prueba.sql</a>";
                        echo "</div>";
                    } else {
                        echo "<div class='alert alert-success'>";
                        echo "<strong>✅ Todo configurado correctamente</strong><br>";
                        echo "Tienes <strong>$competxprograma asociaciones</strong> de competencias por programa.<br>";
                        echo "El sistema está listo para usar.";
                        echo "</div>";
                        
                        echo "<div class='button-group'>";
                        echo "<a href='index.php' class='btn'>Ir al Sistema</a>";
                        echo "<a href='auth/login.php' class='btn btn-secondary'>Ir al Login</a>";
                        echo "</div>";
                    }
                }
                
                // Mostrar datos de ejemplo si existen
                if ($totalRegistros > 0) {
                    echo "<hr style='margin: 30px 0;'>";
                    echo "<h2>👥 Datos de Ejemplo</h2>";
                    
                    // Mostrar programas
                    $stmt = $db->query("SELECT * FROM programa LIMIT 5");
                    $programas = $stmt->fetchAll();
                    if (count($programas) > 0) {
                        echo "<h3>Programas</h3>";
                        echo "<table>";
                        echo "<tr><th>Código</th><th>Denominación</th><th>Tipo</th></tr>";
                        foreach ($programas as $prog) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($prog['prog_codigo']) . "</td>";
                            echo "<td>" . htmlspecialchars($prog['prog_denominacion']) . "</td>";
                            echo "<td>" . htmlspecialchars($prog['prog_tipo']) . "</td>";
                            echo "</tr>";
                        }
                        echo "</table>";
                    }
                    
                    // Mostrar competencias
                    $stmt = $db->query("SELECT * FROM competencia LIMIT 5");
                    $competencias = $stmt->fetchAll();
                    if (count($competencias) > 0) {
                        echo "<h3>Competencias</h3>";
                        echo "<table>";
                        echo "<tr><th>ID</th><th>Nombre Corto</th><th>Horas</th></tr>";
                        foreach ($competencias as $comp) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($comp['comp_id']) . "</td>";
                            echo "<td>" . htmlspecialchars($comp['comp_nombre_corto']) . "</td>";
                            echo "<td>" . htmlspecialchars($comp['comp_horas']) . "</td>";
                            echo "</tr>";
                        }
                        echo "</table>";
                    }
                }
                
            } catch (Exception $e) {
                echo "<div class='alert alert-danger'>";
                echo "<strong>❌ Error de conexión</strong><br>";
                echo htmlspecialchars($e->getMessage());
                echo "</div>";
                
                echo "<div class='button-group'>";
                echo "<a href='conectar_bd.php' class='btn'>Verificar Conexión</a>";
                echo "</div>";
            }
            ?>
        </div>
    </div>
</body>
</html>
