<?php
/**
 * Layout Sidebar - Rediseño Light Premium
 * Barra de navegación lateral con tema claro, bordes redondeados y efectos modernos.
 */

// Helper para detectar página activa
$current_page = $_SERVER['REQUEST_URI'];
function isActive($path) {
    global $current_page;
    // Manejo especial para dashboard index
    if ($path === 'dashboard/index' && (strpos($current_page, 'dashboard/index') !== false || $current_page === BASE_PATH)) {
        return 'active';
    }
    return (strpos($current_page, $path) !== false) ? 'active' : '';
}
?>

<style>
    :root {
        --sidebar-bg: #ffffff;
        --sidebar-hover: #f1f5f9;
        --sidebar-active: #39A900;
        --sidebar-active-bg: rgba(57, 169, 0, 0.1);
        --sidebar-text: #64748b;
        --sidebar-text-bright: #1e293b;
        --sidebar-width: 260px;
        --transition-speed: 0.3s;
        --sidebar-border: #e2e8f0;
    }

    .sidebar {
        position: fixed;
        left: 0;
        top: 0;
        width: var(--sidebar-width);
        height: 100vh;
        background: var(--sidebar-bg);
        color: var(--sidebar-text);
        z-index: 1000;
        display: flex;
        flex-direction: column;
        transition: all var(--transition-speed);
        box-shadow: 4px 0 10px rgba(0, 0, 0, 0.02);
        border-right: 1px solid var(--sidebar-border);
    }

    /* Header del Sidebar */
    .sidebar-header {
        padding: 32px 24px;
        border-bottom: 1px solid var(--sidebar-border);
    }

    .logo-wrapper {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .logo-icon {
        width: 40px;
        height: 40px;
        background: var(--sidebar-active);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        box-shadow: 0 4px 12px rgba(57, 169, 0, 0.2);
    }

    .logo-text h2 {
        font-size: 18px;
        font-weight: 800;
        color: var(--sidebar-text-bright);
        margin: 0;
        letter-spacing: 0.5px;
    }

    .logo-text span {
        font-size: 10px;
        color: var(--sidebar-text);
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    /* Navegación */
    .sidebar-nav {
        flex: 1;
        padding: 20px 12px;
        overflow-y: auto;
    }

    .sidebar-nav::-webkit-scrollbar {
        width: 4px;
    }

    .sidebar-nav::-webkit-scrollbar-thumb {
        background: #e2e8f0;
        border-radius: 4px;
    }

    .nav-list {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .nav-section {
        padding: 20px 12px 10px;
    }

    .section-title {
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        color: #94a3b8;
    }

    .nav-link {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 16px;
        color: var(--sidebar-text);
        text-decoration: none;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 500;
        transition: all var(--transition-speed) ease;
    }

    .nav-link i {
        width: 18px;
        height: 18px;
        transition: transform var(--transition-speed);
        color: #94a3b8;
    }

    .nav-link:hover {
        background: var(--sidebar-hover);
        color: var(--sidebar-text-bright);
    }

    .nav-link:hover i {
        color: var(--sidebar-active);
        transform: translateX(2px);
    }

    .nav-link.active {
        background: var(--sidebar-active-bg);
        color: var(--sidebar-active);
        font-weight: 700;
    }

    .nav-link.active i {
        color: var(--sidebar-active);
    }

    /* Footer / Perfil Usuario */
    .sidebar-footer {
        padding: 20px 16px;
        border-top: 1px solid var(--sidebar-border);
    }

    .user-profile-sidebar {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 12px;
        background: #f8fafc;
        border-radius: 16px;
        border: 1px solid #f1f5f9;
        transition: all 0.2s ease;
    }

    .user-profile-sidebar:hover {
        border-color: var(--sidebar-border);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
    }

    .user-avatar-sidebar {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        overflow: hidden;
        border: 2px solid #ffffff;
        flex-shrink: 0;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }

    .user-avatar-sidebar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .user-info-sidebar {
        flex: 1;
        min-width: 0;
    }

    .user-name-sidebar {
        display: block;
        font-size: 13px;
        font-weight: 700;
        color: var(--sidebar-text-bright);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .user-role-sidebar {
        display: block;
        font-size: 10px;
        color: var(--sidebar-text);
        font-weight: 600;
    }

    .logout-btn-sidebar {
        color: #94a3b8;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 28px;
        height: 28px;
        border-radius: 8px;
    }

    .logout-btn-sidebar:hover {
        color: #ef4444;
        background: #fef2f2;
        transform: scale(1.1);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .sidebar {
            transform: translateX(-100%);
        }
        .sidebar.open {
            transform: translateX(0);
        }
    }
</style>

<aside class="sidebar">
    <!-- Header del Sidebar -->
    <div class="sidebar-header">
        <div class="logo-wrapper">
            <div class="logo-icon">
                <svg width="24" height="24" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="24" cy="24" r="24" fill="transparent"/>
                    <text x="24" y="34" font-family="Arial, sans-serif" font-size="28" font-weight="bold" fill="white" text-anchor="middle">S</text>
                </svg>
            </div>
            <div class="logo-text">
                <h2>SENA</h2>
                <span>Sistema de Gestión</span>
            </div>
        </div>
    </div>

    <!-- Navegación Principal -->
    <nav class="sidebar-nav">
        <ul class="nav-list">
            <?php 
            $rol = $_SESSION['usuario_rol'] ?? '';
            
            if ($rol === 'Administrador'): ?>
                <!-- Menú para Administrador -->
                <li class="nav-item">
                    <a href="<?php echo BASE_PATH; ?>dashboard/index" class="nav-link <?php echo isActive('dashboard/index'); ?>">
                        <i data-lucide="layout-dashboard"></i>
                        <span class="nav-text">Dashboard</span>
                    </a>
                </li>

                <li class="nav-section">
                    <span class="section-title">Centro de Formación</span>
                </li>

                <li class="nav-item">
                    <a href="<?php echo BASE_PATH; ?>centro_formacion/index" class="nav-link <?php echo isActive('centro_formacion/'); ?>">
                        <i data-lucide="building-2"></i>
                        <span class="nav-text">Centro Formación</span>
                    </a>
                </li>
                
                <li class="nav-item">
                    <a href="<?php echo BASE_PATH; ?>sede/index" class="nav-link <?php echo isActive('sede/'); ?>">
                        <i data-lucide="map-pin"></i>
                        <span class="nav-text">Sedes</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?php echo BASE_PATH; ?>ambiente/index" class="nav-link <?php echo isActive('ambiente/'); ?>">
                        <i data-lucide="home"></i>
                        <span class="nav-text">Ambientes</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?php echo BASE_PATH; ?>programa/index" class="nav-link <?php echo isActive('programa/'); ?>">
                        <i data-lucide="book-open"></i>
                        <span class="nav-text">Programas</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?php echo BASE_PATH; ?>instructor/index" class="nav-link <?php echo isActive('instructor/'); ?>">
                        <i data-lucide="user"></i>
                        <span class="nav-text">Instructores</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?php echo BASE_PATH; ?>competencia/index" class="nav-link <?php echo isActive('competencia/'); ?>">
                        <i data-lucide="target"></i>
                        <span class="nav-text">Competencias</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?php echo BASE_PATH; ?>coordinacion/index" class="nav-link <?php echo isActive('coordinacion/'); ?>">
                        <i data-lucide="users"></i>
                        <span class="nav-text">Coordinación</span>
                    </a>
                </li>

            <?php elseif ($rol === 'Coordinador'): ?>
                <!-- Menú para Coordinador -->
                <li class="nav-item">
                    <a href="<?php echo BASE_PATH; ?>dashboard/index" class="nav-link <?php echo isActive('dashboard/index'); ?>">
                        <i data-lucide="layout-dashboard"></i>
                        <span class="nav-text">Dashboard</span>
                    </a>
                </li>

                <li class="nav-section">
                    <span class="section-title">Gestión Académica</span>
                </li>

                <li class="nav-item">
                    <a href="<?php echo BASE_PATH; ?>competencia_programa/index" class="nav-link <?php echo isActive('competencia_programa/'); ?>">
                        <i data-lucide="link"></i>
                        <span class="nav-text">Competencia-Prog</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?php echo BASE_PATH; ?>ficha/index" class="nav-link <?php echo isActive('ficha/'); ?>">
                        <i data-lucide="file-text"></i>
                        <span class="nav-text">Fichas</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?php echo BASE_PATH; ?>instru_competencia/index" class="nav-link <?php echo isActive('instru_competencia/'); ?>">
                        <i data-lucide="award"></i>
                        <span class="nav-text">Instru-Competencia</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?php echo BASE_PATH; ?>asignacion/index" class="nav-link <?php echo isActive('asignacion/'); ?>">
                        <i data-lucide="calendar"></i>
                        <span class="nav-text">Asignaciones</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?php echo BASE_PATH; ?>detalle_asignacion/index" class="nav-link <?php echo isActive('detalle_asignacion/'); ?>">
                        <i data-lucide="clipboard-list"></i>
                        <span class="nav-text">Detalles de Asignación</span>
                    </a>
                </li>

            <?php elseif ($rol === 'Instructor'): ?>
                <!-- Menú para Instructor -->
                <li class="nav-item">
                    <a href="<?php echo BASE_PATH; ?>dashboard/index" class="nav-link <?php echo isActive('dashboard/index'); ?>">
                        <i data-lucide="layout-dashboard"></i>
                        <span class="nav-text">Inicio</span>
                    </a>
                </li>
                
                <li class="nav-item">
                    <a href="<?php echo BASE_PATH; ?>instructor_dashboard/misFichas" class="nav-link <?php echo isActive('misFichas'); ?>">
                        <i data-lucide="file-text"></i>
                        <span class="nav-text">Mis Fichas</span>
                    </a>
                </li>
                
                <li class="nav-item">
                    <a href="<?php echo BASE_PATH; ?>instructor_dashboard/misAsignaciones" class="nav-link <?php echo isActive('misAsignaciones'); ?>">
                        <i data-lucide="calendar"></i>
                        <span class="nav-text">Visualizar Asignación</span>
                    </a>
                </li>
            <?php endif; ?>
</aside>

<!-- Lucide Icons -->
<script src="https://unpkg.com/lucide@latest"></script>
<script>
    lucide.createIcons();
</script>
