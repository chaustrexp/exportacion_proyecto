<!-- Estadísticas del Dashboard -->
<div style="padding: 24px 32px;">
    
    <!-- Primera fila: 4 tarjetas principales -->
    <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 20px;">
        
        <!-- Programas -->
        <div class="stat-card" style="background: white; padding: 20px; border-radius: 12px; border: 1px solid #e5e7eb; box-shadow: 0 1px 3px rgba(0,0,0,0.05); transition: all 0.3s;">
            <div style="display: flex; align-items: center; gap: 12px;">
                <div style="width: 48px; height: 48px; background: linear-gradient(135deg, #E8F5E8 0%, #d4edda 100%); border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                    <i data-lucide="book-open" style="width: 24px; height: 24px; color: #39A900;"></i>
                </div>
                <div style="flex: 1;">
                    <div style="font-size: 11px; color: #9ca3af; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px;">Programas</div>
                    <div style="font-size: 24px; font-weight: 700; color: #1f2937; line-height: 1;"><?php echo $totalProgramas; ?></div>
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
                    <div style="font-size: 24px; font-weight: 700; color: #1f2937; line-height: 1;"><?php echo $totalFichas; ?></div>
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
                    <div style="font-size: 24px; font-weight: 700; color: #1f2937; line-height: 1;"><?php echo $totalInstructores; ?></div>
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
                    <div style="font-size: 24px; font-weight: 700; color: #1f2937; line-height: 1;"><?php echo $totalAmbientes; ?></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Segunda fila: 4 tarjetas de asignaciones -->
    <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px;">
        
        <!-- Total Asignaciones -->
        <div class="stat-card" style="background: white; padding: 20px; border-radius: 12px; border: 1px solid #e5e7eb; box-shadow: 0 1px 3px rgba(0,0,0,0.05); transition: all 0.3s;">
            <div style="display: flex; align-items: center; gap: 12px;">
                <div style="width: 48px; height: 48px; background: linear-gradient(135deg, #FCE7F3 0%, #FBCFE8 100%); border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                    <i data-lucide="calendar" style="width: 24px; height: 24px; color: #ec4899;"></i>
                </div>
                <div style="flex: 1;">
                    <div style="font-size: 11px; color: #9ca3af; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px;">Total Asignaciones</div>
                    <div style="font-size: 24px; font-weight: 700; color: #1f2937; line-height: 1;"><?php echo $totalAsignaciones; ?></div>
                </div>
            </div>
        </div>

        <!-- Asignaciones Activas -->
        <div class="stat-card" style="background: white; padding: 20px; border-radius: 12px; border: 1px solid #e5e7eb; box-shadow: 0 1px 3px rgba(0,0,0,0.05); transition: all 0.3s;">
            <div style="display: flex; align-items: center; gap: 12px;">
                <div style="width: 48px; height: 48px; background: linear-gradient(135deg, #DBEAFE 0%, #BFDBFE 100%); border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                    <i data-lucide="activity" style="width: 24px; height: 24px; color: #3b82f6;"></i>
                </div>
                <div style="flex: 1;">
                    <div style="font-size: 11px; color: #9ca3af; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px;">No Activas</div>
                    <div style="font-size: 24px; font-weight: 700; color: #1f2937; line-height: 1;"><?php echo $asignacionesNoActivas; ?></div>
                </div>
            </div>
        </div>

        <!-- Asignaciones Finalizadas -->
        <div class="stat-card" style="background: white; padding: 20px; border-radius: 12px; border: 1px solid #e5e7eb; box-shadow: 0 1px 3px rgba(0,0,0,0.05); transition: all 0.3s;">
            <div style="display: flex; align-items: center; gap: 12px;">
                <div style="width: 48px; height: 48px; background: linear-gradient(135deg, #E8F5E8 0%, #d4edda 100%); border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                    <i data-lucide="check-circle" style="width: 24px; height: 24px; color: #39A900;"></i>
                </div>
                <div style="flex: 1;">
                    <div style="font-size: 11px; color: #9ca3af; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px;">Finalizadas</div>
                    <div style="font-size: 24px; font-weight: 700; color: #1f2937; line-height: 1;"><?php echo $asignacionesFinalizadas; ?></div>
                </div>
            </div>
        </div>

        <!-- Competencias -->
        <div class="stat-card" style="background: white; padding: 20px; border-radius: 12px; border: 1px solid #e5e7eb; box-shadow: 0 1px 3px rgba(0,0,0,0.05); transition: all 0.3s;">
            <div style="display: flex; align-items: center; gap: 12px;">
                <div style="width: 48px; height: 48px; background: linear-gradient(135deg, #F0FDF4 0%, #DCFCE7 100%); border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                    <i data-lucide="award" style="width: 24px; height: 24px; color: #10b981;"></i>
                </div>
                <div style="flex: 1;">
                    <div style="font-size: 11px; color: #9ca3af; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px;">Competencias</div>
                    <div style="font-size: 24px; font-weight: 700; color: #1f2937; line-height: 1;"><?php echo $totalCompetenciasInstructor; ?></div>
                </div>
            </div>
        </div>
    </div>
</div>
