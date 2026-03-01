<div class="main-content">
    <!-- Header del Dashboard -->
    <div style="padding: 24px 32px;">
        <?php if ($rol === 'Instructor'): ?>
            <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                <div>
                    <h1 style="font-size: 32px; font-weight: 800; color: #1f2937; margin: 0 0 8px; letter-spacing: -1px;">
                        Bienvenido, <?php echo $_SESSION['usuario_nombre'] ?? 'Usuario'; ?>
                    </h1>
                    <p style="font-size: 16px; color: #667085; font-weight: 500; margin: 0;">
                        Este es tu resumen personal de labores académicas
                    </p>
                </div>
                <div style="display: flex; align-items: center; gap: 16px;">
                    <div style="width: 40px; height: 40px; background: #f3f4f6; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; border: 1px solid #e5e7eb;">
                        <i data-lucide="bell" style="width: 20px; height: 20px; color: #374151;"></i>
                    </div>
                    <div style="width: 40px; height: 40px; background: #39A900; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 14px; border: 2px solid white; box-shadow: 0 0 0 1px #e5e7eb;">
                        <?php 
                            $nombres = explode(' ', $_SESSION['usuario_nombre'] ?? 'U');
                            echo strtoupper(substr($nombres[0], 0, 1) . (isset($nombres[1]) ? substr($nombres[1], 0, 1) : ''));
                        ?>
                    </div>
                </div>
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
