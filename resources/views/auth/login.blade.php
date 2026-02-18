<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Acceso - FECOER</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400;1,600&family=Cormorant+Garamond:ital,wght@0,400;0,600;1,400;1,600&family=Montserrat:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --bg-primary: #0f1923;
            --bg-secondary: #1a2a3a;
            --bg-card: rgba(20, 35, 50, 0.85);
            --gold-primary: #c9a84c;
            --gold-light: #e8d48b;
            --gold-dark: #a07c2a;
            --gold-gradient: linear-gradient(135deg, #c9a84c 0%, #e8d48b 40%, #c9a84c 60%, #a07c2a 100%);
            --text-primary: #f0ece2;
            --text-secondary: #8a9bae;
            --text-muted: #5a6a7a;
            --border-color: rgba(201, 168, 76, 0.2);
            --border-focus: rgba(201, 168, 76, 0.5);
            --error-color: #e74c3c;
        }

        body {
            font-family: 'Montserrat', sans-serif;
            background: var(--bg-primary);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow-x: hidden;
            position: relative;
            padding: 20px 0;
        }

        /* ── Fondo con gradiente radial ── */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background:
                radial-gradient(ellipse at 20% 50%, rgba(201, 168, 76, 0.06) 0%, transparent 60%),
                radial-gradient(ellipse at 80% 20%, rgba(201, 168, 76, 0.04) 0%, transparent 50%),
                radial-gradient(ellipse at 50% 80%, rgba(20, 40, 60, 0.8) 0%, transparent 60%),
                linear-gradient(180deg, #0f1923 0%, #162030 50%, #0f1923 100%);
            z-index: 0;
        }

        /* ── Partículas brillantes ── */
        .particles {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
            pointer-events: none;
        }

        .particle {
            position: absolute;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(232, 212, 139, 0.9) 0%, rgba(201, 168, 76, 0.3) 50%, transparent 70%);
            animation: floatParticle linear infinite;
        }

        @keyframes floatParticle {
            0% {
                transform: translateY(100vh) scale(0);
                opacity: 0;
            }
            10% {
                opacity: 1;
            }
            90% {
                opacity: 1;
            }
            100% {
                transform: translateY(-10vh) scale(1);
                opacity: 0;
            }
        }

        /* ── Contenedor principal ── */
        .login-container {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 480px;
            padding: 20px;
        }

        /* ── Logo y título ── */
        .login-header {
            text-align: center;
            margin-bottom: 36px;
        }

        .logo-tree {
            width: 90px;
            height: 90px;
            margin: 0 auto 20px;
            position: relative;
        }

        .logo-tree svg {
            width: 100%;
            height: 100%;
            filter: drop-shadow(0 0 20px rgba(201, 168, 76, 0.3));
        }

        .login-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.6rem;
            font-weight: 600;
            background: var(--gold-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: 0.05em;
            margin-bottom: 4px;
        }

        .login-subtitle {
            font-family: 'Cormorant Garamond', serif;
            font-size: 2.1rem;
            font-style: italic;
            font-weight: 400;
            color: var(--gold-light);
            letter-spacing: 0.02em;
            line-height: 1.1;
        }

        /* ── Card del formulario ── */
        .login-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 4px;
            padding: 40px 36px;
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            position: relative;
            overflow: hidden;
        }

        /* Esquinas decorativas doradas */
        .login-card::before,
        .login-card::after {
            content: '';
            position: absolute;
            width: 50px;
            height: 50px;
            border: 1.5px solid var(--gold-primary);
            opacity: 0.4;
        }

        .login-card::before {
            top: 10px;
            left: 10px;
            border-right: none;
            border-bottom: none;
        }

        .login-card::after {
            bottom: 10px;
            right: 10px;
            border-left: none;
            border-top: none;
        }

        .card-corner-tr,
        .card-corner-bl {
            position: absolute;
            width: 50px;
            height: 50px;
            border: 1.5px solid var(--gold-primary);
            opacity: 0.4;
        }

        .card-corner-tr {
            top: 10px;
            right: 10px;
            border-left: none;
            border-bottom: none;
        }

        .card-corner-bl {
            bottom: 10px;
            left: 10px;
            border-right: none;
            border-top: none;
        }

        /* ── Título del formulario ── */
        .form-heading {
            font-family: 'Cormorant Garamond', serif;
            font-style: italic;
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--gold-light);
            text-align: center;
            margin-bottom: 32px;
            letter-spacing: 0.03em;
        }

        /* ── Campos del formulario ── */
        .form-group {
            margin-bottom: 22px;
            position: relative;
        }

        .form-label {
            display: block;
            font-size: 0.78rem;
            font-weight: 500;
            color: var(--text-secondary);
            margin-bottom: 8px;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        .form-input {
            width: 100%;
            padding: 13px 16px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--border-color);
            border-radius: 3px;
            color: var(--text-primary);
            font-family: 'Montserrat', sans-serif;
            font-size: 0.92rem;
            font-weight: 300;
            letter-spacing: 0.02em;
            transition: all 0.35s ease;
            outline: none;
        }

        .form-input::placeholder {
            color: var(--text-muted);
            font-weight: 300;
        }

        .form-input:focus {
            border-color: var(--border-focus);
            background: rgba(255, 255, 255, 0.08);
            box-shadow: 0 0 0 3px rgba(201, 168, 76, 0.08), 0 0 20px rgba(201, 168, 76, 0.05);
        }

        /* ── Checkbox recordar ── */
        .form-check {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 28px;
        }

        .check-wrapper {
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
        }

        .check-wrapper input[type="checkbox"] {
            -webkit-appearance: none;
            appearance: none;
            width: 16px;
            height: 16px;
            border: 1px solid var(--border-color);
            border-radius: 2px;
            background: rgba(255, 255, 255, 0.05);
            cursor: pointer;
            position: relative;
            transition: all 0.3s ease;
        }

        .check-wrapper input[type="checkbox"]:checked {
            background: var(--gold-primary);
            border-color: var(--gold-primary);
        }

        .check-wrapper input[type="checkbox"]:checked::after {
            content: '✓';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: var(--bg-primary);
            font-size: 11px;
            font-weight: 700;
        }

        .check-label {
            font-size: 0.8rem;
            color: var(--text-secondary);
            font-weight: 400;
            letter-spacing: 0.02em;
        }

        .forgot-link {
            font-size: 0.78rem;
            color: var(--gold-primary);
            text-decoration: none;
            font-weight: 400;
            letter-spacing: 0.02em;
            transition: color 0.3s ease;
        }

        .forgot-link:hover {
            color: var(--gold-light);
        }

        /* ── Botón submit ── */
        .btn-login {
            width: 100%;
            padding: 14px 24px;
            background: var(--gold-gradient);
            border: none;
            border-radius: 50px;
            color: var(--bg-primary);
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.15rem;
            font-weight: 600;
            font-style: italic;
            letter-spacing: 0.08em;
            cursor: pointer;
            transition: all 0.4s ease;
            position: relative;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(201, 168, 76, 0.25);
        }

        .btn-login::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.6s ease;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 30px rgba(201, 168, 76, 0.35);
        }

        .btn-login:hover::before {
            left: 100%;
        }

        .btn-login:active {
            transform: translateY(0);
        }

        /* ── Errores ── */
        .form-error {
            font-size: 0.75rem;
            color: var(--error-color);
            margin-top: 6px;
            letter-spacing: 0.02em;
        }

        .alert-error {
            background: rgba(231, 76, 60, 0.1);
            border: 1px solid rgba(231, 76, 60, 0.25);
            border-radius: 3px;
            padding: 12px 16px;
            margin-bottom: 24px;
            text-align: center;
        }

        .alert-error p {
            font-size: 0.82rem;
            color: var(--error-color);
            font-weight: 400;
        }

        /* ── Status message ── */
        .alert-status {
            background: rgba(201, 168, 76, 0.1);
            border: 1px solid rgba(201, 168, 76, 0.25);
            border-radius: 3px;
            padding: 12px 16px;
            margin-bottom: 24px;
            text-align: center;
        }

        .alert-status p {
            font-size: 0.82rem;
            color: var(--gold-light);
            font-weight: 400;
        }

        /* ── Footer ── */
        .login-footer {
            text-align: center;
            margin-top: 28px;
        }

        .login-footer p {
            font-size: 0.72rem;
            color: var(--text-muted);
            letter-spacing: 0.05em;
        }

        /* ── Responsive ── */
        @media (max-width: 520px) {
            .login-card {
                padding: 32px 24px;
            }

            .login-subtitle {
                font-size: 1.7rem;
            }

            .login-title {
                font-size: 1.3rem;
            }
        }

        @media (max-width: 380px) {
            .login-container {
                padding: 10px;
            }

            .login-card {
                padding: 28px 18px;
            }

            .logo-tree {
                width: 70px;
                height: 70px;
                margin-bottom: 14px;
            }

            .login-title {
                font-size: 1.1rem;
            }

            .login-subtitle {
                font-size: 1.4rem;
            }

            .form-heading {
                font-size: 1.25rem;
                margin-bottom: 24px;
            }

            .form-input {
                padding: 11px 14px;
                font-size: 0.85rem;
            }

            .btn-login {
                padding: 12px 20px;
                font-size: 1rem;
            }
        }

        @media (max-height: 700px) {
            .login-header {
                margin-bottom: 20px;
            }

            .logo-tree {
                width: 70px;
                height: 70px;
                margin-bottom: 12px;
            }

            .login-card {
                padding: 28px 28px;
            }

            .form-heading {
                margin-bottom: 22px;
            }

            .form-group {
                margin-bottom: 16px;
            }

            .form-check {
                margin-bottom: 20px;
            }
        }

        /* ── Animación de entrada ── */
        .login-container {
            animation: fadeInUp 0.8s ease-out;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>
    <!-- Partículas -->
    <div class="particles" id="particles"></div>

    <div class="login-container">
        <!-- Header con logo -->
        <div class="login-header">
            <div class="logo-tree">
                <svg viewBox="0 0 100 120" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <!-- Tronco -->
                    <path d="M50 120 L50 55 Q48 50 42 48 Q36 46 38 40 Q40 34 46 36 Q44 30 48 26 Q52 22 56 26 Q60 30 58 36 Q64 34 66 40 Q68 46 62 48 Q56 50 54 55 L54 120" fill="url(#trunkGrad)" opacity="0.9"/>
                    <!-- Hojas/pétalos -->
                    <g opacity="0.95">
                        <ellipse cx="50" cy="32" rx="5" ry="8" transform="rotate(-15 50 32)" fill="url(#leafGrad)"/>
                        <ellipse cx="38" cy="38" rx="4.5" ry="7" transform="rotate(-40 38 38)" fill="url(#leafGrad)"/>
                        <ellipse cx="62" cy="38" rx="4.5" ry="7" transform="rotate(40 62 38)" fill="url(#leafGrad)"/>
                        <ellipse cx="32" cy="30" rx="4" ry="6.5" transform="rotate(-55 32 30)" fill="url(#leafGrad)"/>
                        <ellipse cx="68" cy="30" rx="4" ry="6.5" transform="rotate(55 68 30)" fill="url(#leafGrad)"/>
                        <ellipse cx="44" cy="22" rx="4" ry="6.5" transform="rotate(-25 44 22)" fill="url(#leafGrad)"/>
                        <ellipse cx="56" cy="22" rx="4" ry="6.5" transform="rotate(25 56 22)" fill="url(#leafGrad)"/>
                        <ellipse cx="36" cy="18" rx="3.5" ry="6" transform="rotate(-50 36 18)" fill="url(#leafGrad)"/>
                        <ellipse cx="64" cy="18" rx="3.5" ry="6" transform="rotate(50 64 18)" fill="url(#leafGrad)"/>
                        <ellipse cx="50" cy="14" rx="4" ry="7" transform="rotate(0 50 14)" fill="url(#leafGrad)"/>
                        <ellipse cx="28" cy="24" rx="3" ry="5.5" transform="rotate(-65 28 24)" fill="url(#leafGrad2)"/>
                        <ellipse cx="72" cy="24" rx="3" ry="5.5" transform="rotate(65 72 24)" fill="url(#leafGrad2)"/>
                        <ellipse cx="42" cy="12" rx="3" ry="5" transform="rotate(-30 42 12)" fill="url(#leafGrad2)"/>
                        <ellipse cx="58" cy="12" rx="3" ry="5" transform="rotate(30 58 12)" fill="url(#leafGrad2)"/>
                        <ellipse cx="50" cy="6" rx="3" ry="5" fill="url(#leafGrad2)"/>
                        <!-- Hojas volando -->
                        <ellipse cx="22" cy="14" rx="2.5" ry="4.5" transform="rotate(-70 22 14)" fill="url(#leafGrad2)" opacity="0.7"/>
                        <ellipse cx="76" cy="10" rx="2.5" ry="4" transform="rotate(60 76 10)" fill="url(#leafGrad2)" opacity="0.6"/>
                        <ellipse cx="80" cy="22" rx="2" ry="3.5" transform="rotate(75 80 22)" fill="url(#leafGrad2)" opacity="0.5"/>
                        <ellipse cx="18" cy="8" rx="2" ry="3.5" transform="rotate(-60 18 8)" fill="url(#leafGrad)" opacity="0.5"/>
                    </g>
                    <defs>
                        <linearGradient id="trunkGrad" x1="46" y1="25" x2="54" y2="120">
                            <stop offset="0%" stop-color="#c9a84c"/>
                            <stop offset="100%" stop-color="#8a6b20"/>
                        </linearGradient>
                        <linearGradient id="leafGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" stop-color="#e8d48b"/>
                            <stop offset="100%" stop-color="#c9a84c"/>
                        </linearGradient>
                        <linearGradient id="leafGrad2" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" stop-color="#c9a84c"/>
                            <stop offset="100%" stop-color="#a07c2a"/>
                        </linearGradient>
                    </defs>
                </svg>
            </div>
            <div class="login-title">FECOER</div>
            <div class="login-subtitle">Acceso al Sistema</div>
        </div>

        <!-- Card del formulario -->
        <div class="login-card">
            <div class="card-corner-tr"></div>
            <div class="card-corner-bl"></div>

            <h2 class="form-heading">Iniciar Sesión</h2>

            <!-- Session Status -->
            @if (session('status'))
                <div class="alert-status">
                    <p>{{ session('status') }}</p>
                </div>
            @endif

            <!-- Validation Errors -->
            @if ($errors->any())
                <div class="alert-error">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email -->
                <div class="form-group">
                    <label for="email" class="form-label">Correo electrónico</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        class="form-input"
                        value="{{ old('email') }}"
                        placeholder="correo@ejemplo.com"
                        required
                        autofocus
                        autocomplete="username"
                    >
                    @error('email')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div class="form-group">
                    <label for="password" class="form-label">Contraseña</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="form-input"
                        placeholder="••••••••"
                        required
                        autocomplete="current-password"
                    >
                    @error('password')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Remember & Forgot -->
                <div class="form-check">
                    <label class="check-wrapper">
                        <input type="checkbox" name="remember" id="remember">
                        <span class="check-label">Recordarme</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="forgot-link">
                            ¿Olvidaste tu contraseña?
                        </a>
                    @endif
                </div>

                <!-- Submit -->
                <button type="submit" class="btn-login">
                    Acceder
                </button>
            </form>
        </div>

        <!-- Footer -->
        <div class="login-footer">
            <p>Copyright &copy; {{ date('Y') }} Todos los derechos reservados FECOER</p>
        </div>
    </div>

    <script>
        // Generar partículas brillantes
        (function() {
            const container = document.getElementById('particles');
            const count = 45;

            for (let i = 0; i < count; i++) {
                const particle = document.createElement('div');
                particle.className = 'particle';

                const size = Math.random() * 4 + 1.5;
                const left = Math.random() * 100;
                const duration = Math.random() * 12 + 8;
                const delay = Math.random() * 15;

                particle.style.width = size + 'px';
                particle.style.height = size + 'px';
                particle.style.left = left + '%';
                particle.style.animationDuration = duration + 's';
                particle.style.animationDelay = delay + 's';

                container.appendChild(particle);
            }
        })();
    </script>
</body>
</html>