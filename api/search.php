<?php
/**
 * API de Búsqueda Global
 * Busca en instructores, fichas, programas, ambientes y asignaciones.
 * Usa PDO via Database::getInstance() consistente con el resto del proyecto.
 * Las URLs de resultados usan el sistema de routing del proyecto (BASE_PATH).
 *
 * Parámetro GET:
 *   q  → término de búsqueda (mínimo 2 caracteres)
 *
 * Respuesta JSON: array de objetos { title, subtitle, url, icon, type }
 */

header('Content-Type: application/json; charset=utf-8');

// Cargar autenticación y configuración (también define BASE_PATH via config.php)
require_once __DIR__ . '/../auth/check_auth.php';
require_once __DIR__ . '/../conexion.php';

// Obtener y validar el parámetro de búsqueda
$query = isset($_GET['q']) ? trim($_GET['q']) : '';

if (mb_strlen($query) < 2) {
    echo json_encode([]);
    exit;
}

// Obtener conexión PDO
$db   = Database::getInstance()->getConnection();
$term = '%' . $query . '%';
$results = [];

try {
    /* ── Instructores ── */
    $stmt = $db->prepare("
        SELECT 
            IdInstructor                     AS id,
            CONCAT(Nombre, ' ', Apellido)    AS title,
            Especialidad                     AS subtitle
        FROM instructor
        WHERE CONCAT(Nombre, ' ', Apellido) LIKE :t
           OR Especialidad                  LIKE :t2
           OR Documento                     LIKE :t3
        LIMIT 5
    ");
    $stmt->execute([':t' => $term, ':t2' => $term, ':t3' => $term]);
    foreach ($stmt->fetchAll() as $row) {
        $results[] = [
            'title'    => $row['title'],
            'subtitle' => 'Instructor - ' . ($row['subtitle'] ?: 'Sin especialidad'),
            'url'      => BASE_PATH . 'instructor/ver/' . $row['id'],
            'icon'     => 'user',
            'type'     => 'instructor',
        ];
    }

    /* ── Fichas ── */
    $stmt = $db->prepare("
        SELECT 
            f.IdFicha       AS id,
            f.NumeroFicha   AS numero,
            p.NombrePrograma AS programa
        FROM ficha f
        LEFT JOIN programa p ON f.IdPrograma = p.IdPrograma
        WHERE f.NumeroFicha   LIKE :t
           OR p.NombrePrograma LIKE :t2
        LIMIT 5
    ");
    $stmt->execute([':t' => $term, ':t2' => $term]);
    foreach ($stmt->fetchAll() as $row) {
        $results[] = [
            'title'    => 'Ficha ' . $row['numero'],
            'subtitle' => $row['programa'] ?: 'Sin programa asignado',
            'url'      => BASE_PATH . 'ficha/show/' . $row['id'],
            'icon'     => 'file-text',
            'type'     => 'ficha',
        ];
    }

    /* ── Programas ── */
    $stmt = $db->prepare("
        SELECT 
            IdPrograma      AS id,
            NombrePrograma  AS title,
            CodigoPrograma  AS codigo
        FROM programa
        WHERE NombrePrograma LIKE :t
           OR CodigoPrograma LIKE :t2
        LIMIT 5
    ");
    $stmt->execute([':t' => $term, ':t2' => $term]);
    foreach ($stmt->fetchAll() as $row) {
        $results[] = [
            'title'    => $row['title'],
            'subtitle' => 'Programa - Código: ' . ($row['codigo'] ?: '—'),
            'url'      => BASE_PATH . 'programa/show/' . $row['id'],
            'icon'     => 'book-open',
            'type'     => 'programa',
        ];
    }

    /* ── Ambientes ── */
    $stmt = $db->prepare("
        SELECT 
            IdAmbiente      AS id,
            NombreAmbiente  AS title,
            TipoAmbiente    AS tipo
        FROM ambiente
        WHERE NombreAmbiente LIKE :t
           OR TipoAmbiente   LIKE :t2
        LIMIT 5
    ");
    $stmt->execute([':t' => $term, ':t2' => $term]);
    foreach ($stmt->fetchAll() as $row) {
        $results[] = [
            'title'    => $row['title'],
            'subtitle' => 'Ambiente - ' . ($row['tipo'] ?: 'Sin tipo'),
            'url'      => BASE_PATH . 'ambiente/ver/' . $row['id'],
            'icon'     => 'map-pin',
            'type'     => 'ambiente',
        ];
    }

    /* ── Asignaciones ── */
    $stmt = $db->prepare("
        SELECT 
            a.IdAsignacion                        AS id,
            f.NumeroFicha                         AS ficha,
            CONCAT(i.Nombre, ' ', i.Apellido)     AS instructor,
            amb.NombreAmbiente                    AS ambiente
        FROM asignacion a
        LEFT JOIN ficha       f   ON a.IdFicha      = f.IdFicha
        LEFT JOIN instructor  i   ON a.IdInstructor = i.IdInstructor
        LEFT JOIN ambiente    amb ON a.IdAmbiente   = amb.IdAmbiente
        WHERE f.NumeroFicha                        LIKE :t
           OR CONCAT(i.Nombre, ' ', i.Apellido)   LIKE :t2
           OR amb.NombreAmbiente                   LIKE :t3
        LIMIT 5
    ");
    $stmt->execute([':t' => $term, ':t2' => $term, ':t3' => $term]);
    foreach ($stmt->fetchAll() as $row) {
        $results[] = [
            'title'    => 'Asignación - Ficha ' . ($row['ficha'] ?: '—'),
            'subtitle' => ($row['instructor'] ?: 'Sin instructor') . ' · ' . ($row['ambiente'] ?: 'Sin ambiente'),
            'url'      => BASE_PATH . 'asignacion/ver/' . $row['id'],
            'icon'     => 'calendar',
            'type'     => 'asignacion',
        ];
    }

} catch (PDOException $e) {
    error_log('API search error: ' . $e->getMessage());
    // Devolver lo que se haya podido buscar hasta el momento (puede estar vacío)
}

// Limitar a 15 resultados totales
$results = array_slice($results, 0, 15);

echo json_encode($results, JSON_UNESCAPED_UNICODE);
?>
