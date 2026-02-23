<?php
// Vista de editar ficha
// Los datos vienen del controlador: $pageTitle, $registro, $programas, $instructores, $coordinaciones
?>

<div class="main-content">
    <div class="form-container">
        <div style="margin-bottom: 24px;">
            <a href="<?php echo BASE_PATH; ?>ficha/index" style="display: inline-flex; align-items: center; gap: 8px; color: #6b7280; text-decoration: none; margin-bottom: 16px; font-size: 14px;">
                <i data-lucide="arrow-left" style="width: 18px; height: 18px;"></i>
                Volver a Fichas
            </a>
            <h2 style="font-size: 24px; font-weight: 700; color: #1f2937; margin: 0 0 4px;">Editar Ficha</h2>
            <p style="font-size: 14px; color: #6b7280; margin: 0;">Modifique los datos de la ficha #<?php echo htmlspecialchars($registro['fich_numero'] ?? $registro['fich_id']); ?></p>
        </div>
        
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-error" style="margin-bottom: 24px;">
                ✗ <?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>
        
        <?php if (isset($_SESSION['errors'])): ?>
            <div class="alert alert-error" style="margin-bottom: 24px;">
                <strong>Por favor corrija los siguientes errores:</strong>
                <ul style="margin: 8px 0 0; padding-left: 20px;">
                    <?php foreach ($_SESSION['errors'] as $error): ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php unset($_SESSION['errors']); ?>
        <?php endif; ?>
        
        <form method="POST" action="<?php echo BASE_PATH; ?>ficha/edit/<?php echo htmlspecialchars($registro['fich_id'] ?? ''); ?>">
            <div class="form-group">
                <label>Número de Ficha *</label>
                <input type="number" 
                       name="fich_numero" 
                       class="form-control" 
                       value="<?php echo htmlspecialchars($registro['fich_numero'] ?? $registro['fich_id']); ?>" 
                       required 
                       min="1" 
                       max="9999999">
                <small style="color: #6b7280; font-size: 12px;">Ingrese el número completo de la ficha (7 dígitos)</small>
            </div>
            
            <div class="form-group">
                <label>Programa *</label>
                <select name="PROGRAMA_prog_id" class="form-control" required>
                    <option value="">Seleccione un programa...</option>
                    <?php if (isset($programas) && is_array($programas)): ?>
                        <?php foreach ($programas as $programa): ?>
                            <option value="<?php echo htmlspecialchars($programa['prog_codigo'] ?? ''); ?>" 
                                    <?php echo (($registro['PROGRAMA_prog_id'] ?? '') == ($programa['prog_codigo'] ?? '')) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($programa['prog_denominacion'] ?? ''); ?>
                            </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>
            
            <div class="form-group">
                <label>Instructor Líder *</label>
                <select name="INSTRUCTOR_inst_id_lider" class="form-control" required>
                    <option value="">Seleccione un instructor...</option>
                    <?php if (isset($instructores) && is_array($instructores)): ?>
                        <?php foreach ($instructores as $instructor): ?>
                            <option value="<?php echo htmlspecialchars($instructor['inst_id'] ?? ''); ?>"
                                    <?php echo (($registro['INSTRUCTOR_inst_id_lider'] ?? '') == ($instructor['inst_id'] ?? '')) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars(($instructor['inst_nombres'] ?? '') . ' ' . ($instructor['inst_apellidos'] ?? '')); ?>
                            </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>
            
            <div class="form-group">
                <label>Jornada *</label>
                <select name="fich_jornada" class="form-control" required>
                    <option value="">Seleccione una jornada...</option>
                    <option value="Diurna" <?php echo (($registro['fich_jornada'] ?? '') == 'Diurna') ? 'selected' : ''; ?>>Diurna</option>
                    <option value="Nocturna" <?php echo (($registro['fich_jornada'] ?? '') == 'Nocturna') ? 'selected' : ''; ?>>Nocturna</option>
                    <option value="Mixta" <?php echo (($registro['fich_jornada'] ?? '') == 'Mixta') ? 'selected' : ''; ?>>Mixta</option>
                    <option value="Fin de Semana" <?php echo (($registro['fich_jornada'] ?? '') == 'Fin de Semana') ? 'selected' : ''; ?>>Fin de Semana</option>
                </select>
            </div>
            
            <div class="form-group">
                <label>Coordinación *</label>
                <select name="COORDINACION_coord_id" class="form-control" required>
                    <option value="">Seleccione una coordinación...</option>
                    <?php if (isset($coordinaciones) && is_array($coordinaciones)): ?>
                        <?php foreach ($coordinaciones as $coordinacion): ?>
                            <option value="<?php echo htmlspecialchars($coordinacion['coord_id'] ?? ''); ?>"
                                    <?php echo (($registro['COORDINACION_coord_id'] ?? '') == ($coordinacion['coord_id'] ?? '')) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($coordinacion['coord_nombre'] ?? ''); ?>
                            </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label>Fecha Inicio Lectiva *</label>
                    <input type="date" 
                           name="fich_fecha_ini_lectiva" 
                           class="form-control" 
                           value="<?php echo htmlspecialchars($registro['fich_fecha_ini_lectiva'] ?? ''); ?>" 
                           required>
                </div>
                
                <div class="form-group">
                    <label>Fecha Fin Lectiva *</label>
                    <input type="date" 
                           name="fich_fecha_fin_lectiva" 
                           class="form-control" 
                           value="<?php echo htmlspecialchars($registro['fich_fecha_fin_lectiva'] ?? ''); ?>" 
                           required>
                </div>
            </div>
            
            <div class="btn-group">
                <button type="submit" class="btn btn-primary">
                    <i data-lucide="save" style="width: 18px; height: 18px;"></i>
                    Actualizar Ficha
                </button>
                <a href="<?php echo BASE_PATH; ?>ficha/index" class="btn btn-secondary">
                    <i data-lucide="x" style="width: 18px; height: 18px;"></i>
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>

<script>
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
</script>
