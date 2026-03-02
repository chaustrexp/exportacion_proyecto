<?php
// Vista de crear competencia
// Los datos vienen del controlador: $pageTitle
?>

<div class="main-content">
    <!-- Form -->
    <div style="max-width: 700px; margin: 0 auto; padding: 32px;">
        <div style="background: white; border-radius: 12px; border: 1px solid #e5e7eb; padding: 32px;">
            <!-- Header -->
            <div style="margin-bottom: 32px; padding-bottom: 24px; border-bottom: 1px solid #e5e7eb;">
                <a href="<?php echo BASE_PATH; ?>competencia/index" style="display: inline-flex; align-items: center; gap: 8px; color: #6b7280; text-decoration: none; margin-bottom: 16px; font-size: 14px;">
                    <i data-lucide="arrow-left" style="width: 18px; height: 18px;"></i>
                    Volver a Competencias
                </a>
                <h1 style="font-size: 24px; font-weight: 700; color: #1f2937; margin: 0 0 4px;">Crear Nueva Competencia</h1>
                <p style="font-size: 14px; color: #6b7280; margin: 0;">Complete la información de la competencia</p>
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
            
            <form method="POST" action="<?php echo BASE_PATH; ?>competencia/crear">
                <div class="form-group">
                    <label style="display: block; font-size: 14px; font-weight: 600; color: #374151; margin-bottom: 8px;">
                        Código/Nombre Corto <span style="color: #ef4444;">*</span>
                    </label>
                    <input type="text" 
                           name="nombre_corto" 
                           class="form-control" 
                           required 
                           placeholder="Ej: PROG-001" 
                           value="<?php echo isset($_SESSION['old_input']['nombre_corto']) ? htmlspecialchars($_SESSION['old_input']['nombre_corto']) : ''; ?>"
                           style="width: 100%; padding: 12px; border: 1px solid #e5e7eb; border-radius: 8px; font-size: 14px;">
                    <small style="color: #6b7280; font-size: 12px; margin-top: 4px; display: block;">Código identificador de la competencia</small>
                </div>

                <div class="form-group">
                    <label style="display: block; font-size: 14px; font-weight: 600; color: #374151; margin-bottom: 8px;">
                        Horas <span style="color: #ef4444;">*</span>
                    </label>
                    <input type="number" 
                           name="horas" 
                           class="form-control" 
                           min="0" 
                           required
                           placeholder="Ej: 120" 
                           value="<?php echo isset($_SESSION['old_input']['horas']) ? htmlspecialchars($_SESSION['old_input']['horas']) : ''; ?>"
                           style="width: 100%; padding: 12px; border: 1px solid #e5e7eb; border-radius: 8px; font-size: 14px;">
                    <small style="color: #6b7280; font-size: 12px; margin-top: 4px; display: block;">Duración en horas de la competencia</small>
                </div>

                <div class="form-group">
                    <label style="display: block; font-size: 14px; font-weight: 600; color: #374151; margin-bottom: 8px;">
                        Nombre de la Unidad de Competencia <span style="color: #ef4444;">*</span>
                    </label>
                    <textarea name="nombre_unidad_competencia" 
                              class="form-control" 
                              rows="4" 
                              required 
                              placeholder="Ej: Programar aplicaciones web con lenguajes de programación" 
                              style="width: 100%; padding: 12px; border: 1px solid #e5e7eb; border-radius: 8px; font-size: 14px; resize: vertical;"><?php echo isset($_SESSION['old_input']['nombre_unidad_competencia']) ? htmlspecialchars($_SESSION['old_input']['nombre_unidad_competencia']) : ''; ?></textarea>
                    <small style="color: #6b7280; font-size: 12px; margin-top: 4px; display: block;">Descripción completa de la competencia</small>
                </div>

                <div style="display: flex; gap: 12px; justify-content: flex-end; margin-top: 32px; padding-top: 24px; border-top: 1px solid #e5e7eb;">
                    <a href="<?php echo BASE_PATH; ?>competencia/index" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Guardar Competencia</button>
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
