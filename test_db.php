<?php
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/conexion.php';

try {
    $db = Database::getInstance()->getConnection();
    echo "SUCCESS: Connected to the database successfully.\n";
    
    // Check tables
    $stmt = $db->query("SHOW TABLES");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    if (empty($tables)) {
        echo "WARNING: Connection successful, but no tables found in the database.\n";
    } else {
        echo "INFO: Found " . count($tables) . " tables: " . implode(", ", $tables) . "\n";
        
        // Check if important tables exist
        $required = ['asignacion', 'ficha', 'instructor'];
        foreach ($required as $table) {
            if (in_array($table, $tables)) {
                $count_stmt = $db->query("SELECT COUNT(*) FROM `$table` ");
                $count = $count_stmt->fetchColumn();
                echo "INFO: Table '$table' exists with $count records.\n";
            } else {
                echo "ERROR: Table '$table' is MISSING.\n";
            }
        }
    }
} catch (Exception $e) {
    echo "FAILURE: Could not connect to the database.\n";
    echo "ERROR MESSAGE: " . $e->getMessage() . "\n";
}
?>
