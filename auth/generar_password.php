<?php
// Script para generar contraseñas encriptadas
$password = 'admin123';
$hash = password_hash($password, PASSWORD_DEFAULT);

echo "Contraseña: $password\n";
echo "Hash: $hash\n";
?>
