<?php
// Vista de ver ficha
// Los datos vienen del controlador: $pageTitle, $registro
?>

<div class="main-content">
    <!-- Header -->
    <div style="padding: 32px 32px 24px; border-bottom: 1px solid #e5e7eb;">
        <a href="<?php echo BASE_PATH; ?>ficha/index" style="display: inline-flex; align-items: center; gap: 8px; color: #6b7280; text-decoration: none; margin-bottom: 16px; font-size: 14px;">
            <i data-lucide="arrow-left" style="width: 18px; height: 18px;"></i>
            Volver a Fichas
        </a>
        <div style="display: flex; justify-content: space-between; align-items: start;">
            <div>
                <h1 style="font-size: 28px; font-weight: 700; color: #1f2937; margin: 0 0 4px;">Ficha #<?php echo htmlspecialchars(str_pad($registro['fich_numero'] ?? $registro['fich_id'], 8, '0', STR_PAD_LEFT)); ?></h1>
                <p style="font-size: 14px; color: #6b7280; margin: 0;"><?php echo htmlspecialchars($registro['prog_denominacion'] ?? 'Sin programa'); ?></p>
            </div>
            <a href="<?php echo BASE_PATH; ?>ficha/edit/<?php echo htmlspecialchars($registro['fich_id'] ?? ''); ?>" class="btn btn-primary">Editar</a>
        </div>
    </div>

    <!-- Details -->
    <div style="max-width: 900px; margin: 0 auto; padding: 32px;">
        <div style="background: white; border-radius: 12px; border: 1px solid #e5e7eb; padding: 32px;">
            
            <!-- Info Grid -->
            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 24px;">
                
                <div>
                    <div style="font-size: 12px; color: #6b7280; margin-bottom: 4px; text-transform: uppercase; font-weight: 600;">Número de Ficha</div>
                    <div style="font-size: 20px; font-weight: 700; color: #3b82f6;">
                        <?php echo htmlspecialchars(str_pad($registro['fich_numero'] ?? $registro['fich_id'], 8, '0', STR_PAD_LEFT)); ?>
                    </div>
                </div>

                <div>
                    <div style="font-size: 12px; color: #6b7280; margin-bottom: 4px; text-transform: uppercase; font-weight: 600;">Jornada</div>
                    <div style="font-size: 18px; font-weight: 600; color: #1f2937;">
                        <?php echo htmlspecialchars($registro['fich_jornada'] ?? 'No especificada'); ?>
                    </div>
                </div>

                <div style="grid-column: 1 / -1;">
                    <div style="font-size: 12px; color: #6b7280; margin-bottom: 4px; text-transform: uppercase; font-weight: 600;">Programa</div>
                    <div style="font-size: 18px; font-weight: 600; color: #1f2937;">
                        <?php echo htmlspecialchars($registro['prog_denominacion'] ?? 'Sin programa'); ?>
                    </div>
                </div>

                <div style="grid-column: 1 / -1;">
                    <div style="font-size: 12px; color: #6b7280; margin-bottom: 4px; text-transform: uppercase; font-weight: 600;">Instructor Líder</div>
                    <div style="font-size: 16px; font-weight: 600; color: #1f2937;">
                        <span style="background: #E8F5E8; color: #39A900; padding: 6px 12px; border-radius: 12px; font-size: 14px;">
                            <?php echo htmlspecialchars($registro['instructor_lider'] ?? 'Sin instructor'); ?>
                        </span>
                    </div>
                </div>

                <div>
                    <div style="font-size: 12px; color: #6b7280; margin-bottom: 4px; text-transform: uppercase; font-weight: 600;">Fecha Inicio Lectiva</div>
                    <div style="font-size: 16px; font-weight: 600; color: #1f2937;">
                        <?php echo ($registro['fich_fecha_ini_lectiva'] ?? false) ? date('d/m/Y', strtotime($registro['fich_fecha_ini_lectiva'])) : 'N/A'; ?>
                    </div>
                </div>

                <div>
                    <div style="font-size: 12px; color: #6b7280; margin-bottom: 4px; text-transform: uppercase; font-weight: 600;">Fecha Fin Lectiva</div>
                    <div style="font-size: 16px; font-weight: 600; color: #1f2937;">
                        <?php echo ($registro['fich_fecha_fin_lectiva'] ?? false) ? date('d/m/Y', strtotime($registro['fich_fecha_fin_lectiva'])) : 'N/A'; ?>
                    </div>
                </div>

                <div style="grid-column: 1 / -1;">
                    <div style="font-size: 12px; color: #6b7280; margin-bottom: 4px; text-transform: uppercase; font-weight: 600;">Coordinación</div>
                    <div style="font-size: 16px; font-weight: 600; color: #1f2937;">
                        <?php echo htmlspecialchars($registro['coord_nombre'] ?? 'Sin coordinación'); ?>
                    </div>
                </div>

            </div>

            <!-- Actions -->
            <div style="display: flex; gap: 12px; justify-content: flex-end; padding-top: 24px; border-top: 1px solid #e5e7eb; margin-top: 24px;">
                <a href="<?php echo BASE_PATH; ?>ficha/index" class="btn btn-secondary">Volver</a>
                <a href="<?php echo BASE_PATH; ?>ficha/edit/<?php echo htmlspecialchars($registro['fich_id'] ?? ''); ?>" class="btn btn-primary">Editar Ficha</a>
            </div>
        </div>
    </div>
</div>

<script>
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
</script>
