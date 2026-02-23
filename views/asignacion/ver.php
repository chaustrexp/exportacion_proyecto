<?php
// La vista ahora es manejada por AsignacionController
// Los datos ($registro, $fichas, etc.) ya están disponibles en el scope
?>

<div class="main-content">
    <div class="detail-card">
        <?php if (registroValido($registro)): ?>
            <h2>Detalle de la Asignación</h2>
            <div class="detail-row">
                <div class="detail-label">ID:</div>
                <div><?php echo e(safe($registro, 'asig_id', safe($registro, 'ASIG_ID', safe($registro, 'id')))); ?></div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Ficha:</div>
                <div><?php echo safeHtml($registro, 'ficha_numero'); ?></div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Programa:</div>
                <div><?php echo safeHtml($registro, 'programa_nombre'); ?></div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Instructor:</div>
                <div><?php echo safeHtml($registro, 'instructor_nombre'); ?></div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Ambiente:</div>
                <div><?php echo safeHtml($registro, 'ambiente_nombre'); ?></div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Competencia:</div>
                <div><?php echo safeHtml($registro, 'competencia_nombre'); ?></div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Fecha Inicio:</div>
                <div><?php echo e(safe($registro, 'asig_fecha_inicio', safe($registro, 'fecha_inicio'))); ?></div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Fecha Fin:</div>
                <div><?php echo e(safe($registro, 'asig_fecha_fin', safe($registro, 'fecha_fin'))); ?></div>
            </div>
            <div class="btn-group" style="margin-top: 20px;">
                <a href="editar.php?id=<?php echo e(safe($registro, 'asig_id', safe($registro, 'ASIG_ID', safe($registro, 'id')))); ?>" class="btn btn-primary">Editar</a>
                <a href="index.php" class="btn btn-secondary">Volver</a>
            </div>
        <?php else: ?>
            <h2>Registro no encontrado</h2>
            <p style="padding: 20px; text-align: center; color: #666;">No se encontraron datos para esta asignación.</p>
            <div class="btn-group" style="margin-top: 20px; justify-content: center;">
                <a href="index.php" class="btn btn-secondary">Volver al Listado</a>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php // Footer incluido por BaseController ?>
