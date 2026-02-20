<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Registro - FECOER</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400;1,600&family=Cormorant+Garamond:ital,wght@0,400;0,600;1,400;1,600&family=Montserrat:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --bg-primary: #152536;
            --bg-deep: #0e1c2a;
            --bg-mid: #1a2d3e;
            --bg-card: rgba(20, 35, 50, 0.85);
            --gold-primary: #c9a84c;
            --gold-light: #e8d48b;
            --gold-dark: #a07c2a;
            --gold-gradient: linear-gradient(135deg, #a07c2a 0%, #c9a84c 25%, #e8d48b 50%, #c9a84c 75%, #a07c2a 100%);
            --text-primary: #eae6dc;
            --text-secondary: #bfc5cc;
            --text-muted: #607080;
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
                radial-gradient(ellipse at 20% 45%, rgba(201,168,76,0.05) 0%, transparent 50%),
                radial-gradient(ellipse at 80% 20%, rgba(201,168,76,0.03) 0%, transparent 40%),
                linear-gradient(180deg, var(--bg-deep) 0%, var(--bg-primary) 30%, var(--bg-mid) 70%, var(--bg-primary) 100%);
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
            overflow: hidden;
        }

        .particle { position: absolute; border-radius: 50%; }

        .particle--glow {
            background: radial-gradient(circle, rgba(232,212,139,1) 0%, rgba(201,168,76,0.8) 40%, transparent 70%);
            animation: floatUp linear infinite;
            box-shadow: 0 0 6px 2px rgba(232,212,139,0.4);
        }
        .particle--soft {
            background: radial-gradient(circle, rgba(255,240,180,1) 0%, rgba(201,168,76,0.5) 50%, transparent 70%);
            animation: floatUp linear infinite;
            box-shadow: 0 0 4px 1px rgba(255,240,180,0.3);
        }
        .particle--bright {
            background: radial-gradient(circle, rgba(255,255,220,1) 0%, rgba(232,212,139,0.9) 30%, transparent 60%);
            animation: floatUp linear infinite;
            box-shadow: 0 0 8px 3px rgba(255,255,220,0.5);
        }
        .particle--static {
            background: radial-gradient(circle, rgba(232,212,139,1) 0%, rgba(201,168,76,0.4) 50%, transparent 70%);
            animation: twinkle ease-in-out infinite;
            box-shadow: 0 0 5px 2px rgba(232,212,139,0.3);
        }

        @keyframes floatUp {
            0%   { transform: translateY(0) scale(0.3); opacity: 0; }
            8%   { opacity: 1; }
            50%  { opacity: 1; }
            85%  { opacity: 0.8; }
            100% { transform: translateY(-110vh) scale(1.2); opacity: 0; }
        }
        @keyframes twinkle {
            0%, 100% { opacity: 0.4; transform: scale(0.8); }
            50%      { opacity: 1; transform: scale(1.6); }
        }

        /* ── Contenedor principal ── */
        .register-container {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 540px;
            padding: 20px;
        }

        /* ── Logo y título ── */
        .register-header {
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

        .register-title {
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

        .register-subtitle {
            font-family: 'Great Vibes', cursive;
            font-size: 2.4rem;
            font-weight: 400;
            color: var(--gold-light);
            letter-spacing: 0.02em;
            line-height: 1.1;
        }

        /* ── Card del formulario ── */
        .register-card {
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
        .register-card::before,
        .register-card::after {
            content: '';
            position: absolute;
            width: 50px;
            height: 50px;
            border: 1.5px solid var(--gold-primary);
            opacity: 0.4;
        }

        .register-card::before {
            top: 10px;
            left: 10px;
            border-right: none;
            border-bottom: none;
        }

        .register-card::after {
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
            font-family: 'Great Vibes', cursive;
            font-size: 2rem;
            font-weight: 400;
            color: var(--gold-light);
            text-align: center;
            margin-bottom: 32px;
            letter-spacing: 0.03em;
        }

        /* ── Campos del formulario ── */
        .form-group {
            margin-bottom: 20px;
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

        .form-label .optional {
            font-size: 0.7rem;
            color: var(--text-muted);
            text-transform: none;
            font-weight: 400;
            letter-spacing: normal;
        }

        .form-input,
        .form-select {
            width: 100%;
            padding: 13px 24px;
            background: rgba(255,255,255,0.93);
            border: none;
            border-radius: 50px;
            color: #333;
            font-family: 'Montserrat', sans-serif;
            font-size: 0.92rem;
            font-weight: 400;
            letter-spacing: 0.02em;
            transition: all 0.35s ease;
            outline: none;
        }

        .form-input::placeholder {
            color: #999;
            font-weight: 300;
        }

        .form-input:focus,
        .form-select:focus {
            box-shadow: 0 0 0 3px rgba(201, 168, 76, 0.25), 0 0 20px rgba(201, 168, 76, 0.1);
        }

        .form-select {
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            cursor: pointer;
            padding-right: 48px;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%23999' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 20px center;
            background-size: 16px;
        }

        /* ── Row de dos columnas ── */
        .form-row {
            display: flex;
            gap: 16px;
        }

        .form-row .form-group {
            flex: 1;
        }

        /* ── Checkbox tratamiento datos ── */
        .form-check {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            margin-bottom: 28px;
            margin-top: 4px;
        }

        .form-check input[type="checkbox"] {
            -webkit-appearance: none;
            appearance: none;
            width: 18px;
            height: 18px;
            min-width: 18px;
            border: 1px solid var(--border-color);
            border-radius: 3px;
            background: rgba(255, 255, 255, 0.05);
            cursor: pointer;
            position: relative;
            transition: all 0.3s ease;
            margin-top: 2px;
        }

        .form-check input[type="checkbox"]:checked {
            background: var(--gold-primary);
            border-color: var(--gold-primary);
        }

        .form-check input[type="checkbox"]:checked::after {
            content: '\2713';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: var(--bg-primary);
            font-size: 12px;
            font-weight: 700;
        }

        .check-text {
            font-size: 0.78rem;
            color: var(--text-secondary);
            font-weight: 400;
            line-height: 1.5;
            letter-spacing: 0.01em;
        }

        .check-text a {
            color: var(--gold-primary);
            text-decoration: underline;
            transition: color 0.3s ease;
        }

        .check-text a:hover {
            color: var(--gold-light);
        }

        /* ── Botón submit ── */
        .btn-register {
            width: 100%;
            padding: 14px 24px;
            background: var(--gold-gradient);
            border: none;
            border-radius: 50px;
            color: var(--bg-primary);
            font-family: 'Great Vibes', cursive;
            font-size: 1.5rem;
            font-weight: 400;
            letter-spacing: 0.03em;
            cursor: pointer;
            transition: all 0.4s ease;
            position: relative;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(201, 168, 76, 0.25);
        }

        .btn-register::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.6s ease;
        }

        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 30px rgba(201, 168, 76, 0.35);
        }

        .btn-register:hover::before {
            left: 100%;
        }

        .btn-register:active {
            transform: translateY(0);
        }

        /* ── Link ya registrado ── */
        .login-link {
            text-align: center;
            margin-top: 24px;
        }

        .login-link p {
            font-size: 0.82rem;
            color: var(--text-secondary);
        }

        .login-link a {
            color: var(--gold-primary);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .login-link a:hover {
            color: var(--gold-light);
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

        /* ── Footer ── */
        .register-footer {
            text-align: center;
            margin-top: 28px;
        }

        .register-footer p {
            font-size: 0.72rem;
            color: var(--text-muted);
            letter-spacing: 0.05em;
        }

        /* ── Responsive ── */
        @media (max-width: 580px) {
            .register-card {
                padding: 32px 24px;
            }

            .register-subtitle {
                font-size: 2rem;
            }

            .register-title {
                font-size: 1.3rem;
            }

            .form-heading {
                font-size: 1.7rem;
            }

            .form-row {
                flex-direction: column;
                gap: 0;
            }
        }

        @media (max-width: 380px) {
            .register-container {
                padding: 10px;
            }

            .register-card {
                padding: 28px 18px;
            }

            .logo-tree {
                width: 70px;
                height: 70px;
                margin-bottom: 14px;
            }

            .register-title {
                font-size: 1.1rem;
            }

            .register-subtitle {
                font-size: 1.7rem;
            }

            .form-heading {
                font-size: 1.5rem;
                margin-bottom: 24px;
            }

            .form-input,
            .form-select {
                padding: 11px 18px;
                font-size: 0.85rem;
            }

            .btn-register {
                padding: 12px 20px;
                font-size: 1.3rem;
            }
        }

        @media (max-height: 700px) and (min-width: 581px) {
            .register-header {
                margin-bottom: 20px;
            }

            .logo-tree {
                width: 70px;
                height: 70px;
                margin-bottom: 12px;
            }

            .register-card {
                padding: 28px 28px;
            }

            .form-heading {
                margin-bottom: 22px;
            }

            .form-group {
                margin-bottom: 14px;
            }

            .form-check {
                margin-bottom: 20px;
            }
        }

        /* ── Animación de entrada ── */
        .register-container {
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

    <div class="register-container">
        <!-- Header con logo -->
        <div class="register-header">
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
            <div class="register-title">FECOER</div>
            <div class="register-subtitle">Registro</div>
        </div>

        <!-- Card del formulario -->
        <div class="register-card">
            <div class="card-corner-tr"></div>
            <div class="card-corner-bl"></div>

            <h2 class="form-heading">Crear Cuenta</h2>

            <!-- Validation Errors -->
            @if ($errors->any())
                <div class="alert-error">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Nombres y apellidos -->
                <div class="form-group">
                    <label for="name" class="form-label">Nombres y apellidos</label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        class="form-input"
                        value="{{ old('name') }}"
                        placeholder="Ingrese su nombre completo"
                        required
                        autofocus
                        autocomplete="name"
                    >
                    @error('name')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Correo electrónico -->
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
                        autocomplete="username"
                    >
                    @error('email')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tipo y Número de documento -->
                <div class="form-row">
                    <div class="form-group">
                        <label for="tipo_documento" class="form-label">Tipo de documento</label>
                        <select id="tipo_documento" name="tipo_documento" class="form-select" required>
                            <option value="" disabled {{ old('tipo_documento') ? '' : 'selected' }}>Seleccione</option>
                            <option value="CC" {{ old('tipo_documento') == 'CC' ? 'selected' : '' }}>Cédula de Ciudadanía</option>
                            <option value="CE" {{ old('tipo_documento') == 'CE' ? 'selected' : '' }}>Cédula de Extranjería</option>
                            <option value="TI" {{ old('tipo_documento') == 'TI' ? 'selected' : '' }}>Tarjeta de Identidad</option>
                            <option value="PP" {{ old('tipo_documento') == 'PP' ? 'selected' : '' }}>Pasaporte</option>
                            <option value="NIT" {{ old('tipo_documento') == 'NIT' ? 'selected' : '' }}>NIT</option>
                        </select>
                        @error('tipo_documento')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="numero_documento" class="form-label">Número de documento</label>
                        <input
                            type="text"
                            id="numero_documento"
                            name="numero_documento"
                            class="form-input"
                            value="{{ old('numero_documento') }}"
                            placeholder="123456789"
                            required
                        >
                        @error('numero_documento')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Celular / WhatsApp -->
                <div class="form-group">
                    <label for="celular" class="form-label">Celular / WhatsApp</label>
                    <input
                        type="tel"
                        id="celular"
                        name="celular"
                        class="form-input"
                        value="{{ old('celular') }}"
                        placeholder="300 123 4567"
                        required
                    >
                    @error('celular')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Organización -->
                <div class="form-group">
                    <label for="organizacion" class="form-label">
                        ¿A qué entidad u organización pertenece? <span class="optional">(Opcional)</span>
                    </label>
                    <input
                        type="text"
                        id="organizacion"
                        name="organizacion"
                        class="form-input"
                        value="{{ old('organizacion') }}"
                        placeholder="Nombre de la entidad"
                    >
                    @error('organizacion')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Contraseña -->
                <div class="form-group">
                    <label for="password" class="form-label">Contraseña</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="form-input"
                        placeholder="••••••••"
                        required
                        autocomplete="new-password"
                    >
                    @error('password')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirmar Contraseña -->
                <div class="form-group">
                    <label for="password_confirmation" class="form-label">Confirmar contraseña</label>
                    <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        class="form-input"
                        placeholder="••••••••"
                        required
                        autocomplete="new-password"
                    >
                </div>

                <!-- Tratamiento de datos -->
                <div class="form-check">
                    <input type="checkbox" name="acepta_tratamiento_datos" id="acepta_tratamiento_datos" value="1" {{ old('acepta_tratamiento_datos') ? 'checked' : '' }}>
                    <span class="check-text">
                        He leído y acepto la <a href="#">Política de Tratamiento de Datos Personales</a> y autorizo a FECOER para recolectar, almacenar y tratar mis datos personales conforme a las finalidades descritas.
                    </span>
                </div>
                @error('acepta_tratamiento_datos')
                    <p class="form-error" style="margin-top: -20px; margin-bottom: 20px;">{{ $message }}</p>
                @enderror

                <!-- Submit -->
                <button type="submit" class="btn-register">
                    Enviar
                </button>
            </form>

            <!-- Link a login -->
            <div class="login-link">
                <p>¿Ya tienes cuenta? <a href="{{ route('login') }}">Iniciar sesión</a></p>
            </div>
        </div>

        <!-- Footer -->
        <div class="register-footer">
            <p>Copyright &copy; {{ date('Y') }} Todos los derechos reservados FECOER</p>
        </div>
    </div>

    <script>
        // Generar partículas brillantes con tipos variados
        (function() {
            const container = document.getElementById('particles');
            const types = ['glow', 'soft', 'bright'];

            // Partículas flotantes
            for (let i = 0; i < 60; i++) {
                const particle = document.createElement('div');
                const type = types[Math.floor(Math.random() * types.length)];
                particle.className = 'particle particle--' + type;

                const size = Math.random() * 4 + 1.5;
                particle.style.width = size + 'px';
                particle.style.height = size + 'px';
                particle.style.left = Math.random() * 100 + '%';
                particle.style.bottom = -(Math.random() * 20) + '%';
                particle.style.animationDuration = (Math.random() * 12 + 8) + 's';
                particle.style.animationDelay = (Math.random() * 15) + 's';

                container.appendChild(particle);
            }

            // Partículas estáticas (titilantes)
            for (let i = 0; i < 30; i++) {
                const particle = document.createElement('div');
                particle.className = 'particle particle--static';

                const size = Math.random() * 3 + 1;
                particle.style.width = size + 'px';
                particle.style.height = size + 'px';
                particle.style.left = Math.random() * 100 + '%';
                particle.style.top = Math.random() * 100 + '%';
                particle.style.animationDuration = (Math.random() * 4 + 2) + 's';
                particle.style.animationDelay = (Math.random() * 5) + 's';

                container.appendChild(particle);
            }
        })();
    </script>
</body>
</html>
