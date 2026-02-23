<script src="https://unpkg.com/lucide@latest"></script>
<script>
    // Datos de asignaciones desde PHP
    const asignaciones = <?php echo json_encode($asignacionesCalendario); ?>;
    const BASE_PATH = '<?php echo BASE_PATH; ?>';
    
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
                const inicio = new Date(a.fecha_inicio);
                const fin = new Date(a.fecha_fin);
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
                    calendarHTML += `<div style="background: #39A900; color: white; padding: 4px 6px; border-radius: 4px; font-size: 10px; margin-bottom: 2px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; cursor: pointer;" title="${asig.instructor_nombre} - Ficha ${asig.ficha_numero}" onclick="event.stopPropagation(); verDetalleAsignacion(${asig.id})">
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
        
        lucide.createIcons();
    }
    
    // Event listeners para navegación
    document.getElementById('prevMonth').addEventListener('click', () => {
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
    
    document.getElementById('nextMonth').addEventListener('click', () => {
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
    
    document.getElementById('todayBtn').addEventListener('click', () => {
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
                const inicio = new Date(a.fecha_inicio);
                const fin = new Date(a.fecha_fin);
                return day >= inicio && day <= fin;
            });
            
            let dayStyle = 'min-height: 150px; padding: 12px; background: white; border: 1px solid #e5e7eb; border-radius: 8px; transition: all 0.2s;';
            if (isToday) {
                dayStyle = 'min-height: 150px; padding: 12px; background: #E8F5E8; border: 2px solid #39A900; border-radius: 8px; transition: all 0.2s;';
            }
            
            calendarHTML += `<div style="${dayStyle}" class="calendar-day" onclick="verAsignacionesDia('${dateStr}', ${JSON.stringify(dayAssignments).replace(/"/g, '&quot;')})">`;
            
            if (dayAssignments.length > 0) {
                dayAssignments.forEach(asig => {
                    calendarHTML += `<div style="background: #39A900; color: white; padding: 6px 8px; border-radius: 4px; font-size: 11px; margin-bottom: 4px; cursor: pointer;" onclick="event.stopPropagation(); verDetalleAsignacion(${asig.id})" title="${asig.instructor_nombre}">
                        <div style="font-weight: 600;">📚 ${asig.ficha_numero}</div>
                        <div style="font-size: 10px; opacity: 0.9;">${asig.hora_inicio}</div>
                    </div>`;
                });
            }
            
            calendarHTML += '</div>';
        }
        
        calendarHTML += '</div>';
        document.getElementById('calendar').innerHTML = calendarHTML;
        lucide.createIcons();
    }
    
    // Vista Diaria
    function renderDayView() {
        const dateStr = `${currentYear}-${String(currentMonth + 1).padStart(2, '0')}-${String(currentDate.getDate()).padStart(2, '0')}`;
        
        document.getElementById('currentMonth').textContent = 
            `${dayNamesFull[currentDate.getDay()]}, ${currentDate.getDate()} de ${monthNames[currentMonth]} ${currentYear}`;
        
        const dayAssignments = asignaciones.filter(a => {
            const inicio = new Date(a.fecha_inicio);
            const fin = new Date(a.fecha_fin);
            return currentDate >= inicio && currentDate <= fin;
        });
        
        let calendarHTML = '<div style="max-width: 800px; margin: 0 auto;">';
        
        if (dayAssignments.length === 0) {
            calendarHTML += `
                <div style="text-align: center; padding: 60px 20px; color: #6b7280;">
                    <div style="font-size: 64px; margin-bottom: 16px;">📅</div>
                    <p style="margin: 0 0 16px; font-size: 18px; font-weight: 600;">No hay asignaciones para este día</p>
                    <button onclick="window.location.href='${BASE_PATH}views/asignacion/crear.php'" class="btn btn-primary">
                        <i data-lucide="plus" style="width: 16px; height: 16px;"></i>
                        Crear Asignación
                    </button>
                </div>
            `;
        } else {
            // Agrupar por hora
            const asignacionesPorHora = {};
            dayAssignments.forEach(asig => {
                const hora = asig.hora_inicio;
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
                    calendarHTML += `
                        <div style="background: white; border: 2px solid #e5e7eb; border-left: 4px solid #39A900; border-radius: 8px; padding: 20px; margin-bottom: 12px; transition: all 0.2s; cursor: pointer;" 
                             onmouseover="this.style.borderColor='#39A900'; this.style.transform='translateX(4px)'; this.style.boxShadow='0 4px 12px rgba(57, 169, 0, 0.2)'" 
                             onmouseout="this.style.borderColor='#e5e7eb'; this.style.borderLeftColor='#39A900'; this.style.transform='translateX(0)'; this.style.boxShadow='none'"
                             onclick="verDetalleAsignacion(${asig.id})">
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
                                <div><strong>Horario:</strong> ${asig.hora_inicio} - ${asig.hora_fin}</div>
                            </div>
                        </div>
                    `;
                });
                
                calendarHTML += '</div>';
            });
        }
        
        calendarHTML += '</div>';
        document.getElementById('calendar').innerHTML = calendarHTML;
        lucide.createIcons();
    }
    
    // Event listeners para navegación
    document.getElementById('prevMonth').addEventListener('click', () => {
        currentMonth--;
        if (currentMonth < 0) {
            currentMonth = 11;
            currentYear--;
        }
        renderCalendar();
    });
    
    document.getElementById('nextMonth').addEventListener('click', () => {
        currentMonth++;
        if (currentMonth > 11) {
            currentMonth = 0;
            currentYear++;
        }
        renderCalendar();
    });
    
    document.getElementById('todayBtn').addEventListener('click', () => {
        const today = new Date();
        currentMonth = today.getMonth();
        currentYear = today.getFullYear();
        renderCalendar();
    });
    
    // Renderizar calendario inicial
    renderCalendar();
    
    lucide.createIcons();
    
    // Hover effect en cards
    document.querySelectorAll('.stat-card').forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-4px)';
            this.style.boxShadow = '0 4px 12px rgba(0, 0, 0, 0.1)';
        });
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
            this.style.boxShadow = 'none';
        });
    });
    
    // Hover effect en filas de tabla
    document.querySelectorAll('.table-row').forEach(row => {
        row.addEventListener('mouseenter', function() {
            this.style.background = '#f9fafb';
        });
        row.addEventListener('mouseleave', function() {
            this.style.background = 'white';
        });
    });


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
                    <button onclick="document.getElementById('modalDia').remove(); window.location.href='${BASE_PATH}views/asignacion/index.php'" class="btn btn-primary btn-sm">
                        Crear Asignación
                    </button>
                </div>
            `;
        } else {
            asignacionesHTML = asignaciones.map(asig => `
                <div style="background: white; border: 2px solid #e5e7eb; border-radius: 8px; padding: 16px; margin-bottom: 12px; transition: all 0.2s; cursor: pointer;" 
                     onmouseover="this.style.borderColor='#39A900'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(57, 169, 0, 0.2)'" 
                     onmouseout="this.style.borderColor='#e5e7eb'; this.style.transform='translateY(0)'; this.style.boxShadow='none'"
                     onclick="verDetalleAsignacion(${asig.id})">
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
            `).join('');
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
                    <div style="padding: 16px 24px; border-top: 1px solid #e5e7eb; display: flex; justify-content: flex-end; gap: 12px;">
                        <button onclick="document.getElementById('modalDia').remove()" class="btn btn-secondary">Cerrar</button>
                        <a href="${BASE_PATH}asignacion/index" class="btn btn-primary">Ver Todas</a>
                    </div>
                </div>
            </div>
        `;
        document.body.insertAdjacentHTML('beforeend', modal);
    }


    // Función para ver detalle de una asignación
    function verDetalleAsignacion(id) {
        console.log('Intentando cargar asignación con ID:', id);
        
        if (!id) {
            alert('Error: ID de asignación no válido');
            return;
        }
        
        fetch(`${BASE_PATH}views/asignacion/get_asignacion.php?id=${id}`)
            .then(response => {
                console.log('Respuesta recibida:', response.status);
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                console.log('Datos recibidos:', data);
                
                if (data.error) {
                    console.error('Error en datos:', data);
                    alert('Error: ' + data.error + (data.debug ? '\n\nDebug: ' + JSON.stringify(data.debug) : ''));
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
                                    <a href="${BASE_PATH}asignacion/show/${data.id}" class="btn btn-secondary btn-sm">Ver Completo</a>
                                    <a href="${BASE_PATH}asignacion/edit/${data.id}" class="btn btn-primary btn-sm">Editar</a>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                document.body.insertAdjacentHTML('beforeend', modal);
            })
            .catch(error => {
                console.error('Error completo:', error);
                alert('Error al cargar los detalles de la asignación.\n\nDetalles técnicos:\n' + error.message + '\n\nRevisa la consola del navegador (F12) para más información.');
            });
    }
</script>
