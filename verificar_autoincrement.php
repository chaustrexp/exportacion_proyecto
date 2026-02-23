<?php
/**
 * Script para verificar si las tablas tienen AUTO_INCREMENT configurado
 * Ejecutar en: http://localhost/exportacion_proyecto/verificar_autoincrement.php
 */

require_once 'conexion.php';

header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificar AUTO_INCREMENT</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            max-width: 1200px;
            margin: 40px auto;
            padding: 20px;
            background: #f5f5f5;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h1 {
            color: #39A900;
            border-bottom: 3px solid #39A900;
            padding-bottom: 10px;
        }
        h2 {
            color: #333;
            margin-top: 30px;
        }
        .info {
            background: #e3f2fd;
            padding: 15px;
            border-left: 4px solid #2196F3;
            margin: 20px 0;
        }
        .success {
            background: #e8f5e9;
            padding: 15px;
            border-left: 4px solid #4caf50;
            margin: 10px 0;
        }
        .error {
            background: #ffebee;
            padding: 15px;
            border-left: 4px solid #f44336;
            margin: 10px 0;
        }
        .warning {
            background: #fff3e0;
            padding: 15px;
            border-left: 4px solid #ff9800;
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
            background: #39A900;
            color: white;
        }
        tr:hover {
            background: #f5f5f5;
        }
        .badge {
            padding: 5px 10px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: bold;
        }
        .badge-success {
            background: #4caf50;
            color: white;
        }
        .badge-error {
            background: #f44336;
            color: white;
        }
        code {
            background: #f5f5f5;
            padding: 2px 6px;
            border-radius: 3px;
            font-family: 'Courier New', monospace;
        }
        .sql-box {
            background: #263238;
            color: #aed581;
            padding: 20px;
            border-radius: 5px;
            overflow-x: auto;
            margin: 20px 0;
        }
        .sql-box pre {
            margin: 0;
            font-family: 'Courier New', monospace;
        }
        .btn {
            display: inline-block;
            padding: 12px 24px;
            background: #39A900;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 10px 5px;
        }
        .btn:hover {
            background: #2d8000;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔍 Verificación de AUTO_INCREMENT</h1>
        
        <div class="info">
            <strong>Base de datos conectada:</strong> <code><?php echo DB_NAME; ?></code><br>
            <strong>Host:</strong> <code><?php echo DB_HOST; ?></code><br>
            <strong>Usuario:</strong> <code><?php echo DB_USER; ?></code>
        </div>

        <?php
        try {
            $db = Database::getInstance()->getConnection();
            
            // Tablas a verificar
            $tablas = [
                'titulo_programa' => 'titpro_id',
                'programa' => 'prog_codigo',
                'competencia' => 'comp_id',
                'centro_formacion' => 'cent_id',
                'instructor' => 'inst_id',
                'coordinacion' => 'coord_id',
                'ficha' => 'fich_id',
                'sede' => 'sede_id',
                'asignacion' => 'asig_id',
                'detallexasignacion' => 'detasig_id'
            ];
            
            echo "<h2>📊 Estado de las Tablas</h2>";
            echo "<table>";
            echo "<tr><th>Tabla</th><th>Campo PK</th><th>AUTO_INCREMENT</th><th>Estado</th></tr>";
            
            $tablas_sin_autoincrement = [];
            
            foreach ($tablas as $tabla => $campo_pk) {
                $stmt = $db->query("SHOW CREATE TABLE `{$tabla}`");
                $result = $stmt->fetch();
                $create_table = $result['Create Table'];
                
                // Verificar si tiene AUTO_INCREMENT
                $tiene_autoincrement = (stripos($create_table, 'AUTO_INCREMENT') !== false);
                
                echo "<tr>";
                echo "<td><strong>{$tabla}</strong></td>";
                echo "<td><code>{$campo_pk}</code></td>";
                
                if ($tiene_autoincrement) {
                    echo "<td><span class='badge badge-success'>✓ SÍ</span></td>";
                    echo "<td style='color: #4caf50;'>Correcto</td>";
                } else {
                    echo "<td><span class='badge badge-error'>✗ NO</span></td>";
                    echo "<td style='color: #f44336;'>Necesita corrección</td>";
                    $tablas_sin_autoincrement[] = ['tabla' => $tabla, 'campo' => $campo_pk];
                }
                echo "</tr>";
            }
            
            echo "</table>";
            
            // Mostrar resumen
            if (empty($tablas_sin_autoincrement)) {
                echo "<div class='success'>";
                echo "<strong>✓ ¡Perfecto!</strong> Todas las tablas tienen AUTO_INCREMENT configurado correctamente.";
                echo "</div>";
            } else {
                echo "<div class='error'>";
                echo "<strong>✗ Problema encontrado:</strong> " . count($tablas_sin_autoincrement) . " tabla(s) sin AUTO_INCREMENT.";
                echo "</div>";
                
                echo "<h2>🔧 Solución: Ejecutar este SQL</h2>";
                echo "<div class='warning'>";
                echo "<strong>Instrucciones:</strong><br>";
                echo "1. Copia el código SQL de abajo<br>";
                echo "2. Abre phpMyAdmin: <a href='http://localhost/phpmyadmin' target='_blank'>http://localhost/phpmyadmin</a><br>";
                echo "3. Selecciona la base de datos <code>progsena</code><br>";
                echo "4. Ve a la pestaña 'SQL'<br>";
                echo "5. Pega el código y haz clic en 'Continuar'";
                echo "</div>";
                
                echo "<div class='sql-box'><pre>";
                echo "USE progsena;\n\n";
                foreach ($tablas_sin_autoincrement as $tabla_info) {
                    echo "ALTER TABLE `{$tabla_info['tabla']}` \n";
                    echo "MODIFY COLUMN `{$tabla_info['campo']}` INT NOT NULL AUTO_INCREMENT;\n\n";
                }
                echo "-- Verificar cambios\n";
                foreach ($tablas_sin_autoincrement as $tabla_info) {
                    echo "SHOW CREATE TABLE `{$tabla_info['tabla']}`;\n";
                }
                echo "</pre></div>";
                
                echo "<a href='http://localhost/phpmyadmin' target='_blank' class='btn'>Abrir phpMyAdmin</a>";
                echo "<a href='verificar_autoincrement.php' class='btn'>Verificar de Nuevo</a>";
            }
            
        } catch (Exception $e) {
            echo "<div class='error'>";
            echo "<strong>Error:</strong> " . $e->getMessage();
            echo "</div>";
        }
        ?>
        
        <h2>📝 Información Adicional</h2>
        <div class="info">
            <strong>¿Por qué es necesario AUTO_INCREMENT?</strong><br>
            Sin AUTO_INCREMENT, MySQL intenta insertar 0 como valor predeterminado en el campo PRIMARY KEY, 
            causando el error "Duplicate entry '0' for key 'PRIMARY'" cuando intentas crear un segundo registro.
            <br><br>
            <strong>¿Qué hace AUTO_INCREMENT?</strong><br>
            Genera automáticamente un número único e incremental para cada nuevo registro, 
            sin necesidad de especificarlo manualmente en el INSERT.
        </div>
        
        <div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #ddd; text-align: center; color: #666;">
            <a href="index.php" class="btn">← Volver al Sistema</a>
        </div>
    </div>
</body>
</html>
