<?php
// Vista de detalle de asignación
// Los datos vienen del controlador: $registro
?>

<div class="main-content">
    <div class="detail-card">
        <?php if (isset($registro) && $registro): ?>
            <h2>Detalle de Asignación</h2>
            <div class="detail-row">
                <div class="detail-label">ID:</div>
                <div><?php echo htmlspecialchars($registro['detasig_id'] ?? ''); ?></div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Asignación ID:</div>
                <div><?php echo htmlspecialchars($registro['ASIGNACION_ASIG_ID'] ?? ''); ?></div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Hora Inicio:</div>
                <div><?php echo htmlspecialchars($registro['detasig_hora_ini'] ?? ''); ?></div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Hora Fin:</div>
                <div><?php echo htmlspecialchars($registro['detasig_hora_fin'] ?? ''); ?></div>
            </div>
            <div class="btn-group" style="margin-top: 20px;">
                <a href="<?php echo BASE_PATH; ?>detalle_asignacion/editar?id=<?php echo $registro['detasig_id']; ?>" class="btn btn-primary">Editar</a>
                <a href="<?php echo BASE_PATH; ?>detalle_asignacion" class="btn btn-secondary">Volver</a>
            </div>
        <?php else: ?>
            <h2>Registro no encontrado</h2>
            <p style="padding: 20px; text-align: center; color: #666;">No se encontraron datos para este detalle de asignación.</p>
            <div class="btn-group" style="margin-top: 20px; justify-content: center;">
                <a href="<?php echo BASE_PATH; ?>detalle_asignacion" class="btn btn-secondary">Volver al Listado</a>
            </div>
        <?php endif; ?>
    </div>
</div>
