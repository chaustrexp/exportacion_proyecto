<?php
/**
 * API de Notificaciones
 * Devuelve notificaciones del sistema para el usuario autenticado.
 * Usa PDO via Database::getInstance() consistente con el resto del proyecto.
 * 
 * GET  /api/notifications.php         → retorna lista de notificaciones JSON
 * POST /api/notifications.php         → marca notificaciones como leídas
 */

header('Content-Type: application/json; charset=utf-8');

// Cargar autenticación y configuración
require_once __DIR__ . '/../auth/check_auth.php';
require_once __DIR__ . '/../conexion.php';

$userId  = $_SESSION['usuario_id'] ?? null;
$method  = $_SERVER['REQUEST_METHOD'];

if (!$userId) {
    http_response_code(401);
    echo json_encode(['error' => 'No autenticado']);
    exit;
}

// Obtener conexión PDO
$db  = Database::getInstance()->getConnection();

/* ===== GET: Listar notificaciones ===== */
if ($method === 'GET') {
    try {
        // Comprobar si existe la tabla notificaciones
        $check = $db->query("SHOW TABLES LIKE 'notificaciones'");
        if ($check->rowCount() === 0) {
            // Sin tabla: devolver notificaciones basadas en actividad reciente del sistema
            echo json_encode(getSystemNotifications($db, $userId));
            exit;
        }

        $stmt = $db->prepare("
            SELECT 
                IdNotificacion  AS id,
                Titulo          AS title,
                Mensaje         AS message,
                Leida           AS is_read,
                FechaCreacion   AS created_at
            FROM notificaciones
            WHERE IdUsuario = :uid
            ORDER BY FechaCreacion DESC
            LIMIT 20
        ");
        $stmt->execute([':uid' => $userId]);
        $rows = $stmt->fetchAll();

        $notificaciones = array_map(function ($row) {
            return [
                'id'      => (int)$row['id'],
                'title'   => $row['title'],
                'message' => $row['message'],
                'read'    => (bool)$row['is_read'],
                'time'    => formatRelativeTime($row['created_at']),
            ];
        }, $rows);

        echo json_encode($notificaciones);

    } catch (PDOException $e) {
        error_log('API notifications GET error: ' . $e->getMessage());
        // Fallback a notificaciones del sistema
        echo json_encode(getSystemNotifications($db, $userId));
    }
    exit;
}

/* ===== POST: Marcar como leídas ===== */
if ($method === 'POST') {
    $input  = json_decode(file_get_contents('php://input'), true) ?? [];
    $action = $input['action'] ?? '';

    try {
        $check = $db->query("SHOW TABLES LIKE 'notificaciones'");
        if ($check->rowCount() === 0) {
            echo json_encode(['success' => true, 'message' => 'Ok']);
            exit;
        }

        if ($action === 'mark_read' && isset($input['id'])) {
            $stmt = $db->prepare("
                UPDATE notificaciones 
                SET Leida = 1 
                WHERE IdNotificacion = :id AND IdUsuario = :uid
            ");
            $stmt->execute([':id' => (int)$input['id'], ':uid' => $userId]);

        } elseif ($action === 'mark_all_read') {
            $stmt = $db->prepare("
                UPDATE notificaciones 
                SET Leida = 1 
                WHERE IdUsuario = :uid
            ");
            $stmt->execute([':uid' => $userId]);
        }

        echo json_encode(['success' => true]);

    } catch (PDOException $e) {
        error_log('API notifications POST error: ' . $e->getMessage());
        http_response_code(500);
        echo json_encode(['success' => false, 'error' => 'Error interno']);
    }
    exit;
}

http_response_code(405);
echo json_encode(['error' => 'Método no permitido']);

/* ===== Funciones Auxiliares ===== */

/**
 * Genera notificaciones dinámicas basadas en actividad reciente de la BD.
 * Se usa cuando no existe la tabla "notificaciones".
 */
function getSystemNotifications(PDO $db, int $userId): array {
    $rol  = $_SESSION['usuario_rol'] ?? '';
    $nots = [];

    try {
        // Últimas asignaciones creadas (Admin y Coordinador)
        if (in_array($rol, ['Administrador', 'Coordinador'])) {
            $stmt = $db->query("
                SELECT a.IdAsignacion, f.NumeroFicha, a.HorarioInicio
                FROM asignacion a
                LEFT JOIN ficha f ON a.IdFicha = f.IdFicha
                ORDER BY a.IdAsignacion DESC
                LIMIT 3
            ");
            foreach ($stmt->fetchAll() as $row) {
                $nots[] = [
                    'id'      => $row['IdAsignacion'],
                    'title'   => 'Asignación activa',
                    'message' => 'Ficha ' . ($row['NumeroFicha'] ?? '—') . ' tiene una asignación registrada.',
                    'read'    => false,
                    'time'    => formatRelativeTime($row['HorarioInicio'] ?? date('Y-m-d H:i:s')),
                ];
            }
        }

        // Fichas recientes
        $stmt = $db->query("
            SELECT IdFicha, NumeroFicha, FechaInicio
            FROM ficha
            ORDER BY IdFicha DESC
            LIMIT 2
        ");
        foreach ($stmt->fetchAll() as $row) {
            $nots[] = [
                'id'      => 100 + $row['IdFicha'],
                'title'   => 'Ficha registrada',
                'message' => 'La ficha ' . $row['NumeroFicha'] . ' está activa en el sistema.',
                'read'    => true,
                'time'    => formatRelativeTime($row['FechaInicio'] ?? date('Y-m-d H:i:s')),
            ];
        }

    } catch (PDOException $e) {
        // Si algo falla, devolver arreglo vacío
        return [];
    }

    return $nots;
}

/**
 * Convierte un datetime a texto relativo en español.
 */
function formatRelativeTime(?string $datetime): string {
    if (!$datetime) return 'Hace un momento';
    try {
        $now  = new DateTime();
        $date = new DateTime($datetime);
        $diff = $now->diff($date);

        if ($diff->y > 0) return 'Hace ' . $diff->y . ' año'  . ($diff->y  > 1 ? 's' : '');
        if ($diff->m > 0) return 'Hace ' . $diff->m . ' mes'  . ($diff->m  > 1 ? 'es' : '');
        if ($diff->d > 6) return 'Hace ' . (int)($diff->d / 7) . ' semana' . ((int)($diff->d / 7) > 1 ? 's' : '');
        if ($diff->d > 0) return 'Hace ' . $diff->d . ' día'  . ($diff->d  > 1 ? 's' : '');
        if ($diff->h > 0) return 'Hace ' . $diff->h . ' hora' . ($diff->h  > 1 ? 's' : '');
        if ($diff->i > 0) return 'Hace ' . $diff->i . ' minuto' . ($diff->i > 1 ? 's' : '');
        return 'Hace un momento';
    } catch (Exception $e) {
        return 'Fecha desconocida';
    }
}
?>
