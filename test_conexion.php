<?php
// Test de conexión simple
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Test de Conexión</h1>";

// Test 1: Verificar que el archivo conexion.php existe
echo "<h2>1. Verificando archivo conexion.php</h2>";
if (file_exists('conexion.php')) {
    echo "✓ Archivo existe<br>";
    require_once 'conexion.php';
} else {
    die("✗ Archivo conexion.php no encontrado");
}

// Test 2: Verificar constantes
echo "<h2>2. Configuración de Base de Datos</h2>";
echo "Host: " . DB_HOST . "<br>";
echo "Database: " . DB_NAME . "<br>";
echo "User: " . DB_USER . "<br>";
echo "Password: " . (empty(DB_PASS) ? '(vacía)' : '***') . "<br>";

// Test 3: Intentar conectar
echo "<h2>3. Probando Conexión</h2>";
try {
    $db = Database::getInstance();
    $conn = $db->getConnection();
    echo "✓ Conexión exitosa<br>";
    
    // Test 4: Verificar que la tabla usuarios existe
    echo "<h2>4. Verificando tabla usuarios</h2>";
    $stmt = $conn->query("SHOW TABLES LIKE 'usuarios'");
    $result = $stmt->fetch();
    
    if ($result) {
        echo "✓ Tabla 'usuarios' existe<br>";
        
        // Test 5: Contar usuarios
        echo "<h2>5. Contando usuarios</h2>";
        $stmt = $conn->query("SELECT COUNT(*) as total FROM usuarios");
        $count = $stmt->fetch();
        echo "Total de usuarios: " . $count['total'] . "<br>";
        
        // Test 6: Mostrar usuarios
        echo "<h2>6. Usuarios en la base de datos</h2>";
        $stmt = $conn->query("SELECT id, nombre, email, rol, estado FROM usuarios");
        $usuarios = $stmt->fetchAll();
        
        if (count($usuarios) > 0) {
            echo "<table border='1' cellpadding='5'>";
            echo "<tr><th>ID</th><th>Nombre</th><th>Email</th><th>Rol</th><th>Estado</th></tr>";
            foreach ($usuarios as $user) {
                echo "<tr>";
                echo "<td>" . $user['id'] . "</td>";
                echo "<td>" . $user['nombre'] . "</td>";
                echo "<td>" . $user['email'] . "</td>";
                echo "<td>" . $user['rol'] . "</td>";
                echo "<td>" . $user['estado'] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "⚠ No hay usuarios en la base de datos<br>";
        }
        
        // Test 7: Probar login
        echo "<h2>7. Probando autenticación</h2>";
        $email = 'admin@sena.edu.co';
        $password = 'admin123';
        
        $stmt = $conn->prepare("SELECT * FROM usuarios WHERE email = ? AND estado = 'Activo'");
        $stmt->execute([$email]);
        $usuario = $stmt->fetch();
        
        if ($usuario) {
            echo "✓ Usuario encontrado: " . $usuario['nombre'] . "<br>";
            echo "Email: " . $usuario['email'] . "<br>";
            echo "Hash almacenado: " . substr($usuario['password'], 0, 20) . "...<br>";
            
            if (password_verify($password, $usuario['password'])) {
                echo "✓ Contraseña correcta<br>";
                echo "<br><strong style='color: green;'>TODO FUNCIONA CORRECTAMENTE</strong><br>";
                echo "<a href='auth/login.php'>Ir al Login</a>";
            } else {
                echo "✗ Contraseña incorrecta<br>";
                echo "Intentando regenerar hash...<br>";
                $newHash = password_hash($password, PASSWORD_DEFAULT);
                echo "Nuevo hash: " . $newHash . "<br>";
                echo "<br>Ejecuta este SQL en phpMyAdmin:<br>";
                echo "<code>UPDATE usuarios SET password = '$newHash' WHERE email = '$email';</code>";
            }
        } else {
            echo "✗ Usuario no encontrado o inactivo<br>";
        }
        
    } else {
        echo "✗ Tabla 'usuarios' NO existe<br>";
        echo "<br><strong>SOLUCIÓN:</strong> Debes ejecutar el archivo crear_admin.sql en phpMyAdmin<br>";
    }
    
} catch (PDOException $e) {
    echo "✗ Error de conexión: " . $e->getMessage() . "<br>";
    echo "<br><strong>Posibles causas:</strong><br>";
    echo "- MySQL no está iniciado en XAMPP/WAMP<br>";
    echo "- La base de datos 'progsena' no existe<br>";
    echo "- Usuario o contraseña incorrectos<br>";
}
?>
