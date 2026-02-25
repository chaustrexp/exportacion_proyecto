<?php
/**
 * Vista de Login
 */
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SENA - Inicio de Sesión</title>
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        :root {
            --sena-green: #39A900;
            --sena-blue: #00324D;
            --sena-light-gray: #f8fafc;
            --text-main: #1e293b;
            --text-muted: #64748b;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Public Sans', sans-serif;
            background: var(--sena-light-gray);
            min-height: 100vh;
            display: flex;
        }

        .split-layout {
            display: flex;
            width: 100%;
            height: 100vh;
        }

        /* Left side: Login Form */
        .login-side {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px;
            background: white;
            z-index: 2;
        }

        .login-card {
            width: 100%;
            max-width: 400px;
        }

        .logo-container {
            text-align: center;
            margin-bottom: 32px;
        }

        .logo-container img {
            width: 80px;
            height: auto;
            margin-bottom: 20px;
        }

        .logo-container h1 {
            color: var(--sena-blue);
            font-size: 28px;
            font-weight: 800;
            letter-spacing: -0.5px;
            margin-bottom: 8px;
        }

        .logo-container h1 span {
            color: var(--sena-green);
        }

        /* Right side: Image Panel */
        .image-side {
            flex: 1.2;
            position: relative;
            background-image: url('<?php echo BASE_PATH; ?>assets/images/ImagenFachada111124SENA.jpg');
            background-size: cover;
            background-position: center;
            display: none; /* Hidden on mobile */
        }

        @media (min-width: 1024px) {
            .image-side {
                display: block;
            }
        }

        .image-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(0, 50, 77, 0.8) 0%, rgba(57, 169, 0, 0.4) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 60px;
            color: white;
        }

        .overlay-content {
            max-width: 500px;
        }

        .overlay-content h2 {
            font-size: 42px;
            font-weight: 800;
            line-height: 1.1;
            margin-bottom: 24px;
        }

        .overlay-content p {
            font-size: 18px;
            opacity: 0.9;
            line-height: 1.6;
        }

        .error-alert {
            background: #fff1f2;
            border-left: 4px solid #ef4444;
            color: #991b1b;
            padding: 16px;
            border-radius: 12px;
            margin-bottom: 24px;
            font-size: 14px;
            display: flex;
            gap: 12px;
            align-items: center;
        }

        .form-group { margin-bottom: 24px; }

        .form-group label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: var(--text-main);
            margin-bottom: 8px;
        }

        .form-control {
            width: 100%;
            padding: 14px;
            border: 1.5px solid #e2e8f0;
            border-radius: 12px;
            font-size: 15px;
            transition: all 0.2s;
            background: #fdfdfd;
        }

        .form-control:focus {
            border-color: var(--sena-green);
            outline: none;
            box-shadow: 0 0 0 4px rgba(57, 169, 0, 0.1);
            background: white;
        }

        .btn-login {
            width: 100%;
            background: var(--sena-green);
            color: white;
            padding: 14px;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 4px 12px rgba(57, 169, 0, 0.2);
        }

        .btn-login:hover {
            background: #2d8500;
            transform: translateY(-1px);
            box-shadow: 0 6px 15px rgba(57, 169, 0, 0.3);
        }

        .footer-text {
            text-align: center;
            margin-top: 32px;
            font-size: 13px;
            color: var(--text-muted);
        }
    </style>
</head>
<body>
    <div class="split-layout">
        <!-- Left Side -->
        <div class="login-side">
            <div class="login-card">
                <div class="logo-container">
                    <img src="<?php echo BASE_PATH; ?>assets/images/sena-logo.png" alt="SENA Logo">
                    <h1>Prog<span>SENA</span></h1>
                    <p style="font-size: 15px; color: var(--text-muted);">Gestión Académica de Exportación</p>
                </div>

                <?php if (isset($error) && !empty($error)): ?>
                    <div class="error-alert">
                        <i data-lucide="alert-circle" style="width: 20px; height: 20px;"></i>
                        <span><?php echo htmlspecialchars($error); ?></span>
                    </div>
                <?php endif; ?>

                <form action="<?php echo BASE_PATH; ?>auth/login" method="POST">
                    <div class="form-group">
                        <label for="rol">Perfil de Acceso</label>
                        <select id="rol" name="rol" class="form-control" required>
                            <option value="" disabled selected>Seleccione su rol...</option>
                            <option value="Instructor">Instructor</option>
                            <option value="Coordinador">Coordinador</option>
                            <option value="Administrador">Administrador</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="email">Correo Institucional</label>
                        <input type="email" id="email" name="email" class="form-control" placeholder="usuario@sena.edu.co" required autofocus>
                    </div>
                    <div class="form-group">
                        <label for="password">Contraseña</label>
                        <input type="password" id="password" name="password" class="form-control" placeholder="••••••••" required>
                    </div>
                    <button type="submit" class="btn-login">Entrar al Sistema</button>
                </form>

                <div class="footer-text">
                    © <?php echo date('Y'); ?> Servicio Nacional de Aprendizaje SENA<br>
                    Todos los derechos reservados.
                </div>
            </div>
        </div>

        <!-- Right Side -->
        <div class="image-side">
            <div class="image-overlay">
                <div class="overlay-content">
                    <h2>Bienvenido a la<br>Excelencia Académica</h2>
                    <p>Optimice la gestión de sus procesos educativos con nuestra plataforma integral diseñada para la comunidad SENA.</p>
                </div>
            </div>
        </div>
    </div>
    <script>lucide.createIcons();</script>
</body>
</html>
