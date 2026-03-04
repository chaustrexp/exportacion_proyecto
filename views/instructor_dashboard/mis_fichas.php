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
    
    <div class="main-content sena-enhanced-theme">
        <div class="header-actions" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 20px;">
            <div>
                <h1>📚 Fichas Asignadas: <?php echo htmlspecialchars($instructor_nombre); ?></h1>
                <p>Listado completo de fichas vinculadas</p>
            </div>
            
            <form method="GET" action="<?php echo BASE_PATH; ?>instructor_dashboard/misFichas" style="background: white; padding: 12px 20px; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); border: 1px solid #e5e7eb;">
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
                                    <td><span class="badge-modern badge-tipo"><?php echo htmlspecialchars($ficha['prog_tipo']); ?></span></td>
                                    <td><span class="badge-modern badge-jornada"><?php echo htmlspecialchars($ficha['fich_jornada']); ?></span></td>
                                    <td><?php echo htmlspecialchars($ficha['coord_nombre']); ?></td>
                                    <td><span class="badge-modern badge-asignas"><?php echo $ficha['total_asignaciones']; ?></span></td>
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
