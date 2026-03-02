<?php
/**
 * Vista de Login - Rediseño Premium
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
            --border-color: #E5E7EB;
            --shadow-soft: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.05);
            --shadow-premium: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Public Sans', 'Inter', sans-serif;
            background-color: var(--bg-light);
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow-x: hidden;
        }

        /* --- Estructura Principal --- */
        .login-wrapper {
            display: flex;
            width: 100%;
            height: 100vh;
            background: #fff;
        }

        /* --- Lado del Formulario --- */
        .form-side {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 40px;
            background: #ffffff;
            position: relative;
            z-index: 10;
        }

        .form-container {
            width: 100%;
            max-width: 420px;
            animation: fadeIn 0.8s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .logo-header {
            text-align: center;
            margin-bottom: 48px;
        }

        .logo-header img {
            width: 80px;
            height: auto;
            margin-bottom: 16px;
            filter: drop-shadow(0 4px 6px rgba(0,0,0,0.1));
        }

        .brand-name {
            font-family: 'Public Sans', sans-serif;
        }

        .brand-name h1 {
            font-size: 28px;
            font-weight: 800;
            color: var(--sena-blue);
            letter-spacing: -1px;
            margin-bottom: 4px;
        }

        .brand-name span {
            font-size: 11px;
            font-weight: 600;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 1.5px;
        }

        /* --- Estilos del Formulario --- */
        .login-title {
            margin-bottom: 32px;
            text-align: center;
        }

        .login-title h2 {
            font-size: 24px;
            font-weight: 700;
            color: #111827;
            margin-bottom: 8px;
        }

        .login-title p {
            font-size: 14px;
            color: var(--text-muted);
        }

        .form-group {
            margin-bottom: 24px;
        }

        .form-group label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 8px;
        }

        .input-wrapper {
            position: relative;
            transition: all 0.3s;
        }

        .input-wrapper i {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            width: 18px;
            height: 18px;
            color: #9ca3af;
            transition: color 0.3s;
        }

        .form-control {
            width: 100%;
            padding: 12px 16px 12px 44px;
            background: #fff;
            border: 2px solid #f3f4f6;
            border-radius: 12px;
            font-size: 15px;
            font-family: inherit;
            color: var(--text-main);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .form-control:focus {
            outline: none;
            border-color: var(--sena-green);
            background: #fff;
            box-shadow: 0 0 0 4px rgba(57, 169, 0, 0.1);
        }

        .form-control:focus + i {
            color: var(--sena-green);
        }

        select.form-control {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%239ca3af' stroke-width='2'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M19 9l-7 7-7-7'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 14px center;
            background-size: 16px;
        }

        .submit-btn {
            width: 100%;
            padding: 14px;
            background: var(--sena-green);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 8px;
            box-shadow: 0 4px 12px rgba(57, 169, 0, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .submit-btn:hover {
            background: var(--sena-green-dark);
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(57, 169, 0, 0.3);
        }

        .submit-btn:active {
            transform: translateY(0);
        }

        /* --- Alertas --- */
        .alert {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 16px;
            border-radius: 12px;
            margin-bottom: 24px;
            font-size: 14px;
            line-height: 1.4;
            animation: shake 0.5s cubic-bezier(.36,.07,.19,.97) both;
        }

        .alert-danger {
            background-color: #fef2f2;
            border: 1px solid #fee2e2;
            color: #991b1b;
        }

        @keyframes shake {
            10%, 90% { transform: translate3d(-1px, 0, 0); }
            20%, 80% { transform: translate3d(2px, 0, 0); }
            30%, 50%, 70% { transform: translate3d(-4px, 0, 0); }
            40%, 60% { transform: translate3d(4px, 0, 0); }
        }

        /* --- Lado de la Imagen --- */
        .image-side {
            flex: 1;
            position: relative;
            background-image: url('<?php echo BASE_PATH; ?>assets/images/ImagenFachada111124SENA.jpg');
            background-size: cover;
            background-position: center;
            display: block;
        }

        .image-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(0, 50, 77, 0.85) 0%, rgba(57, 169, 0, 0.6) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 80px;
        }

        .overlay-text {
            max-width: 500px;
            color: white;
        }

        .overlay-text h2 {
            font-size: 48px;
            font-weight: 800;
            line-height: 1.1;
            margin-bottom: 24px;
            letter-spacing: -2px;
        }

        .overlay-text p {
            font-size: 17px;
            line-height: 1.6;
            opacity: 0.9;
            font-weight: 400;
            max-width: 480px;
        }

        /* Badge Superior */
        .overlay-badge {
            display: inline-block;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            background: rgba(255, 255, 255, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.35);
            border-radius: 30px;
            padding: 6px 18px;
            margin-bottom: 28px;
            color: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(4px);
        }

        /* Línea Decorativa */
        .overlay-divider {
            width: 50px;
            height: 3px;
            background: linear-gradient(90deg, #39A900, #6fcf00);
            border-radius: 3px;
            margin: 24px 0;
        }

        /* Estadísticas */
        .overlay-stats {
            display: flex;
            gap: 40px;
            margin-top: 40px;
            padding-top: 32px;
            border-top: 1px solid rgba(255, 255, 255, 0.2);
        }

        .overlay-stat {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .stat-val {
            font-size: 22px;
            font-weight: 800;
            color: white;
            letter-spacing: -0.5px;
        }

        .stat-lbl {
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: rgba(255, 255, 255, 0.65);
        }


        /* --- Footer --- */
        .login-footer {
            margin-top: auto;
            padding-top: 40px;
            text-align: center;
            font-size: 12px;
            color: var(--text-muted);
        }

        /* --- Responsive --- */
        @media (max-width: 1024px) {
            .image-side { display: none; }
            .form-side { padding: 20px; }
            .form-container { max-width: 400px; }
            .overlay-text h2 { font-size: 36px; }
        }

        @media (max-width: 480px) {
            .brand-name h1 { font-size: 24px; }
            .login-title h2 { font-size: 20px; }
            .form-control { padding: 10px 14px 10px 40px; }
        }
    </style>
</head>
<body>
    <div class="login-wrapper">
        <!-- Formulario Seccion -->
        <main class="form-side">
            <div class="form-container">
                <!-- Logo y Brand -->
                <div class="logo-header">
                    <img src="<?php echo BASE_PATH; ?>assets/images/sena-logo.png" alt="SENA Logo">
                    <div class="brand-name">
                        <h1>ProgSENA</h1>
                        <span>Gestión Académica de Exportación</span>
                    </div>
                </div>

                <!-- Formulario de Inicio de Sesión -->
                <div class="login-box">
                    <div class="login-title">
                        <h2>¡Bienvenido de nuevo!</h2>
                        <p>Por favor, ingresa tus credenciales institucional.</p>
                    </div>

                    <!-- Mensajes de Error -->
                    <?php if (isset($error) && !empty($error)): ?>
                        <div class="alert alert-danger" role="alert">
                            <i data-lucide="alert-circle"></i>
                            <span><?php echo htmlspecialchars($error); ?></span>
                        </div>
                    <?php endif; ?>

                    <form action="<?php echo BASE_PATH; ?>auth/login" method="POST">
                        <div class="form-group">
                            <label for="rol">Perfil de Acceso</label>
                            <div class="input-wrapper">
                                <i data-lucide="users"></i>
                                <select id="rol" name="rol" class="form-control" required>
                                    <option value="" disabled selected>Seleccione su rol...</option>
                                    <option value="Instructor">Instructor</option>
                                    <option value="Coordinador">Coordinador</option>
                                    <option value="Administrador">Administrador</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="email">Correo Institucional</label>
                            <div class="input-wrapper">
                                <i data-lucide="mail"></i>
                                <input type="email" id="email" name="email" class="form-control" 
                                       placeholder="usuario@sena.edu.co" required autofocus>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password">Contraseña</label>
                            <div class="input-wrapper">
                                <i data-lucide="lock"></i>
                                <input type="password" id="password" name="password" class="form-control" 
                                       placeholder="••••••••" required>
                            </div>
                        </div>

                        <button type="submit" class="submit-btn" id="loginBtn">
                            <span>Entrar al Sistema</span>
                            <i data-lucide="chevron-right"></i>
                        </button>
                    </form>
                </div>

                <footer class="login-footer">
                    <p>© <?php echo date('Y'); ?> Servicio Nacional de Aprendizaje SENA</p>
                    <p>Todos los derechos reservados.</p>
                </footer>
            </div>
        </main>

        <!-- Imagen y Texto Seccion -->
        <section class="image-side">
            <div class="image-overlay">
                <div class="overlay-text">
                    <!-- Badge -->
                    <div class="overlay-badge">Ecosistema Digital de Aprendizaje</div>

                    <!-- Título Principal -->
                    <h2>Bienvenido a la<br>Excelencia Académica</h2>

                    <!-- Línea Decorativa -->
                    <div class="overlay-divider"></div>

                    <!-- Descripción -->
                    <p>Optimice la gestión de sus procesos educativos con nuestra plataforma integral diseñada exclusivamente para la comunidad.</p>

                    <!-- Estadísticas -->
                    <div class="overlay-stats">
                        <div class="overlay-stat">
                            <span class="stat-val">100%</span>
                            <span class="stat-lbl">Digital</span>
                        </div>
                        <div class="overlay-stat">
                            <span class="stat-val">24/7</span>
                            <span class="stat-lbl">Soporte</span>
                        </div>
                        <div class="overlay-stat">
                            <span class="stat-val">Secure</span>
                            <span class="stat-lbl">Encrypted</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script>
        // Inicializar iconos de Lucide
        lucide.createIcons();

        // Pequeño feedback visual al enviar el formulario
        document.querySelector('form').addEventListener('submit', function() {
            const btn = document.getElementById('loginBtn');
            btn.innerHTML = '<span>Verificando...</span> <i data-lucide="loader-2" class="animate-spin"></i>';
            lucide.createIcons();
            btn.style.opacity = '0.8';
            btn.style.pointerEvents = 'none';
        });
    </script>
</body>
</html>
