<?php
// Esta vista es renderizada por el controlador
$registro = $data['registro'] ?? null;
?>

<div class="main-content">
    <div style="max-width: 800px; margin: 0 auto; padding: 32px;">
        <!-- Header -->
        <div style="margin-bottom: 32px; display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h1 style="font-size: 28px; font-weight: 700; color: #1f2937; margin: 0 0 8px;">Detalle de la Sede</h1>
                <p style="font-size: 14px; color: #6b7280; margin: 0;">Información completa de la sede</p>
            </div>
            <a href="<?php echo BASE_PATH; ?>sede/editar/<?php echo $registro['sede_id']; ?>" class="btn btn-primary">
                <i data-lucide="edit" style="width: 16px; height: 16px;"></i>
                Editar
            </a>
        </div>

        <!-- Card de Detalles -->
        <div style="background: white; border-radius: 12px; border: 1px solid #e5e7eb; overflow: hidden;">
            <!-- Header del Card -->
            <div style="background: linear-gradient(135deg, #14b8a6 0%, #0d9488 100%); padding: 24px; color: white;">
                <div style="display: flex; align-items: center; gap: 16px;">
                    <div style="width: 64px; height: 64px; background: rgba(255,255,255,0.2); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 32px;">
                        📍
                    </div>
                    <div>
                        <h2 style="font-size: 24px; font-weight: 700; margin: 0 0 4px;"><?php echo htmlspecialchars($registro['sede_nombre']); ?></h2>
                        <p style="margin: 0; opacity: 0.9;">Sede del Centro de Formación</p>
                    </div>
                </div>
            </div>

            <!-- Contenido -->
            <div style="padding: 32px;">
                <div style="display: grid; gap: 24px;">
                    <!-- ID -->
                    <div style="border-bottom: 1px solid #f3f4f6; padding-bottom: 16px;">
                        <div style="font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase; margin-bottom: 8px;">
                            ID de la Sede
                        </div>
                        <div style="font-size: 16px; color: #1f2937; font-weight: 600;">
                            <?php echo htmlspecialchars($registro['sede_id']); ?>
                        </div>
                    </div>

                    <!-- Nombre -->
                    <div style="border-bottom: 1px solid #f3f4f6; padding-bottom: 16px;">
                        <div style="font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase; margin-bottom: 8px;">
                            Nombre de la Sede
                        </div>
                        <div style="font-size: 16px; color: #1f2937;">
                            <?php echo htmlspecialchars($registro['sede_nombre']); ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer con Acciones -->
            <div style="background: #f9fafb; padding: 20px 32px; display: flex; gap: 12px; justify-content: flex-end; border-top: 1px solid #e5e7eb;">
                <a href="<?php echo BASE_PATH; ?>sede/index" class="btn btn-secondary">
                    <i data-lucide="arrow-left" style="width: 16px; height: 16px;"></i>
                    Volver al Listado
                </a>
                <a href="<?php echo BASE_PATH; ?>sede/editar/<?php echo $registro['sede_id']; ?>" class="btn btn-primary">
                    <i data-lucide="edit" style="width: 16px; height: 16px;"></i>
                    Editar Sede
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
