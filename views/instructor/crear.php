<?php
// Vista de crear instructor
// Los datos vienen del controlador: $pageTitle, $centros
?>

<div class="main-content">
    <div style="max-width: 700px; margin: 0 auto; padding: 32px;">
        <div style="background: white; border-radius: 12px; border: 1px solid #e5e7eb; padding: 32px;">
            <div style="margin-bottom: 32px; padding-bottom: 24px; border-bottom: 1px solid #e5e7eb;">
                <a href="<?php echo BASE_PATH; ?>instructor/index" style="display: inline-flex; align-items: center; gap: 8px; color: #6b7280; text-decoration: none; margin-bottom: 16px; font-size: 14px;">
                    <i data-lucide="arrow-left" style="width: 18px; height: 18px;"></i>
                    Volver a Instructores
                </a>
                <h1 style="font-size: 24px; font-weight: 700; color: #1f2937; margin: 0 0 4px;">Crear Nuevo Instructor</h1>
                <p style="font-size: 14px; color: #6b7280; margin: 0;">Complete la información del instructor</p>
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
            
            <form method="POST" action="<?php echo BASE_PATH; ?>instructor/crear">
                <div class="form-row" style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                    <div class="form-group">
                        <label style="display: block; font-size: 14px; font-weight: 600; color: #374151; margin-bottom: 8px;">
                            Nombres <span style="color: #ef4444;">*</span>
                        </label>
                        <input type="text" 
                               name="inst_nombres" 
                               class="form-control" 
                               required 
                               placeholder="Ej: Juan Carlos"
                               value="<?php echo isset($_SESSION['old_input']['inst_nombres']) ? htmlspecialchars($_SESSION['old_input']['inst_nombres']) : ''; ?>"
                               style="width: 100%; padding: 12px; border: 1px solid #e5e7eb; border-radius: 8px; font-size: 14px;">
                    </div>
                    
                    <div class="form-group">
                        <label style="display: block; font-size: 14px; font-weight: 600; color: #374151; margin-bottom: 8px;">
                            Apellidos <span style="color: #ef4444;">*</span>
                        </label>
                        <input type="text" 
                               name="inst_apellidos" 
                               class="form-control" 
                               required 
                               placeholder="Ej: Pérez García"
                               value="<?php echo isset($_SESSION['old_input']['inst_apellidos']) ? htmlspecialchars($_SESSION['old_input']['inst_apellidos']) : ''; ?>"
                               style="width: 100%; padding: 12px; border: 1px solid #e5e7eb; border-radius: 8px; font-size: 14px;">
                    </div>
                </div>

                <div class="form-row" style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                    <div class="form-group">
                        <label style="display: block; font-size: 14px; font-weight: 600; color: #374151; margin-bottom: 8px;">
                            Correo Electrónico <span style="color: #ef4444;">*</span>
                        </label>
                        <input type="email" 
                               name="inst_correo" 
                               class="form-control" 
                               required 
                               placeholder="Ej: juan.perez@sena.edu.co"
                               value="<?php echo isset($_SESSION['old_input']['inst_correo']) ? htmlspecialchars($_SESSION['old_input']['inst_correo']) : ''; ?>"
                               style="width: 100%; padding: 12px; border: 1px solid #e5e7eb; border-radius: 8px; font-size: 14px;">
                    </div>
                    
                    <div class="form-group">
                        <label style="display: block; font-size: 14px; font-weight: 600; color: #374151; margin-bottom: 8px;">
                            Teléfono
                        </label>
                        <input type="text" 
                               name="inst_telefono" 
                               class="form-control" 
                               placeholder="Ej: 3001234567"
                               value="<?php echo isset($_SESSION['old_input']['inst_telefono']) ? htmlspecialchars($_SESSION['old_input']['inst_telefono']) : ''; ?>"
                               style="width: 100%; padding: 12px; border: 1px solid #e5e7eb; border-radius: 8px; font-size: 14px;">
                    </div>
                </div>

                <div class="form-group">
                    <label style="display: block; font-size: 14px; font-weight: 600; color: #374151; margin-bottom: 8px;">
                        Centro de Formación <span style="color: #ef4444;">*</span>
                    </label>
                    <select name="centro_formacion_cent_id" 
                            class="form-control" 
                            required 
                            style="width: 100%; padding: 12px; border: 1px solid #e5e7eb; border-radius: 8px; font-size: 14px;">
                        <option value="">Seleccione un centro...</option>
                        <?php if (isset($centros) && is_array($centros)): ?>
                            <?php foreach ($centros as $centro): ?>
                                <option value="<?php echo htmlspecialchars($centro['cent_id'] ?? ''); ?>"
                                        <?php echo (isset($_SESSION['old_input']['centro_formacion_cent_id']) && $_SESSION['old_input']['centro_formacion_cent_id'] == $centro['cent_id']) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($centro['cent_nombre'] ?? ''); ?>
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label style="display: block; font-size: 14px; font-weight: 600; color: #374151; margin-bottom: 8px;">
                        Contraseña
                    </label>
                    <input type="password" 
                           name="inst_password" 
                           class="form-control" 
                           placeholder="Dejar vacío para usar contraseña por defecto (123456)" 
                           style="width: 100%; padding: 12px; border: 1px solid #e5e7eb; border-radius: 8px; font-size: 14px;">
                    <small style="color: #6b7280; font-size: 12px; margin-top: 4px; display: block;">Si no ingresa una contraseña, se usará "123456" por defecto</small>
                </div>

                <div style="display: flex; gap: 12px; justify-content: flex-end; margin-top: 32px; padding-top: 24px; border-top: 1px solid #e5e7eb;">
                    <a href="<?php echo BASE_PATH; ?>instructor/index" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Guardar Instructor</button>
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
