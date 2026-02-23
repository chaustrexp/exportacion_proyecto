<?php
// Limpiar caché de PHP
if (function_exists('opcache_reset')) {
    opcache_reset();
    echo "✓ Caché de OPcache limpiado<br>";
} else {
    echo "✗ OPcache no está habilitado<br>";
}

if (function_exists('apc_clear_cache')) {
    apc_clear_cache();
    echo "✓ Caché de APC limpiado<br>";
} else {
    echo "✗ APC no está habilitado<br>";
}

echo "<br><strong>Caché limpiado. Ahora recarga la página de programas.</strong><br>";
echo "<a href='programa/index'>Ir a Programas</a>";
?>
