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
    <!-- Primera fila: 4 tarjetas principales (Solo para Admin) -->
    <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 20px;">
        
        <!-- Programas -->
        <div class="stat-card" style="background: white; padding: 20px; border-radius: 12px; border: 1px solid #e5e7eb; box-shadow: 0 1px 3px rgba(0,0,0,0.05); transition: all 0.3s;">
            <div style="display: flex; align-items: center; gap: 12px;">
                <div style="width: 48px; height: 48px; background: linear-gradient(135deg, #E8F5E8 0%, #d4edda 100%); border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                    <i data-lucide="book-open" style="width: 24px; height: 24px; color: #39A900;"></i>
                </div>
                <div style="flex: 1;">
                    <div style="font-size: 11px; color: #9ca3af; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px;">Programas</div>
                    <div style="font-size: 24px; font-weight: 700; color: #1f2937; line-height: 1;"><?php echo $totalProgramas ?? 0; ?></div>
                </div>
            </div>
        </div>

        <!-- Fichas -->
        <div class="stat-card" style="background: white; padding: 20px; border-radius: 12px; border: 1px solid #e5e7eb; box-shadow: 0 1px 3px rgba(0,0,0,0.05); transition: all 0.3s;">
            <div style="display: flex; align-items: center; gap: 12px;">
                <div style="width: 48px; height: 48px; background: linear-gradient(135deg, #EFF6FF 0%, #DBEAFE 100%); border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                    <i data-lucide="file-text" style="width: 24px; height: 24px; color: #3b82f6;"></i>
                </div>
                <div style="flex: 1;">
                    <div style="font-size: 11px; color: #9ca3af; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px;">Fichas</div>
                    <div style="font-size: 24px; font-weight: 700; color: #1f2937; line-height: 1;"><?php echo $totalFichas ?? 0; ?></div>
                </div>
            </div>
        </div>

        <!-- Instructores -->
        <div class="stat-card" style="background: white; padding: 20px; border-radius: 12px; border: 1px solid #e5e7eb; box-shadow: 0 1px 3px rgba(0,0,0,0.05); transition: all 0.3s;">
            <div style="display: flex; align-items: center; gap: 12px;">
                <div style="width: 48px; height: 48px; background: linear-gradient(135deg, #F5F3FF 0%, #EDE9FE 100%); border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                    <i data-lucide="users" style="width: 24px; height: 24px; color: #8b5cf6;"></i>
                </div>
                <div style="flex: 1;">
                    <div style="font-size: 11px; color: #9ca3af; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px;">Instructores</div>
                    <div style="font-size: 24px; font-weight: 700; color: #1f2937; line-height: 1;"><?php echo $totalInstructores ?? 0; ?></div>
                </div>
            </div>
        </div>

        <!-- Ambientes -->
        <div class="stat-card" style="background: white; padding: 20px; border-radius: 12px; border: 1px solid #e5e7eb; box-shadow: 0 1px 3px rgba(0,0,0,0.05); transition: all 0.3s;">
            <div style="display: flex; align-items: center; gap: 12px;">
                <div style="width: 48px; height: 48px; background: linear-gradient(135deg, #FEF3C7 0%, #FDE68A 100%); border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                    <i data-lucide="home" style="width: 24px; height: 24px; color: #f59e0b;"></i>
                </div>
                <div style="flex: 1;">
                    <div style="font-size: 11px; color: #9ca3af; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px;">Ambientes</div>
                    <div style="font-size: 24px; font-weight: 700; color: #1f2937; line-height: 1;"><?php echo $totalAmbientes ?? 0; ?></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Segunda fila Admin -->
    <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px;">
        <div class="stat-card" style="background: white; padding: 20px; border-radius: 12px; border: 1px solid #e5e7eb; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
            <div style="display: flex; align-items: center; gap: 12px;">
                <div style="width: 40px; height: 40px; background: #FFF1F2; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                    <i data-lucide="calendar" style="width: 20px; height: 20px; color: #E11D48;"></i>
                </div>
                <div>
                    <div style="font-size: 10px; color: #9ca3af; font-weight: 700; text-transform: uppercase;">Total Asignaciones</div>
                    <div style="font-size: 20px; font-weight: 700; color: #1f2937;"><?php echo $totalAsignaciones ?? 0; ?></div>
                </div>
            </div>
        </div>
        <div class="stat-card" style="background: white; padding: 20px; border-radius: 12px; border: 1px solid #e5e7eb; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
            <div style="display: flex; align-items: center; gap: 12px;">
                <div style="width: 40px; height: 40px; background: #F0FDF4; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                    <i data-lucide="activity" style="width: 20px; height: 20px; color: #16A34A;"></i>
                </div>
                <div>
                    <div style="font-size: 10px; color: #9ca3af; font-weight: 700; text-transform: uppercase;">Activas</div>
                    <div style="font-size: 20px; font-weight: 700; color: #1f2937;"><?php echo $asignacionesActivas ?? 0; ?></div>
                </div>
            </div>
        </div>
        <div class="stat-card" style="background: white; padding: 20px; border-radius: 12px; border: 1px solid #e5e7eb; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
            <div style="display: flex; align-items: center; gap: 12px;">
                <div style="width: 40px; height: 40px; background: #F9FAFB; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                    <i data-lucide="check-circle" style="width: 20px; height: 20px; color: #4B5563;"></i>
                </div>
                <div>
                    <div style="font-size: 10px; color: #9ca3af; font-weight: 700; text-transform: uppercase;">Finalizadas</div>
                    <div style="font-size: 20px; font-weight: 700; color: #1f2937;"><?php echo $asignacionesFinalizadas ?? 0; ?></div>
                </div>
            </div>
        </div>
        <div class="stat-card" style="background: white; padding: 20px; border-radius: 12px; border: 1px solid #e5e7eb; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
            <div style="display: flex; align-items: center; gap: 12px;">
                <div style="width: 40px; height: 40px; background: #FEFCE8; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                    <i data-lucide="clock" style="width: 20px; height: 20px; color: #CA8A04;"></i>
                </div>
                <div>
                    <div style="font-size: 10px; color: #9ca3af; font-weight: 700; text-transform: uppercase;">No Activas</div>
                    <div style="font-size: 20px; font-weight: 700; color: #1f2937;"><?php echo $asignacionesNoActivas ?? 0; ?></div>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>
</div>
