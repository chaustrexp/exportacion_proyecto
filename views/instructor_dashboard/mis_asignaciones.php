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
    
    <div class="main-content sena-enhanced-theme">
        <div class="header-actions" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 20px;">
            <div>
                <h1>📅 Asignaciones: <?php echo htmlspecialchars($instructor_nombre); ?></h1>
                <p>Listado completo del historial y próximas clases</p>
            </div>
            
            <form method="GET" action="<?php echo BASE_PATH; ?>instructor_dashboard/misAsignaciones" style="background: white; padding: 12px 20px; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); border: 1px solid #e5e7eb;">
                <div style="display: flex; align-items: center; gap: 12px;">
                    <label for="view_instructor_id" style="font-weight: 600; color: #374151; font-size: 14px;">Filtrar instructor:</label>
                    <select name="view_instructor_id" id="view_instructor_id" style="padding: 8px 12px; border-radius: 8px; border: 1px solid #d1d5db; font-size: 14px; color: #1f2937; outline: none; cursor: pointer; min-width: 250px;" onchange="this.form.submit()">
                        <option value="<?php echo $_SESSION['instructor_id']; ?>" <?php echo (isset($view_instructor_id) && $view_instructor_id == $_SESSION['instructor_id']) ? 'selected' : ''; ?>>
                            Mis Asignaciones (<?php echo htmlspecialchars($_SESSION['nombre'] ?? $_SESSION['usuario_nombre']); ?>)
                        </option>
                        <optgroup label="Otros Instructores">
                        <?php foreach ($instructores as $inst): ?>
                            <?php if ($inst['inst_id'] != $_SESSION['instructor_id']): ?>
                                <option value="<?php echo $inst['inst_id']; ?>" <?php echo (isset($view_instructor_id) && $view_instructor_id == $inst['inst_id']) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($inst['inst_nombres'] . ' ' . $inst['inst_apellidos']); ?>
                                </option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                        </optgroup>
                    </select>
                </div>
            </form>
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
