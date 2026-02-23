<?php
/**
 * API de Notificaciones
 * Gestiona las notificaciones del usuario
 */

header('Content-Type: application/json');
require_once __DIR__ . '/../auth/check_auth.php';
require_once __DIR__ . '/../conexion.php';

$userId = $_SESSION['usuario_id'];
$method = $_SERVER['REQUEST_METHOD'];

// GET: Obtener notificaciones
if ($method === 'GET') {
    try {
        // Verificar si existe la tabla de notificaciones
        $tableCheck = $conn->query("SHOW TABLES LIKE 'notificaciones'");
        
        if ($tableCheck->num_rows === 0) {
            // Si no existe la tabla, devolver notificaciones de ejemplo
            echo json_encode(getMockNotifications());
            exit;
        }
        
        // Obtener notificaciones del usuario
        $stmt = $conn->prepare("
            SELECT 
                IdNotificacion as id,
                Titulo as title,
                Mensaje as message,
                Leida as read,
                FechaCreacion as created_at
            FROM notificaciones
            WHERE IdUsuario = ?
            ORDER BY FechaCreacion DESC
            LIMIT 20
        ");
        $stmt->bind_param('i', $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $notifications = [];
        while ($row = $result->fetch_assoc()) {
            $notifications[] = [
                'id' => $row['id'],
                'title' => $row['title'],
                'message' => $row['message'],
                'read' => (bool)$row['read'],
                'time' => formatRelativeTime($row['created_at'])
            ];
        }
        
        echo json_encode($notifications);
        
    } catch (Exception $e) {
        error_log('Error obteniendo notificaciones: ' . $e->getMessage());
        echo json_encode(getMockNotifications());
    }
}

// POST: Marcar notificaciones como leídas
if ($method === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $action = $input['action'] ?? '';
    
    try {
        // Verificar si existe la tabla
        $tableCheck = $conn->query("SHOW TABLES LIKE 'notificaciones'");
        
        if ($tableCheck->num_rows === 0) {
            echo json_encode(['success' => true, 'message' => 'Tabla no existe aún']);
            exit;
        }
        
        if ($action === 'mark_read' && isset($input['id'])) {
            // Marcar una notificación como leída
            $notificationId = $input['id'];
            $stmt = $conn->prepare("
                UPDATE notificaciones 
                SET Leida = 1 
                WHERE IdNotificacion = ? AND IdUsuario = ?
            ");
            $stmt->bind_param('ii', $notificationId, $userId);
            $stmt->execute();
            
            echo json_encode(['success' => true]);
            
        } elseif ($action === 'mark_all_read') {
            // Marcar todas como leídas
            $stmt = $conn->prepare("
                UPDATE notificaciones 
                SET Leida = 1 
                WHERE IdUsuario = ?
            ");
            $stmt->bind_param('i', $userId);
            $stmt->execute();
            
            echo json_encode(['success' => true]);
        }
        
    } catch (Exception $e) {
        error_log('Error actualizando notificaciones: ' . $e->getMessage());
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
}

// Funciones auxiliares
function getMockNotifications() {
    return [
        [
            'id' => 1,
            'title' => 'Nueva asignación creada',
            'message' => 'Se ha creado una nueva asignación para la ficha 2024-01',
            'time' => 'Hace 5 minutos',
            'read' => false
        ],
        [
            'id' => 2,
            'title' => 'Instructor actualizado',
            'message' => 'Los datos del instructor han sido actualizados correctamente',
            'time' => 'Hace 1 hora',
            'read' => false
        ],
        [
            'id' => 3,
            'title' => 'Ficha completada',
            'message' => 'Una ficha ha completado su programa de formación',
            'time' => 'Hace 2 horas',
            'read' => false
        ],
        [
            'id' => 4,
            'title' => 'Nuevo ambiente disponible',
            'message' => 'Un nuevo ambiente está disponible para asignaciones',
            'time' => 'Ayer',
            'read' => true
        ],
        [
            'id' => 5,
            'title' => 'Recordatorio',
            'message' => 'Tienes asignaciones pendientes de revisión',
            'time' => 'Hace 2 días',
            'read' => true
        ]
    ];
}

function formatRelativeTime($datetime) {
    $now = new DateTime();
    $date = new DateTime($datetime);
    $diff = $now->diff($date);
    
    if ($diff->y > 0) return 'Hace ' . $diff->y . ' año' . ($diff->y > 1 ? 's' : '');
    if ($diff->m > 0) return 'Hace ' . $diff->m . ' mes' . ($diff->m > 1 ? 'es' : '');
    if ($diff->d > 7) return 'Hace ' . floor($diff->d / 7) . ' semana' . (floor($diff->d / 7) > 1 ? 's' : '');
    if ($diff->d > 0) return 'Hace ' . $diff->d . ' día' . ($diff->d > 1 ? 's' : '');
    if ($diff->h > 0) return 'Hace ' . $diff->h . ' hora' . ($diff->h > 1 ? 's' : '');
    if ($diff->i > 0) return 'Hace ' . $diff->i . ' minuto' . ($diff->i > 1 ? 's' : '');
    return 'Hace un momento';
}
?>
