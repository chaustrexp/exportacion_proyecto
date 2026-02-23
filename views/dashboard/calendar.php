<div style="padding: 0 32px 24px;">
    <div style="background: white; border-radius: 12px; border: 1px solid #e5e7eb; overflow: hidden;">
        
        <!-- Header del calendario -->
        <div style="padding: 20px 24px; border-bottom: 1px solid #e5e7eb; display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h2 style="font-size: 18px; font-weight: 700; color: #1f2937; margin: 0 0 4px;">
                    <i data-lucide="calendar-days" style="width: 20px; height: 20px; vertical-align: middle; margin-right: 8px;"></i>
                    Calendario de Asignaciones
                </h2>
                <p style="font-size: 13px; color: #6b7280; margin: 0;">Vista <span id="vistaActual">mensual</span> de todas las asignaciones</p>
            </div>
            <div style="display: flex; gap: 12px; align-items: center;">
                <!-- Selector de Vista -->
                <div style="display: flex; gap: 4px; background: #f3f4f6; padding: 4px; border-radius: 8px;">
                    <button id="btnMes" class="btn-vista active" onclick="cambiarVista('mes')" style="padding: 6px 16px; border: none; background: white; color: #39A900; border-radius: 6px; font-size: 13px; font-weight: 600; cursor: pointer; transition: all 0.2s;">
                        Mes
                    </button>
                    <button id="btnSemana" class="btn-vista" onclick="cambiarVista('semana')" style="padding: 6px 16px; border: none; background: transparent; color: #6b7280; border-radius: 6px; font-size: 13px; font-weight: 600; cursor: pointer; transition: all 0.2s;">
                        Semana
                    </button>
                    <button id="btnDia" class="btn-vista" onclick="cambiarVista('dia')" style="padding: 6px 16px; border: none; background: transparent; color: #6b7280; border-radius: 6px; font-size: 13px; font-weight: 600; cursor: pointer; transition: all 0.2s;">
                        Día
                    </button>
                </div>
                
                <!-- Navegación -->
                <div style="display: flex; gap: 8px; align-items: center;">
                    <button id="prevMonth" class="btn btn-secondary btn-sm">
                        <i data-lucide="chevron-left" style="width: 16px; height: 16px;"></i>
                    </button>
                    <span id="currentMonth" style="font-weight: 600; color: #1f2937; min-width: 150px; text-align: center;"></span>
                    <button id="nextMonth" class="btn btn-secondary btn-sm">
                        <i data-lucide="chevron-right" style="width: 16px; height: 16px;"></i>
                    </button>
                    <button id="todayBtn" class="btn btn-primary btn-sm" style="margin-left: 8px;">Hoy</button>
                </div>
            </div>
        </div>

        <!-- Calendario -->
        <div id="calendar" style="padding: 24px;"></div>
    </div>
</div>
