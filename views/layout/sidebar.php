<?php
/**
 * Layout Sidebar
 * Barra de navegación lateral persistente. Gestiona el enrutamiento dinámico
 * y el control de visibilidad de módulos basado en el rol del usuario (RBAC).
 * Incluye lógica para marcar el enlace activo basado en la URL actual.
 */
?>
<aside class="sidebar">
    <!-- Header del Sidebar -->
    <div class="sidebar-header">
        <div class="logo-wrapper">
            <div class="logo-icon">
                <svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="24" cy="24" r="24" fill="#39A900"/>
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
                <!-- Menú para Administrador (Centro de Formación) -->
                <li class="nav-item">
                    <a href="<?php echo BASE_PATH; ?>dashboard/index" class="nav-link">
                        <i class="nav-icon" data-lucide="layout-dashboard"></i>
                        <span class="nav-text">Dashboard</span>
                    </a>
                </li>

                <li class="nav-section">
                    <span class="section-title">Centro de Formación</span>
                </li>

                <li class="nav-item">
                    <a href="<?php echo BASE_PATH; ?>centro_formacion/index" class="nav-link">
                        <i class="nav-icon" data-lucide="building-2"></i>
                        <span class="nav-text">Centro Formación</span>
                    </a>
                </li>
                
                <li class="nav-item">
                    <a href="<?php echo BASE_PATH; ?>sede/index" class="nav-link">
                        <i class="nav-icon" data-lucide="map-pin"></i>
                        <span class="nav-text">Sedes</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?php echo BASE_PATH; ?>ambiente/index" class="nav-link">
                        <i class="nav-icon" data-lucide="home"></i>
                        <span class="nav-text">Ambientes</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?php echo BASE_PATH; ?>programa/index" class="nav-link">
                        <i class="nav-icon" data-lucide="book-open"></i>
                        <span class="nav-text">Programas</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?php echo BASE_PATH; ?>instructor/index" class="nav-link">
                        <i class="nav-icon" data-lucide="user"></i>
                        <span class="nav-text">Instructores</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?php echo BASE_PATH; ?>competencia/index" class="nav-link">
                        <i class="nav-icon" data-lucide="target"></i>
                        <span class="nav-text">Competencias</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?php echo BASE_PATH; ?>coordinacion/index" class="nav-link">
                        <i class="nav-icon" data-lucide="users"></i>
                        <span class="nav-text">Coordinación</span>
                    </a>
                </li>

            <?php elseif ($rol === 'Coordinador'): ?>
                <!-- Menú para Coordinador -->
                <li class="nav-item">
                    <a href="<?php echo BASE_PATH; ?>dashboard/index" class="nav-link">
                        <i class="nav-icon" data-lucide="layout-dashboard"></i>
                        <span class="nav-text">Dashboard</span>
                    </a>
                </li>

                <li class="nav-section">
                    <span class="section-title">Gestión Académica</span>
                </li>

                <li class="nav-item">
                    <a href="<?php echo BASE_PATH; ?>competencia_programa/index" class="nav-link">
                        <i class="nav-icon" data-lucide="link"></i>
                        <span class="nav-text">Competencia-Prog</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?php echo BASE_PATH; ?>ficha/index" class="nav-link">
                        <i class="nav-icon" data-lucide="file-text"></i>
                        <span class="nav-text">Fichas</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?php echo BASE_PATH; ?>instru_competencia/index" class="nav-link">
                        <i class="nav-icon" data-lucide="award"></i>
                        <span class="nav-text">Instru-Competencia</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?php echo BASE_PATH; ?>asignacion/index" class="nav-link">
                        <i class="nav-icon" data-lucide="calendar"></i>
                        <span class="nav-text">Asignaciones</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?php echo BASE_PATH; ?>detalle_asignacion/index" class="nav-link">
                        <i class="nav-icon" data-lucide="clipboard-list"></i>
                        <span class="nav-text">Detalles de Asignación</span>
                    </a>
                </li>

            <?php elseif ($rol === 'Instructor'): ?>
                <!-- Menú para Instructor -->
                <li class="nav-item">
                    <a href="<?php echo BASE_PATH; ?>dashboard/index" class="nav-link">
                        <i class="nav-icon" data-lucide="layout-dashboard"></i>
                        <span class="nav-text">Inicio</span>
                    </a>
                </li>
                
                <li class="nav-item">
                    <a href="<?php echo BASE_PATH; ?>instructor_dashboard/misFichas" class="nav-link">
                        <i class="nav-icon" data-lucide="file-text"></i>
                        <span class="nav-text">Mis Fichas</span>
                    </a>
                </li>
                
                <li class="nav-item">
                    <a href="<?php echo BASE_PATH; ?>instructor_dashboard/misAsignaciones" class="nav-link">
                        <i class="nav-icon" data-lucide="calendar"></i>
                        <span class="nav-text">Visualizar Asignación</span>
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </nav>

    <div class="sidebar-footer">
        <div class="user-profile-sidebar">
            <div class="user-avatar-sidebar">
                <img src="<?php echo BASE_PATH; ?>assets/images/foto-perfil.jpg" alt="Foto de perfil">
            </div>
            <div class="user-info-sidebar">
                <span class="user-name-sidebar"><?php echo $_SESSION['usuario_nombre']; ?></span>
                <span class="user-role-sidebar"><?php echo $_SESSION['usuario_rol']; ?></span>
            </div>
            <a href="<?php echo BASE_PATH; ?>auth/logout" class="logout-btn-sidebar" title="Cerrar Sesión">
                <i data-lucide="log-out"></i>
            </a>
        </div>
    </div>
</aside>

<!-- Script para Lucide Icons -->
<script src="https://unpkg.com/lucide@latest"></script>
<script>
    lucide.createIcons();
</script>

