<?php
// Vista manejada por el controlador
?>

<div class="main-content">
    <div class="form-container">
        <h2>Editar Ambiente</h2>
        <form method="POST" action="<?php echo BASE_PATH; ?>ambiente/editar/<?php echo htmlspecialchars($registro['amb_id'] ?? ''); ?>">
            <div class="form-group">
                <label>Código (No editable)</label>
                <input type="text" class="form-control" value="<?php echo htmlspecialchars($registro['amb_id'] ?? ''); ?>" readonly disabled>
            </div>
            <div class="form-group">
                <label>Nombre del Ambiente *</label>
                <input type="text" name="nombre" class="form-control" value="<?php echo htmlspecialchars($registro['amb_nombre'] ?? ''); ?>" required>
            </div>
            
            <div class="form-group">
                <label>Sede *</label>
                <select name="sede_id" class="form-control" required>
                    <option value="">Seleccione...</option>
                    <?php if (isset($sedes) && is_array($sedes)): ?>
                        <?php foreach ($sedes as $sede): ?>
                            <option value="<?php echo htmlspecialchars($sede['sede_id'] ?? ''); ?>" 
                                    <?php echo (isset($registro['sede_sede_id']) && $registro['sede_sede_id'] == $sede['sede_id']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($sede['sede_nombre'] ?? ''); ?>
                            </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>
            <div class="btn-group">
                <button type="submit" class="btn btn-primary">Actualizar</button>
                <a href="<?php echo BASE_PATH; ?>ambiente" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>

<?php // Footer incluido por BaseController ?>
