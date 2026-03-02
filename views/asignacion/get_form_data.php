<?php
require_once __DIR__ . '/../../auth/check_auth.php';
require_once __DIR__ . '/../../model/FichaModel.php';
require_once __DIR__ . '/../../model/InstructorModel.php';
require_once __DIR__ . '/../../model/AmbienteModel.php';
require_once __DIR__ . '/../../model/CompetenciaModel.php';

header('Content-Type: application/json');

try {
    $fichaModel = new FichaModel();
    $instructorModel = new InstructorModel();
    $ambienteModel = new AmbienteModel();
    $competenciaModel = new CompetenciaModel();

    $fichas = $fichaModel->getAll();
    $instructores = $instructorModel->getAll();
    $ambientes = $ambienteModel->getAll();
    $competencias = $competenciaModel->getAll();

    // Formatear datos para el frontend
    $response = [
        'fichas' => array_map(function($f) {
            return [
                'id' => $f['fich_id'] ?? $f['id'],
                'numero' => $f['fich_id'] ?? $f['numero'] ?? 'N/A'
            ];
        }, $fichas),
        'instructores' => array_map(function($i) {
            return [
                'id' => $i['inst_id'] ?? $i['id'],
                'nombre' => ($i['inst_nombres'] ?? '') . ' ' . ($i['inst_apellidos'] ?? '')
            ];
        }, $instructores),
        'ambientes' => array_map(function($a) {
            return [
                'id' => $a['amb_id'] ?? $a['id'],
                'nombre' => $a['amb_nombre'] ?? $a['nombre'] ?? 'N/A'
            ];
        }, $ambientes),
        'competencias' => array_map(function($c) {
            return [
                'id' => $c['comp_id'] ?? $c['id'],
                'nombre' => $c['comp_nombre_corto'] ?? $c['nombre'] ?? 'N/A'
            ];
        }, $competencias)
    ];

    echo json_encode($response);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Error al cargar los datos: ' . $e->getMessage()]);
}
?>
