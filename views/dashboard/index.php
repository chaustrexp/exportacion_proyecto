<div class="main-content">
    <!-- Header del Dashboard -->
    <div style="padding: 16px 0;">
        <?php if ($rol === 'Instructor'): ?>
            <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 20px;">
                <div>
                    <?php if (isset($instructor_info) && $instructor_info['is_owner']): ?>
                        <h1 style="font-size: 32px; font-weight: 800; color: #1f2937; margin: 0 0 8px; letter-spacing: -1px;">
                            Bienvenido, <?php echo htmlspecialchars($instructor_info['inst_nombres']); ?>
                        </h1>
                        <p style="font-size: 16px; color: #667085; font-weight: 500; margin: 0;">
                            Este es tu resumen personal de labores académicas
                        </p>
                    <?php else: ?>
                        <h1 style="font-size: 32px; font-weight: 800; color: #1f2937; margin: 0 0 8px; letter-spacing: -1px;">
                            👁️ Viendo horario de: <?php echo htmlspecialchars($instructor_info['inst_nombres']); ?>
                        </h1>
                        <p style="font-size: 16px; color: #667085; font-weight: 500; margin: 0;">
                            Estás visualizando el panel de control y cronograma de este instructor.
                        </p>
                    <?php endif; ?>
                </div>
                
                <form method="GET" action="<?php echo BASE_PATH; ?>dashboard/index" style="background: white; padding: 12px 20px; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); border: 1px solid #e5e7eb;">
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <label for="view_instructor_id" style="font-weight: 600; color: #374151; font-size: 14px;">Ver agenda de:</label>
                        <select name="view_instructor_id" id="view_instructor_id" style="padding: 8px 12px; border-radius: 8px; border: 1px solid #d1d5db; font-size: 14px; color: #1f2937; outline: none; cursor: pointer; min-width: 250px;" onchange="this.form.submit()">
                            <option value="<?php echo $_SESSION['instructor_id']; ?>" <?php echo (isset($view_instructor_id) && $view_instructor_id == $_SESSION['instructor_id']) ? 'selected' : ''; ?>>
                                Mis Asignaciones (<?php echo htmlspecialchars($_SESSION['nombre'] ?? $_SESSION['usuario_nombre']); ?>)
                            </option>
                            <optgroup label="Otros Instructores">
                            <?php foreach ($instructores as $inst): ?>
                                <?php if ($inst['inst_id'] != $_SESSION['instructor_id']): ?>
                                    <option value="<?php echo $inst['inst_id']; ?>" <?php echo (isset($view_instructor_id) && $view_instructor_id == $inst['inst_id']) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($inst['inst_nombres'] . ' ' . $inst['inst_apellidos']); ?>
                                    </option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                            </optgroup>
                        </select>
                    </div>
                </form>
            </div>
        <?php else: ?>
            <div style="background: #e8f5e9; padding: 32px; border-radius: 24px; border: 1px solid #c3e6cb; position: relative; overflow: hidden; display: flex; justify-content: space-between; align-items: center;">
                <div style="position: relative; z-index: 2;">
                    <h1 style="font-size: 32px; font-weight: 800; color: #1f2937; margin: 0 0 8px; letter-spacing: -1px;">
                        <?php 
                            $nombre = $_SESSION['usuario_nombre'] ?? 'Usuario';
                            if ($rol === 'Coordinador') echo 'Bienvenido Coordinador, ' . $nombre;
                            else echo 'Bienvenido Administrador'; 
                        ?>
                    </h1>
                    <p style="font-size: 16px; color: #667085; font-weight: 500; margin: 0;">
                        <?php 
                            if ($rol === 'Coordinador') echo 'Gestión y seguimiento de la coordinación académica centralizada.';
                            else echo 'Resumen general de la gestión académica y operativa del sistema.'; 
                        ?>
                    </p>
                </div>
                
                <?php if ($rol === 'Coordinador'): ?>
                <div style="position: relative; z-index: 2;">
                    <a href="<?php echo BASE_PATH; ?>asignacion/crear" style="background: #15803d; color: white; padding: 12px 24px; border-radius: 12px; font-weight: 700; font-size: 14px; text-decoration: none; display: flex; align-items: center; gap: 8px; transition: all 0.2s; box-shadow: 0 4px 6px -1px rgba(21, 128, 61, 0.2);" onmouseover="this.style.background='#166534'; this.style.transform='translateY(-2px)';" onmouseout="this.style.background='#15803d'; this.style.transform='translateY(0)';">
                        <i data-lucide="plus" style="width: 18px; height: 18px;"></i>
                        Nueva Asignación
                    </a>
                </div>
                <?php endif; ?>

                <!-- Decorative circle -->
                <div style="position: absolute; top: -50px; right: -50px; width: 200px; height: 200px; background: rgba(57, 169, 0, 0.05); border-radius: 50%;"></div>
            </div>
        <?php endif; ?>
    </div>

    <!-- Tarjetas de Estadísticas -->
    <?php include __DIR__ . '/stats_cards.php'; ?>

    <?php if ($rol !== 'Administrador'): ?>
        <?php if ($rol === 'Instructor'): ?>
            <div style="padding: 0 32px 12px;">
                <h2 style="font-size: 18px; font-weight: 700; color: #374151; display: flex; align-items: center; gap: 8px;">
                    <i data-lucide="calendar-days" style="width: 20px; height: 20px; color: #39A900;"></i>
                    Mi Horario Académico
                </h2>
            </div>
        <?php elseif ($rol === 'Coordinador'): ?>
            <div style="padding: 0 32px 12px;">
                <h2 style="font-size: 18px; font-weight: 700; color: #374151; display: flex; align-items: center; gap: 8px;">
                    <i data-lucide="layout-grid" style="width: 20px; height: 20px; color: #8b5cf6;"></i>
                    Vista General Académica
                </h2>
            </div>
        <?php endif; ?>

        <!-- Calendario de Asignaciones -->
        <?php include __DIR__ . '/calendar.php'; ?>
    <?php endif; ?>

    <!-- Tabla de Últimas Asignaciones -->
    <div style="padding: 0 32px 12px; margin-top: 32px;">
        <h2 style="font-size: 18px; font-weight: 700; color: #374151; display: flex; align-items: center; gap: 8px;">
            <i data-lucide="list-checks" style="width: 20px; height: 20px; color: <?php echo $rol === 'Instructor' ? '#39A900' : '#3b82f6'; ?>;"></i>
            <?php echo $rol === 'Instructor' ? 'Mis Clases Recientes' : 'Seguimiento de Asignaciones'; ?>
        </h2>
    </div>
    <?php include __DIR__ . '/recent_assignments.php'; ?>
</div>

<!-- Scripts del Dashboard -->
<?php include __DIR__ . '/scripts.php'; ?>
