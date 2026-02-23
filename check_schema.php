<?php
require_once 'conexion.php';
$output = "";
try {
    $db = Database::getInstance()->getConnection();
    foreach (['coordinacion', 'ficha'] as $table) {
        $stmt = $db->query("DESCRIBE $table");
        $columns = $stmt->fetchAll();
        $output .= "\nTable: $table\n";
        foreach ($columns as $col) {
            $output .= "  - " . $col['Field'] . "\n";
        }
    }
    file_put_contents('schema_output.txt', $output);
    echo "Schema saved to schema_output.txt\n";
} catch (Exception $e) {
    file_put_contents('schema_output.txt', "Error: " . $e->getMessage());
    echo "Error occurred. Check schema_output.txt\n";
}
?>
