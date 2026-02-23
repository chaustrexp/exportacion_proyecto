<?php
// Vista de ver competencia
// Los datos vienen del controlador: $pageTitle, $registro
?>

<div class="main-content">
    <div style="padding: 32px 32px 24px; border-bottom: 1px solid #e5e7eb;">
        <a href="<?php echo BASE_PATH; ?>competencia/index" style="display: inline-flex; align-items: center; gap: 8px; color: #6b7280; text-decoration: none; margin-bottom: 16px; font-size: 14px;">
            <i data-lucide="arrow-left" style="width: 18px; height: 18px;"></i>
            Volver a Competencias
        </a>
        <div style="display: flex; justify-content: space-between; align-items: start;">
            <div>
                <h1 style="font-size: 28px; font-weight: 700; color: #1f2937; margin: 0 0 4px;"><?php echo htmlspecialchars($registro['comp_nombre_corto'] ?? 'Competencia'); ?></h1>
                <p style="font-size: 14px; color: #6b7280; margin: 0;">ID: <strong style="color: #10b981;"><?php echo htmlspecialchars($registro['comp_id'] ?? ''); ?></strong></p>
            </div>
            <a href="<?php echo BASE_PATH; ?>competencia/editar/<?php echo htmlspecialchars($registro['comp_id'] ?? ''); ?>" class="btn btn-primary">Editar</a>
        </div>
    </div>

    <div style="max-width: 900px; margin: 0 auto; padding: 32px;">
        <div style="background: white; border-radius: 12px; border: 1px solid #e5e7eb; padding: 32px;">
            
            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 24px; margin-bottom: 24px;">
                
                <div>
                    <div style="font-size: 12px; color: #6b7280; margin-bottom: 4px; text-transform: uppercase; font-weight: 600;">Código/Nombre Corto</div>
                    <div style="font-size: 20px; font-weight: 700; color: #10b981;"><?php echo htmlspecialchars($registro['comp_nombre_corto'] ?? 'N/A'); ?></div>
                </div>

                <div>
                    <div style="font-size: 12px; color: #6b7280; margin-bottom: 4px; text-transform: uppercase; font-weight: 600;">Horas</div>
                    <div style="font-size: 20px; font-weight: 700; color: #1f2937;">
                        <span style="background: #E8F5E8; color: #39A900; padding: 6px 16px; border-radius: 12px; font-size: 18px;">
                            <?php echo htmlspecialchars($registro['comp_horas'] ?? '0'); ?> h
                        </span>
                    </div>
                </div>

                <div style="grid-column: 1 / -1;">
                    <div style="font-size: 12px; color: #6b7280; margin-bottom: 8px; text-transform: uppercase; font-weight: 600;">Nombre de la Unidad de Competencia</div>
                    <div style="font-size: 16px; font-weight: 500; color: #1f2937; line-height: 1.6;">
                        <?php echo htmlspecialchars($registro['comp_nombre_unidad_competencia'] ?? 'N/A'); ?>
                    </div>
                </div>

            </div>

            <div style="display: flex; gap: 12px; justify-content: flex-end; padding-top: 24px; border-top: 1px solid #e5e7eb;">
                <a href="<?php echo BASE_PATH; ?>competencia/index" class="btn btn-secondary">Volver</a>
                <a href="<?php echo BASE_PATH; ?>competencia/editar/<?php echo htmlspecialchars($registro['comp_id'] ?? ''); ?>" class="btn btn-primary">Editar Competencia</a>
            </div>
        </div>
    </div>
</div>

<script>
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
</script>
