<?php
// Vista de index competencias
// Los datos vienen del controlador: $pageTitle, $registros, $mensaje
?>

<div class="main-content">
    <!-- Header -->
    <div style="padding: 32px 32px 24px; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #e5e7eb;">
        <div>
            <h1 style="font-size: 28px; font-weight: 700; color: #1f2937; margin: 0 0 4px;">Competencias</h1>
            <p style="font-size: 14px; color: #6b7280; margin: 0;">Gestiona las competencias de formación</p>
        </div>
        <a href="<?php echo BASE_PATH; ?>competencia/crear" class="btn btn-primary" style="display: inline-flex; align-items: center; gap: 8px;">
            <i data-lucide="plus" style="width: 18px; height: 18px;"></i>
            Nueva Competencia
        </a>
    </div>

    <!-- Alert Messages -->
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success" style="margin: 24px 32px;">
            ✓ <?php echo htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>
    
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-error" style="margin: 24px 32px;">
            ✗ <?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>
    
    <?php if (isset($mensaje)): ?>
        <div class="alert alert-success" style="margin: 24px 32px;">
            ✓ <?php echo htmlspecialchars($mensaje); ?>
        </div>
    <?php endif; ?>

    <!-- Stats -->
    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; padding: 24px 32px;">
        <div style="background: white; padding: 20px; border-radius: 12px; border: 1px solid #e5e7eb;">
            <div style="font-size: 13px; color: #6b7280; margin-bottom: 8px;">Total Competencias</div>
            <div style="font-size: 32px; font-weight: 700; color: #10b981;"><?php echo count($registros ?? []); ?></div>
        </div>
        <div style="background: white; padding: 20px; border-radius: 12px; border: 1px solid #e5e7eb;">
            <div style="font-size: 13px; color: #6b7280; margin-bottom: 8px;">Registradas</div>
            <div style="font-size: 32px; font-weight: 700; color: #3b82f6;"><?php echo count($registros ?? []); ?></div>
        </div>
    </div>

    <!-- Table -->
    <div style="padding: 0 32px 32px;">
        <div style="background: white; border-radius: 12px; border: 1px solid #e5e7eb; overflow: hidden;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: #f9fafb; border-bottom: 1px solid #e5e7eb;">
                        <th style="padding: 16px; text-align: left; font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase; width: 150px;">Código</th>
                        <th style="padding: 16px; text-align: left; font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase;">Unidad de Competencia</th>
                        <th style="padding: 16px; text-align: center; font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase; width: 100px;">Horas</th>
                        <th style="padding: 16px; text-align: right; font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase; width: 200px;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($registros)): ?>
                    <tr>
                        <td colspan="4" style="text-align: center; padding: 60px 20px; color: #6b7280;">
                            <div style="font-size: 48px; margin-bottom: 16px;">🎯</div>
                            <p style="margin: 0 0 16px; font-size: 16px;">No hay competencias registradas</p>
                            <a href="<?php echo BASE_PATH; ?>competencia/crear" class="btn btn-primary btn-sm">Crear Primera Competencia</a>
                        </td>
                    </tr>
                    <?php else: ?>
                        <?php foreach ($registros as $registro): ?>
                        <tr style="border-bottom: 1px solid #f3f4f6;">
                            <td style="padding: 16px;">
                                <strong style="color: #10b981; font-size: 14px;"><?php echo htmlspecialchars($registro['comp_nombre_corto'] ?? ''); ?></strong>
                            </td>
                            <td style="padding: 16px;">
                                <div style="font-weight: 600; color: #1f2937;">
                                    <?php 
                                    $unidad = $registro['comp_nombre_unidad_competencia'] ?? '';
                                    echo strlen($unidad) > 80 ? htmlspecialchars(substr($unidad, 0, 80)) . '...' : htmlspecialchars($unidad); 
                                    ?>
                                </div>
                            </td>
                            <td style="padding: 16px; text-align: center;">
                                <span style="background: #E8F5E8; color: #39A900; padding: 4px 12px; border-radius: 12px; font-size: 12px; font-weight: 600;">
                                    <?php echo htmlspecialchars($registro['comp_horas'] ?? '0'); ?> h
                                </span>
                            </td>
                            <td style="padding: 16px;">
                                <div class="btn-group" style="justify-content: flex-end;">
                                    <a href="<?php echo BASE_PATH; ?>competencia/ver/<?php echo htmlspecialchars($registro['comp_id'] ?? ''); ?>" class="btn btn-secondary btn-sm">Ver</a>
                                    <a href="<?php echo BASE_PATH; ?>competencia/editar/<?php echo htmlspecialchars($registro['comp_id'] ?? ''); ?>" class="btn btn-primary btn-sm">Editar</a>
                                    <button onclick="confirmarEliminacion(<?php echo htmlspecialchars($registro['comp_id'] ?? ''); ?>, 'competencia')" class="btn btn-danger btn-sm">Eliminar</button>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
    
    document.querySelectorAll('tbody tr').forEach(row => {
        if (row.cells.length > 1) {
            row.addEventListener('mouseenter', function() {
                this.style.background = '#f9fafb';
            });
            row.addEventListener('mouseleave', function() {
                this.style.background = 'white';
            });
        }
    });
    
    function confirmarEliminacion(id, tipo) {
        if (confirm(`¿Está seguro de eliminar esta ${tipo}?`)) {
            window.location.href = `<?php echo BASE_PATH; ?>competencia/eliminar/${id}`;
        }
    }
</script>
