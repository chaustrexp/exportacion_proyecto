<?php
// Vista de ver programa
// Los datos vienen del controlador: $pageTitle, $registro
?>

<div class="main-content">
    <!-- Header Simple -->
    <div style="padding: 32px 32px 24px; border-bottom: 1px solid #e5e7eb;">
        <a href="<?php echo BASE_PATH; ?>programa/index" style="display: inline-flex; align-items: center; gap: 8px; color: #6b7280; text-decoration: none; margin-bottom: 16px; font-size: 14px;">
            <i data-lucide="arrow-left" style="width: 18px; height: 18px;"></i>
            Volver a Programas
        </a>
        <div style="display: flex; justify-content: space-between; align-items: start;">
            <div>
                <h1 style="font-size: 28px; font-weight: 700; color: #1f2937; margin: 0 0 4px;"><?php echo htmlspecialchars($registro['prog_denominacion'] ?? 'Programa'); ?></h1>
                <p style="font-size: 14px; color: #6b7280; margin: 0;">Código: <strong style="color: #39A900;"><?php echo htmlspecialchars($registro['prog_codigo'] ?? ''); ?></strong></p>
            </div>
            <a href="<?php echo BASE_PATH; ?>programa/edit/<?php echo htmlspecialchars($registro['prog_codigo'] ?? ''); ?>" class="btn btn-primary">Editar</a>
        </div>
    </div>

    <!-- Details -->
    <div style="max-width: 800px; margin: 0 auto; padding: 32px;">
        <div style="background: white; border-radius: 12px; border: 1px solid #e5e7eb; padding: 32px;">
            
            <!-- Info Grid -->
            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 24px; margin-bottom: 24px;">
                
                <div>
                    <div style="font-size: 12px; color: #6b7280; margin-bottom: 4px; text-transform: uppercase; font-weight: 600;">Código</div>
                    <div style="font-size: 18px; font-weight: 700; color: #39A900;"><?php echo htmlspecialchars($registro['prog_codigo'] ?? 'N/A'); ?></div>
                </div>

                <div>
                    <div style="font-size: 12px; color: #6b7280; margin-bottom: 4px; text-transform: uppercase; font-weight: 600;">Tipo</div>
                    <div style="font-size: 18px; font-weight: 700; color: #1f2937;"><?php echo htmlspecialchars($registro['prog_tipo'] ?? 'No especificado'); ?></div>
                </div>

                <div style="grid-column: 1 / -1;">
                    <div style="font-size: 12px; color: #6b7280; margin-bottom: 4px; text-transform: uppercase; font-weight: 600;">Nombre del Programa</div>
                    <div style="font-size: 18px; font-weight: 600; color: #1f2937;"><?php echo htmlspecialchars($registro['prog_denominacion'] ?? 'N/A'); ?></div>
                </div>

                <div style="grid-column: 1 / -1;">
                    <div style="font-size: 12px; color: #6b7280; margin-bottom: 4px; text-transform: uppercase; font-weight: 600;">Título que Otorga</div>
                    <div style="font-size: 16px; font-weight: 600; color: #1f2937;">
                        <span style="background: #E8F5E8; color: #39A900; padding: 6px 12px; border-radius: 12px; font-size: 14px;">
                            <?php echo htmlspecialchars($registro['titpro_nombre'] ?? 'Sin título'); ?>
                        </span>
                    </div>
                </div>

            </div>

            <!-- Actions -->
            <div style="display: flex; gap: 12px; justify-content: flex-end; padding-top: 24px; border-top: 1px solid #e5e7eb;">
                <a href="<?php echo BASE_PATH; ?>programa/index" class="btn btn-secondary">Volver</a>
                <a href="<?php echo BASE_PATH; ?>programa/edit/<?php echo htmlspecialchars($registro['prog_codigo'] ?? ''); ?>" class="btn btn-primary">Editar Programa</a>
            </div>
        </div>
    </div>
</div>

<script>
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
</script>
