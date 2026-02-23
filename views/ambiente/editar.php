<?php
// Vista manejada por el controlador
?>

<div class="main-content">
    <div class="form-container">
        <h2>Editar Ambiente</h2>
        <form method="POST">
            <div class="form-group">
                <label>Código *</label>
                <input type="text" name="codigo" class="form-control" value="<?php echo safeHtml($registro, 'amb_codigo'); ?>" required>
            </div>
            <div class="form-group">
                <label>Nombre *</label>
                <input type="text" name="nombre" class="form-control" value="<?php echo safeHtml($registro, 'amb_nombre'); ?>" required>
            </div>
            <div class="form-group">
                <label>Capacidad *</label>
                <input type="number" name="capacidad" class="form-control" value="<?php echo safeHtml($registro, 'amb_capacidad'); ?>" required>
            </div>
            <div class="form-group">
                <label>Tipo *</label>
                <input type="text" name="tipo" class="form-control" value="<?php echo safeHtml($registro, 'amb_tipo'); ?>" required>
            </div>
            <div class="form-group">
                <label>Sede</label>
                <select name="sede_id" class="form-control">
                    <option value="">Seleccione...</option>
                    <?php foreach ($sedes as $sede): ?>
                        <option value="<?php echo safeHtml($sede, 'sede_id'); ?>" 
                                <?php echo (safe($registro, 'SEDE_sede_id') == safe($sede, 'sede_id')) ? 'selected' : ''; ?>>
                            <?php echo safeHtml($sede, 'sede_nombre'); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="btn-group">
                <button type="submit" class="btn btn-primary">Actualizar</button>
                <a href="index.php" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>

<?php // Footer incluido por BaseController ?>
