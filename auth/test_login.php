<?php
// Script de prueba para verificar login
require_once __DIR__ . '/../conexion.php';

$email = 'admin@sena.edu.co';
$password = 'admin123';

echo "=== TEST DE LOGIN ===\n\n";
echo "Email: $email\n";
echo "Password: $password\n\n";

try {
    $db = Database::getInstance()->getConnection();
    $stmt = $db->prepare("SELECT * FROM usuarios WHERE email = ?");
    $stmt->execute([$email]);
    $usuario = $stmt->fetch();
    
    if ($usuario) {
        echo "✓ Usuario encontrado\n";
        echo "  Nombre: {$usuario['nombre']}\n";
        echo "  Rol: {$usuario['rol']}\n";
        echo "  Estado: {$usuario['estado']}\n";
        echo "  Password Hash: " . substr($usuario['password'], 0, 30) . "...\n\n";
        
        if (password_verify($password, $usuario['password'])) {
            echo "✓ CONTRASEÑA CORRECTA - LOGIN EXITOSO!\n";
        } else {
            echo "✗ CONTRASEÑA INCORRECTA\n";
        }
    } else {
        echo "✗ Usuario no encontrado\n";
    }
} catch (PDOException $e) {
    echo "✗ Error: " . $e->getMessage() . "\n";
}
?>
