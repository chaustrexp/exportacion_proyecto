<?php
// Vista de estadísticas específica para Instructores
$rol = $_SESSION['usuario_rol'] ?? $_SESSION['rol'] ?? 'Instructor';
?>

<div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 24px;">
    
    <!-- Próxima Clase Highlight -->
    <div style="grid-column: span 2; background: linear-gradient(135deg, #39A900 0%, #2d8500 100%); padding: 24px; border-radius: 16px; color: white; display: flex; flex-direction: column; justify-content: space-between; position: relative; overflow: hidden; box-shadow: 0 4px 12px rgba(57, 169, 0, 0.2);">
        <div style="position: relative; z-index: 2;">
            <div style="font-size: 13px; font-weight: 600; text-transform: uppercase; letter-spacing: 1px; opacity: 0.9; margin-bottom: 8px;">PRÓXIMA CLASE</div>
            <?php if (isset($proximaClase) && $proximaClase): ?>
                <h3 style="font-size: 20px; font-weight: 700; margin: 0 0 4px;"><?php echo htmlspecialchars($proximaClase['ficha_nombre']); ?></h3>
                <p style="font-size: 14px; opacity: 0.8; margin: 0;">Ficha: <?php echo htmlspecialchars($proximaClase['ficha_codigo']); ?></p>
                <div style="margin-top: 16px; display: flex; align-items: center; gap: 8px;">
                    <i data-lucide="map-pin" style="width: 16px; height: 16px;"></i>
                    <span style="font-size: 14px; font-weight: 500;"><?php echo htmlspecialchars($proximaClase['ambiente_nombre']); ?></span>
                </div>
            <?php else: ?>
                <h3 style="font-size: 20px; font-weight: 700; margin: 0;">Sin clases próximas</h3>
                <p style="font-size: 14px; opacity: 0.8; margin: 0;">Disfruta tu tiempo libre</p>
            <?php endif; ?>
        </div>
        <i data-lucide="clock" style="position: absolute; right: -20px; bottom: -20px; width: 140px; height: 140px; opacity: 0.1; transform: rotate(-15deg);"></i>
    </div>

    <!-- Total Asignaciones -->
    <div class="stat-card" style="background: white; padding: 20px; border-radius: 16px; border: 1px solid #e5e7eb; display: flex; flex-direction: column; justify-content: center; transition: all 0.3s;">
        <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px;">
            <div style="width: 40px; height: 40px; background: #E0E7FF; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                <i data-lucide="calendar" style="width: 20px; height: 20px; color: #4F46E5;"></i>
            </div>
            <div style="font-size: 11px; color: #6b7280; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">Mis Labores</div>
        </div>
        <div style="font-size: 28px; font-weight: 800; color: #1f2937; line-height: 1;"><?php echo $totalAsignaciones; ?></div>
        <div style="font-size: 12px; color: #9ca3af; margin-top: 4px;">Asignaciones totales</div>
    </div>

    <!-- Mis Fichas -->
    <div class="stat-card" style="background: white; padding: 20px; border-radius: 16px; border: 1px solid #e5e7eb; display: flex; flex-direction: column; justify-content: center; transition: all 0.3s;">
        <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px;">
            <div style="width: 40px; height: 40px; background: #ECFDF5; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                <i data-lucide="users-2" style="width: 20px; height: 20px; color: #059669;"></i>
            </div>
            <div style="font-size: 11px; color: #6b7280; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">Mis Grupos</div>
        </div>
        <div style="font-size: 28px; font-weight: 800; color: #1f2937; line-height: 1;"><?php echo $totalFichas; ?></div>
        <div style="font-size: 12px; color: #9ca3af; margin-top: 4px;">Fichas asignadas</div>
    </div>

</div>

<!-- Segunda Fila Instructor: Progreso y Estado -->
<div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 24px;">
    
    <div class="stat-card" style="background: white; padding: 16px 20px; border-radius: 12px; border: 1px solid #e5e7eb; display: flex; align-items: center; gap: 15px;">
        <div style="width: 10px; height: 10px; background: #10b981; border-radius: 50%;"></div>
        <span style="font-size: 14px; font-weight: 600; color: #4b5563;">Activas: <span style="color: #1f2937;"><?php echo $asignacionesActivas; ?></span></span>
    </div>

    <div class="stat-card" style="background: white; padding: 16px 20px; border-radius: 12px; border: 1px solid #e5e7eb; display: flex; align-items: center; gap: 15px;">
        <div style="width: 10px; height: 10px; background: #3b82f6; border-radius: 50%;"></div>
        <span style="font-size: 14px; font-weight: 600; color: #4b5563;">Finalizadas: <span style="color: #1f2937;"><?php echo $asignacionesFinalizadas; ?></span></span>
    </div>

    <div class="stat-card" style="background: white; padding: 16px 20px; border-radius: 12px; border: 1px solid #e5e7eb; display: flex; align-items: center; gap: 15px;">
        <div style="width: 10px; height: 10px; background: #f59e0b; border-radius: 50%;"></div>
        <span style="font-size: 14px; font-weight: 600; color: #4b5563;">Pendientes: <span style="color: #1f2937;"><?php echo $asignacionesNoActivas; ?></span></span>
    </div>

</div>
