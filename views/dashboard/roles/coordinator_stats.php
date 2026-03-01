<?php
// Vista de estadísticas específica para Coordinadores
$rol = $_SESSION['usuario_rol'] ?? $_SESSION['rol'] ?? 'Coordinador';
?>

<div style="display: grid; grid-template-columns: repeat(7, 1fr); gap: 16px; margin-bottom: 32px;">
    
    <!-- Programa -->
    <div class="stat-card" style="background: white; padding: 16px; border-radius: 12px; border: 1px solid #e5e7eb; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
        <div style="font-size: 10px; color: #9ca3af; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px;">PROGRAMA</div>
        <div style="display: flex; align-items: center; gap: 6px;">
            <span style="font-size: 24px; font-weight: 800; color: #1f2937;"><?php echo $totalProgramas; ?></span>
            <i data-lucide="book-open" style="width: 14px; height: 14px; color: #9ca3af; opacity: 0.5;"></i>
        </div>
    </div>

    <!-- Ficha -->
    <div class="stat-card" style="background: white; padding: 16px; border-radius: 12px; border: 1px solid #e5e7eb; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
        <div style="font-size: 10px; color: #9ca3af; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px;">FICHA</div>
        <div style="display: flex; align-items: center; gap: 6px;">
            <span style="font-size: 24px; font-weight: 800; color: #1f2937;"><?php echo $totalFichas; ?></span>
            <i data-lucide="file-text" style="width: 14px; height: 14px; color: #9ca3af; opacity: 0.5;"></i>
        </div>
    </div>

    <!-- Instructores -->
    <div class="stat-card" style="background: white; padding: 16px; border-radius: 12px; border: 1px solid #e5e7eb; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
        <div style="font-size: 10px; color: #9ca3af; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px;">INSTRUCTORES</div>
        <div style="display: flex; align-items: center; gap: 6px;">
            <span style="font-size: 24px; font-weight: 800; color: #1f2937;"><?php echo $totalInstructores; ?></span>
            <i data-lucide="users" style="width: 14px; height: 14px; color: #9ca3af; opacity: 0.5;"></i>
        </div>
    </div>

    <!-- Ambiente -->
    <div class="stat-card" style="background: white; padding: 16px; border-radius: 12px; border: 1px solid #e5e7eb; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
        <div style="font-size: 10px; color: #9ca3af; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px;">AMBIENTE</div>
        <div style="display: flex; align-items: center; gap: 6px;">
            <span style="font-size: 24px; font-weight: 800; color: #1f2937;"><?php echo $totalAmbientes; ?></span>
            <i data-lucide="home" style="width: 14px; height: 14px; color: #9ca3af; opacity: 0.5;"></i>
        </div>
    </div>

    <!-- Asignaciones -->
    <div class="stat-card" style="background: white; padding: 16px; border-radius: 12px; border: 1px solid #e5e7eb; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
        <div style="font-size: 10px; color: #9ca3af; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px;">ASIGNACIONES</div>
        <div style="display: flex; align-items: center; gap: 6px;">
            <span style="font-size: 24px; font-weight: 800; color: #1f2937;"><?php echo $totalAsignaciones; ?></span>
            <i data-lucide="calendar" style="width: 14px; height: 14px; color: #9ca3af; opacity: 0.5;"></i>
        </div>
    </div>

    <!-- Activa -->
    <div class="stat-card" style="background: white; padding: 16px; border-radius: 12px; border: 1px solid #e5e7eb; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
        <div style="font-size: 10px; color: #9ca3af; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px;">ACTIVA</div>
        <div style="display: flex; align-items: center; gap: 8px;">
            <span style="font-size: 24px; font-weight: 800; color: #10b981;"><?php echo $asignacionesActivas; ?></span>
            <div style="width: 16px; height: 16px; background: #dcfce7; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                <i data-lucide="check" style="width: 10px; height: 10px; color: #16a34a;"></i>
            </div>
        </div>
    </div>

    <!-- Finalizada -->
    <div class="stat-card" style="background: white; padding: 16px; border-radius: 12px; border: 1px solid #e5e7eb; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
        <div style="font-size: 10px; color: #9ca3af; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px;">FINALIZADA</div>
        <div style="display: flex; align-items: center; gap: 8px;">
            <span style="font-size: 24px; font-weight: 800; color: #ef4444;"><?php echo $asignacionesFinalizadas; ?></span>
            <div style="width: 16px; height: 16px; background: #fee2e2; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                <i data-lucide="x" style="width: 10px; height: 10px; color: #dc2626;"></i>
            </div>
        </div>
    </div>
</div>
