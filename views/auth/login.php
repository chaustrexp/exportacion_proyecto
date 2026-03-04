<?php
/**
 * Vista de Login - Rediseño Premium v2
 * Se mantiene toda la lógica funcional de PHP y los atributos del formulario.
 */
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SENA - Inicio de Sesión</title>
    <!-- Fuentes Modernas -->
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Iconos Lucide -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        :root {
            --sena-green: #39A900;
            --sena-green-dark: #2d8500;
            --sena-blue: #00324D;
            --text-main: #1f2937;
            --text-muted: #6b7280;
            --bg-light: #F3F4F6;
            --bg-input: #f8fafc;
            --border-color: #E5E7EB;
            --shadow-soft: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.05);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Public Sans', 'Inter', sans-serif;
            background-color: #ffffff;
            color: var(--text-main);
            min-height: 100vh;
            overflow-x: hidden;
        }

        .login-wrapper {
            display: flex;
            width: 100%;
            height: 100vh;
        }

        /* --- Lado del Formulario --- */
        .form-side {
            flex: 0 0 45%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 60px;
            background: #ffffff;
            position: relative;
        }

        .form-container {
            width: 100%;
            max-width: 380px;
            animation: fadeIn 0.8s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(15px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Contenedor del Logo Estilo Mockup */
        .logo-box {
            width: 90px;
            height: 90px;
            background-color: #94a881; /* Color verde oliva del mockup */
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 24px;
            border-radius: 4px;
            padding: 12px;
        }

        .logo-box img {
            width: 100%;
            height: auto;
            filter: brightness(0) invert(1);
        }

        .brand-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .brand-header h1 {
            font-size: 32px;
            font-weight: 800;
            color: #111827;
            letter-spacing: -0.5px;
            margin-bottom: 4px;
        }

        .brand-header span {
            font-size: 11px;
            font-weight: 700;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 1.2px;
        }

        .login-intro {
            text-align: center;
            margin-bottom: 32px;
        }

        .login-intro h2 {
            font-size: 22px;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 12px;
        }

        .login-intro p {
            font-size: 14px;
            color: #64748b;
            line-height: 1.5;
        }

        /* --- Estilos de Inputs --- */
        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 11px;
            font-weight: 700;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
        }

        .form-group label i {
            width: 14px;
            height: 14px;
        }

        .input-wrapper {
            position: relative;
        }

        .form-control {
            width: 100%;
            padding: 14px 16px;
            background: var(--bg-input);
            border: 1px solid #f1f5f9;
            border-radius: 8px;
            font-size: 14px;
            font-family: inherit;
            color: #1e293b;
            transition: all 0.2s ease;
        }

        .form-control:focus {
            outline: none;
            border-color: #cbd5e1;
            background: #ffffff;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }

        .form-control::placeholder {
            color: #94a3b8;
        }

        select.form-control {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%2394a3b8' stroke-width='2.5'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M19 9l-7 7-7-7'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 16px center;
            background-size: 14px;
        }

        .forgot-password {
            display: block;
            text-align: right;
            font-size: 12px;
            font-weight: 600;
            color: var(--sena-green);
            text-decoration: none;
            margin-bottom: 24px;
            transition: color 0.2s;
        }

        .forgot-password:hover {
            color: var(--sena-green-dark);
        }

        .submit-btn {
            width: 100%;
            padding: 14px;
            background: #39A900;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            box-shadow: 0 4px 14px rgba(57, 169, 0, 0.4);
        }

        .submit-btn:hover {
            background: #2d8500;
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(57, 169, 0, 0.5);
        }

        .submit-btn i {
            width: 18px;
            height: 18px;
        }

        /* --- Alertas --- */
        .alert {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 14px;
            border-radius: 8px;
            margin-bottom: 24px;
            font-size: 13.5px;
            background-color: #fff1f2;
            border: 1px solid #ffe4e6;
            color: #e11d48;
        }

        /* --- Lado de la Imagen --- */
        .image-side {
            flex: 1;
            position: relative;
            background-image: url('<?php echo BASE_PATH; ?>assets/images/ImagenFachada111124SENA.jpg');
            background-size: cover;
            background-position: center;
        }

        .image-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(2, 44, 34, 0.9) 0%, rgba(34, 133, 49, 0.8) 100%);
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 80px;
        }

        .overlay-content {
            max-width: 580px;
            color: white;
        }

        .overlay-badge {
            display: inline-block;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            padding: 6px 16px;
            margin-bottom: 32px;
        }

        .overlay-content h2 {
            font-size: 58px;
            font-weight: 800;
            line-height: 1.05;
            margin-bottom: 24px;
            letter-spacing: -1.5px;
        }

        .overlay-divider {
            width: 80px;
            height: 4px;
            background: #ffffff;
            margin-bottom: 32px;
        }

        .overlay-content p {
            font-size: 18px;
            line-height: 1.6;
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 48px;
        }

        /* Estadísticas Inferiores */
        .overlay-footer {
            margin-top: auto;
            display: flex;
            gap: 60px;
            padding-top: 40px;
            border-top: 1px solid rgba(255, 255, 255, 0.15);
        }

        .stat-item {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .stat-header {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 28px;
            font-weight: 800;
            color: #ffffff;
        }

        .stat-header i {
            width: 20px;
            height: 20px;
            color: #4ade80;
        }

        .stat-label {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: rgba(255, 255, 255, 0.7);
        }

        /* --- Footer --- */
        .login-footer {
            margin-top: 48px;
            text-align: center;
            font-size: 11px;
            color: #94a3b8;
            line-height: 1.6;
        }

        /* --- Responsive --- */
        @media (max-width: 1100px) {
            .form-side { flex: 0 0 50%; padding: 40px; }
            .overlay-content h2 { font-size: 42px; }
        }

        @media (max-width: 900px) {
            .image-side { display: none; }
            .form-side { flex: 1; height: 100vh; }
        }
    </style>
</head>
<body>
    <div class="login-wrapper">
        <!-- Lado del Formulario -->
        <main class="form-side">
            <div class="form-container">
                <!-- Logo Estilo Mockup -->
                <div class="logo-box">
                    <img src="<?php echo BASE_PATH; ?>assets/images/sena-logo.png" alt="SENA Logo">
                </div>

                <!-- Marca -->
                <div class="brand-header">
                    <h1>ProgSENA</h1>
                    <span>Gestión Académica de Exportación</span>
                </div>

                <!-- Bienvenida -->
                <div class="login-intro">
                    <h2>¡Bienvenido de nuevo!</h2>
                    <p>Ingresa tus credenciales institucionales para continuar.</p>
                </div>

                <!-- Alertas -->
                <?php if (isset($error) && !empty($error)): ?>
                    <div class="alert">
                        <i data-lucide="alert-circle"></i>
                        <span><?php echo htmlspecialchars($error); ?></span>
                    </div>
                <?php endif; ?>

                <!-- Formulario -->
                <form action="<?php echo BASE_PATH; ?>auth/login" method="POST">
                    <div class="form-group">
                        <label for="rol">
                            <i data-lucide="user-check"></i>
                            Perfil de Acceso
                        </label>
                        <select id="rol" name="rol" class="form-control" required>
                            <option value="" disabled selected>Seleccione su rol...</option>
                            <option value="Instructor">Instructor</option>
                            <option value="Coordinador">Coordinador</option>
                            <option value="Administrador">Administrador</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="email">
                            <i data-lucide="mail"></i>
                            Correo Institucional
                        </label>
                        <input type="email" id="email" name="email" class="form-control" 
                               placeholder="usuario@sena.edu.co" required autofocus>
                    </div>

                    <div class="form-group">
                        <label for="password">
                            <i data-lucide="lock"></i>
                            Contraseña
                        </label>
                        <input type="password" id="password" name="password" class="form-control" 
                               placeholder="••••••••" required>
                    </div>

                    <a href="#" class="forgot-password">¿Olvidó su contraseña?</a>

                    <button type="submit" class="submit-btn" id="loginBtn">
                        Entrar al Sistema
                        <i data-lucide="arrow-right"></i>
                    </button>
                </form>

                <footer class="login-footer">
                    <p>© <?php echo date('Y'); ?> SERVICIO NACIONAL DE APRENDIZAJE SENA<br>TODOS LOS DERECHOS RESERVADOS.</p>
                </footer>
            </div>
        </main>

        <!-- Lado de la Imagen -->
        <section class="image-side">
            <div class="image-overlay">
                <div class="overlay-content">
                    <div class="overlay-badge">Ecosistema Digital de Aprendizaje</div>
                    <h2>Bienvenido a la<br>Excelencia Académica</h2>
                    <div class="overlay-divider"></div>
                    <p>Optimice la gestión de sus procesos educativos con nuestra plataforma integral diseñada exclusivamente para la comunidad.</p>
                </div>

                <div class="overlay-footer">
                    <div class="stat-item">
                        <div class="stat-header">100%</div>
                        <div class="stat-label">Digital</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-header">24/7</div>
                        <div class="stat-label">Soporte</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-header">
                            <i data-lucide="shield-check"></i>
                        </div>
                        <div class="stat-label">Seguro y Encriptado</div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script>
        // Inicializar iconos de Lucide
        lucide.createIcons();

        // Feedback al enviar
        document.querySelector('form').addEventListener('submit', function() {
            const btn = document.getElementById('loginBtn');
            btn.innerHTML = 'Verificando... <i data-lucide="loader-2" style="animation: spin 1s linear infinite;"></i>';
            lucide.createIcons();
            btn.style.opacity = '0.8';
            btn.style.pointerEvents = 'none';
        });

        // Definir animación de spin si no existe en CSS
        const style = document.createElement('style');
        style.innerHTML = '@keyframes spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }';
        document.head.appendChild(style);
    </script>
</body>
</html>
