<!-- Estadísticas del Dashboard -->
<div style="padding: 24px 32px;">
    
    <?php 
    $rol = $_SESSION['usuario_rol'] ?? $_SESSION['rol'] ?? 'Instructor';
    
    if ($rol === 'Instructor') {
        include __DIR__ . '/roles/instructor_stats.php';
    } elseif ($rol === 'Coordinador') {
        include __DIR__ . '/roles/coordinator_stats.php';
    } else {
        // Vista Administrador (Vista global clásica)
    ?>
    <!-- Estadísticas Administrador (8 tarjetas en una fila) -->
    <div style="display: grid; grid-template-columns: repeat(8, 1fr); gap: 16px; margin-bottom: 32px;">
        
        <!-- Programas -->
        <div class="stat-card" style="background: white; padding: 16px; border-radius: 12px; border: 1px solid #e5e7eb; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
            <div style="font-size: 10px; color: #9ca3af; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px;">PROGRAMAS</div>
            <div style="display: flex; align-items: baseline; gap: 6px;">
                <span style="font-size: 24px; font-weight: 800; color: #1f2937;"><?php echo $totalProgramas ?? 0; ?></span>
                <span style="font-size: 12px; font-weight: 700; color: #10b981;">+2</span>
            </div>
        </div>

        <!-- Fichas -->
        <div class="stat-card" style="background: white; padding: 16px; border-radius: 12px; border: 1px solid #e5e7eb; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
            <div style="font-size: 10px; color: #9ca3af; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px;">FICHAS</div>
            <div style="font-size: 24px; font-weight: 800; color: #1f2937;"><?php echo $totalFichas ?? 0; ?></div>
        </div>

        <!-- Instructores -->
        <div class="stat-card" style="background: white; padding: 16px; border-radius: 12px; border: 1px solid #e5e7eb; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
            <div style="font-size: 10px; color: #9ca3af; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px;">INSTRUCTORES</div>
            <div style="font-size: 24px; font-weight: 800; color: #1f2937;"><?php echo $totalInstructores ?? 0; ?></div>
        </div>

        <!-- Ambientes -->
        <div class="stat-card" style="background: white; padding: 16px; border-radius: 12px; border: 1px solid #e5e7eb; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
            <div style="font-size: 10px; color: #9ca3af; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px;">AMBIENTES</div>
            <div style="font-size: 24px; font-weight: 800; color: #1f2937;"><?php echo $totalAmbientes ?? 0; ?></div>
        </div>

        <!-- Asignaciones -->
        <div class="stat-card" style="background: white; padding: 16px; border-radius: 12px; border: 1px solid #e5e7eb; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
            <div style="font-size: 10px; color: #9ca3af; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px;">ASIGNACIONES</div>
            <div style="font-size: 24px; font-weight: 800; color: #1f2937;"><?php echo $totalAsignaciones ?? 0; ?></div>
        </div>

        <!-- Activas -->
        <div class="stat-card" style="background: white; padding: 16px; border-radius: 12px; border: 1px solid #e5e7eb; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
            <div style="font-size: 10px; color: #9ca3af; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px;">ACTIVAS</div>
            <div style="font-size: 24px; font-weight: 800; color: #10b981;"><?php echo $asignacionesActivas ?? 0; ?></div>
        </div>

        <!-- Finalizadas -->
        <div class="stat-card" style="background: white; padding: 16px; border-radius: 12px; border: 1px solid #e5e7eb; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
            <div style="font-size: 10px; color: #9ca3af; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px;">FINALIZADAS</div>
            <div style="font-size: 24px; font-weight: 800; color: #1f2937;"><?php echo $asignacionesFinalizadas ?? 0; ?></div>
        </div>

        <!-- No Activas -->
        <div class="stat-card" style="background: white; padding: 16px; border-radius: 12px; border: 1px solid #e5e7eb; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
            <div style="font-size: 10px; color: #9ca3af; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px;">NO ACTIVAS</div>
            <div style="font-size: 24px; font-weight: 800; color: #f59e0b;"><?php echo $asignacionesNoActivas ?? 0; ?></div>
        </div>
    </div>
    <?php } ?>
</div>
