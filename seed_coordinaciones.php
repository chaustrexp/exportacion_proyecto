<?php
/**
 * Script temporal para poblar la tabla coordinacion con datos reales del SENA.
 * Borrar este archivo después de ejecutarlo.
 */
require_once __DIR__ . '/conexion.php';

$db = Database::getInstance()->getConnection();

// --- 1. Obtener centros de formación disponibles ---
$stmtCentros = $db->query("SELECT cent_id, cent_nombre FROM centro_formacion ORDER BY cent_id LIMIT 1");
$centros = $stmtCentros->fetchAll(PDO::FETCH_ASSOC);

if (empty($centros)) {
    die('<p style="color:red;">❌ No hay registros en centro_formacion. Crea al menos uno primero.</p>');
}

$cent_id = $centros[0]['cent_id'];
$cent_nombre = $centros[0]['cent_nombre'];

// --- 2. Verificar coordinaciones con fichas asociadas ---
$stmtUsadas = $db->query("SELECT DISTINCT coordinacion_coord_id FROM ficha");
$coordUsadas = $stmtUsadas->fetchAll(PDO::FETCH_COLUMN);

echo "<h3>Centro de Formación usado: [{$cent_id}] {$cent_nombre}</h3>";

// --- 3. Eliminar solo las coordinaciones sin fichas asociadas ---
if (!empty($coordUsadas)) {
    $placeholders = implode(',', array_fill(0, count($coordUsadas), '?'));
    $stmtDel = $db->prepare("DELETE FROM coordinacion WHERE coord_id NOT IN ({$placeholders})");
    $stmtDel->execute($coordUsadas);
    echo "<p>⚠️ Se conservaron " . count($coordUsadas) . " coordinaciones con fichas asociadas.</p>";
} else {
    $db->exec("DELETE FROM coordinacion");
    echo "<p>✅ Tabla coordinacion vaciada.</p>";
}

// --- 4. Insertar nuevas coordinaciones SENA ---
$coordinaciones = [
    // Dependencias Nacionales
    'Dirección de Formación Profesional',
    'Dirección del Sistema Nacional de Formación para el Trabajo (SNFT)',
    'Dirección de Empleo y Trabajo',
    'Dirección de Promoción y Relaciones Corporativas',
    'Secretaría General',
    'Dirección Administrativa y Financiera',
    // Por Centro de Formación
    'Coordinación Académica',
    'Coordinación de Formación',
    'Coordinación de Relaciones Corporativas',
];

$stmt = $db->prepare("INSERT INTO coordinacion (coord_nombre, centro_formacion_cent_id) VALUES (?, ?)");

foreach ($coordinaciones as $nombre) {
    $stmt->execute([$nombre, $cent_id]);
    $id = $db->lastInsertId();
    echo "<p>✅ Insertada: [{$id}] {$nombre}</p>";
}

// --- 5. Mostrar resultado final ---
$stmtAll = $db->query("SELECT coord_id, coord_nombre FROM coordinacion ORDER BY coord_id");
$todas = $stmtAll->fetchAll(PDO::FETCH_ASSOC);
echo "<h3>Coordinaciones en base de datos:</h3><table border='1' cellpadding='6'><tr><th>ID</th><th>Nombre</th></tr>";
foreach ($todas as $c) {
    echo "<tr><td>{$c['coord_id']}</td><td>{$c['coord_nombre']}</td></tr>";
}
echo "</table><br><p style='color:orange;'><strong>⚠️ Elimina el archivo seed_coordinaciones.php del servidor después de verificar.</strong></p>";
