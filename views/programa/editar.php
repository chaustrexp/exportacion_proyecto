<?php
// Vista de editar programa
// Los datos vienen del controlador: $pageTitle, $registro, $titulos
?>

<div class="main-content">
    <div style="max-width: 700px; margin: 0 auto; padding: 32px;">
        <div style="background: white; border-radius: 12px; border: 1px solid #e5e7eb; padding: 32px;">
            <!-- Header -->
            <div style="margin-bottom: 32px; padding-bottom: 24px; border-bottom: 1px solid #e5e7eb;">
                <a href="<?php echo BASE_PATH; ?>programa/index" style="display: inline-flex; align-items: center; gap: 8px; color: #6b7280; text-decoration: none; margin-bottom: 16px; font-size: 14px;">
                    <i data-lucide="arrow-left" style="width: 18px; height: 18px;"></i>
                    Volver a Programas
                </a>
                <h1 style="font-size: 24px; font-weight: 700; color: #1f2937; margin: 0 0 4px;">Editar Programa</h1>
                <p style="font-size: 14px; color: #6b7280; margin: 0;">Código: <strong style="color: #39A900;"><?php echo htmlspecialchars($registro['prog_codigo'] ?? ''); ?></strong></p>
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
            
            <form method="POST" action="<?php echo BASE_PATH; ?>programa/edit/<?php echo htmlspecialchars($registro['prog_codigo'] ?? ''); ?>">
                <div class="form-group">
                    <label style="display: block; font-size: 14px; font-weight: 600; color: #374151; margin-bottom: 8px;">
                        Código <span style="color: #ef4444;">*</span>
                    </label>
                    <input type="text" 
                           name="prog_codigo" 
                           class="form-control" 
                           value="<?php echo htmlspecialchars($registro['prog_codigo'] ?? ''); ?>" 
                           readonly
                           style="width: 100%; padding: 12px; border: 1px solid #e5e7eb; border-radius: 8px; font-size: 14px; background: #f9fafb;">
                    <small style="color: #6b7280;">El código no se puede modificar</small>
                </div>
                
                <div class="form-group">
                    <label style="display: block; font-size: 14px; font-weight: 600; color: #374151; margin-bottom: 8px;">
                        Denominación <span style="color: #ef4444;">*</span>
                    </label>
                    <input type="text" 
                           name="prog_denominacion" 
                           class="form-control" 
                           value="<?php echo htmlspecialchars($registro['prog_denominacion'] ?? ''); ?>" 
                           required
                           style="width: 100%; padding: 12px; border: 1px solid #e5e7eb; border-radius: 8px; font-size: 14px;">
                </div>
                
                <div class="form-group">
                    <label style="display: block; font-size: 14px; font-weight: 600; color: #374151; margin-bottom: 8px;">
                        Tipo <span style="color: #ef4444;">*</span>
                    </label>
                    <select name="prog_tipo" class="form-control" required style="width: 100%; padding: 12px; border: 1px solid #e5e7eb; border-radius: 8px; font-size: 14px;">
                        <option value="">Seleccione...</option>
                        <option value="Técnico" <?php echo (($registro['prog_tipo'] ?? '') == 'Técnico') ? 'selected' : ''; ?>>Técnico</option>
                        <option value="Tecnólogo" <?php echo (($registro['prog_tipo'] ?? '') == 'Tecnólogo') ? 'selected' : ''; ?>>Tecnólogo</option>
                        <option value="Especialización" <?php echo (($registro['prog_tipo'] ?? '') == 'Especialización') ? 'selected' : ''; ?>>Especialización</option>
                        <option value="Curso Corto" <?php echo (($registro['prog_tipo'] ?? '') == 'Curso Corto') ? 'selected' : ''; ?>>Curso Corto</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label style="display: block; font-size: 14px; font-weight: 600; color: #374151; margin-bottom: 8px;">
                        Título Programa <span style="color: #ef4444;">*</span>
                    </label>
                    <select name="titulo_programa_titpro_id" class="form-control" required style="width: 100%; padding: 12px; border: 1px solid #e5e7eb; border-radius: 8px; font-size: 14px;">
                        <option value="">Seleccione...</option>
                        <?php if (isset($titulos) && is_array($titulos)): ?>
                            <?php foreach ($titulos as $titulo): ?>
                                <option value="<?php echo htmlspecialchars($titulo['titpro_id'] ?? ''); ?>" 
                                        <?php echo (($registro['titulo_programa_titpro_id'] ?? '') == ($titulo['titpro_id'] ?? '')) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($titulo['titpro_nombre'] ?? ''); ?>
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>
                
                <div style="display: flex; gap: 12px; justify-content: flex-end; margin-top: 32px; padding-top: 24px; border-top: 1px solid #e5e7eb;">
                    <a href="<?php echo BASE_PATH; ?>programa/index" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Actualizar Programa</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
    
    // Focus effect en inputs
    document.querySelectorAll('.form-control').forEach(input => {
        if (!input.hasAttribute('readonly')) {
            input.addEventListener('focus', function() {
                this.style.borderColor = '#39A900';
                this.style.outline = 'none';
                this.style.boxShadow = '0 0 0 3px rgba(57, 169, 0, 0.1)';
            });
            input.addEventListener('blur', function() {
                this.style.borderColor = '#e5e7eb';
                this.style.boxShadow = 'none';
            });
        }
    });
</script>
