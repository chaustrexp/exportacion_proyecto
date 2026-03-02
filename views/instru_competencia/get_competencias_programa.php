<?php
require_once __DIR__ . '/../../conexion.php';

header('Content-Type: application/json');

if (!isset($_GET['programa_id']) || empty($_GET['programa_id'])) {
    echo json_encode(['success' => false, 'message' => 'ID de programa no proporcionado']);
    exit;
}

$programa_id = $_GET['programa_id'];

try {
    $db = Database::getInstance()->getConnection();
    
    // Obtener competencias asociadas al programa desde COMPETxPROGRAMA
    $stmt = $db->prepare("
        SELECT c.comp_id, c.comp_nombre_corto, c.comp_nombre_unidad_competencia
        FROM COMPETENCIA c
        INNER JOIN COMPETxPROGRAMA cp ON c.comp_id = cp.COMPETENCIA_comp_id
        WHERE cp.PROGRAMA_prog_id = ?
        ORDER BY c.comp_nombre_corto
    ");
    
    $stmt->execute([$programa_id]);
    $competencias = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode([
        'success' => true,
        'competencias' => $competencias
    ]);
    
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error al obtener competencias: ' . $e->getMessage()
    ]);
}
?>
