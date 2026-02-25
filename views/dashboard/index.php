<div class="main-content">
    <!-- Header del Dashboard -->
    <div style="padding: 32px 32px 24px; border-bottom: 1px solid #e5e7eb;">
        <?php $esInstructor = (($_SESSION['usuario_rol'] ?? $_SESSION['rol'] ?? '') === 'Instructor'); ?>
        <h1 style="font-size: 32px; font-weight: 700; color: #1f2937; margin: 0 0 4px;">
            <?php 
                $nombre = $_SESSION['usuario_nombre'] ?? 'Usuario';
                if ($rol === 'Instructor') echo 'Bienvenido, ' . $nombre;
                elseif ($rol === 'Coordinador') echo 'Bienvenido Coordinador, ' . $nombre;
                else echo 'Bienvenido Administrador'; 
            ?>
        </h1>
        <p style="font-size: 14px; color: #6b7280; margin: 0;">
            <?php 
                if ($rol === 'Instructor') echo 'Este es tu resumen personal de labores académicas';
                elseif ($rol === 'Coordinador') echo 'Gestión y seguimiento de la coordinación académica';
                else echo 'Resumen general de la gestión académica'; 
            ?>
        </p>
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
