<div class="main-content">
    <!-- Header del Dashboard -->
    <div style="padding: 32px 32px 24px; border-bottom: 1px solid #e5e7eb;">
        <h1 style="font-size: 32px; font-weight: 700; color: #1f2937; margin: 0 0 4px;">Bienvenido al Sistema SENA</h1>
        <p style="font-size: 14px; color: #6b7280; margin: 0;">Resumen general de la gestión académica</p>
    </div>

    <!-- Tarjetas de Estadísticas -->
    <?php include __DIR__ . '/stats_cards.php'; ?>

    <!-- Calendario de Asignaciones -->
    <?php include __DIR__ . '/calendar.php'; ?>

    <!-- Tabla de Últimas Asignaciones -->
    <?php include __DIR__ . '/recent_assignments.php'; ?>
</div>

<!-- Scripts del Dashboard -->
<?php include __DIR__ . '/scripts.php'; ?>
