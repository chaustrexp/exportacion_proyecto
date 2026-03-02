<?php
// Vista de ver instructor
// Los datos vienen del controlador: $pageTitle, $registro
?>

<div class="main-content">
    <div style="max-width: 700px; margin: 0 auto; padding: 32px;">
        <div style="background: white; border-radius: 12px; border: 1px solid #e5e7eb; padding: 32px;">
            <div style="margin-bottom: 32px; padding-bottom: 24px; border-bottom: 1px solid #e5e7eb;">
                <a href="<?php echo BASE_PATH; ?>instructor/index" style="display: inline-flex; align-items: center; gap: 8px; color: #6b7280; text-decoration: none; margin-bottom: 16px; font-size: 14px;">
                    <i data-lucide="arrow-left" style="width: 18px; height: 18px;"></i>
                    Volver a Instructores
                </a>
                <h1 style="font-size: 24px; font-weight: 700; color: #1f2937; margin: 0 0 4px;">Detalle del Instructor</h1>
                <p style="font-size: 14px; color: #6b7280; margin: 0;">Información completa del instructor</p>
            </div>
            
            <div style="display: grid; gap: 24px;">
                <div style="padding: 20px; background: #f9fafb; border-radius: 8px; border: 1px solid #e5e7eb;">
                    <div style="font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase; margin-bottom: 8px;">ID</div>
                    <div style="font-size: 16px; color: #1f2937; font-weight: 600;">
                        <?php echo htmlspecialchars($registro['inst_id'] ?? 'N/A'); ?>
                    </div>
                </div>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                    <div style="padding: 20px; background: #f9fafb; border-radius: 8px; border: 1px solid #e5e7eb;">
                        <div style="font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase; margin-bottom: 8px;">Nombres</div>
                        <div style="font-size: 16px; color: #1f2937; font-weight: 600;">
                            <?php echo htmlspecialchars($registro['inst_nombres'] ?? 'N/A'); ?>
                        </div>
                    </div>
                    
                    <div style="padding: 20px; background: #f9fafb; border-radius: 8px; border: 1px solid #e5e7eb;">
                        <div style="font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase; margin-bottom: 8px;">Apellidos</div>
                        <div style="font-size: 16px; color: #1f2937; font-weight: 600;">
                            <?php echo htmlspecialchars($registro['inst_apellidos'] ?? 'N/A'); ?>
                        </div>
                    </div>
                </div>
                
                <div style="padding: 20px; background: #f9fafb; border-radius: 8px; border: 1px solid #e5e7eb;">
                    <div style="font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase; margin-bottom: 8px;">Correo Electrónico</div>
                    <div style="font-size: 16px; color: #1f2937; font-weight: 600;">
                        <?php echo htmlspecialchars($registro['inst_correo'] ?? 'N/A'); ?>
                    </div>
                </div>
                
                <div style="padding: 20px; background: #f9fafb; border-radius: 8px; border: 1px solid #e5e7eb;">
                    <div style="font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase; margin-bottom: 8px;">Teléfono</div>
                    <div style="font-size: 16px; color: #1f2937; font-weight: 600;">
                        <?php echo htmlspecialchars($registro['inst_telefono'] ?? 'N/A'); ?>
                    </div>
                </div>
                
                <div style="padding: 20px; background: #f9fafb; border-radius: 8px; border: 1px solid #e5e7eb;">
                    <div style="font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase; margin-bottom: 8px;">Centro de Formación</div>
                    <div style="font-size: 16px; color: #1f2937; font-weight: 600;">
                        <?php echo htmlspecialchars($registro['cent_nombre'] ?? 'N/A'); ?>
                    </div>
                </div>
            </div>
            
            <div style="display: flex; gap: 12px; justify-content: flex-end; margin-top: 32px; padding-top: 24px; border-top: 1px solid #e5e7eb;">
                <a href="<?php echo BASE_PATH; ?>instructor/index" class="btn btn-secondary">Volver</a>
                <a href="<?php echo BASE_PATH; ?>instructor/editar?id=<?php echo htmlspecialchars($registro['inst_id'] ?? ''); ?>" class="btn btn-primary">Editar</a>
            </div>
        </div>
    </div>
</div>

<script>
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
</script>
