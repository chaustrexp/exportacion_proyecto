<?php
// Vista de crear competencia_programa
// Los datos vienen del controlador: $pageTitle, $programas, $competencias
?>

<div class="main-content">
    <div style="max-width: 700px; margin: 0 auto; padding: 32px;">
        <div style="background: white; border-radius: 12px; border: 1px solid #e5e7eb; padding: 32px;">
            <div style="margin-bottom: 32px; padding-bottom: 24px; border-bottom: 1px solid #e5e7eb;">
                <a href="<?php echo BASE_PATH; ?>competencia_programa/index" style="display: inline-flex; align-items: center; gap: 8px; color: #6b7280; text-decoration: none; margin-bottom: 16px; font-size: 14px;">
                    <i data-lucide="arrow-left" style="width: 18px; height: 18px;"></i>
                    Volver a Competencias por Programa
                </a>
                <h1 style="font-size: 24px; font-weight: 700; color: #1f2937; margin: 0 0 4px;">Asignar Competencia a Programa</h1>
                <p style="font-size: 14px; color: #6b7280; margin: 0;">Crea una nueva relación entre competencia y programa</p>
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
            
            <form method="POST" action="<?php echo BASE_PATH; ?>competencia_programa/crear">
                <div class="form-group">
                    <label style="display: block; font-size: 14px; font-weight: 600; color: #374151; margin-bottom: 8px;">
                        Programa <span style="color: #ef4444;">*</span>
                    </label>
                    <select name="programa_id" 
                            class="form-control" 
                            required
                            style="width: 100%; padding: 12px; border: 1px solid #e5e7eb; border-radius: 8px; font-size: 14px;">
                        <option value="">Seleccione un programa...</option>
                        <?php if (isset($programas) && is_array($programas)): ?>
                            <?php foreach ($programas as $programa): ?>
                                <option value="<?php echo htmlspecialchars($programa['prog_codigo'] ?? ''); ?>"
                                        <?php echo (isset($_SESSION['old_input']['programa_id']) && $_SESSION['old_input']['programa_id'] == $programa['prog_codigo']) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($programa['prog_denominacion'] ?? ''); ?>
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label style="display: block; font-size: 14px; font-weight: 600; color: #374151; margin-bottom: 8px;">
                        Competencia <span style="color: #ef4444;">*</span>
                    </label>
                    <select name="competencia_id" 
                            class="form-control" 
                            required
                            style="width: 100%; padding: 12px; border: 1px solid #e5e7eb; border-radius: 8px; font-size: 14px;">
                        <option value="">Seleccione una competencia...</option>
                        <?php if (isset($competencias) && is_array($competencias)): ?>
                            <?php foreach ($competencias as $competencia): ?>
                                <option value="<?php echo htmlspecialchars($competencia['comp_id'] ?? ''); ?>"
                                        <?php echo (isset($_SESSION['old_input']['competencia_id']) && $_SESSION['old_input']['competencia_id'] == $competencia['comp_id']) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($competencia['comp_nombre_corto'] ?? ''); ?> - 
                                    <?php echo htmlspecialchars(substr($competencia['comp_nombre_unidad_competencia'] ?? '', 0, 60)); ?>...
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>
                
                <div style="display: flex; gap: 12px; justify-content: flex-end; margin-top: 32px; padding-top: 24px; border-top: 1px solid #e5e7eb;">
                    <a href="<?php echo BASE_PATH; ?>competencia_programa/index" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Guardar Relación</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php 
// Limpiar old_input después de mostrar
if (isset($_SESSION['old_input'])) {
    unset($_SESSION['old_input']);
}
?>

<script>
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
</script>
