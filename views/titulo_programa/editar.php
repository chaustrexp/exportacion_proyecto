<?php
// Vista de editar titulo_programa
// Los datos vienen del controlador: $pageTitle, $registro
?>

<div class="main-content">
    <div style="max-width: 700px; margin: 0 auto; padding: 32px;">
        <div style="background: white; border-radius: 12px; border: 1px solid #e5e7eb; padding: 32px;">
            <div style="margin-bottom: 32px; padding-bottom: 24px; border-bottom: 1px solid #e5e7eb;">
                <a href="<?php echo BASE_PATH; ?>titulo_programa/index" style="display: inline-flex; align-items: center; gap: 8px; color: #6b7280; text-decoration: none; margin-bottom: 16px; font-size: 14px;">
                    <i data-lucide="arrow-left" style="width: 18px; height: 18px;"></i>
                    Volver a Títulos de Programa
                </a>
                <h1 style="font-size: 24px; font-weight: 700; color: #1f2937; margin: 0 0 4px;">Editar Título</h1>
                <p style="font-size: 14px; color: #6b7280; margin: 0;">Modifica la información del título</p>
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
            
            <form method="POST" action="<?php echo BASE_PATH; ?>titulo_programa/editar?id=<?php echo htmlspecialchars($registro['titpro_id'] ?? ''); ?>">
                <div class="form-group">
                    <label style="display: block; font-size: 14px; font-weight: 600; color: #374151; margin-bottom: 8px;">
                        ID
                    </label>
                    <input type="text" 
                           value="<?php echo htmlspecialchars($registro['titpro_id'] ?? ''); ?>" 
                           disabled
                           style="width: 100%; padding: 12px; border: 1px solid #e5e7eb; border-radius: 8px; font-size: 14px; background: #f9fafb; color: #6b7280;">
                </div>
                
                <div class="form-group">
                    <label style="display: block; font-size: 14px; font-weight: 600; color: #374151; margin-bottom: 8px;">
                        Nombre del Título <span style="color: #ef4444;">*</span>
                    </label>
                    <input type="text" 
                           name="titpro_nombre" 
                           class="form-control" 
                           required
                           value="<?php echo isset($_SESSION['old_input']['titpro_nombre']) ? htmlspecialchars($_SESSION['old_input']['titpro_nombre']) : htmlspecialchars($registro['titpro_nombre'] ?? ''); ?>"
                           style="width: 100%; padding: 12px; border: 1px solid #e5e7eb; border-radius: 8px; font-size: 14px;">
                </div>
                
                <div style="display: flex; gap: 12px; justify-content: flex-end; margin-top: 32px; padding-top: 24px; border-top: 1px solid #e5e7eb;">
                    <a href="<?php echo BASE_PATH; ?>titulo_programa/index" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Actualizar Título</button>
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
