<?php
// Mock server variables for CLI
$_SERVER['SERVER_NAME'] = 'localhost';

require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/conexion.php';
require_once __DIR__ . '/controller/AmbienteController.php';

// Mock session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

class TestAmbienteController extends AmbienteController {
    public function __construct() {
        parent::__construct();
    }
    
    // Override redirect to avoid actual redirection during test
    public function redirect($url, $statusCode = 302) {
        echo "REDIRECTED TO: $url (Status: $statusCode)\n";
    }
}

try {
    $db = Database::getInstance()->getConnection();
    
    // 1. Create a temporary environment to test with
    $test_code = "TEST_CODE_" . time();
    $db->exec("INSERT INTO ambiente (amb_id, amb_nombre, sede_id) VALUES ('$test_code', 'Ambiente de Prueba', '1')");
    echo "STEP 1: Created test environment with code: $test_code\n";
    
    // 2. Mock POST data for a duplicate entry
    $_POST = [
        'codigo' => $test_code,
        'nombre' => 'Duplicate Name',
        'sede_id' => '1'
    ];
    $_SERVER['REQUEST_METHOD'] = 'POST';
    
    $controller = new TestAmbienteController();
    
    echo "STEP 2: Attempting to store duplicate environment...\n";
    $controller->store();
    
    // 3. Verify that the error was caught and stored in session
    if (isset($_SESSION['error']) && strpos($_SESSION['error'], $test_code) !== false) {
        echo "SUCCESS: Duplicate entry caught correctly. Error: " . $_SESSION['error'] . "\n";
    } else {
        echo "FAILURE: Duplicate entry was NOT caught or error message is incorrect.\n";
        echo "Session error: " . ($_SESSION['error'] ?? 'NONE') . "\n";
    }
    
    // Cleanup
    $db->exec("DELETE FROM ambiente WHERE amb_id = '$test_code'");
    echo "STEP 3: Cleaned up test record.\n";
    
} catch (Exception $e) {
    echo "ERROR during test: " . $e->getMessage() . "\n";
}
?>
