<?php
require_once __DIR__ . '/../../auth/check_auth.php';
$pageTitle = 'Mis Fichas - Instructor';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    <link rel="stylesheet" href="<?php echo BASE_PATH; ?>assets/css/styles.css">
    <link rel="stylesheet" href="<?php echo BASE_PATH; ?>assets/css/theme-enhanced.css">
</head>
<body>
    <?php include __DIR__ . '/../layout/header.php'; ?>
    <?php include __DIR__ . '/../layout/sidebar.php'; ?>
    
    <div class="main-content">
        <div class="page-header">
            <h1>📚 Mis Fichas Asignadas</h1>
            <p>Listado completo de todas las fichas en las que participas</p>
        </div>
        
        <div class="content-card">
            <?php if (count($fichas) > 0): ?>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Número Ficha</th>
                                <th>Programa</th>
                                <th>Tipo</th>
                                <th>Jornada</th>
                                <th>Coordinación</th>
                                <th>Asignaciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($fichas as $ficha): ?>
                                <tr>
                                    <td><strong><?php echo htmlspecialchars($ficha['fich_numero']); ?></strong></td>
                                    <td><?php echo htmlspecialchars($ficha['prog_denominacion']); ?></td>
                                    <td><span class="badge badge-success"><?php echo htmlspecialchars($ficha['prog_tipo']); ?></span></td>
                                    <td><span class="badge badge-primary"><?php echo htmlspecialchars($ficha['fich_jornada']); ?></span></td>
                                    <td><?php echo htmlspecialchars($ficha['coord_nombre']); ?></td>
                                    <td><?php echo $ficha['total_asignaciones']; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="empty-state">
                    <p>No tienes fichas asignadas actualmente.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <?php include __DIR__ . '/../layout/footer.php'; ?>
</body>
</html>
