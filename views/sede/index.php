<?php
$registros = $data['registros'] ?? [];
?>

<div class="main-content">
    <!-- Header -->
    <div style="padding: 32px 32px 24px; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #e5e7eb;">
        <div>
            <h1 style="font-size: 28px; font-weight: 700; color: #1f2937; margin: 0 0 4px;">Sedes</h1>
            <p style="font-size: 14px; color: #6b7280; margin: 0;">Gestiona las sedes del centro de formación</p>
        </div>
        <a href="<?php echo BASE_PATH; ?>sede/crear" class="btn btn-primary" style="display: inline-flex; align-items: center; gap: 8px;">
            <i data-lucide="plus" style="width: 18px; height: 18px;"></i>
            Nueva Sede
        </a>
    </div>

    <!-- Alert -->
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success" style="margin: 24px 32px;">
            <?php 
            echo $_SESSION['success'];
            unset($_SESSION['success']);
            ?>
        </div>
    <?php endif; ?>
    
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger" style="margin: 24px 32px;">
            <?php 
            echo $_SESSION['error'];
            unset($_SESSION['error']);
            ?>
        </div>
    <?php endif; ?>

    <!-- Stats -->
    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; padding: 24px 32px;">
        <div style="background: white; padding: 20px; border-radius: 12px; border: 1px solid #e5e7eb;">
            <div style="font-size: 13px; color: #6b7280; margin-bottom: 8px;">Total Sedes</div>
            <div style="font-size: 32px; font-weight: 700; color: #14b8a6;"><?php echo count($registros); ?></div>
        </div>
        <div style="background: white; padding: 20px; border-radius: 12px; border: 1px solid #e5e7eb;">
            <div style="font-size: 13px; color: #6b7280; margin-bottom: 8px;">Sedes Activas</div>
            <div style="font-size: 32px; font-weight: 700; color: #3b82f6;">
                <?php echo count($registros); ?>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div style="padding: 0 32px 32px;">
        <div style="background: white; border-radius: 12px; border: 1px solid #e5e7eb; overflow: hidden;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: #f9fafb; border-bottom: 1px solid #e5e7eb;">
                        <th style="padding: 16px; text-align: left; font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase;">ID</th>
                        <th style="padding: 16px; text-align: left; font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase;">Nombre</th>
                        <th style="padding: 16px; text-align: right; font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($registros)): ?>
                    <tr>
                        <td colspan="3" style="text-align: center; padding: 60px 20px; color: #6b7280;">
                            <div style="font-size: 48px; margin-bottom: 16px;">📍</div>
                            <p style="margin: 0 0 16px; font-size: 16px;">No hay sedes registradas</p>
                            <a href="<?php echo BASE_PATH; ?>sede/crear" class="btn btn-primary btn-sm">Crear Primera Sede</a>
                        </td>
                    </tr>
                    <?php else: ?>
                        <?php foreach ($registros as $registro): ?>
                        <tr style="border-bottom: 1px solid #f3f4f6;">
                            <td style="padding: 16px;">
                                <strong style="color: #14b8a6; font-size: 14px;"><?php echo htmlspecialchars($registro['sede_id'] ?? ''); ?></strong>
                            </td>
                            <td style="padding: 16px;">
                                <div style="font-weight: 600; color: #1f2937;"><?php echo htmlspecialchars($registro['sede_nombre'] ?? ''); ?></div>
                            </td>
                            <td style="padding: 16px;">
                                <div class="btn-group" style="justify-content: flex-end;">
                                    <a href="<?php echo BASE_PATH; ?>sede/ver/<?php echo $registro['sede_id']; ?>" class="btn btn-secondary btn-sm">Ver</a>
                                    <a href="<?php echo BASE_PATH; ?>sede/editar/<?php echo $registro['sede_id']; ?>" class="btn btn-primary btn-sm">Editar</a>
                                    <a href="<?php echo BASE_PATH; ?>sede/eliminar/<?php echo $registro['sede_id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Está seguro de eliminar esta sede?')">Eliminar</a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
</script>
