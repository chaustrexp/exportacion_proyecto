<?php
// Vista manejada por el controlador
?>

<div class="main-content">
    <div class="detail-card">
        <?php if (registroValido($registro)): ?>
            <h2>Detalle del Ambiente</h2>
            <div class="detail-row">
                <div class="detail-label">ID:</div>
                <div><?php echo safeHtml($registro, 'id'); ?></div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Código:</div>
                <div><?php echo safeHtml($registro, 'codigo'); ?></div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Nombre:</div>
                <div><?php echo safeHtml($registro, 'nombre'); ?></div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Capacidad:</div>
                <div><?php echo safeHtml($registro, 'capacidad'); ?></div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Tipo:</div>
                <div><?php echo safeHtml($registro, 'tipo'); ?></div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Sede:</div>
                <div><?php echo safeHtml($registro, 'sede_nombre'); ?></div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Fecha Creación:</div>
                <div><?php echo safeHtml($registro, 'created_at'); ?></div>
            </div>
            <div class="btn-group" style="margin-top: 20px;">
                <a href="editar.php?id=<?php echo safeHtml($registro, 'id'); ?>" class="btn btn-primary">Editar</a>
                <a href="index.php" class="btn btn-secondary">Volver</a>
            </div>
        <?php else: ?>
            <h2>Registro no encontrado</h2>
            <p style="padding: 20px; text-align: center; color: #666;">No se encontraron datos para este ambiente.</p>
            <div class="btn-group" style="margin-top: 20px; justify-content: center;">
                <a href="index.php" class="btn btn-secondary">Volver al Listado</a>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php // Footer incluido por BaseController ?>
