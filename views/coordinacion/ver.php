<?php
// Esta vista es renderizada por el controlador
$registro = $data['registro'] ?? null;
?>

<div class="main-content">
    <div style="max-width: 800px; margin: 0 auto; padding: 32px;">
        <!-- Header -->
        <div style="margin-bottom: 32px; display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h1 style="font-size: 28px; font-weight: 700; color: #1f2937; margin: 0 0 8px;">Detalle de Coordinación</h1>
                <p style="font-size: 14px; color: #6b7280; margin: 0;">Información completa de la coordinación</p>
            </div>
            <a href="<?php echo BASE_PATH; ?>coordinacion/editar/<?php echo $registro['coord_id']; ?>" class="btn btn-primary">
                <i data-lucide="edit" style="width: 16px; height: 16px;"></i>
                Editar
            </a>
        </div>

        <!-- Card de Detalles -->
        <div style="background: white; border-radius: 12px; border: 1px solid #e5e7eb; overflow: hidden;">
            <!-- Header del Card -->
            <div style="background: linear-gradient(135deg, #a855f7 0%, #9333ea 100%); padding: 24px; color: white;">
                <div style="display: flex; align-items: center; gap: 16px;">
                    <div style="width: 64px; height: 64px; background: rgba(255,255,255,0.2); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 32px;">
                        🎯
                    </div>
                    <div>
                        <h2 style="font-size: 24px; font-weight: 700; margin: 0 0 4px;"><?php echo htmlspecialchars($registro['coord_nombre']); ?></h2>
                        <p style="margin: 0; opacity: 0.9;">Coordinación Académica</p>
                    </div>
                </div>
            </div>

            <!-- Contenido -->
            <div style="padding: 32px;">
                <div style="display: grid; gap: 24px;">
                    <!-- ID -->
                    <div style="border-bottom: 1px solid #f3f4f6; padding-bottom: 16px;">
                        <div style="font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase; margin-bottom: 8px;">
                            ID de Coordinación
                        </div>
                        <div style="font-size: 16px; color: #1f2937; font-weight: 600;">
                            <?php echo htmlspecialchars($registro['coord_id']); ?>
                        </div>
                    </div>

                    <!-- Descripción -->
                    <div style="border-bottom: 1px solid #f3f4f6; padding-bottom: 16px;">
                        <div style="font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase; margin-bottom: 8px;">
                            Nombre de la Coordinación
                        </div>
                        <div style="font-size: 16px; color: #1f2937;">
                            <?php echo htmlspecialchars($registro['coord_nombre']); ?>
                        </div>
                    </div>

                    <!-- Centro de Formación -->
                    <div style="border-bottom: 1px solid #f3f4f6; padding-bottom: 16px;">
                        <div style="font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase; margin-bottom: 8px;">
                            Centro de Formación
                        </div>
                        <div style="font-size: 16px; color: #1f2937;">
                            <span style="background: #F5F3FF; color: #a855f7; padding: 6px 12px; border-radius: 8px; font-weight: 600;">
                                <?php echo htmlspecialchars($registro['cent_nombre'] ?? 'Sin centro'); ?>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer con Acciones -->
            <div style="background: #f9fafb; padding: 20px 32px; display: flex; gap: 12px; justify-content: flex-end; border-top: 1px solid #e5e7eb;">
                <a href="<?php echo BASE_PATH; ?>coordinacion/index" class="btn btn-secondary">
                    <i data-lucide="arrow-left" style="width: 16px; height: 16px;"></i>
                    Volver al Listado
                </a>
                <a href="<?php echo BASE_PATH; ?>coordinacion/editar/<?php echo $registro['coord_id']; ?>" class="btn btn-primary">
                    <i data-lucide="edit" style="width: 16px; height: 16px;"></i>
                    Editar Coordinación
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
</script>
