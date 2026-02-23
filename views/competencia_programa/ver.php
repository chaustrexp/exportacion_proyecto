<?php
// Vista manejada por el controlador
?>

<div class="main-content">
    <div class="detail-card">
        <?php if (registroValido($registro)): ?>
            <h2>Detalle de Competencia-Programa</h2>
            <div class="detail-row">
                <div class="detail-label">ID:</div>
                <div><?php echo safeHtml($registro, 'id'); ?></div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Competencia:</div>
                <div><?php echo safeHtml($registro, 'competencia_nombre'); ?></div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Programa:</div>
                <div><?php echo safeHtml($registro, 'programa_nombre'); ?></div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Horas:</div>
                <div><?php echo safeHtml($registro, 'horas'); ?></div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Fecha Creación:</div>
                <div><?php echo safeHtml($registro, 'created_at'); ?></div>
            </div>
            <div class="btn-group" style="margin-top: 20px;">
                <a href="<?php echo BASE_PATH; ?>competencia_programa/editar?id=<?php echo htmlspecialchars($registro['id'] ?? ''); ?>" class="btn btn-primary">Editar</a>
                <a href="<?php echo BASE_PATH; ?>competencia_programa" class="btn btn-secondary">Volver</a>
            </div>
        <?php else: ?>
            <h2>Registro no encontrado</h2>
            <p style="padding: 20px; text-align: center; color: #666;">No se encontraron datos para esta relación competencia-programa.</p>
            <div class="btn-group" style="margin-top: 20px; justify-content: center;">
                <a href="<?php echo BASE_PATH; ?>competencia_programa" class="btn btn-secondary">Volver al Listado</a>
            </div>
        <?php endif; ?>
    </div>
</div>
