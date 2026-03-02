<?php
// Vista de perfil de usuario
// Los datos vienen del controlador o se cargan aquí si no hay controlador (legacy)
$pageTitle = "Mi Perfil";
?>

<div class="main-content">
    <div class="dashboard-header">
        <h1 class="dashboard-title">Mi Perfil</h1>
        <p class="dashboard-subtitle">Administra tu información personal y contraseña</p>
    </div>

    <?php if (isset($mensaje) && $mensaje): ?>
        <div class="alert alert-success"><?php echo $mensaje; ?></div>
    <?php endif; ?>
    
    <?php if (isset($error) && $error): ?>
        <div class="alert alert-error"><?php echo $error; ?></div>
    <?php endif; ?>

    <div class="profile-container">
        <div class="profile-card">
            <div class="profile-header">
                <div class="profile-avatar">
                    <img src="<?php echo BASE_PATH; ?>assets/images/foto-perfil.jpg" alt="Foto de perfil" class="avatar-lg">
                </div>
                <div class="profile-info">
                    <h2><?php echo htmlspecialchars($usuario['nombre'] ?? ''); ?></h2>
                    <p><?php echo htmlspecialchars($usuario['rol'] ?? ''); ?></p>
                    <span class="profile-badge <?php echo ($usuario['estado'] ?? '') === 'Activo' ? 'badge-success' : 'badge-danger'; ?>">
                        <?php echo $usuario['estado'] ?? ''; ?>
                    </span>
                </div>
            </div>

            <form method="POST" class="profile-form">
                <h3>Información Personal</h3>
                
                <div class="form-group">
                    <label for="nombre">Nombre Completo</label>
                    <input type="text" id="nombre" name="nombre" class="form-control" 
                           value="<?php echo htmlspecialchars($usuario['nombre'] ?? ''); ?>" required>
                </div>

                <div class="form-group">
                    <label for="email">Correo Electrónico</label>
                    <input type="email" id="email" name="email" class="form-control" 
                           value="<?php echo htmlspecialchars($usuario['email'] ?? ''); ?>" required>
                </div>

                <div class="form-group">
                    <label>Rol</label>
                    <input type="text" class="form-control" value="<?php echo htmlspecialchars($usuario['rol'] ?? ''); ?>" disabled>
                </div>

                <div class="form-divider"></div>

                <h3>Cambiar Contraseña</h3>
                <p class="form-hint">Deja estos campos vacíos si no deseas cambiar tu contraseña</p>

                <div class="form-group">
                    <label for="password_actual">Contraseña Actual</label>
                    <input type="password" id="password_actual" name="password_actual" class="form-control">
                </div>

                <div class="form-group">
                    <label for="password_nueva">Nueva Contraseña</label>
                    <input type="password" id="password_nueva" name="password_nueva" class="form-control">
                </div>

                <div class="form-group">
                    <label for="password_confirmar">Confirmar Nueva Contraseña</label>
                    <input type="password" id="password_confirmar" name="password_confirmar" class="form-control">
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">
                        <i data-lucide="save"></i>
                        Guardar Cambios
                    </button>
                    <a href="<?php echo BASE_PATH; ?>" class="btn btn-secondary">
                        <i data-lucide="x"></i>
                        Cancelar
                    </a>
                </div>
            </form>
        </div>

        <div class="profile-stats">
            <h3>Información de la Cuenta</h3>
            <div class="stat-item">
                <i data-lucide="calendar"></i>
                <div>
                    <span>Fecha de Registro</span>
                    <strong><?php echo isset($usuario['fecha_registro']) ? date('d/m/Y', strtotime($usuario['fecha_registro'])) : 'N/A'; ?></strong>
                </div>
            </div>
            <div class="stat-item">
                <i data-lucide="clock"></i>
                <div>
                    <span>Último Acceso</span>
                    <strong><?php echo (isset($usuario['ultimo_acceso']) && $usuario['ultimo_acceso']) ? date('d/m/Y H:i', strtotime($usuario['ultimo_acceso'])) : 'Nunca'; ?></strong>
                </div>
            </div>
            <div class="stat-item">
                <i data-lucide="shield"></i>
                <div>
                    <span>Estado</span>
                    <strong><?php echo $usuario['estado'] ?? 'N/A'; ?></strong>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
</script>
