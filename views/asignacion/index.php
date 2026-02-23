<?php
// La vista ahora es manejada por AsignacionController
// Los datos ($registros, $fichas, etc.) ya están disponibles en el scope
?>

<div class="main-content">
    <!-- Header -->
    <div style="padding: 32px 32px 24px; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #e5e7eb;">
        <div style="flex: 1;">
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 4px;">
                <h1 style="font-size: 28px; font-weight: 700; color: #1f2937; margin: 0;">Asignaciones</h1>
                <?php
                // Verificar si el controlador está disponible
                $controladorDisponible = file_exists(__DIR__ . '/../../controller/AsignacionController.php');
                if ($controladorDisponible):
                ?>
                <span style="background: linear-gradient(135deg, #39A900 0%, #007832 100%); color: white; padding: 4px 12px; border-radius: 6px; font-size: 11px; font-weight: 700; display: inline-flex; align-items: center; gap: 6px; box-shadow: 0 2px 4px rgba(57, 169, 0, 0.3);">
                    <span style="font-size: 14px;">⚡</span>
                    CONTROLADOR ACTIVO
                </span>
                <?php endif; ?>
            </div>
            <p style="font-size: 14px; color: #6b7280; margin: 0;">Gestiona las asignaciones de instructores y ambientes</p>
        </div>
        <button onclick="abrirModalNuevaAsignacion()" class="btn btn-primary" style="display: inline-flex; align-items: center; gap: 8px;">
            <i data-lucide="plus" style="width: 18px; height: 18px;"></i>
            Nueva Asignación
        </button>
    </div>

    <!-- Alert -->
    <?php if (isset($_GET['msg'])): ?>
        <div class="alert alert-success" style="margin: 24px 32px;">
            <?php 
            if ($_GET['msg'] == 'creado') echo '✓ Asignación creada exitosamente';
            if ($_GET['msg'] == 'actualizado') echo '✓ Asignación actualizada exitosamente';
            if ($_GET['msg'] == 'eliminado') echo '✓ Asignación eliminada exitosamente';
            ?>
        </div>
    <?php endif; ?>

    <!-- Stats -->
    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; padding: 24px 32px;">
        <div style="background: white; padding: 20px; border-radius: 12px; border: 1px solid #e5e7eb;">
            <div style="font-size: 13px; color: #6b7280; margin-bottom: 8px;">Total Asignaciones</div>
            <div style="font-size: 32px; font-weight: 700; color: #ec4899;"><?php echo count($registros); ?></div>
        </div>
        <div style="background: white; padding: 20px; border-radius: 12px; border: 1px solid #e5e7eb;">
            <div style="font-size: 13px; color: #6b7280; margin-bottom: 8px;">Asignaciones Activas</div>
            <div style="font-size: 32px; font-weight: 700; color: #10b981;">
                <?php 
                $hoy = date('Y-m-d');
                $activas = array_filter($registros, function($r) use ($hoy) {
                    $inicio = $r['asig_fecha_inicio'] ?? '';
                    $fin = $r['asig_fecha_fin'] ?? '';
                    return $inicio <= $hoy && $fin >= $hoy;
                });
                echo count($activas);
                ?>
            </div>
        </div>
    </div>

    <!-- Tabs -->
    <div style="padding: 0 32px 24px;">
        <div style="display: inline-flex; gap: 4px; background: #f3f4f6; padding: 4px; border-radius: 12px;">
            <button onclick="showTab('table')" id="tab-table" style="padding: 10px 24px; border: none; background: white; font-weight: 600; color: #1f2937; border-radius: 10px; cursor: pointer; transition: all 0.3s; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                <i data-lucide="list" style="width: 16px; height: 16px; vertical-align: middle; margin-right: 6px;"></i>
                Lista
            </button>
            <button onclick="showTab('calendar')" id="tab-calendar" style="padding: 10px 24px; border: none; background: transparent; font-weight: 600; color: #6b7280; border-radius: 10px; cursor: pointer; transition: all 0.3s;">
                <i data-lucide="calendar" style="width: 16px; height: 16px; vertical-align: middle; margin-right: 6px;"></i>
                Calendario
            </button>
        </div>
    </div>

    <!-- Calendar View -->
    <div id="calendar-view" style="display: none; padding: 0 32px 32px;">
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

    <!-- Table -->
    <div id="table-view" style="padding: 0 32px 32px;">
        <div style="background: white; border-radius: 12px; border: 1px solid #e5e7eb; overflow: hidden;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: #f9fafb; border-bottom: 1px solid #e5e7eb;">
                        <th style="padding: 16px; text-align: left; font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase;">ID (Ficha)</th>
                        <th style="padding: 16px; text-align: left; font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase;">Programa</th>
                        <th style="padding: 16px; text-align: left; font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase;">Instructor</th>
                        <th style="padding: 16px; text-align: left; font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase;">Ambiente</th>
                        <th style="padding: 16px; text-align: left; font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase;">Fecha Inicio</th>
                        <th style="padding: 16px; text-align: left; font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase;">Estado</th>
                        <th style="padding: 16px; text-align: right; font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($registros)): ?>
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 60px 20px; color: #6b7280;">
                            <div style="font-size: 48px; margin-bottom: 16px;">📅</div>
                            <p style="margin: 0 0 16px; font-size: 16px;">No hay asignaciones registradas</p>
                            <a href="<?php echo BASE_PATH; ?>asignacion/crear" class="btn btn-primary btn-sm">Crear Primera Asignación</a>
                        </td>
                    </tr>
                    <?php else: ?>
                        <?php foreach ($registros as $registro): ?>
                        <tr style="border-bottom: 1px solid #f3f4f6;">
                            <td style="padding: 16px;">
                                <strong style="color: #ec4899; font-size: 14px;">
                                    <?php echo str_pad(htmlspecialchars($registro['ficha_numero'] ?? ''), 8, '0', STR_PAD_LEFT); ?>
                                </strong>
                            </td>
                            <td style="padding: 16px;">
                                <div style="font-weight: 600; color: #1f2937;"><?php echo htmlspecialchars($registro['programa_nombre'] ?? 'N/A'); ?></div>
                            </td>
                            <td style="padding: 16px;">
                                <div style="color: #6b7280;"><?php echo htmlspecialchars($registro['instructor_nombre'] ?? ''); ?></div>
                            </td>
                            <td style="padding: 16px; color: #6b7280;">
                                <?php echo htmlspecialchars($registro['ambiente_nombre'] ?? 'N/A'); ?>
                            </td>
                            <td style="padding: 16px; color: #6b7280;">
                                <?php echo isset($registro['asig_fecha_inicio']) ? date('d/m/Y', strtotime($registro['asig_fecha_inicio'])) : 'N/A'; ?>
                            </td>
                            <td style="padding: 16px;">
                                <?php 
                                $hoy = date('Y-m-d');
                                $fecha_inicio = $registro['asig_fecha_inicio'] ?? '';
                                $fecha_fin = $registro['asig_fecha_fin'] ?? '';
                                
                                if ($fecha_fin && $fecha_fin < $hoy) {
                                    echo '<span style="background: #FEE2E2; color: #DC2626; padding: 4px 12px; border-radius: 12px; font-size: 12px; font-weight: 600;">Finalizada</span>';
                                } elseif ($fecha_inicio && $fecha_inicio > $hoy) {
                                    echo '<span style="background: #FEF3C7; color: #D97706; padding: 4px 12px; border-radius: 12px; font-size: 12px; font-weight: 600;">Pendiente</span>';
                                } else {
                                    echo '<span style="background: #E8F5E8; color: #39A900; padding: 4px 12px; border-radius: 12px; font-size: 12px; font-weight: 600;">Activa</span>';
                                }
                                ?>
                            </td>
                            <td style="padding: 16px;">
                                <div class="btn-group" style="justify-content: flex-end;">
                                    <a href="<?php echo BASE_PATH; ?>asignacion/ver/<?php echo $registro['asig_id'] ?? $registro['ASIG_ID']; ?>" class="btn btn-secondary btn-sm">Ver</a>
                                    <a href="<?php echo BASE_PATH; ?>asignacion/editar/<?php echo $registro['asig_id'] ?? $registro['ASIG_ID']; ?>" class="btn btn-primary btn-sm">Editar</a>
                                    <button onclick="confirmarEliminacion(<?php echo $registro['asig_id'] ?? $registro['ASIG_ID']; ?>, 'asignacion')" class="btn btn-danger btn-sm">Eliminar</button>
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
    
    document.querySelectorAll('tbody tr').forEach(row => {
        if (row.cells.length > 1) {
            row.addEventListener('mouseenter', function() {
                this.style.background = '#f9fafb';
            });
            row.addEventListener('mouseleave', function() {
                this.style.background = 'white';
            });
        }
    });

    // Tab switching
    function showTab(tab) {
        const tableView = document.getElementById('table-view');
        const calendarView = document.getElementById('calendar-view');
        const tabTable = document.getElementById('tab-table');
        const tabCalendar = document.getElementById('tab-calendar');

        if (tab === 'table') {
            tableView.style.display = 'block';
            calendarView.style.display = 'none';
            tabTable.style.background = 'white';
            tabTable.style.color = '#1f2937';
            tabTable.style.boxShadow = '0 2px 4px rgba(0,0,0,0.1)';
            tabCalendar.style.background = 'transparent';
            tabCalendar.style.color = '#6b7280';
            tabCalendar.style.boxShadow = 'none';
        } else {
            tableView.style.display = 'none';
            calendarView.style.display = 'block';
            tabTable.style.background = 'transparent';
            tabTable.style.color = '#6b7280';
            tabTable.style.boxShadow = 'none';
            tabCalendar.style.background = 'white';
            tabCalendar.style.color = '#1f2937';
            tabCalendar.style.boxShadow = '0 2px 4px rgba(0,0,0,0.1)';
            
            if (!window.calendarInitialized) {
                initCalendar();
                window.calendarInitialized = true;
            }
        }
        
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    }

    // Datos de asignaciones desde PHP
    const asignaciones = <?php echo json_encode($registros); ?>;
    
    let currentDate = new Date();
    let currentMonth = currentDate.getMonth();
    let currentYear = currentDate.getFullYear();
    let currentView = 'mes'; // mes, semana, dia
    
    const monthNames = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
                        'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
    const dayNames = ['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb'];
    const dayNamesFull = ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];
    
    // Función para cambiar vista
    function cambiarVista(vista) {
        currentView = vista;
        
        // Actualizar botones activos
        document.querySelectorAll('.btn-vista').forEach(btn => {
            btn.style.background = 'transparent';
            btn.style.color = '#6b7280';
        });
        
        const btnActivo = document.getElementById(`btn${vista.charAt(0).toUpperCase() + vista.slice(1)}`);
        btnActivo.style.background = 'white';
        btnActivo.style.color = '#39A900';
        
        // Actualizar texto de vista
        const textoVista = vista === 'mes' ? 'mensual' : vista === 'semana' ? 'semanal' : 'diaria';
        document.getElementById('vistaActual').textContent = textoVista;
        
        // Renderizar según vista
        if (vista === 'mes') {
            renderCalendar();
        } else if (vista === 'semana') {
            renderWeekView();
        } else {
            renderDayView();
        }
    }
    
    function renderCalendar() {
        const firstDay = new Date(currentYear, currentMonth, 1);
        const lastDay = new Date(currentYear, currentMonth + 1, 0);
        const prevLastDay = new Date(currentYear, currentMonth, 0);
        
        const firstDayIndex = firstDay.getDay();
        const lastDayDate = lastDay.getDate();
        const prevLastDayDate = prevLastDay.getDate();
        
        // Actualizar título del mes
        document.getElementById('currentMonth').textContent = `${monthNames[currentMonth]} ${currentYear}`;
        
        let calendarHTML = '<div style="display: grid; grid-template-columns: repeat(7, 1fr); gap: 8px;">';
        
        // Headers de días
        dayNames.forEach(day => {
            calendarHTML += `<div style="text-align: center; font-weight: 600; color: #6b7280; font-size: 12px; padding: 8px 0; text-transform: uppercase;">${day}</div>`;
        });
        
        // Días del mes anterior
        for (let i = firstDayIndex; i > 0; i--) {
            calendarHTML += `<div style="min-height: 100px; padding: 8px; background: #f9fafb; border-radius: 8px; opacity: 0.5;">
                <div style="font-size: 14px; color: #9ca3af; font-weight: 500;">${prevLastDayDate - i + 1}</div>
            </div>`;
        }
        
        // Días del mes actual
        const today = new Date();
        for (let day = 1; day <= lastDayDate; day++) {
            const dateStr = `${currentYear}-${String(currentMonth + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
            const isToday = day === today.getDate() && currentMonth === today.getMonth() && currentYear === today.getFullYear();
            
            // Buscar asignaciones para este día
            const dayAssignments = asignaciones.filter(a => {
                const inicio = new Date(a.asig_fecha_inicio || a.fecha_inicio);
                const fin = new Date(a.asig_fecha_fin || a.fecha_fin);
                const currentDay = new Date(currentYear, currentMonth, day);
                return currentDay >= inicio && currentDay <= fin;
            });
            
            let dayStyle = 'min-height: 100px; padding: 8px; background: white; border: 1px solid #e5e7eb; border-radius: 8px; transition: all 0.2s;';
            if (isToday) {
                dayStyle = 'min-height: 100px; padding: 8px; background: #E8F5E8; border: 2px solid #39A900; border-radius: 8px; transition: all 0.2s;';
            }
            
            calendarHTML += `<div style="${dayStyle}" class="calendar-day" data-date="${dateStr}" onclick="verAsignacionesDia('${dateStr}', ${JSON.stringify(dayAssignments).replace(/"/g, '&quot;')})">
                <div style="font-size: 14px; color: ${isToday ? '#39A900' : '#1f2937'}; font-weight: ${isToday ? '700' : '500'}; margin-bottom: 4px;">${day}</div>`;
            
            // Mostrar asignaciones
            if (dayAssignments.length > 0) {
                dayAssignments.slice(0, 2).forEach(asig => {
                    calendarHTML += `<div style="background: #39A900; color: white; padding: 4px 6px; border-radius: 4px; font-size: 10px; margin-bottom: 2px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; cursor: pointer;" title="${asig.instructor_nombre} - Ficha ${asig.ficha_numero}" onclick="event.stopPropagation(); verDetalleAsignacion(${asig.asig_id || asig.ASIG_ID || asig.id})">
                        📚 ${asig.ficha_numero}
                    </div>`;
                });
                if (dayAssignments.length > 2) {
                    calendarHTML += `<div style="font-size: 10px; color: #6b7280; margin-top: 2px;">+${dayAssignments.length - 2} más</div>`;
                }
            }
            
            calendarHTML += '</div>';
        }
        
        // Días del siguiente mes
        const remainingDays = 7 - ((firstDayIndex + lastDayDate) % 7);
        if (remainingDays < 7) {
            for (let i = 1; i <= remainingDays; i++) {
                calendarHTML += `<div style="min-height: 100px; padding: 8px; background: #f9fafb; border-radius: 8px; opacity: 0.5;">
                    <div style="font-size: 14px; color: #9ca3af; font-weight: 500;">${i}</div>
                </div>`;
            }
        }
        
        calendarHTML += '</div>';
        document.getElementById('calendar').innerHTML = calendarHTML;
        
        // Hover effect en días
        document.querySelectorAll('.calendar-day').forEach(day => {
            day.addEventListener('mouseenter', function() {
                if (!this.style.background.includes('#E8F5E8')) {
                    this.style.background = '#f9fafb';
                    this.style.transform = 'scale(1.02)';
                }
            });
            day.addEventListener('mouseleave', function() {
                if (!this.style.background.includes('#E8F5E8')) {
                    this.style.background = 'white';
                    this.style.transform = 'scale(1)';
                }
            });
        });
        
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    }
    
    // Vista Semanal
    function renderWeekView() {
        const startOfWeek = new Date(currentDate);
        startOfWeek.setDate(currentDate.getDate() - currentDate.getDay());
        
        const endOfWeek = new Date(startOfWeek);
        endOfWeek.setDate(startOfWeek.getDate() + 6);
        
        document.getElementById('currentMonth').textContent = 
            `${startOfWeek.getDate()} ${monthNames[startOfWeek.getMonth()]} - ${endOfWeek.getDate()} ${monthNames[endOfWeek.getMonth()]} ${currentYear}`;
        
        let calendarHTML = '<div style="display: grid; grid-template-columns: repeat(7, 1fr); gap: 8px;">';
        
        // Headers de días
        for (let i = 0; i < 7; i++) {
            const day = new Date(startOfWeek);
            day.setDate(startOfWeek.getDate() + i);
            calendarHTML += `<div style="text-align: center; font-weight: 600; color: #6b7280; font-size: 12px; padding: 8px 0; text-transform: uppercase;">
                ${dayNames[i]}<br><span style="font-size: 18px; color: #1f2937;">${day.getDate()}</span>
            </div>`;
        }
        
        // Días de la semana
        const today = new Date();
        for (let i = 0; i < 7; i++) {
            const day = new Date(startOfWeek);
            day.setDate(startOfWeek.getDate() + i);
            const dateStr = `${day.getFullYear()}-${String(day.getMonth() + 1).padStart(2, '0')}-${String(day.getDate()).padStart(2, '0')}`;
            const isToday = day.getDate() === today.getDate() && day.getMonth() === today.getMonth() && day.getFullYear() === today.getFullYear();
            
            const dayAssignments = asignaciones.filter(a => {
                const inicio = new Date(a.asig_fecha_inicio || a.fecha_inicio);
                const fin = new Date(a.asig_fecha_fin || a.fecha_fin);
                return day >= inicio && day <= fin;
            });
            
            let dayStyle = 'min-height: 150px; padding: 12px; background: white; border: 1px solid #e5e7eb; border-radius: 8px; transition: all 0.2s;';
            if (isToday) {
                dayStyle = 'min-height: 150px; padding: 12px; background: #E8F5E8; border: 2px solid #39A900; border-radius: 8px; transition: all 0.2s;';
            }
            
            calendarHTML += `<div style="${dayStyle}" class="calendar-day" onclick="verAsignacionesDia('${dateStr}', ${JSON.stringify(dayAssignments).replace(/"/g, '&quot;')})">`;
            
            if (dayAssignments.length > 0) {
                dayAssignments.forEach(asig => {
                    const asigId = asig.asig_id || asig.ASIG_ID || asig.id;
                    calendarHTML += `<div style="background: #39A900; color: white; padding: 6px 8px; border-radius: 4px; font-size: 11px; margin-bottom: 4px; cursor: pointer;" onclick="event.stopPropagation(); verDetalleAsignacion(${asigId})" title="${asig.instructor_nombre}">
                        <div style="font-weight: 600;">📚 ${asig.ficha_numero}</div>
                        <div style="font-size: 10px; opacity: 0.9;">${asig.asig_hora_inicio || asig.hora_inicio || '08:00'}</div>
                    </div>`;
                });
            }
            
            calendarHTML += '</div>';
        }
        
        calendarHTML += '</div>';
        document.getElementById('calendar').innerHTML = calendarHTML;
        if (typeof lucide !== 'undefined') lucide.createIcons();
    }
    
    // Vista Diaria
    function renderDayView() {
        const dateStr = `${currentYear}-${String(currentMonth + 1).padStart(2, '0')}-${String(currentDate.getDate()).padStart(2, '0')}`;
        
        document.getElementById('currentMonth').textContent = 
            `${dayNamesFull[currentDate.getDay()]}, ${currentDate.getDate()} de ${monthNames[currentMonth]} ${currentYear}`;
        
        const dayAssignments = asignaciones.filter(a => {
            const inicio = new Date(a.asig_fecha_inicio || a.fecha_inicio);
            const fin = new Date(a.asig_fecha_fin || a.fecha_fin);
            return currentDate >= inicio && currentDate <= fin;
        });
        
        let calendarHTML = '<div style="max-width: 800px; margin: 0 auto;">';
        
        if (dayAssignments.length === 0) {
            calendarHTML += `
                <div style="text-align: center; padding: 60px 20px; color: #6b7280;">
                    <div style="font-size: 64px; margin-bottom: 16px;">📅</div>
                    <p style="margin: 0 0 16px; font-size: 18px; font-weight: 600;">No hay asignaciones para este día</p>
                    <button onclick="abrirModalNuevaAsignacion()" class="btn btn-primary">
                        <i data-lucide="plus" style="width: 16px; height: 16px;"></i>
                        Crear Asignación
                    </button>
                </div>
            `;
        } else {
            // Agrupar por hora
            const asignacionesPorHora = {};
            dayAssignments.forEach(asig => {
                const hora = asig.asig_hora_inicio || asig.hora_inicio || '08:00';
                if (!asignacionesPorHora[hora]) {
                    asignacionesPorHora[hora] = [];
                }
                asignacionesPorHora[hora].push(asig);
            });
            
            // Ordenar por hora
            const horasOrdenadas = Object.keys(asignacionesPorHora).sort();
            
            horasOrdenadas.forEach(hora => {
                calendarHTML += `<div style="margin-bottom: 24px;">
                    <div style="font-size: 14px; font-weight: 700; color: #6b7280; margin-bottom: 12px; display: flex; align-items: center; gap: 8px;">
                        <i data-lucide="clock" style="width: 16px; height: 16px;"></i>
                        ${hora}
                    </div>`;
                
                asignacionesPorHora[hora].forEach(asig => {
                    const asigId = asig.asig_id || asig.ASIG_ID || asig.id;
                    calendarHTML += `
                        <div style="background: white; border: 2px solid #e5e7eb; border-left: 4px solid #39A900; border-radius: 8px; padding: 20px; margin-bottom: 12px; transition: all 0.2s; cursor: pointer;" 
                             onmouseover="this.style.borderColor='#39A900'; this.style.transform='translateX(4px)'; this.style.boxShadow='0 4px 12px rgba(57, 169, 0, 0.2)'" 
                             onmouseout="this.style.borderColor='#e5e7eb'; this.style.borderLeftColor='#39A900'; this.style.transform='translateX(0)'; this.style.boxShadow='none'"
                             onclick="verDetalleAsignacion(${asigId})">
                            <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 12px;">
                                <div>
                                    <div style="font-weight: 700; color: #1f2937; font-size: 18px; margin-bottom: 4px;">📚 Ficha ${asig.ficha_numero}</div>
                                    <div style="font-size: 14px; color: #6b7280;">
                                        <strong>Instructor:</strong> ${asig.instructor_nombre}
                                    </div>
                                </div>
                                <span style="background: #E8F5E8; color: #39A900; padding: 6px 14px; border-radius: 12px; font-size: 12px; font-weight: 600;">ACTIVA</span>
                            </div>
                            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 12px; font-size: 14px; color: #6b7280;">
                                ${asig.ambiente_nombre ? `<div><strong>Ambiente:</strong> ${asig.ambiente_nombre}</div>` : ''}
                                ${asig.competencia_nombre ? `<div><strong>Competencia:</strong> ${asig.competencia_nombre}</div>` : ''}
                                <div><strong>Horario:</strong> ${asig.asig_hora_inicio || asig.hora_inicio || '08:00'} - ${asig.asig_hora_fin || asig.hora_fin || '17:00'}</div>
                            </div>
                        </div>
                    `;
                });
                
                calendarHTML += '</div>';
            });
        }
        
        calendarHTML += '</div>';
        document.getElementById('calendar').innerHTML = calendarHTML;
        if (typeof lucide !== 'undefined') lucide.createIcons();
    }
    
    // Event listeners para navegación
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('prevMonth')?.addEventListener('click', () => {
            if (currentView === 'mes') {
                currentMonth--;
                if (currentMonth < 0) {
                    currentMonth = 11;
                    currentYear--;
                }
                renderCalendar();
            } else if (currentView === 'semana') {
                currentDate.setDate(currentDate.getDate() - 7);
                currentMonth = currentDate.getMonth();
                currentYear = currentDate.getFullYear();
                renderWeekView();
            } else {
                currentDate.setDate(currentDate.getDate() - 1);
                currentMonth = currentDate.getMonth();
                currentYear = currentDate.getFullYear();
                renderDayView();
            }
        });
        
        document.getElementById('nextMonth')?.addEventListener('click', () => {
            if (currentView === 'mes') {
                currentMonth++;
                if (currentMonth > 11) {
                    currentMonth = 0;
                    currentYear++;
                }
                renderCalendar();
            } else if (currentView === 'semana') {
                currentDate.setDate(currentDate.getDate() + 7);
                currentMonth = currentDate.getMonth();
                currentYear = currentDate.getFullYear();
                renderWeekView();
            } else {
                currentDate.setDate(currentDate.getDate() + 1);
                currentMonth = currentDate.getMonth();
                currentYear = currentDate.getFullYear();
                renderDayView();
            }
        });
        
        document.getElementById('todayBtn')?.addEventListener('click', () => {
            const today = new Date();
            currentDate = new Date();
            currentMonth = today.getMonth();
            currentYear = today.getFullYear();
            if (currentView === 'mes') {
                renderCalendar();
            } else if (currentView === 'semana') {
                renderWeekView();
            } else {
                renderDayView();
            }
        });
    });
    
    // Initialize calendar
    function initCalendar() {
        renderCalendar();
    }

    // Función para ver asignaciones de un día
    function verAsignacionesDia(fecha, asignaciones) {
        const fechaObj = new Date(fecha + 'T00:00:00');
        const fechaFormateada = fechaObj.toLocaleDateString('es-ES', { 
            weekday: 'long', 
            year: 'numeric', 
            month: 'long', 
            day: 'numeric' 
        });

        let asignacionesHTML = '';
        if (asignaciones.length === 0) {
            asignacionesHTML = `
                <div style="text-align: center; padding: 40px 20px; color: #6b7280;">
                    <div style="font-size: 48px; margin-bottom: 16px;">📅</div>
                    <p style="margin: 0 0 16px; font-size: 16px;">No hay asignaciones para este día</p>
                    <button onclick="document.getElementById('modalDia').remove(); abrirModalNuevaAsignacion()" class="btn btn-primary btn-sm">
                        Crear Asignación
                    </button>
                </div>
            `;
        } else {
            asignacionesHTML = asignaciones.map(asig => {
                const asigId = asig.asig_id || asig.ASIG_ID || asig.id;
                return `
                <div style="background: white; border: 2px solid #e5e7eb; border-radius: 8px; padding: 16px; margin-bottom: 12px; transition: all 0.2s; cursor: pointer;" 
                     onmouseover="this.style.borderColor='#39A900'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(57, 169, 0, 0.2)'" 
                     onmouseout="this.style.borderColor='#e5e7eb'; this.style.transform='translateY(0)'; this.style.boxShadow='none'"
                     onclick="verDetalleAsignacion(${asigId})">
                    <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 8px;">
                        <div style="font-weight: 700; color: #1f2937; font-size: 16px;">📚 Ficha ${asig.ficha_numero}</div>
                        <span style="background: #E8F5E8; color: #39A900; padding: 4px 12px; border-radius: 12px; font-size: 11px; font-weight: 600;">ACTIVA</span>
                    </div>
                    <div style="font-size: 14px; color: #6b7280; margin-bottom: 4px;">
                        <strong>Instructor:</strong> ${asig.instructor_nombre}
                    </div>
                    ${asig.ambiente_nombre ? `<div style="font-size: 14px; color: #6b7280; margin-bottom: 4px;">
                        <strong>Ambiente:</strong> ${asig.ambiente_nombre}
                    </div>` : ''}
                    ${asig.competencia_nombre ? `<div style="font-size: 14px; color: #6b7280;">
                        <strong>Competencia:</strong> ${asig.competencia_nombre}
                    </div>` : ''}
                </div>
            `}).join('');
        }

        const modal = `
            <div id="modalDia" style="position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.6); display: flex; align-items: center; justify-content: center; z-index: 9999; padding: 20px;" onclick="if(event.target.id==='modalDia') this.remove()">
                <div style="background: white; border-radius: 12px; max-width: 600px; width: 100%; box-shadow: 0 25px 70px rgba(0,0,0,0.4); overflow: hidden; max-height: 90vh; overflow-y: auto;" onclick="event.stopPropagation()">
                    
                    <!-- Header -->
                    <div style="background: linear-gradient(135deg, #39A900 0%, #007832 100%); padding: 24px; color: white;">
                        <h3 style="font-size: 22px; font-weight: 700; margin: 0 0 4px;">Asignaciones del Día</h3>
                        <p style="font-size: 14px; margin: 0; opacity: 0.95;">${fechaFormateada}</p>
                    </div>

                    <!-- Contenido -->
                    <div style="padding: 24px;">
                        ${asignacionesHTML}
                    </div>

                    <!-- Footer -->
                    <div style="padding: 16px 24px; border-top: 1px solid #e5e7eb; display: flex; justify-content: space-between; gap: 12px;">
                        <button onclick="document.getElementById('modalDia').remove()" class="btn btn-secondary">Cerrar</button>
                        <button onclick="document.getElementById('modalDia').remove(); abrirModalNuevaAsignacion('${fecha}')" class="btn btn-primary">Nueva Asignación</button>
                    </div>
                </div>
            </div>
        `;
        document.body.insertAdjacentHTML('beforeend', modal);
    }

    // Función para ver detalle de una asignación
    function verDetalleAsignacion(id) {
        fetch(`${window.BASE_PATH}views/asignacion/get_asignacion.php?id=${id}`)
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    alert('Error: ' + data.error);
                    return;
                }

                const modal = `
                    <div id="modalDetalle" style="position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.6); display: flex; align-items: center; justify-content: center; z-index: 10000; padding: 20px;" onclick="if(event.target.id==='modalDetalle') this.remove()">
                        <div style="background: white; border-radius: 12px; max-width: 600px; width: 100%; box-shadow: 0 25px 70px rgba(0,0,0,0.4); overflow: hidden;" onclick="event.stopPropagation()">
                            
                            <!-- Header -->
                            <div style="background: linear-gradient(135deg, #39A900 0%, #007832 100%); padding: 24px; color: white;">
                                <h3 style="font-size: 22px; font-weight: 700; margin: 0 0 4px;">Detalle de Asignación</h3>
                                <p style="font-size: 14px; margin: 0; opacity: 0.95;">ID: ${data.id}</p>
                            </div>

                            <!-- Contenido -->
                            <div style="padding: 24px;">
                                <!-- Estado -->
                                <div style="background: ${data.estado_bg}; border-left: 4px solid ${data.estado_color}; padding: 16px; border-radius: 8px; margin-bottom: 24px;">
                                    <div style="font-weight: 700; color: ${data.estado_color}; font-size: 16px; margin-bottom: 4px;">
                                        ${data.estado === 'Activa' ? '✓' : data.estado === 'Pendiente' ? '⏳' : '✕'} ${data.estado}
                                    </div>
                                    <div style="font-size: 13px; color: #6b7280;">
                                        ${data.fecha_inicio_formatted} - ${data.fecha_fin_formatted}
                                    </div>
                                </div>

                                <!-- Información -->
                                <div style="display: grid; gap: 16px;">
                                    <div style="border-bottom: 1px solid #e5e7eb; padding-bottom: 12px;">
                                        <div style="font-size: 12px; color: #6b7280; margin-bottom: 4px; text-transform: uppercase; font-weight: 600;">Ficha</div>
                                        <div style="font-size: 18px; font-weight: 700; color: #ec4899;">${data.ficha_numero}</div>
                                    </div>

                                    <div style="border-bottom: 1px solid #e5e7eb; padding-bottom: 12px;">
                                        <div style="font-size: 12px; color: #6b7280; margin-bottom: 4px; text-transform: uppercase; font-weight: 600;">Instructor</div>
                                        <div style="font-size: 16px; font-weight: 600; color: #1f2937;">${data.instructor_nombre}</div>
                                    </div>

                                    ${data.ambiente_nombre !== 'No disponible' ? `
                                    <div style="border-bottom: 1px solid #e5e7eb; padding-bottom: 12px;">
                                        <div style="font-size: 12px; color: #6b7280; margin-bottom: 4px; text-transform: uppercase; font-weight: 600;">Ambiente</div>
                                        <div style="font-size: 16px; font-weight: 600; color: #1f2937;">${data.ambiente_nombre}</div>
                                    </div>
                                    ` : ''}

                                    ${data.competencia_nombre !== 'No disponible' ? `
                                    <div style="border-bottom: 1px solid #e5e7eb; padding-bottom: 12px;">
                                        <div style="font-size: 12px; color: #6b7280; margin-bottom: 4px; text-transform: uppercase; font-weight: 600;">Competencia</div>
                                        <div style="font-size: 16px; font-weight: 600; color: #1f2937;">${data.competencia_nombre}</div>
                                    </div>
                                    ` : ''}

                                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                                        <div>
                                            <div style="font-size: 12px; color: #6b7280; margin-bottom: 4px; text-transform: uppercase; font-weight: 600;">Hora Inicio</div>
                                            <div style="font-size: 16px; font-weight: 600; color: #1f2937;">⏰ ${data.hora_inicio}</div>
                                        </div>
                                        <div>
                                            <div style="font-size: 12px; color: #6b7280; margin-bottom: 4px; text-transform: uppercase; font-weight: 600;">Hora Fin</div>
                                            <div style="font-size: 16px; font-weight: 600; color: #1f2937;">⏰ ${data.hora_fin}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Footer -->
                            <div style="padding: 16px 24px; border-top: 1px solid #e5e7eb; display: flex; justify-content: space-between; gap: 12px;">
                                <button onclick="document.getElementById('modalDetalle').remove()" class="btn btn-secondary">Cerrar</button>
                                <div style="display: flex; gap: 8px;">
                                    <a href="${window.BASE_PATH}asignacion/ver/${data.id}" class="btn btn-secondary btn-sm">Ver Completo</a>
                                    <a href="${window.BASE_PATH}asignacion/editar/${data.id}" class="btn btn-primary btn-sm">Editar</a>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                document.body.insertAdjacentHTML('beforeend', modal);
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al cargar los detalles de la asignación');
            });
    }

    // Show create modal
    function showCreateModal(startDate, endDate) {
        // Cargar datos para los selects
        fetch(`${window.BASE_PATH}views/asignacion/get_form_data.php`)
            .then(response => response.json())
            .then(data => {
                const modal = `
                    <div id="createModal" style="position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.6); display: flex; align-items: center; justify-content: center; z-index: 9999; padding: 20px;" onclick="if(event.target.id==='createModal') this.remove()">
                        <div style="background: white; border-radius: 12px; max-width: 700px; width: 100%; box-shadow: 0 25px 70px rgba(0,0,0,0.4); overflow: hidden; max-height: 90vh; overflow-y: auto;" onclick="event.stopPropagation()">
                            
                            <!-- Header Verde -->
                            <div style="background: white; padding: 20px 24px; display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid #e5e7eb;">
                                <div style="display: flex; align-items: center; gap: 12px;">
                                    <div style="width: 32px; height: 32px; background: #39A900; border-radius: 6px; display: flex; align-items: center; justify-content: center;">
                                        <span style="font-size: 18px;">📅</span>
                                    </div>
                                    <h3 style="font-size: 18px; font-weight: 700; color: #1f2937; margin: 0;">Agregar Evento</h3>
                                </div>
                                <button onclick="document.getElementById('createModal').remove()" style="background: transparent; border: none; width: 28px; height: 28px; cursor: pointer; display: flex; align-items: center; justify-content: center; color: #6b7280; font-size: 24px; line-height: 1;">×</button>
                            </div>

                            <!-- Contenido -->
                            <form id="createForm" method="POST" action="<?php echo BASE_PATH; ?>asignacion/crear" onsubmit="return validateForm(event)">
                                <div style="padding: 24px;">
                                    
                                    <!-- Sección: Información del Evento -->
                                    <div style="margin-bottom: 24px;">
                                        <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 16px; padding: 8px 12px; background: white; border-left: 4px solid #39A900;">
                                            <span style="font-size: 14px; font-weight: 700; color: #1f2937;">Información del Evento</span>
                                        </div>
                                        
                                        <!-- Tabla de información -->
                                        <table style="width: 100%; border-collapse: collapse; border: 1px solid #e5e7eb;">
                                            <thead>
                                                <tr style="background: #39A900;">
                                                    <th style="padding: 12px 16px; text-align: left; font-size: 12px; font-weight: 700; color: white; text-transform: uppercase; border-right: 1px solid rgba(255,255,255,0.3);">CAMPO</th>
                                                    <th style="padding: 12px 16px; text-align: left; font-size: 12px; font-weight: 700; color: white; text-transform: uppercase; border-right: 1px solid rgba(255,255,255,0.3);">VALOR</th>
                                                    <th style="padding: 12px 16px; text-align: center; font-size: 12px; font-weight: 700; color: white; text-transform: uppercase; border-right: 1px solid rgba(255,255,255,0.3);">ESTADO</th>
                                                    <th style="padding: 12px 16px; text-align: center; font-size: 12px; font-weight: 700; color: white; text-transform: uppercase;">VERIFICADO</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr style="background: white; border-bottom: 1px solid #e5e7eb;">
                                                    <td style="padding: 12px 16px; font-size: 13px; font-weight: 600; color: #374151;">Ficha</td>
                                                    <td style="padding: 12px 16px;">
                                                        <select name="ficha_id" required style="width: 100%; padding: 8px 12px; border: 2px solid #e5e7eb; border-radius: 6px; font-size: 13px; background: white;">
                                                            <option value="">Seleccionar...</option>
                                                            ${data.fichas.map(f => `<option value="${f.id}">${f.numero}</option>`).join('')}
                                                        </select>
                                                    </td>
                                                    <td style="padding: 12px 16px; text-align: center;">
                                                        <span style="background: #FEF3C7; color: #D97706; padding: 4px 12px; border-radius: 4px; font-size: 11px; font-weight: 700; text-transform: uppercase;">PENDIENTE</span>
                                                    </td>
                                                    <td style="padding: 12px 16px; text-align: center;">
                                                        <span style="color: #D97706; font-size: 18px;">⏳</span>
                                                    </td>
                                                </tr>
                                                <tr style="background: #f9fafb; border-bottom: 1px solid #e5e7eb;">
                                                    <td style="padding: 12px 16px; font-size: 13px; font-weight: 600; color: #374151;">Instructor</td>
                                                    <td style="padding: 12px 16px;">
                                                        <select name="instructor_id" required style="width: 100%; padding: 8px 12px; border: 2px solid #e5e7eb; border-radius: 6px; font-size: 13px; background: white;">
                                                            <option value="">Seleccionar...</option>
                                                            ${data.instructores.map(i => `<option value="${i.id}">${i.nombre}</option>`).join('')}
                                                        </select>
                                                    </td>
                                                    <td style="padding: 12px 16px; text-align: center;">
                                                        <span style="background: #FEF3C7; color: #D97706; padding: 4px 12px; border-radius: 4px; font-size: 11px; font-weight: 700; text-transform: uppercase;">PENDIENTE</span>
                                                    </td>
                                                    <td style="padding: 12px 16px; text-align: center;">
                                                        <span style="color: #D97706; font-size: 18px;">⏳</span>
                                                    </td>
                                                </tr>
                                                <tr style="background: white; border-bottom: 1px solid #e5e7eb;">
                                                    <td style="padding: 12px 16px; font-size: 13px; font-weight: 600; color: #374151;">Ambiente</td>
                                                    <td style="padding: 12px 16px;">
                                                        <select name="ambiente_id" required style="width: 100%; padding: 8px 12px; border: 2px solid #e5e7eb; border-radius: 6px; font-size: 13px; background: white;">
                                                            <option value="">Seleccionar...</option>
                                                            ${data.ambientes.map(a => `<option value="${a.id}">${a.nombre}</option>`).join('')}
                                                        </select>
                                                    </td>
                                                    <td style="padding: 12px 16px; text-align: center;">
                                                        <span style="background: #FEF3C7; color: #D97706; padding: 4px 12px; border-radius: 4px; font-size: 11px; font-weight: 700; text-transform: uppercase;">PENDIENTE</span>
                                                    </td>
                                                    <td style="padding: 12px 16px; text-align: center;">
                                                        <span style="color: #D97706; font-size: 18px;">⏳</span>
                                                    </td>
                                                </tr>
                                                <tr style="background: #f9fafb; border-bottom: 1px solid #e5e7eb;">
                                                    <td style="padding: 12px 16px; font-size: 13px; font-weight: 600; color: #374151;">Competencia</td>
                                                    <td style="padding: 12px 16px;">
                                                        <select name="competencia_id" style="width: 100%; padding: 8px 12px; border: 2px solid #e5e7eb; border-radius: 6px; font-size: 13px; background: white;">
                                                            <option value="">Seleccionar...</option>
                                                            ${data.competencias.map(c => `<option value="${c.id}">${c.nombre}</option>`).join('')}
                                                        </select>
                                                    </td>
                                                    <td style="padding: 12px 16px; text-align: center;">
                                                        <span style="background: #E5E7EB; color: #6B7280; padding: 4px 12px; border-radius: 4px; font-size: 11px; font-weight: 700; text-transform: uppercase;">OPCIONAL</span>
                                                    </td>
                                                    <td style="padding: 12px 16px; text-align: center;">
                                                        <span style="color: #6B7280; font-size: 18px;">-</span>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <!-- Días de la semana -->
                                    <div style="margin-bottom: 24px;">
                                        <label style="display: block; font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 12px;">Días de la semana</label>
                                        <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                                            <label style="display: flex; align-items: center; gap: 6px; padding: 8px 14px; border: 2px solid #39A900; background: #E8F5E8; border-radius: 8px; cursor: pointer; transition: all 0.2s;">
                                                <input type="checkbox" name="dias[]" value="1" checked style="width: 18px; height: 18px; cursor: pointer; accent-color: #39A900;">
                                                <span style="font-size: 14px; font-weight: 500; color: #1f2937;">Lun</span>
                                            </label>
                                            <label style="display: flex; align-items: center; gap: 6px; padding: 8px 14px; border: 2px solid #39A900; background: #E8F5E8; border-radius: 8px; cursor: pointer; transition: all 0.2s;">
                                                <input type="checkbox" name="dias[]" value="2" checked style="width: 18px; height: 18px; cursor: pointer; accent-color: #39A900;">
                                                <span style="font-size: 14px; font-weight: 500; color: #1f2937;">Mar</span>
                                            </label>
                                            <label style="display: flex; align-items: center; gap: 6px; padding: 8px 14px; border: 2px solid #39A900; background: #E8F5E8; border-radius: 8px; cursor: pointer; transition: all 0.2s;">
                                                <input type="checkbox" name="dias[]" value="3" checked style="width: 18px; height: 18px; cursor: pointer; accent-color: #39A900;">
                                                <span style="font-size: 14px; font-weight: 500; color: #1f2937;">Mié</span>
                                            </label>
                                            <label style="display: flex; align-items: center; gap: 6px; padding: 8px 14px; border: 2px solid #39A900; background: #E8F5E8; border-radius: 8px; cursor: pointer; transition: all 0.2s;">
                                                <input type="checkbox" name="dias[]" value="4" checked style="width: 18px; height: 18px; cursor: pointer; accent-color: #39A900;">
                                                <span style="font-size: 14px; font-weight: 500; color: #1f2937;">Jue</span>
                                            </label>
                                            <label style="display: flex; align-items: center; gap: 6px; padding: 8px 14px; border: 2px solid #39A900; background: #E8F5E8; border-radius: 8px; cursor: pointer; transition: all 0.2s;">
                                                <input type="checkbox" name="dias[]" value="5" checked style="width: 18px; height: 18px; cursor: pointer; accent-color: #39A900;">
                                                <span style="font-size: 14px; font-weight: 500; color: #1f2937;">Vie</span>
                                            </label>
                                            <label style="display: flex; align-items: center; gap: 6px; padding: 8px 14px; border: 2px solid #e5e7eb; border-radius: 8px; cursor: pointer; transition: all 0.2s;">
                                                <input type="checkbox" name="dias[]" value="6" style="width: 18px; height: 18px; cursor: pointer; accent-color: #39A900;">
                                                <span style="font-size: 14px; font-weight: 500; color: #1f2937;">Sáb</span>
                                            </label>
                                        </div>
                                    </div>

                                    <!-- Información adicional -->
                                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 24px;">
                                        <div style="background: white; padding: 16px; border-radius: 8px; border: 2px solid #e5e7eb;">
                                            <div style="font-size: 11px; color: #6b7280; font-weight: 600; text-transform: uppercase; margin-bottom: 8px; letter-spacing: 0.5px;">RANGO DE FECHAS</div>
                                            <div style="display: grid; grid-template-columns: 1fr auto 1fr; gap: 8px; align-items: center;">
                                                <input type="date" name="fecha_inicio" value="${startDate}" required style="width: 100%; padding: 8px; border: 2px solid #e5e7eb; border-radius: 6px; font-size: 13px;">
                                                <span style="color: #6b7280; font-weight: 500;">-</span>
                                                <input type="date" name="fecha_fin" value="${endDate}" required style="width: 100%; padding: 8px; border: 2px solid #e5e7eb; border-radius: 6px; font-size: 13px;">
                                            </div>
                                        </div>
                                        <div style="background: white; padding: 16px; border-radius: 8px; border: 2px solid #e5e7eb;">
                                            <div style="font-size: 11px; color: #6b7280; font-weight: 600; text-transform: uppercase; margin-bottom: 8px; letter-spacing: 0.5px;">RANGO DE HORAS</div>
                                            <div style="display: grid; grid-template-columns: 1fr auto 1fr; gap: 8px; align-items: center;">
                                                <input type="time" name="hora_inicio" value="08:00" required style="width: 100%; padding: 8px; border: 2px solid #e5e7eb; border-radius: 6px; font-size: 13px;">
                                                <span style="color: #6b7280; font-weight: 500;">-</span>
                                                <input type="time" name="hora_fin" value="17:00" required style="width: 100%; padding: 8px; border: 2px solid #e5e7eb; border-radius: 6px; font-size: 13px;">
                                            </div>
                                            <p style="font-size: 11px; color: #6b7280; margin: 6px 0 0; font-style: italic;">Horario: 6:00 AM - 10:00 PM</p>
                                        </div>
                                    </div>

                                    <!-- Botones de acción -->
                                    <div style="display: flex; gap: 12px;">
                                        <button type="button" onclick="document.getElementById('createModal').remove()" style="flex: 1; padding: 12px; background: #6b7280; color: white; border: none; border-radius: 8px; font-weight: 600; font-size: 14px; cursor: pointer; transition: all 0.2s;" onmouseover="this.style.background='#4b5563'" onmouseout="this.style.background='#6b7280'">
                                            Cancelar
                                        </button>
                                        <button type="submit" style="flex: 1; padding: 12px; background: #39A900; color: white; border: none; border-radius: 8px; font-weight: 600; font-size: 14px; cursor: pointer; transition: all 0.2s;" onmouseover="this.style.background='#2d8700'" onmouseout="this.style.background='#39A900'">
                                            Guardar
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                `;
                document.body.insertAdjacentHTML('beforeend', modal);
                
                // Agregar efecto hover a los checkboxes
                document.querySelectorAll('#createModal label:has(input[type="checkbox"])').forEach(label => {
                    const checkbox = label.querySelector('input[type="checkbox"]');
                    checkbox.addEventListener('change', function() {
                        if (this.checked) {
                            label.style.borderColor = '#39A900';
                            label.style.background = '#E8F5E8';
                        } else {
                            label.style.borderColor = '#e5e7eb';
                            label.style.background = 'white';
                        }
                    });
                    // Inicializar estado
                    if (checkbox.checked) {
                        label.style.borderColor = '#39A900';
                        label.style.background = '#E8F5E8';
                    }
                });
                
                if (typeof lucide !== 'undefined') {
                    lucide.createIcons();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al cargar los datos del formulario');
            });
    }

    // Validar formulario antes de enviar
    function validateForm(event) {
        // Validar que al menos un día esté seleccionado
        const diasCheckboxes = document.querySelectorAll('input[name="dias[]"]:checked');
        if (diasCheckboxes.length === 0) {
            event.preventDefault();
            alert('Por favor, selecciona al menos un día de la semana');
            return false;
        }

        // Validar rango de horas (6:00 AM - 10:00 PM)
        const horaInicio = document.querySelector('input[name="hora_inicio"]').value;
        const horaFin = document.querySelector('input[name="hora_fin"]').value;
        
        const [horaInicioH, horaInicioM] = horaInicio.split(':').map(Number);
        const [horaFinH, horaFinM] = horaFin.split(':').map(Number);
        
        const minutosInicio = horaInicioH * 60 + horaInicioM;
        const minutosFin = horaFinH * 60 + horaFinM;
        const minutosMin = 6 * 60; // 6:00 AM
        const minutosMax = 22 * 60; // 10:00 PM
        
        if (minutosInicio < minutosMin || minutosInicio > minutosMax) {
            event.preventDefault();
            alert('La hora de inicio debe estar entre 6:00 AM y 10:00 PM');
            return false;
        }
        
        if (minutosFin < minutosMin || minutosFin > minutosMax) {
            event.preventDefault();
            alert('La hora de fin debe estar entre 6:00 AM y 10:00 PM');
            return false;
        }
        
        if (minutosFin <= minutosInicio) {
            event.preventDefault();
            alert('La hora de fin debe ser posterior a la hora de inicio');
            return false;
        }
        
        return true;
    }

</script>

<script>
// Función para abrir modal de nueva asignación
function abrirModalNuevaAsignacion(date = null) {
    const hoy = date || new Date().toISOString().split('T')[0];
    const fechaObj = new Date(hoy + 'T00:00:00');
    const fechaFormateada = fechaObj.toLocaleDateString('es-ES', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
    
    // Obtener la ficha preseleccionada desde la URL si existe
    const urlParams = new URLSearchParams(window.location.search);
    const fichaIdFromUrl = urlParams.get('ficha_id') || '';
    
    const modal = `
        <div id="modalNuevaAsignacion" style="position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.6); display: flex; align-items: center; justify-content: center; z-index: 9999; padding: 20px;" onclick="if(event.target.id==='modalNuevaAsignacion') cerrarModal()">
            <div style="background: white; border-radius: 12px; max-width: 500px; width: 100%; box-shadow: 0 25px 70px rgba(0,0,0,0.4); overflow: hidden; max-height: 90vh; overflow-y: auto;" onclick="event.stopPropagation()">
                
                <!-- Header Verde -->
                <div style="background: linear-gradient(135deg, #39A900 0%, #007832 100%); padding: 24px; color: white;">
                    <h3 style="font-size: 22px; font-weight: 700; margin: 0 0 4px;">Nueva Asignación</h3>
                    <p style="font-size: 14px; margin: 0; opacity: 0.95;">${fechaFormateada}</p>
                </div>

                <!-- Formulario -->
                <form method="POST" action="" style="padding: 24px;">
                    <input type="hidden" name="crear_asignacion" value="1">
                    
                    <!-- ID Asignación (auto) -->
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 8px;">ID Asignación:</label>
                        <input type="text" value="Auto-generado" disabled style="width: 100%; padding: 10px 12px; border: 2px solid #e5e7eb; border-radius: 6px; font-size: 14px; background: #f9fafb; color: #6b7280;">
                    </div>

                    <!-- Instructor -->
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 8px;">Instructor:</label>
                        <select name="instructor_id" required style="width: 100%; padding: 10px 12px; border: 2px solid #e5e7eb; border-radius: 6px; font-size: 14px; background: white; color: #1f2937;">
                            <option value="">Seleccione un instructor</option>
                            <?php foreach ($instructores as $instructor): ?>
                                <option value="<?php echo htmlspecialchars($instructor['inst_id'] ?? ''); ?>">
                                    <?php echo htmlspecialchars(($instructor['inst_nombres'] ?? '') . ' ' . ($instructor['inst_apellidos'] ?? '')); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Fecha Inicio y Fin -->
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 20px;">
                        <div>
                            <label style="display: block; font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 8px;">Fecha Inicio:</label>
                            <input type="date" name="fecha_inicio" value="${hoy}" required style="width: 100%; padding: 10px 12px; border: 2px solid #e5e7eb; border-radius: 6px; font-size: 14px;">
                        </div>
                        <div>
                            <label style="display: block; font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 8px;">Fecha Fin:</label>
                            <input type="date" name="fecha_fin" value="${hoy}" required style="width: 100%; padding: 10px 12px; border: 2px solid #e5e7eb; border-radius: 6px; font-size: 14px;">
                        </div>
                    </div>

                    <!-- Horario -->
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 20px;">
                        <div>
                            <label style="display: block; font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 8px;">Hora Inicio:</label>
                            <input type="time" name="hora_inicio" value="08:00" required style="width: 100%; padding: 10px 12px; border: 2px solid #e5e7eb; border-radius: 6px; font-size: 14px;">
                        </div>
                        <div>
                            <label style="display: block; font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 8px;">Hora Fin:</label>
                            <input type="time" name="hora_fin" value="10:00" required style="width: 100%; padding: 10px 12px; border: 2px solid #e5e7eb; border-radius: 6px; font-size: 14px;">
                        </div>
                    </div>

                    <!-- Ficha -->
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 8px;">Ficha:</label>
                        <select name="ficha_id" required style="width: 100%; padding: 10px 12px; border: 2px solid #e5e7eb; border-radius: 6px; font-size: 14px; background: white; color: #1f2937;">
                            <option value="">Seleccione una ficha</option>
                            <?php foreach ($fichas as $ficha): ?>
                                <option value="<?php echo htmlspecialchars($ficha['fich_id'] ?? ''); ?>" ${fichaIdFromUrl == '<?php echo $ficha['fich_id']; ?>' ? 'selected' : ''}>
                                    Ficha <?php echo str_pad(htmlspecialchars($ficha['fich_numero'] ?? ''), 8, '0', STR_PAD_LEFT); ?> - <?php echo htmlspecialchars($ficha['prog_denominacion'] ?? ''); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Ambiente -->
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 8px;">Ambiente:</label>
                        <select name="ambiente_id" style="width: 100%; padding: 10px 12px; border: 2px solid #e5e7eb; border-radius: 6px; font-size: 14px; background: white; color: #1f2937;">
                            <option value="">Seleccione un ambiente</option>
                            <?php foreach ($ambientes as $ambiente): ?>
                                <option value="<?php echo htmlspecialchars($ambiente['amb_id'] ?? ''); ?>">
                                    <?php echo htmlspecialchars($ambiente['amb_nombre'] ?? ''); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Competencia -->
                    <div style="margin-bottom: 24px;">
                        <label style="display: block; font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 8px;">Competencia:</label>
                        <select name="competencia_id" style="width: 100%; padding: 10px 12px; border: 2px solid #e5e7eb; border-radius: 6px; font-size: 14px; background: white; color: #1f2937;">
                            <option value="">Seleccione una competencia</option>
                            <?php foreach ($competencias as $competencia): ?>
                                <option value="<?php echo htmlspecialchars($competencia['comp_id'] ?? ''); ?>">
                                    <?php echo htmlspecialchars($competencia['comp_nombre_corto'] ?? ''); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Botones -->
                    <div style="display: flex; gap: 12px;">
                        <button type="button" onclick="cerrarModal()" style="flex: 1; padding: 14px; background: #6b7280; color: white; border: none; border-radius: 8px; font-weight: 600; font-size: 14px; cursor: pointer; transition: all 0.2s;" onmouseover="this.style.background='#4b5563'" onmouseout="this.style.background='#6b7280'">
                            Cancelar
                        </button>
                        <button type="submit" style="flex: 1; padding: 14px; background: linear-gradient(135deg, #39A900 0%, #007832 100%); color: white; border: none; border-radius: 8px; font-weight: 600; font-size: 14px; cursor: pointer; transition: all 0.2s; box-shadow: 0 4px 12px rgba(57, 169, 0, 0.3);" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 16px rgba(57, 169, 0, 0.4)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(57, 169, 0, 0.3)'">
                            Guardar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    `;
    document.body.insertAdjacentHTML('beforeend', modal);
}

function cerrarModal() {
    const modal = document.getElementById('modalNuevaAsignacion');
    if (modal) {
        modal.remove();
    }
}
</script>

<?php // Footer incluido por BaseController ?>
