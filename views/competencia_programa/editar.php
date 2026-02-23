<?php
// Vista manejada por el controlador
?>

<div class="main-content">
    <div class="form-container">
        <h2>Editar Relación Competencia-Programa</h2>
        <form method="POST">
            <div class="form-group">
                <label>Competencia *</label>
                <select name="competencia_id" class="form-control" required>
                    <option value="">Seleccione...</option>
                    <?php foreach ($competencias as $competencia): ?>
                        <option value="<?php echo safeHtml($competencia, 'comp_id'); ?>" 
                                <?php echo (safe($registro, 'COMPETENCIA_comp_id') == safe($competencia, 'comp_id')) ? 'selected' : ''; ?>>
                            <?php echo safeHtml($competencia, 'comp_nombre_corto'); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="form-group">
                <label>Programa *</label>
                <select name="programa_id" class="form-control" required>
                    <option value="">Seleccione...</option>
                    <?php foreach ($programas as $programa): ?>
                        <option value="<?php echo safeHtml($programa, 'prog_codigo'); ?>" 
                                <?php echo (safe($registro, 'PROGRAMA_prog_codigo') == safe($programa, 'prog_codigo')) ? 'selected' : ''; ?>>
                            <?php echo safeHtml($programa, 'prog_denominacion'); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="btn-group">
                <button type="submit" class="btn btn-primary">Actualizar</button>
                <a href="<?php echo BASE_PATH; ?>competencia_programa" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
