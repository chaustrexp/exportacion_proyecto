<?php
// Vista de estadísticas específica para Instructores
$rol = $_SESSION['usuario_rol'] ?? $_SESSION['rol'] ?? 'Instructor';
?>

<div style="display: grid; grid-template-columns: 1.5fr 1fr 1fr; gap: 24px; margin-bottom: 24px;">
    
    <!-- Tarjeta Principal: Próxima Clase -->
    <div style="background: #2d7a1e; padding: 32px; border-radius: 24px; color: white; position: relative; overflow: hidden; display: flex; flex-direction: column; justify-content: space-between; box-shadow: 0 10px 15px -3px rgba(45, 122, 30, 0.2);">
        <div style="position: relative; z-index: 2;">
            <div style="font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: rgba(255, 255, 255, 0.8); margin-bottom: 12px;">PRÓXIMA CLASE</div>
            <?php if (isset($proximaClase) && $proximaClase): ?>
                <h3 style="font-size: 36px; font-weight: 800; margin: 0 0 8px; line-height: 1.1; letter-spacing: -1px;"><?php echo htmlspecialchars($proximaClase['ficha_nombre']); ?></h3>
                <p style="font-size: 16px; color: rgba(255, 255, 255, 0.9); font-weight: 500; margin: 0;">Ficha: <?php echo htmlspecialchars($proximaClase['ficha_codigo']); ?></p>
            <?php else: ?>
                <h3 style="font-size: 36px; font-weight: 800; margin: 0 0 8px; line-height: 1.1; letter-spacing: -1px;">Sin clases próximas</h3>
                <p style="font-size: 16px; color: rgba(255, 255, 255, 0.7); font-weight: 500; margin: 0;">Disfruta de tu tiempo libre</p>
            <?php endif; ?>
        </div>
        
        <div style="margin-top: 32px; position: relative; z-index: 2;">
            <a href="<?php echo BASE_PATH; ?>instructor_dashboard/misAsignaciones" style="display: inline-flex; align-items: center; background: rgba(255, 255, 255, 0.2); color: white; padding: 10px 20px; border-radius: 12px; font-weight: 700; font-size: 14px; text-decoration: none; border: 1px solid rgba(255, 255, 255, 0.3); transition: all 0.2s;" onmouseover="this.style.background='white'; this.style.color='#2d7a1e';" onmouseout="this.style.background='rgba(255, 255, 255, 0.2)'; this.style.color='white';">
                Ver Agenda Completa
            </a>
        </div>
        
        <!-- Large Clock Icon decoration -->
        <div style="position: absolute; right: -20px; top: 10px; width: 180px; height: 180px; opacity: 0.15; pointer-events: none;">
            <i data-lucide="clock" style="width: 100%; height: 100%; transform: rotate(-10deg);"></i>
        </div>
    </div>

    <!-- Estadísticas Secundarias -->
    <div class="stat-card" style="background: white; padding: 32px; border-radius: 24px; border: 1px solid #e5e7eb; display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);">
        <div style="width: 48px; height: 48px; background: #e0e7ff; color: #4338ca; border-radius: 14px; display: flex; align-items: center; justify-content: center; margin-bottom: 16px;">
            <i data-lucide="clipboard-list" style="width: 24px; height: 24px;"></i>
        </div>
        <div style="font-size: 11px; color: #667085; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px;">MIS LABORES</div>
        <div style="font-size: 32px; font-weight: 800; color: #1f2937; line-height: 1;"><?php echo $totalAsignaciones; ?></div>
        <div style="font-size: 12px; color: #9ca3af; font-weight: 600; margin-top: 8px; text-transform: uppercase;">Asignaciones Totales</div>
    </div>

    <div class="stat-card" style="background: white; padding: 32px; border-radius: 24px; border: 1px solid #e5e7eb; display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);">
        <div style="width: 48px; height: 48px; background: #ecfdf5; color: #065f46; border-radius: 14px; display: flex; align-items: center; justify-content: center; margin-bottom: 16px;">
            <i data-lucide="users" style="width: 24px; height: 24px;"></i>
        </div>
        <div style="font-size: 11px; color: #667085; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px;">MIS GRUPOS</div>
        <div style="font-size: 32px; font-weight: 800; color: #1f2937; line-height: 1;"><?php echo $totalFichas; ?></div>
        <div style="font-size: 12px; color: #9ca3af; font-weight: 600; margin-top: 8px; text-transform: uppercase;">Fichas Asignadas</div>
    </div>

</div>

<!-- Resumen de Estados (Inline) -->
<div style="display: flex; gap: 32px; padding: 0 12px; margin-bottom: 32px;">
    <div style="display: flex; align-items: center; gap: 10px;">
        <div style="width: 10px; height: 10px; background: #10b981; border-radius: 50%;"></div>
        <span style="font-size: 14px; font-weight: 600; color: #485162;">Activas: <span style="color: #1f2937;"><?php echo $asignacionesActivas; ?></span></span>
    </div>
    <div style="display: flex; align-items: center; gap: 10px;">
        <div style="width: 10px; height: 10px; background: #3b82f6; border-radius: 50%;"></div>
        <span style="font-size: 14px; font-weight: 600; color: #485162;">Finalizadas: <span style="color: #1f2937;"><?php echo $asignacionesFinalizadas; ?></span></span>
    </div>
    <div style="display: flex; align-items: center; gap: 10px;">
        <div style="width: 10px; height: 10px; background: #f59e0b; border-radius: 50%;"></div>
        <span style="font-size: 14px; font-weight: 600; color: #485162;">Pendientes: <span style="color: #1f2937;"><?php echo $asignacionesNoActivas; ?></span></span>
    </div>
</div>
