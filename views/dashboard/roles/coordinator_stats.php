<?php
// Vista de estadísticas específica para Coordinadores
$rol = $_SESSION['usuario_rol'] ?? $_SESSION['rol'] ?? 'Coordinador';
?>

<div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 24px;">
    
    <!-- Gestión de Instructores -->
    <div class="stat-card" style="background: white; padding: 24px; border-radius: 16px; border: 1px solid #e5e7eb; display: flex; flex-direction: column; justify-content: center; transition: all 0.3s; position: relative; overflow: hidden;">
        <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px; position: relative; z-index: 2;">
            <div style="width: 48px; height: 48px; background: #F5F3FF; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                <i data-lucide="users" style="width: 24px; height: 24px; color: #8b5cf6;"></i>
            </div>
            <div>
                <div style="font-size: 11px; color: #6b7280; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">Instructores</div>
                <div style="font-size: 28px; font-weight: 800; color: #1f2937; line-height: 1;"><?php echo $totalInstructores; ?></div>
            </div>
        </div>
        <p style="font-size: 13px; color: #6b7280; margin: 0; position: relative; z-index: 2;">Carga académica total</p>
        <i data-lucide="users" style="position: absolute; right: -15px; bottom: -15px; width: 100px; height: 100px; opacity: 0.05;"></i>
    </div>

    <!-- Gestión de Programas -->
    <div class="stat-card" style="background: white; padding: 24px; border-radius: 16px; border: 1px solid #e5e7eb; display: flex; flex-direction: column; justify-content: center; transition: all 0.3s; position: relative; overflow: hidden;">
        <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px; position: relative; z-index: 2;">
            <div style="width: 48px; height: 48px; background: #E8F5E8; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                <i data-lucide="book-open" style="width: 24px; height: 24px; color: #39A900;"></i>
            </div>
            <div>
                <div style="font-size: 11px; color: #6b7280; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">Programas</div>
                <div style="font-size: 28px; font-weight: 800; color: #1f2937; line-height: 1;"><?php echo $totalProgramas; ?></div>
            </div>
        </div>
        <p style="font-size: 13px; color: #6b7280; margin: 0; position: relative; z-index: 2;">Oferta académica activa</p>
        <i data-lucide="book-open" style="position: absolute; right: -15px; bottom: -15px; width: 100px; height: 100px; opacity: 0.05;"></i>
    </div>

    <!-- Gestión de Fichas -->
    <div class="stat-card" style="background: white; padding: 24px; border-radius: 16px; border: 1px solid #e5e7eb; display: flex; flex-direction: column; justify-content: center; transition: all 0.3s; position: relative; overflow: hidden;">
        <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px; position: relative; z-index: 2;">
            <div style="width: 48px; height: 48px; background: #EFF6FF; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                <i data-lucide="file-text" style="width: 24px; height: 24px; color: #3b82f6;"></i>
            </div>
            <div>
                <div style="font-size: 11px; color: #6b7280; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">Fichas</div>
                <div style="font-size: 28px; font-weight: 800; color: #1f2937; line-height: 1;"><?php echo $totalFichas; ?></div>
            </div>
        </div>
        <p style="font-size: 13px; color: #6b7280; margin: 0; position: relative; z-index: 2;">Grupos en formación</p>
        <i data-lucide="file-text" style="position: absolute; right: -15px; bottom: -15px; width: 100px; height: 100px; opacity: 0.05;"></i>
    </div>

    <!-- Ocupación de Ambientes -->
    <div class="stat-card" style="background: white; padding: 24px; border-radius: 16px; border: 1px solid #e5e7eb; display: flex; flex-direction: column; justify-content: center; transition: all 0.3s; position: relative; overflow: hidden;">
        <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px; position: relative; z-index: 2;">
            <div style="width: 48px; height: 48px; background: #FEF3C7; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                <i data-lucide="layout" style="width: 24px; height: 24px; color: #d97706;"></i>
            </div>
            <div>
                <div style="font-size: 11px; color: #6b7280; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">Ambientes</div>
                <div style="font-size: 28px; font-weight: 800; color: #1f2937; line-height: 1;"><?php echo $totalAmbientes; ?></div>
            </div>
        </div>
        <p style="font-size: 13px; color: #6b7280; margin: 0; position: relative; z-index: 2;">Capacidad de ambientes</p>
        <i data-lucide="layout" style="position: absolute; right: -15px; bottom: -15px; width: 100px; height: 100px; opacity: 0.05;"></i>
    </div>

</div>

<!-- Segunda Fila Coordinador: Resumen de Asignaciones -->
<div style="display: flex; align-items: center; gap: 24px; padding: 20px; background: #f9fafb; border-radius: 12px; border: 1px solid #e5e7eb; margin-bottom: 24px;">
    <div style="font-size: 14px; font-weight: 700; color: #374151; display: flex; align-items: center; gap: 8px;">
        <i data-lucide="pie-chart" style="width: 18px; height: 18px; color: #39A900;"></i>
        ESTADO DE ASIGNACIONES:
    </div>
    <div style="display: flex; gap: 20px;">
        <div style="display: flex; align-items: center; gap: 8px;">
            <div style="width: 8px; height: 8px; background: #3b82f6; border-radius: 50%;"></div>
            <span style="font-size: 13px; color: #6b7280;">Total: <strong style="color: #111827;"><?php echo $totalAsignaciones; ?></strong></span>
        </div>
        <div style="display: flex; align-items: center; gap: 8px;">
            <div style="width: 8px; height: 8px; background: #10b981; border-radius: 50%;"></div>
            <span style="font-size: 13px; color: #6b7280;">Activas: <strong style="color: #111827;"><?php echo $asignacionesActivas; ?></strong></span>
        </div>
        <div style="display: flex; align-items: center; gap: 8px;">
            <div style="width: 8px; height: 8px; background: #6b7280; border-radius: 50%;"></div>
            <span style="font-size: 13px; color: #6b7280;">Finalizadas: <strong style="color: #111827;"><?php echo $asignacionesFinalizadas; ?></strong></span>
        </div>
    </div>
</div>
