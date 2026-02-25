<?php
// Script de prueba para verificar login de instructor
require_once __DIR__ . '/../conexion.php';

echo "<h2>Test de Login - Instructor</h2>";

$email = 'joselop@sena.edu.co';
$password = 'instructor123';

try {
    $db = Database::getInstance()->getConnection();
    
    // 1. Verificar que la tabla usuarios existe
    echo "<h3>1. Verificando tabla usuarios...</h3>";
    $stmt = $db->query("SHOW TABLES LIKE 'usuarios'");
    $tableExists = $stmt->fetch();
    
    if (!$tableExists) {
        echo "❌ La tabla 'usuarios' NO existe<br>";
        exit;
    }
    echo "✅ La tabla 'usuarios' existe<br>";
    
    // 2. Buscar el usuario
    echo "<h3>2. Buscando usuario: $email</h3>";
    $stmt = $db->prepare("SELECT * FROM usuarios WHERE email = ?");
    $stmt->execute([$email]);
    $usuario = $stmt->fetch();
    
    if (!$usuario) {
        echo "❌ Usuario NO encontrado<br>";
        echo "<p>Ejecuta este SQL en phpMyAdmin:</p>";
        echo "<pre>";
        echo "INSERT INTO usuarios (nombre, email, password, rol, instructor_id, estado)\n";
        echo "VALUES ('Jose Lopez', 'joselop@sena.edu.co', '\$2y\$10\$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Instructor', 2, 'Activo');";
        echo "</pre>";
        exit;
    }
    
    echo "✅ Usuario encontrado<br>";
    echo "<pre>";
    print_r([
        'id' => $usuario['id'],
        'nombre' => $usuario['nombre'],
        'email' => $usuario['email'],
        'rol' => $usuario['rol'],
        'estado' => $usuario['estado'],
        'instructor_id' => $usuario['instructor_id']
    ]);
    echo "</pre>";
    
    // 3. Verificar estado
    echo "<h3>3. Verificando estado...</h3>";
    if ($usuario['estado'] !== 'Activo') {
        echo "❌ Usuario está INACTIVO (estado: {$usuario['estado']})<br>";
        echo "<p>Ejecuta este SQL para activarlo:</p>";
        echo "<pre>UPDATE usuarios SET estado = 'Activo' WHERE email = '$email';</pre>";
        exit;
    }
    echo "✅ Usuario está ACTIVO<br>";
    
    // 4. Verificar contraseña
    echo "<h3>4. Verificando contraseña...</h3>";
    echo "Password ingresado: $password<br>";
    echo "Hash en BD: {$usuario['password']}<br>";
    
    if (password_verify($password, $usuario['password'])) {
        echo "✅ Contraseña CORRECTA<br>";
    } else {
        echo "❌ Contraseña INCORRECTA<br>";
        echo "<p>Genera un nuevo hash:</p>";
        $newHash = password_hash($password, PASSWORD_DEFAULT);
        echo "<pre>";
        echo "UPDATE usuarios SET password = '$newHash' WHERE email = '$email';";
        echo "</pre>";
        exit;
    }
    
    // 5. Verificar instructor_id
    echo "<h3>5. Verificando instructor_id...</h3>";
    if (empty($usuario['instructor_id'])) {
        echo "⚠️ instructor_id está vacío<br>";
    } else {
        echo "✅ instructor_id: {$usuario['instructor_id']}<br>";
        
        // Verificar que el instructor existe
        $stmt = $db->prepare("SELECT * FROM instructor WHERE inst_id = ?");
        $stmt->execute([$usuario['instructor_id']]);
        $instructor = $stmt->fetch();
        
        if ($instructor) {
            echo "✅ Instructor existe en la tabla instructor<br>";
            echo "<pre>";
            print_r([
                'inst_id' => $instructor['inst_id'],
                'inst_nombres' => $instructor['inst_nombres'],
                'inst_apellidos' => $instructor['inst_apellidos']
            ]);
            echo "</pre>";
        } else {
            echo "❌ Instructor NO existe en la tabla instructor<br>";
        }
    }
    
    // 6. Verificar asignaciones
    echo "<h3>6. Verificando asignaciones...</h3>";
    $stmt = $db->prepare("SELECT COUNT(*) as total FROM asignacion WHERE instructor_inst_id = ?");
    $stmt->execute([$usuario['instructor_id']]);
    $result = $stmt->fetch();
    echo "Total de asignaciones: {$result['total']}<br>";
    
    if ($result['total'] == 0) {
        echo "⚠️ No hay asignaciones para este instructor<br>";
    }
    
    echo "<hr>";
    echo "<h2>✅ RESUMEN</h2>";
    echo "<p><strong>El usuario puede iniciar sesión correctamente</strong></p>";
    echo "<p>Credenciales:</p>";
    echo "<ul>";
    echo "<li>Email: $email</li>";
    echo "<li>Password: $password</li>";
    echo "</ul>";
    
} catch (PDOException $e) {
    echo "❌ Error de conexión: " . $e->getMessage();
}
?>
