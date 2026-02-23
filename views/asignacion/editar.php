<?php
// La vista ahora es manejada por AsignacionController
// Los datos ($registro, $fichas, etc.) ya están disponibles en el scope
?>

<div class="main-content">
    <div class="form-container">
        <h2>Editar Asignación</h2>
        <form method="POST">
            <div class="form-group">
                <label>Ficha *</label>
                <select name="ficha_id" class="form-control" required>
                    <option value="">Seleccione...</option>
                    <?php foreach ($fichas as $ficha): ?>
                        <option value="<?php echo safeHtml($ficha, 'fich_id'); ?>" 
                                <?php echo (safe($registro, 'FICHA_fich_id') == safe($ficha, 'fich_id')) ? 'selected' : ''; ?>>
                            Ficha <?php echo str_pad(safeHtml($ficha, 'fich_numero'), 8, '0', STR_PAD_LEFT); ?> - <?php echo safeHtml($ficha, 'prog_denominacion'); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="form-group">
                <label>Instructor *</label>
                <select name="instructor_id" class="form-control" required>
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
                <label>Ambiente</label>
                <select name="ambiente_id" class="form-control">
                    <option value="">Seleccione...</option>
                    <?php foreach ($ambientes as $ambiente): ?>
                        <option value="<?php echo safeHtml($ambiente, 'amb_id'); ?>" 
                                <?php echo (safe($registro, 'AMBIENTE_amb_id') == safe($ambiente, 'amb_id')) ? 'selected' : ''; ?>>
                            <?php echo safeHtml($ambiente, 'amb_nombre'); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="form-group">
                <label>Competencia</label>
                <select name="competencia_id" class="form-control">
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
                <label>Fecha Inicio *</label>
                <input type="date" name="fecha_inicio" class="form-control" value="<?php echo safeHtml($registro, 'asig_fecha_ini'); ?>" required>
            </div>
            
            <div class="form-group">
                <label>Fecha Fin *</label>
                <input type="date" name="fecha_fin" class="form-control" value="<?php echo safeHtml($registro, 'asig_fecha_fin'); ?>" required>
            </div>
            
            <div class="btn-group">
                <button type="submit" class="btn btn-primary">Actualizar</button>
                <a href="index.php" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>

<?php // Footer incluido por BaseController ?>
