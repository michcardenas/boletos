<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="/images/logo.png">
    <title>Checkout - FECOER</title>
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

        /* ── Partículas ── */
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

        /* ── Contenedor ── */
        .checkout-container {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 580px;
            padding: 20px;
            animation: fadeInUp 0.8s ease-out;
        }

        /* ── Header ── */
        .checkout-header {
            text-align: center;
            margin-bottom: 36px;
        }

        .logo-tree {
            width: 90px;
            height: 90px;
            margin: 0 auto 20px;
        }

        .logo-tree svg {
            width: 100%;
            height: 100%;
            filter: drop-shadow(0 0 20px rgba(201, 168, 76, 0.3));
        }

        .checkout-title {
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

        .checkout-subtitle {
            font-family: 'Great Vibes', cursive;
            font-size: 2.4rem;
            font-weight: 400;
            color: var(--gold-light);
            letter-spacing: 0.02em;
            line-height: 1.1;
        }

        /* ── Card ── */
        .checkout-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 4px;
            padding: 40px 36px;
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            position: relative;
            overflow: hidden;
        }

        .checkout-card::before,
        .checkout-card::after {
            content: '';
            position: absolute;
            width: 50px;
            height: 50px;
            border: 1.5px solid var(--gold-primary);
            opacity: 0.4;
        }

        .checkout-card::before {
            top: 10px;
            left: 10px;
            border-right: none;
            border-bottom: none;
        }

        .checkout-card::after {
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

        .form-heading {
            font-family: 'Great Vibes', cursive;
            font-size: 2rem;
            font-weight: 400;
            color: var(--gold-light);
            text-align: center;
            margin-bottom: 28px;
            letter-spacing: 0.03em;
        }

        /* ── Resumen de compra ── */
        .order-summary {
            background: rgba(201, 168, 76, 0.08);
            border: 1px solid rgba(201, 168, 76, 0.25);
            border-radius: 4px;
            padding: 24px;
            margin-bottom: 28px;
        }

        .summary-title {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.1rem;
            font-weight: 600;
            font-style: italic;
            color: var(--gold-light);
            margin-bottom: 16px;
            letter-spacing: 0.03em;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 7px 0;
            font-size: 0.88rem;
            color: var(--text-secondary);
            border-bottom: 1px solid rgba(201, 168, 76, 0.1);
        }

        .summary-row:last-child {
            border-bottom: none;
        }

        .summary-total {
            margin-top: 8px;
            padding-top: 12px;
            border-top: 1px solid rgba(201, 168, 76, 0.3);
            border-bottom: none;
            font-size: 1.05rem;
            font-weight: 600;
            color: var(--gold-light);
        }

        /* ── Campos ── */
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

        .form-row {
            display: flex;
            gap: 16px;
        }

        .form-row .form-group {
            flex: 1;
        }

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

        /* ── Pasarela de pagos placeholder ── */
        .payment-section {
            margin: 28px 0;
            text-align: center;
        }

        .payment-label {
            font-size: 0.78rem;
            font-weight: 500;
            color: var(--text-secondary);
            text-transform: uppercase;
            letter-spacing: 0.08em;
            margin-bottom: 12px;
        }

        .payment-box {
            border: 2px dashed rgba(201, 168, 76, 0.3);
            border-radius: 12px;
            padding: 30px 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
        }

        .payment-box-icon {
            font-size: 2rem;
            opacity: 0.5;
        }

        .payment-box-text {
            color: var(--text-muted);
            font-size: 0.85rem;
        }

        .payment-box-soon {
            font-family: 'Cormorant Garamond', serif;
            font-style: italic;
            font-size: 0.9rem;
            color: var(--gold-primary);
            opacity: 0.7;
        }

        /* ── Botón ── */
        .btn-checkout {
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

        .btn-checkout::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.6s ease;
        }

        .btn-checkout:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 30px rgba(201, 168, 76, 0.35);
        }

        .btn-checkout:hover::before {
            left: 100%;
        }

        .btn-checkout:active {
            transform: translateY(0);
        }

        /* ── Link volver ── */
        .back-link {
            text-align: center;
            margin-top: 24px;
        }

        .back-link a {
            font-size: 0.82rem;
            color: var(--gold-primary);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .back-link a:hover {
            color: var(--gold-light);
        }

        /* ── Footer ── */
        .checkout-footer {
            text-align: center;
            margin-top: 28px;
        }

        .checkout-footer p {
            font-size: 0.72rem;
            color: var(--text-muted);
            letter-spacing: 0.05em;
        }

        /* ── Separador ── */
        .form-separator {
            font-family: 'Cormorant Garamond', serif;
            font-style: italic;
            font-size: 1rem;
            color: var(--gold-primary);
            text-align: center;
            margin: 28px 0 24px;
            letter-spacing: 0.05em;
            opacity: 0.7;
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .form-separator::before,
        .form-separator::after {
            content: '';
            flex: 1;
            height: 1px;
            background: rgba(201, 168, 76, 0.25);
        }

        /* ── Responsive ── */
        @media (max-width: 580px) {
            .checkout-card {
                padding: 32px 24px;
            }

            .checkout-subtitle {
                font-size: 2rem;
            }

            .checkout-title {
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
            .checkout-container {
                padding: 10px;
            }

            .checkout-card {
                padding: 28px 18px;
            }

            .logo-tree {
                width: 70px;
                height: 70px;
                margin-bottom: 14px;
            }

            .checkout-title {
                font-size: 1.1rem;
            }

            .checkout-subtitle {
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

            .btn-checkout {
                padding: 12px 20px;
                font-size: 1.3rem;
            }

            .order-summary {
                padding: 16px;
            }

            .summary-row {
                font-size: 0.82rem;
            }
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

    <div class="checkout-container">
        <!-- Header -->
        <div class="checkout-header">
            <img src="/images/logo-fecoer.png" alt="FECOER" style="height: 160px; width: auto; filter: drop-shadow(0 0 10px rgba(201,168,76,0.35)); margin-bottom: 8px;">
            <div class="checkout-subtitle">Checkout</div>
        </div>

        <!-- Card -->
        <div class="checkout-card">
            <div class="card-corner-tr"></div>
            <div class="card-corner-bl"></div>

            <h2 class="form-heading">Finalizar Compra</h2>

            <!-- Resumen de compra -->
            <div class="order-summary">
                <h3 class="summary-title">Resumen de tu compra</h3>
                <div class="summary-row">
                    <span>Tipo de entrada</span>
                    <span>{{ $ticketType === 'presencial' ? 'Presencial' : 'Virtual' }}</span>
                </div>
                <div class="summary-row">
                    <span>Cantidad de boletas</span>
                    <span>{{ $quantity }}</span>
                </div>
                <div class="summary-row">
                    <span>Donaci&oacute;n</span>
                    <span>${{ number_format($donation, 0, ',', '.') }} COP</span>
                </div>
                <div class="summary-row summary-total">
                    <span>Total</span>
                    <span>${{ number_format($total, 0, ',', '.') }} COP</span>
                </div>
            </div>

            <!-- Errores -->
            @if ($errors->any())
                <div class="alert-error">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <!-- Formulario -->
            <form method="POST" action="{{ route('checkout.store') }}">
                @csrf

                <input type="hidden" name="ticket_type" value="{{ $ticketType }}">
                <input type="hidden" name="quantity" value="{{ $quantity }}">
                <input type="hidden" name="donation" value="{{ $donation }}">

                <div class="form-separator">Datos del comprador</div>

                <!-- Nombres -->
                <div class="form-group">
                    <label for="name" class="form-label">Nombres y apellidos</label>
                    <input type="text" id="name" name="name" class="form-input"
                        value="{{ old('name', $user->name ?? '') }}"
                        placeholder="Ingrese su nombre completo" required>
                    @error('name')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div class="form-group">
                    <label for="email" class="form-label">Correo electr&oacute;nico</label>
                    <input type="email" id="email" name="email" class="form-input"
                        value="{{ old('email', $user->email ?? '') }}"
                        placeholder="correo@ejemplo.com" required>
                    @error('email')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tipo y Número de documento -->
                <div class="form-row">
                    <div class="form-group">
                        <label for="tipo_documento" class="form-label">Tipo de documento</label>
                        <select id="tipo_documento" name="tipo_documento" class="form-select" required>
                            <option value="" disabled {{ old('tipo_documento', $user->tipo_documento ?? '') ? '' : 'selected' }}>Seleccione</option>
                            <option value="CC" {{ old('tipo_documento', $user->tipo_documento ?? '') == 'CC' ? 'selected' : '' }}>C&eacute;dula de Ciudadan&iacute;a</option>
                            <option value="CE" {{ old('tipo_documento', $user->tipo_documento ?? '') == 'CE' ? 'selected' : '' }}>C&eacute;dula de Extranjer&iacute;a</option>
                            <option value="TI" {{ old('tipo_documento', $user->tipo_documento ?? '') == 'TI' ? 'selected' : '' }}>Tarjeta de Identidad</option>
                            <option value="PP" {{ old('tipo_documento', $user->tipo_documento ?? '') == 'PP' ? 'selected' : '' }}>Pasaporte</option>
                            <option value="NIT" {{ old('tipo_documento', $user->tipo_documento ?? '') == 'NIT' ? 'selected' : '' }}>NIT</option>
                        </select>
                        @error('tipo_documento')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="numero_documento" class="form-label">N&uacute;mero de documento</label>
                        <input type="text" id="numero_documento" name="numero_documento" class="form-input"
                            value="{{ old('numero_documento', $user->numero_documento ?? '') }}"
                            placeholder="123456789" required>
                        @error('numero_documento')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Celular -->
                <div class="form-group">
                    <label for="celular" class="form-label">Celular / WhatsApp</label>
                    <input type="tel" id="celular" name="celular" class="form-input"
                        value="{{ old('celular', $user->celular ?? '') }}"
                        placeholder="300 123 4567" required>
                    @error('celular')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Organización -->
                <div class="form-group">
                    <label for="organizacion" class="form-label">
                        &iquest;A qu&eacute; entidad u organizaci&oacute;n pertenece? <span class="optional">(Opcional)</span>
                    </label>
                    <input type="text" id="organizacion" name="organizacion" class="form-input"
                        value="{{ old('organizacion', $user->organizacion ?? '') }}"
                        placeholder="Nombre de la entidad">
                    @error('organizacion')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Pasarela de pagos -->
                <div class="payment-section">
                    <p class="payment-label">Pasarela de pago</p>
                    @if($epaycoConfigured)
                        <div class="payment-box" style="border-style: solid; border-color: rgba(201, 168, 76, 0.4); display: flex; align-items: center; gap: 12px;">
                            <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: var(--gold-primary); flex-shrink: 0;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                            <span class="payment-box-text" style="color: var(--text-secondary); flex: 1;">
                                Pago seguro con <strong style="color: var(--gold-light);">ePayco</strong>
                            </span>
                            @if($epaycoTestMode)
                                <span style="font-size: 0.68rem; color: #f39c12; font-weight: 600; text-transform: uppercase; letter-spacing: 1px; padding: 3px 10px; background: rgba(243, 156, 18, 0.15); border: 1px solid rgba(243, 156, 18, 0.3); border-radius: 50px; flex-shrink: 0;">
                                    Prueba
                                </span>
                            @endif
                        </div>
                    @else
                        <div class="payment-box">
                            <span class="payment-box-icon">&#128179;</span>
                            <span class="payment-box-text">Logo de pasarela de pago</span>
                            <span class="payment-box-soon">Pr&oacute;ximamente</span>
                        </div>
                    @endif
                </div>

                <!-- Submit -->
                <button type="submit" class="btn-checkout">
                    {{ $epaycoConfigured ? 'Proceder al Pago' : 'Confirmar Compra' }}
                </button>
            </form>

            <!-- Volver -->
            <div class="back-link">
                <a href="/#entradas">&larr; Volver a entradas</a>
            </div>
        </div>

        <!-- Footer -->
        <div class="checkout-footer">
            <p>Copyright &copy; {{ date('Y') }} Todos los derechos reservados FECOER</p>
        </div>
    </div>

    <script>
        (function() {
            const container = document.getElementById('particles');
            const types = ['glow', 'soft', 'bright'];

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
