<?php
// No requerir autenticación para AJAX
// require_once __DIR__ . '/../../auth/check_auth.php';
require_once __DIR__ . '/../../conexion.php';
require_once __DIR__ . '/../../model/AsignacionModel.php';

header('Content-Type: application/json');

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if (!$id) {
    http_response_code(400);
    echo json_encode([
        'error' => 'ID no proporcionado',
        'debug' => [
            'get_params' => $_GET,
            'id_received' => $id
        ]
    ]);
    exit;
}

try {
    $model = new AsignacionModel();
    $asignacion = $model->getById($id);

    if (!$asignacion || empty($asignacion)) {
        http_response_code(404);
        echo json_encode([
            'error' => 'Asignación no encontrada',
            'debug' => [
                'id_buscado' => $id,
                'resultado' => $asignacion
            ]
        ]);
        exit;
    }

    // Formatear datos para el frontend
    $response = [
        'id' => $asignacion['asig_id'] ?? $asignacion['ASIG_ID'] ?? $id,
        'ficha_numero' => $asignacion['ficha_numero'] ?? 'N/A',
        'instructor_nombre' => $asignacion['instructor_nombre'] ?? 'N/A',
        'ambiente_nombre' => $asignacion['ambiente_nombre'] ?? 'No disponible',
        'competencia_nombre' => $asignacion['competencia_nombre'] ?? 'No disponible',
        'fecha_inicio' => $asignacion['fecha_inicio'] ?? $asignacion['asig_fecha_inicio'] ?? date('Y-m-d'),
        'fecha_fin' => $asignacion['fecha_fin'] ?? $asignacion['asig_fecha_fin'] ?? date('Y-m-d'),
    ];

    // Formatear fechas
    $fecha_inicio_str = $response['fecha_inicio'];
    $fecha_fin_str = $response['fecha_fin'];
    
    $response['fecha_inicio_formatted'] = date('d/m/Y', strtotime($fecha_inicio_str));
    $response['fecha_fin_formatted'] = date('d/m/Y', strtotime($fecha_fin_str));
    
    // Extraer horas de los campos datetime
    $fecha_ini_completa = $asignacion['asig_fecha_ini'] ?? $asignacion['ASIG_FECHA_INI'] ?? date('Y-m-d H:i:s');
    $fecha_fin_completa = $asignacion['asig_fecha_fin'] ?? $asignacion['ASIG_FECHA_FIN'] ?? date('Y-m-d H:i:s');
    
    $response['hora_inicio'] = date('H:i', strtotime($fecha_ini_completa));
    $response['hora_fin'] = date('H:i', strtotime($fecha_fin_completa));

    // Calcular estado
    $hoy = date('Y-m-d');
    $fecha_inicio = $response['fecha_inicio'];
    $fecha_fin = $response['fecha_fin'];

    if ($fecha_fin && $fecha_fin < $hoy) {
        $response['estado'] = 'Finalizada';
        $response['estado_color'] = '#DC2626';
        $response['estado_bg'] = '#FEE2E2';
    } elseif ($fecha_inicio && $fecha_inicio > $hoy) {
        $response['estado'] = 'Pendiente';
        $response['estado_color'] = '#D97706';
        $response['estado_bg'] = '#FEF3C7';
    } else {
        $response['estado'] = 'Activa';
        $response['estado_color'] = '#39A900';
        $response['estado_bg'] = '#E8F5E8';
    }

    echo json_encode($response);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Error al cargar la asignación: ' . $e->getMessage()]);
}
?>
