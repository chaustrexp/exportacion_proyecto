<div style="padding: 0 32px 24px;">
    <div style="background: white; border-radius: 20px; border: 1px solid #e5e7eb; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);">
        
        <!-- Header del calendario -->
        <div style="padding: 24px 32px; border-bottom: 1px solid #e5e7eb; display: flex; justify-content: space-between; align-items: center;">
            <div style="display: flex; align-items: center; gap: 12px;">
                <div style="width: 40px; height: 40px; background: #f3f4f6; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                    <i data-lucide="calendar" style="width: 20px; height: 20px; color: #374151;"></i>
                </div>
                <div>
                    <h2 style="font-size: 18px; font-weight: 700; color: #1f2937; margin: 0;">Calendario de Asignaciones</h2>
                    <p style="font-size: 13px; color: #6b7280; margin: 4px 0 0;">Vista <span id="vistaActual">mensual</span> de todas las asignaciones programadas</p>
                </div>
            </div>
            <div style="display: flex; gap: 24px; align-items: center;">
                <!-- Selector de Vista -->
                <div style="display: flex; gap: 4px; background: #f3f4f6; padding: 4px; border-radius: 10px;">
                    <button id="btnMes" class="btn-vista active" onclick="cambiarVista('mes')" style="padding: 8px 16px; border: none; background: white; color: #39A900; border-radius: 8px; font-size: 13px; font-weight: 700; cursor: pointer; transition: all 0.2s; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
                        Mes
                    </button>
                    <button id="btnSemana" class="btn-vista" onclick="cambiarVista('semana')" style="padding: 8px 16px; border: none; background: transparent; color: #6b7280; border-radius: 8px; font-size: 13px; font-weight: 600; cursor: pointer; transition: all 0.2s;">
                        Semana
                    </button>
                    <button id="btnDia" class="btn-vista" onclick="cambiarVista('dia')" style="padding: 8px 16px; border: none; background: transparent; color: #6b7280; border-radius: 8px; font-size: 13px; font-weight: 600; cursor: pointer; transition: all 0.2s;">
                        Día
                    </button>
                </div>
                
                <!-- Navegación -->
                <div style="display: flex; gap: 12px; align-items: center;">
                    <button id="prevMonth" style="background: none; border: none; color: #9ca3af; cursor: pointer; padding: 4px; transition: color 0.2s;" onmouseover="this.style.color='#1f2937'" onmouseout="this.style.color='#9ca3af'">
                        <i data-lucide="chevron-left" style="width: 20px; height: 20px;"></i>
                    </button>
                    <span id="currentMonth" style="font-size: 15px; font-weight: 700; color: #1f2937; min-width: 140px; text-align: center;"></span>
                    <button id="nextMonth" style="background: none; border: none; color: #9ca3af; cursor: pointer; padding: 4px; transition: color 0.2s;" onmouseover="this.style.color='#1f2937'" onmouseout="this.style.color='#9ca3af'">
                        <i data-lucide="chevron-right" style="width: 20px; height: 20px;"></i>
                    </button>
                    <button id="todayBtn" style="margin-left: 8px; background: #39A900; color: white; border: none; padding: 8px 16px; border-radius: 8px; font-size: 13px; font-weight: 700; cursor: pointer; transition: all 0.2s;" onmouseover="this.style.background='#2d8500'" onmouseout="this.style.background='#39A900'">
                        Hoy
                    </button>
                </div>
            </div>
        </div>

        <!-- Calendario -->
        <div id="calendar" style="padding: 32px; background: #fdfdfd;"></div>
    </div>
</div>
