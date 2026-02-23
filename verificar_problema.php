<?php
require_once 'conexion.php';
header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Diagnóstico del Problema</title>
    <style>
        body { font-family: Arial; max-width: 1000px; margin: 20px auto; padding: 20px; }
        .error { background: #ffebee; padding: 15px; border-left: 4px solid #f44336; margin: 10px 0; }
        .success { background: #e8f5e9; padding: 15px; border-left: 4px solid #4caf50; margin: 10px 0; }
        .warning { background: #fff3e0; padding: 15px; border-left: 4px solid #ff9800; margin: 10px 0; }
        .code { background: #263238; color: #aed581; padding: 15px; border-radius: 5px; overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        th, td { padding: 10px; text-align: left; border: 1px solid #ddd; }
        th { background: #39A900; color: white; }
        h2 { color: #39A900; border-bottom: 2px solid #39A900; padding-bottom: 5px; }
    </style>
</head>
<body>
    <h1>🔍 Diagnóstico del Problema</h1>
    
    <?php
    try {
        $db = Database::getInstance()->getConnection();
        
        echo "<h2>1. Verificar Estructura de la Tabla PROGRAMA</h2>";
        
        $stmt = $db->query("SHOW CREATE TABLE programa");
        $result = $stmt->fetch();
        $create_table = $result['Create Table'];
        
        echo "<div class='code'><pre>" . htmlspecialchars($create_table) . "</pre></div>";
        
        if (stripos($create_table, 'AUTO_INCREMENT') !== false) {
            echo "<div class='success'>✓ La tabla programa SÍ tiene AUTO_INCREMENT</div>";
        } else {
            echo "<div class='error'>✗ La tabla programa NO tiene AUTO_INCREMENT - ESTE ES EL PROBLEMA</div>";
            echo "<div class='warning'><strong>SOLUCIÓN:</strong> Ejecuta este comando en phpMyAdmin:</div>";
            echo "<div class='code'><pre>ALTER TABLE `programa` MODIFY COLUMN `prog_codigo` INT NOT NULL AUTO_INCREMENT;</pre></div>";
        }
        
        echo "<h2>2. Verificar Registros Existentes</h2>";
        
        $stmt = $db->query("SELECT * FROM programa ORDER BY prog_codigo");
        $programas = $stmt->fetchAll();
        
        if (empty($programas)) {
            echo "<div class='warning'>No hay programas registrados todavía</div>";
        } else {
            echo "<table>";
            echo "<tr><th>prog_codigo</th><th>prog_denominacion</th><th>titulo_programa_titpro_id</th><th>prog_tipo</th></tr>";
            foreach ($programas as $prog) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($prog['prog_codigo']) . "</td>";
                echo "<td>" . htmlspecialchars($prog['prog_denominacion']) . "</td>";
                echo "<td>" . htmlspecialchars($prog['titulo_programa_titpro_id']) . "</td>";
                echo "<td>" . htmlspecialchars($prog['prog_tipo']) . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        }
        
        echo "<h2>3. Probar INSERT Manual</h2>";
        
        // Obtener un titulo_programa válido
        $stmt = $db->query("SELECT titpro_id FROM titulo_programa LIMIT 1");
        $titulo = $stmt->fetch();
        
        if ($titulo) {
            echo "<div class='warning'>Intentando insertar un programa de prueba...</div>";
            
            try {
                $stmt = $db->prepare("INSERT INTO programa (prog_denominacion, titulo_programa_titpro_id, prog_tipo) VALUES (?, ?, ?)");
                $stmt->execute(['PRUEBA AUTO INCREMENT', $titulo['titpro_id'], 'Tecnólogo']);
                
                $nuevo_id = $db->lastInsertId();
                
                echo "<div class='success'>✓ INSERT exitoso! Nuevo ID generado: " . $nuevo_id . "</div>";
                
                // Eliminar el registro de prueba
                $stmt = $db->prepare("DELETE FROM programa WHERE prog_codigo = ?");
                $stmt->execute([$nuevo_id]);
                
                echo "<div class='success'>✓ Registro de prueba eliminado. La tabla funciona correctamente.</div>";
                
            } catch (Exception $e) {
                echo "<div class='error'>✗ ERROR al insertar: " . htmlspecialchars($e->getMessage()) . "</div>";
                
                if (strpos($e->getMessage(), 'Duplicate entry') !== false) {
                    echo "<div class='error'><strong>CONFIRMADO:</strong> El problema es que NO hay AUTO_INCREMENT</div>";
                    echo "<div class='warning'><strong>SOLUCIÓN INMEDIATA:</strong></div>";
                    echo "<div class='code'><pre>ALTER TABLE `programa` MODIFY COLUMN `prog_codigo` INT NOT NULL AUTO_INCREMENT;</pre></div>";
                }
            }
        }
        
        echo "<h2>4. Verificar Otras Tablas</h2>";
        
        $tablas = ['titulo_programa', 'competencia', 'centro_formacion', 'instructor', 'coordinacion', 'ficha', 'sede'];
        
        echo "<table>";
        echo "<tr><th>Tabla</th><th>AUTO_INCREMENT</th></tr>";
        
        foreach ($tablas as $tabla) {
            $stmt = $db->query("SHOW CREATE TABLE `{$tabla}`");
            $result = $stmt->fetch();
            $create = $result['Create Table'];
            
            $tiene_auto = (stripos($create, 'AUTO_INCREMENT') !== false);
            
            echo "<tr>";
            echo "<td><strong>{$tabla}</strong></td>";
            if ($tiene_auto) {
                echo "<td style='color: green;'>✓ SÍ</td>";
            } else {
                echo "<td style='color: red;'>✗ NO</td>";
            }
            echo "</tr>";
        }
        
        echo "</table>";
        
    } catch (Exception $e) {
        echo "<div class='error'>Error: " . htmlspecialchars($e->getMessage()) . "</div>";
    }
    ?>
    
    <h2>5. Comandos SQL para Copiar y Pegar</h2>
    
    <p>Si alguna tabla NO tiene AUTO_INCREMENT, copia estos comandos en phpMyAdmin:</p>
    
    <div class='code'><pre>USE progsena;

ALTER TABLE `titulo_programa` MODIFY COLUMN `titpro_id` INT NOT NULL AUTO_INCREMENT;
ALTER TABLE `programa` MODIFY COLUMN `prog_codigo` INT NOT NULL AUTO_INCREMENT;
ALTER TABLE `competencia` MODIFY COLUMN `comp_id` INT NOT NULL AUTO_INCREMENT;
ALTER TABLE `centro_formacion` MODIFY COLUMN `cent_id` INT NOT NULL AUTO_INCREMENT;
ALTER TABLE `instructor` MODIFY COLUMN `inst_id` INT NOT NULL AUTO_INCREMENT;
ALTER TABLE `coordinacion` MODIFY COLUMN `coord_id` INT NOT NULL AUTO_INCREMENT;
ALTER TABLE `ficha` MODIFY COLUMN `fich_id` INT NOT NULL AUTO_INCREMENT;
ALTER TABLE `sede` MODIFY COLUMN `sede_id` INT NOT NULL AUTO_INCREMENT;</pre></div>
    
    <p><a href="http://localhost/phpmyadmin" target="_blank" style="display: inline-block; padding: 10px 20px; background: #39A900; color: white; text-decoration: none; border-radius: 5px;">Abrir phpMyAdmin</a></p>
    
    <p><a href="verificar_problema.php" style="display: inline-block; padding: 10px 20px; background: #2196F3; color: white; text-decoration: none; border-radius: 5px;">Verificar de Nuevo</a></p>
    
</body>
</html>
