<?php
/**
 * Vista de Login Rediseñada
 */
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SENA - Inicio de Sesión</title>
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        :root {
            --sena-green: #39A900;
            --sena-green-dark: #2d8500;
            --sena-blue: #00324D;
            --text-main: #1f2937;
            --text-muted: #6b7280;
            --bg-light: #f9fafb;
            --border-color: #e5e7eb;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Public Sans', -apple-system, sans-serif;
            background: #ffffff;
            min-height: 100vh;
            color: var(--text-main);
            overflow-x: hidden;
        }

        .login-wrapper {
            display: flex;
            width: 100%;
            height: 100vh;
            overflow: hidden;
        }

        /* --- LEFT SIDE: FORM --- */
        .form-side {
            width: 50%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 40px;
            background: #ffffff;
            position: relative;
            z-index: 10;
            height: 100vh;
        }

        .form-content-wrapper {
            width: 100%;
            max-width: 400px;
            display: flex;
            flex-direction: column;
            align-items: center; /* Center form items horizontally */
            text-align: center;
        }

        .header-logo {
            display: flex;
            flex-direction: column; /* Vertical stacked logo like mockup */
            align-items: center;
            gap: 15px;
            margin-bottom: 40px;
        }

        .header-logo img {
            width: 80px; /* Larger logo */
            height: auto;
        }

        .header-logo .brand-text {
            display: flex;
            flex-direction: column;
        }

        .brand-text h2 {
            font-size: 20px;
            font-weight: 800;
            color: var(--sena-blue);
            line-height: 1;
        }

        .brand-text span {
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--text-muted);
            font-weight: 600;
        }

        .overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(0, 50, 77, 0.9) 0%, rgba(57, 169, 0, 0.7) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px;
            color: white;
            text-align: center;
        }

        .overlay-content {
            max-width: 750px;
            width: 100%;
        }

        .overlay h2 {
            font-size: clamp(40px, 6vw, 64px);
            font-weight: 800;
            line-height: 1;
            margin-bottom: 30px;
            letter-spacing: -3px;
        }

        .overlay p {
            font-size: 16px;
            opacity: 0.9;
            line-height: 1.6;
            margin-bottom: 60px;
            max-width: 600px;
            margin-inline: auto;
        }

        .stats-row {
            display: flex;
            justify-content: center;
            gap: 24px;
            flex-wrap: wrap;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.08); 
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            padding: 24px 16px;
            width: 140px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 12px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .glass-card:hover {
            background: rgba(255, 255, 255, 0.15);
            transform: translateY(-8px);
            border-color: rgba(255, 255, 255, 0.4);
        }

        .stat-icon {
            width: 24px;
            height: 24px;
            margin-bottom: 4px;
            color: #39A900;
        }

        .stat-item .val {
            font-size: 24px;
            font-weight: 800;
            display: block;
            line-height: 1;
            margin-bottom: 4px;
        }

        .stat-item .lbl {
            font-size: 8px;
            text-transform: uppercase;
            letter-spacing: 1px;
            opacity: 0.8;
            font-weight: 700;
        }

        .error-alert {
            background: #fff1f2;
            border: 1px solid #fecaca;
            color: #991b1b;
            padding: 14px;
            border-radius: 10px;
            margin-bottom: 24px;
            font-size: 13px;
            display: flex;
            align-items: center;
            gap: 10px;
            animation: shake 0.5s ease;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }

        .welcome-section {
            margin-bottom: 0;
        }

        .welcome-section h1 {
            font-size: 36px;
            font-weight: 800;
            color: #00324D; /* More like mockup blue */
            margin-bottom: 12px;
            letter-spacing: -1.5px;
        }

        .welcome-section p {
            font-size: 14px;
            color: var(--text-muted);
            line-height: 1.5;
        }

        .form-group {
            margin-bottom: 24px;
        }

        .form-group label {
            display: block;
            font-size: 11px;
            font-weight: 800;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 10px;
        }

        .input-container {
            position: relative;
        }

        .input-container i {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            width: 18px;
            height: 18px;
            color: #d1d5db;
            pointer-events: none;
        }

        .form-control {
            width: 100%;
            padding: 14px 16px 14px 48px;
            border: 1px solid #f3f4f6;
            border-radius: 12px;
            font-size: 14px;
            font-family: inherit;
            color: var(--text-main);
            background: #ffffff;
            transition: all 0.2s;
            box-shadow: 0 2px 4px rgba(0,0,0,0.02);
        }

        .form-control:focus {
            outline: none;
            border-color: var(--sena-green);
            background: white;
            box-shadow: 0 0 0 4px rgba(57, 169, 0, 0.08);
        }

        .form-control::placeholder {
            color: #d1d5db;
        }

        .label-with-link {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .forgot-link {
            font-size: 11px;
            color: var(--sena-green);
            text-decoration: none;
            font-weight: 700;
        }

        .forgot-link:hover {
            text-decoration: underline;
        }

        .checkbox-group {
            display: flex;
            align-items: center;
            margin-bottom: 30px;
        }

        .checkbox-wrapper {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .checkbox-wrapper input {
            width: 20px;
            height: 20px;
            accent-color: var(--sena-green);
            cursor: pointer;
            border-radius: 6px;
        }

        .form-content-wrapper {
            margin: auto 0;
            width: 100%;
            max-width: 480px;
            padding: 40px 0;
            display: flex;
            flex-direction: column;
            gap: 40px;
        }

        .btn-login {
            width: 100%;
            background: #39A900;
            color: white;
            padding: 14px;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s;
            margin-top: 10px;
        }

        .btn-login:hover {
            background: #2d8500;
        }

        .footer-text {
            font-size: 10px;
            color: var(--text-muted);
            text-align: center;
            margin-top: 40px;
            width: 100%;
        }

        /* --- RIGHT SIDE: PHOTO & TEXT --- */
        .image-side {
            width: 50%;
            position: relative;
            background-image: url('<?php echo BASE_PATH; ?>assets/images/ImagenFachada111124SENA.jpg');
            background-size: cover;
            background-position: center;
        }

        .overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(rgba(0, 50, 77, 0.7), rgba(57, 169, 0, 0.3)); /* Refined transparent gradient */
            display: flex;
            align-items: center;
            justify-content: flex-start;
            padding: 80px;
            color: white;
            text-align: left;
        }

        .overlay-content {
            max-width: 550px;
        }

        .overlay h2 {
            font-size: 52px;
            font-weight: 800;
            line-height: 1.1;
            margin-bottom: 25px;
            letter-spacing: -2px;
        }

        .overlay p {
            font-size: 16px;
            line-height: 1.6;
            opacity: 0.95;
            font-weight: 500;
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .image-side { display: none; }
            .form-side { width: 100%; height: auto; padding: 60px 20px; }
            .form-content-wrapper { max-width: 380px; }
        }
    </style>
</head>
<body>
    <div class="login-wrapper">
        <!-- Parte Izquierda (Formulario Centrado) -->
        <div class="form-side">
            <div class="form-content-wrapper">
                <!-- Header Logo -->
                <div class="header-logo">
                    <img src="<?php echo BASE_PATH; ?>assets/images/sena-logo.png" alt="SENA Logo">
                    <div class="brand-text">
                        <h2>ProgSENA</h2>
                        <span>Gestión Académica de Exportación</span>
                    </div>
                </div>

                <div class="login-form">
                    <?php if (isset($error) && !empty($error)): ?>
                        <div class="error-alert">
                            <i data-lucide="alert-circle" style="width: 18px; height: 18px;"></i>
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

                        <button type="submit" class="btn-login">
                            Entrar al Sistema
                        </button>
                    </form>
                </div>

                <div class="footer-text">
                    © <?php echo date('Y'); ?> Servicio Nacional de Aprendizaje SENA<br>
                    Todos los derechos reservados.
                </div>
            </div>
        </div>

        <!-- Parte Derecha (Imagen y Texto) -->
        <div class="image-side">
            <div class="overlay">
                <div class="overlay-content">
                    <h2>Bienvenido a la<br>Excelencia Académica</h2>
                    <p>Optimice la gestión de sus procesos educativos con nuestra plataforma integral diseñada para la comunidad SENA.</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Inicializar iconos
        lucide.createIcons();
    </script>
</body>
</html>
