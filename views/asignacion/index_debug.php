<?php
// Activar errores para debug
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Debug de Asignaciones</h1><pre>";

try {
    echo "1. Cargando auth...\n";
    require_once __DIR__ . '/../../auth/check_auth.php';
    echo "   ✓ Auth cargado\n\n";
    
    echo "2. Cargando modelos...\n";
    require_once __DIR__ . '/../../model/AsignacionModel.php';
    require_once __DIR__ . '/../../model/FichaModel.php';
    require_once __DIR__ . '/../../model/InstructorModel.php';
    require_once __DIR__ . '/../../model/AmbienteModel.php';
    require_once __DIR__ . '/../../model/CompetenciaModel.php';
    echo "   ✓ Modelos cargados\n\n";
    
    echo "3. Instanciando modelos...\n";
    $model = new AsignacionModel();
    $fichaModel = new FichaModel();
    $instructorModel = new InstructorModel();
    $ambienteModel = new AmbienteModel();
    $competenciaModel = new CompetenciaModel();
    echo "   ✓ Modelos instanciados\n\n";
    
    echo "4. Obteniendo registros...\n";
    $registros = $model->getAll();
    echo "   ✓ Registros obtenidos: " . count($registros) . "\n\n";
    
    echo "5. Obteniendo fichas...\n";
    $fichas = $fichaModel->getAll();
    echo "   ✓ Fichas obtenidas: " . count($fichas) . "\n\n";
    
    echo "6. Obteniendo instructores...\n";
    $instructores = $instructorModel->getAll();
    echo "   ✓ Instructores obtenidos: " . count($instructores) . "\n\n";
    
    echo "7. Obteniendo ambientes...\n";
    $ambientes = $ambienteModel->getAll();
    echo "   ✓ Ambientes obtenidos: " . count($ambientes) . "\n\n";
    
    echo "8. Obteniendo competencias...\n";
    $competencias = $competenciaModel->getAll();
    echo "   ✓ Competencias obtenidas: " . count($competencias) . "\n\n";
    
    echo "9. Definiendo pageTitle...\n";
    $pageTitle = "Gestión de Asignaciones";
    echo "   ✓ pageTitle: $pageTitle\n\n";
    
    echo "10. Cargando header...\n";
    include __DIR__ . '/../layout/header.php';
    echo "   ✓ Header cargado\n\n";
    
    echo "11. Cargando sidebar...\n";
    include __DIR__ . '/../layout/sidebar.php';
    echo "   ✓ Sidebar cargado\n\n";
    
    echo "=== TODO FUNCIONÓ CORRECTAMENTE ===\n";
    echo "El problema debe estar en otra parte del archivo index.php\n";
    
} catch (Exception $e) {
    echo "\n✗ ERROR EN LÍNEA " . $e->getLine() . ":\n";
    echo "Archivo: " . $e->getFile() . "\n";
    echo "Mensaje: " . $e->getMessage() . "\n\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}

echo "</pre>";
?>
