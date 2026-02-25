<?php
require_once __DIR__ . '/../../auth/check_auth.php';
$pageTitle = 'Mis Asignaciones - Instructor';
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
            <h1>📅 Mis Asignaciones</h1>
            <p>Historial completo de todas tus asignaciones</p>
        </div>
        
        <div class="content-card">
            <?php if (count($asignaciones) > 0): ?>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Fecha/Hora</th>
                                <th>Ficha</th>
                                <th>Programa</th>
                                <th>Competencia</th>
                                <th>Ambiente</th>
                                <th>Sede</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($asignaciones as $asig): ?>
                                <tr>
                                    <td>
                                        <?php 
                                        $fecha = new DateTime($asig['asig_fecha_ini']);
                                        $fechaFin = new DateTime($asig['asig_fecha_fin']);
                                        echo $fecha->format('d/m/Y') . '<br>';
                                        echo '<small>' . $fecha->format('H:i') . ' - ' . $fechaFin->format('H:i') . '</small>';
                                        ?>
                                    </td>
                                    <td><strong><?php echo htmlspecialchars($asig['fich_numero']); ?></strong></td>
                                    <td><?php echo htmlspecialchars($asig['prog_denominacion']); ?></td>
                                    <td>
                                        <strong><?php echo htmlspecialchars($asig['comp_nombre_corto']); ?></strong><br>
                                        <small><?php echo htmlspecialchars($asig['comp_nombre_unidad_competencia']); ?></small>
                                    </td>
                                    <td><?php echo htmlspecialchars($asig['amb_nombre']); ?></td>
                                    <td><?php echo htmlspecialchars($asig['sede_nombre']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="empty-state">
                    <p>No tienes asignaciones registradas.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <?php include __DIR__ . '/../layout/footer.php'; ?>
</body>
</html>
