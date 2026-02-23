<?php
// Vista de ver titulo_programa
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
                <h1 style="font-size: 24px; font-weight: 700; color: #1f2937; margin: 0 0 4px;"><?php echo htmlspecialchars($registro['titpro_denominacion'] ?? 'Título'); ?></h1>
                <p style="font-size: 14px; color: #6b7280; margin: 0;">ID: <strong style="color: #f59e0b;"><?php echo htmlspecialchars($registro['titpro_id'] ?? ''); ?></strong></p>
            </div>
            
            <div style="display: grid; gap: 24px;">
                <div style="padding: 20px; background: #f9fafb; border-radius: 8px; border: 1px solid #e5e7eb;">
                    <div style="font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase; margin-bottom: 8px;">ID</div>
                    <div style="font-size: 16px; color: #1f2937; font-weight: 600;">
                        <?php echo htmlspecialchars($registro['titpro_id'] ?? 'N/A'); ?>
                    </div>
                </div>
                
                <div style="padding: 20px; background: #f9fafb; border-radius: 8px; border: 1px solid #e5e7eb;">
                    <div style="font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase; margin-bottom: 8px;">Nombre del Título</div>
                    <div style="font-size: 16px; color: #1f2937; font-weight: 600;">
                        <?php echo htmlspecialchars($registro['titpro_nombre'] ?? 'N/A'); ?>
                    </div>
                </div>
            </div>
            
            <div style="display: flex; gap: 12px; justify-content: flex-end; margin-top: 32px; padding-top: 24px; border-top: 1px solid #e5e7eb;">
                <a href="<?php echo BASE_PATH; ?>titulo_programa/index" class="btn btn-secondary">Volver</a>
                <a href="<?php echo BASE_PATH; ?>titulo_programa/editar?id=<?php echo htmlspecialchars($registro['titpro_id'] ?? ''); ?>" class="btn btn-primary">Editar</a>
            </div>
        </div>
    </div>
</div>

<script>
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
</script>
