<?php
// Vista manejada por el controlador
?>

<div class="main-content">
    <div class="form-container">
        <h2>Editar Competencia de Instructor</h2>
        <form method="POST">
            <div class="form-group">
                <label>Instructor *</label>
                <select name="INSTRUCTOR_inst_id" class="form-control" required>
                    <option value="">Seleccione...</option>
                    <?php foreach ($instructores as $instructor): ?>
                        <option value="<?php echo safeHtml($instructor, 'inst_id'); ?>" 
                            <?php echo (safe($registro, 'INSTRUCTOR_inst_id') == safe($instructor, 'inst_id')) ? 'selected' : ''; ?>>
                            <?php echo safeHtml($instructor, 'inst_nombres') . ' ' . safeHtml($instructor, 'inst_apellidos'); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label>Programa *</label>
                <select name="COMPETxPROGRAMA_PROGRAMA_prog_id" class="form-control" required>
                    <option value="">Seleccione...</option>
                    <?php foreach ($programas as $programa): ?>
                        <option value="<?php echo safeHtml($programa, 'prog_codigo'); ?>"
                            <?php echo (safe($registro, 'COMPETxPROGRAMA_PROGRAMA_prog_id') == safe($programa, 'prog_codigo')) ? 'selected' : ''; ?>>
                            <?php echo safeHtml($programa, 'prog_denominacion'); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label>Competencia *</label>
                <select name="COMPETxPROGRAMA_COMPETENCIA_comp_id" class="form-control" required>
                    <option value="">Seleccione...</option>
                    <?php foreach ($competencias as $competencia): ?>
                        <option value="<?php echo safeHtml($competencia, 'comp_id'); ?>"
                            <?php echo (safe($registro, 'COMPETxPROGRAMA_COMPETENCIA_comp_id') == safe($competencia, 'comp_id')) ? 'selected' : ''; ?>>
                            <?php echo safeHtml($competencia, 'comp_nombre_corto') . ' - ' . safeHtml($competencia, 'comp_nombre_unidad_competencia'); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label>Fecha de Vigencia *</label>
                <input type="date" name="inscomp_vigencia" class="form-control" 
                    value="<?php echo safeHtml($registro, 'inscomp_vigencia'); ?>" required>
                <small style="color: #6b7280; font-size: 12px; margin-top: 4px; display: block;">
                    Fecha hasta la cual el instructor está certificado para impartir esta competencia
                </small>
            </div>

            <div class="btn-group">
                <button type="submit" class="btn btn-primary">Actualizar</button>
                <a href="index.php" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>

<?php // Footer incluido por BaseController ?>
