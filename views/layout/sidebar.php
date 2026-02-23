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
            <!-- Dashboard -->
            <li class="nav-item">
                <a href="<?php echo BASE_PATH; ?>dashboard/index" class="nav-link">
                    <i class="nav-icon" data-lucide="layout-dashboard"></i>
                    <span class="nav-text">Dashboard</span>
                </a>
            </li>

            <!-- Sección: Académico -->
            <li class="nav-section">
                <span class="section-title">Académico</span>
            </li>

            <li class="nav-item">
                <a href="<?php echo BASE_PATH; ?>programa/index" class="nav-link">
                    <i class="nav-icon" data-lucide="book-open"></i>
                    <span class="nav-text">Programas</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="<?php echo BASE_PATH; ?>ficha/index" class="nav-link">
                    <i class="nav-icon" data-lucide="file-text"></i>
                    <span class="nav-text">Fichas</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="<?php echo BASE_PATH; ?>competencia/index" class="nav-link">
                    <i class="nav-icon" data-lucide="target"></i>
                    <span class="nav-text">Competencias</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="<?php echo BASE_PATH; ?>competencia_programa/index" class="nav-link">
                    <i class="nav-icon" data-lucide="link"></i>
                    <span class="nav-text">Competencia-Programa</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="<?php echo BASE_PATH; ?>titulo_programa/index" class="nav-link">
                    <i class="nav-icon" data-lucide="graduation-cap"></i>
                    <span class="nav-text">Título Programa</span>
                </a>
            </li>

            <!-- Sección: Recursos -->
            <li class="nav-section">
                <span class="section-title">Recursos</span>
            </li>

            <li class="nav-item">
                <a href="<?php echo BASE_PATH; ?>instructor/index" class="nav-link">
                    <i class="nav-icon" data-lucide="user"></i>
                    <span class="nav-text">Instructores</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="<?php echo BASE_PATH; ?>instru_competencia/index" class="nav-link">
                    <i class="nav-icon" data-lucide="award"></i>
                    <span class="nav-text">Competencias Instructor</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="<?php echo BASE_PATH; ?>ambiente/index" class="nav-link">
                    <i class="nav-icon" data-lucide="home"></i>
                    <span class="nav-text">Ambientes</span>
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
                    <span class="nav-text">Detalle Asignación</span>
                </a>
            </li>

            <!-- Sección: Infraestructura -->
            <li class="nav-section">
                <span class="section-title">Infraestructura</span>
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
                <a href="<?php echo BASE_PATH; ?>coordinacion/index" class="nav-link">
                    <i class="nav-icon" data-lucide="users"></i>
                    <span class="nav-text">Coordinación</span>
                </a>
            </li>
        </ul>
    </nav>

    <!-- Footer del Sidebar con Perfil de Usuario -->
    <div class="sidebar-footer">
        <div class="user-profile-sidebar">
            <div class="user-avatar-sidebar">
                <img src="<?php echo BASE_PATH; ?>assets/images/foto-perfil.jpg" alt="Foto de perfil">
            </div>
            <div class="user-info-sidebar">
                <span class="user-name-sidebar"><?php echo $_SESSION['usuario_nombre']; ?></span>
                <span class="user-role-sidebar"><?php echo $_SESSION['usuario_rol']; ?></span>
            </div>
        </div>
    </div>
</aside>

<!-- Script para Lucide Icons -->
<script src="https://unpkg.com/lucide@latest"></script>
<script>
    lucide.createIcons();
</script>

