<?php
/**
 * API de Búsqueda Global
 * Busca en instructores, fichas, asignaciones, programas y ambientes
 */

header('Content-Type: application/json');
require_once __DIR__ . '/../auth/check_auth.php';
require_once __DIR__ . '/../conexion.php';

// Obtener query de búsqueda
$query = isset($_GET['q']) ? trim($_GET['q']) : '';

if (strlen($query) < 2) {
    echo json_encode([]);
    exit;
}

$results = [];

try {
    // Buscar en instructores
    $stmt = $conn->prepare("
        SELECT 
            IdInstructor as id,
            CONCAT(Nombre, ' ', Apellido) as title,
            Especialidad as subtitle,
            'instructor' as type
        FROM instructor
        WHERE CONCAT(Nombre, ' ', Apellido) LIKE ? 
           OR Especialidad LIKE ?
           OR Documento LIKE ?
        LIMIT 5
    ");
    $searchTerm = "%{$query}%";
    $stmt->bind_param('sss', $searchTerm, $searchTerm, $searchTerm);
    $stmt->execute();
    $result = $stmt->get_result();
    
    while ($row = $result->fetch_assoc()) {
        $results[] = [
            'title' => $row['title'],
            'subtitle' => 'Instructor - ' . $row['subtitle'],
            'url' => BASE_PATH . 'views/instructor/ver.php?id=' . $row['id'],
            'icon' => 'user',
            'type' => 'instructor'
        ];
    }
    
    // Buscar en fichas
    $stmt = $conn->prepare("
        SELECT 
            f.IdFicha as id,
            f.NumeroFicha as title,
            p.NombrePrograma as subtitle
        FROM ficha f
        LEFT JOIN programa p ON f.IdPrograma = p.IdPrograma
        WHERE f.NumeroFicha LIKE ?
           OR p.NombrePrograma LIKE ?
        LIMIT 5
    ");
    $stmt->bind_param('ss', $searchTerm, $searchTerm);
    $stmt->execute();
    $result = $stmt->get_result();
    
    while ($row = $result->fetch_assoc()) {
        $results[] = [
            'title' => 'Ficha ' . $row['title'],
            'subtitle' => $row['subtitle'] ?: 'Sin programa asignado',
            'url' => BASE_PATH . 'views/ficha/ver.php?id=' . $row['id'],
            'icon' => 'file-text',
            'type' => 'ficha'
        ];
    }
    
    // Buscar en programas
    $stmt = $conn->prepare("
        SELECT 
            IdPrograma as id,
            NombrePrograma as title,
            CodigoPrograma as subtitle
        FROM programa
        WHERE NombrePrograma LIKE ?
           OR CodigoPrograma LIKE ?
        LIMIT 5
    ");
    $stmt->bind_param('ss', $searchTerm, $searchTerm);
    $stmt->execute();
    $result = $stmt->get_result();
    
    while ($row = $result->fetch_assoc()) {
        $results[] = [
            'title' => $row['title'],
            'subtitle' => 'Programa - ' . $row['subtitle'],
            'url' => BASE_PATH . 'views/programa/ver.php?id=' . $row['id'],
            'icon' => 'book-open',
            'type' => 'programa'
        ];
    }
    
    // Buscar en ambientes
    $stmt = $conn->prepare("
        SELECT 
            IdAmbiente as id,
            NombreAmbiente as title,
            TipoAmbiente as subtitle
        FROM ambiente
        WHERE NombreAmbiente LIKE ?
           OR TipoAmbiente LIKE ?
        LIMIT 5
    ");
    $stmt->bind_param('ss', $searchTerm, $searchTerm);
    $stmt->execute();
    $result = $stmt->get_result();
    
    while ($row = $result->fetch_assoc()) {
        $results[] = [
            'title' => $row['title'],
            'subtitle' => 'Ambiente - ' . $row['subtitle'],
            'url' => BASE_PATH . 'views/ambiente/ver.php?id=' . $row['id'],
            'icon' => 'map-pin',
            'type' => 'ambiente'
        ];
    }
    
    // Buscar en asignaciones
    $stmt = $conn->prepare("
        SELECT 
            a.IdAsignacion as id,
            f.NumeroFicha as ficha,
            CONCAT(i.Nombre, ' ', i.Apellido) as instructor,
            amb.NombreAmbiente as ambiente
        FROM asignacion a
        LEFT JOIN ficha f ON a.IdFicha = f.IdFicha
        LEFT JOIN instructor i ON a.IdInstructor = i.IdInstructor
        LEFT JOIN ambiente amb ON a.IdAmbiente = amb.IdAmbiente
        WHERE f.NumeroFicha LIKE ?
           OR CONCAT(i.Nombre, ' ', i.Apellido) LIKE ?
           OR amb.NombreAmbiente LIKE ?
        LIMIT 5
    ");
    $stmt->bind_param('sss', $searchTerm, $searchTerm, $searchTerm);
    $stmt->execute();
    $result = $stmt->get_result();
    
    while ($row = $result->fetch_assoc()) {
        $results[] = [
            'title' => 'Asignación - Ficha ' . $row['ficha'],
            'subtitle' => $row['instructor'] . ' - ' . $row['ambiente'],
            'url' => BASE_PATH . 'views/asignacion/ver.php?id=' . $row['id'],
            'icon' => 'calendar',
            'type' => 'asignacion'
        ];
    }
    
} catch (Exception $e) {
    error_log('Error en búsqueda: ' . $e->getMessage());
}

// Limitar resultados totales a 15
$results = array_slice($results, 0, 15);

echo json_encode($results);
?>
