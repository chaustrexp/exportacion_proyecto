<?php
// Vista de crear programa
// Los datos vienen del controlador: $pageTitle, $titulos
?>

<div class="main-content">
    <!-- Form -->
    <div style="max-width: 700px; margin: 0 auto; padding: 32px;">
        <div style="background: white; border-radius: 12px; border: 1px solid #e5e7eb; padding: 32px;">
            <!-- Header dentro del formulario -->
            <div style="margin-bottom: 32px; padding-bottom: 24px; border-bottom: 1px solid #e5e7eb;">
                <a href="<?php echo BASE_PATH; ?>programa/index" style="display: inline-flex; align-items: center; gap: 8px; color: #6b7280; text-decoration: none; margin-bottom: 16px; font-size: 14px; transition: color 0.2s;">
                    <i data-lucide="arrow-left" style="width: 18px; height: 18px;"></i>
                    Volver a Programas
                </a>
                <h1 style="font-size: 24px; font-weight: 700; color: #1f2937; margin: 0 0 4px;">Crear Nuevo Programa</h1>
                <p style="font-size: 14px; color: #6b7280; margin: 0;">Complete la información del programa de formación</p>
            </div>
            
            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-error" style="margin-bottom: 24px;">
                    ✗ <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>
            
            <?php if (isset($_SESSION['errors'])): ?>
                <div class="alert alert-error" style="margin-bottom: 24px;">
                    <strong>Por favor corrija los siguientes errores:</strong>
                    <ul style="margin: 8px 0 0; padding-left: 20px;">
                        <?php foreach ($_SESSION['errors'] as $error): ?>
                            <li><?php echo $error; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <?php unset($_SESSION['errors']); ?>
            <?php endif; ?>
            
            <form method="POST" action="<?php echo BASE_PATH; ?>programa/create">
                <div class="form-group">
                    <label style="display: block; font-size: 14px; font-weight: 600; color: #374151; margin-bottom: 8px;">
                        Denominación del Programa <span style="color: #ef4444;">*</span>
                    </label>
                    <input type="text" name="prog_denominacion" class="form-control" required 
                           placeholder="Ej: Análisis y Desarrollo de Software" 
                           value="<?php echo isset($_SESSION['old_input']['prog_denominacion']) ? htmlspecialchars($_SESSION['old_input']['prog_denominacion']) : ''; ?>"
                           style="width: 100%; padding: 12px; border: 1px solid #e5e7eb; border-radius: 8px; font-size: 14px;">
                </div>

                <div class="form-group">
                    <label style="display: block; font-size: 14px; font-weight: 600; color: #374151; margin-bottom: 8px;">
                        Título que Otorga <span style="color: #ef4444;">*</span>
                    </label>
                    <select name="titulo_programa_titpro_id" class="form-control" required style="width: 100%; padding: 12px; border: 1px solid #e5e7eb; border-radius: 8px; font-size: 14px;">
                        <option value="">Seleccione un título...</option>
                        <?php foreach ($titulos as $titulo): ?>
                            <option value="<?php echo safeHtml($titulo, 'titpro_id'); ?>"
                                    <?php echo (isset($_SESSION['old_input']['titulo_programa_titpro_id']) && $_SESSION['old_input']['titulo_programa_titpro_id'] == $titulo['titpro_id']) ? 'selected' : ''; ?>>
                                <?php echo safeHtml($titulo, 'titpro_nombre'); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label style="display: block; font-size: 14px; font-weight: 600; color: #374151; margin-bottom: 8px;">
                        Tipo de Programa
                    </label>
                    <select name="prog_tipo" class="form-control" style="width: 100%; padding: 12px; border: 1px solid #e5e7eb; border-radius: 8px; font-size: 14px;">
                        <option value="">Seleccione un tipo...</option>
                        <option value="Técnico" <?php echo (isset($_SESSION['old_input']['prog_tipo']) && $_SESSION['old_input']['prog_tipo'] == 'Técnico') ? 'selected' : ''; ?>>Técnico</option>
                        <option value="Tecnólogo" <?php echo (isset($_SESSION['old_input']['prog_tipo']) && $_SESSION['old_input']['prog_tipo'] == 'Tecnólogo') ? 'selected' : ''; ?>>Tecnólogo</option>
                        <option value="Especialización" <?php echo (isset($_SESSION['old_input']['prog_tipo']) && $_SESSION['old_input']['prog_tipo'] == 'Especialización') ? 'selected' : ''; ?>>Especialización</option>
                        <option value="Curso Corto" <?php echo (isset($_SESSION['old_input']['prog_tipo']) && $_SESSION['old_input']['prog_tipo'] == 'Curso Corto') ? 'selected' : ''; ?>>Curso Corto</option>
                    </select>
                </div>

                <div style="display: flex; gap: 12px; justify-content: flex-end; margin-top: 32px; padding-top: 24px; border-top: 1px solid #e5e7eb;">
                    <a href="<?php echo BASE_PATH; ?>programa/index" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Guardar Programa</button>
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
    
    // Focus effect en inputs
    document.querySelectorAll('.form-control').forEach(input => {
        input.addEventListener('focus', function() {
            this.style.borderColor = '#39A900';
            this.style.outline = 'none';
            this.style.boxShadow = '0 0 0 3px rgba(57, 169, 0, 0.1)';
        });
        input.addEventListener('blur', function() {
            this.style.borderColor = '#e5e7eb';
            this.style.boxShadow = 'none';
        });
    });
</script>
