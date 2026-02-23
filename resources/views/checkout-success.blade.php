<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="/images/logo.png">
    <title>Compra Registrada - FECOER</title>
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

        .success-container {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 520px;
            padding: 20px;
            animation: fadeInUp 0.8s ease-out;
        }

        .success-header {
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

        .success-title {
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

        .success-subtitle {
            font-family: 'Great Vibes', cursive;
            font-size: 2.4rem;
            font-weight: 400;
            color: var(--gold-light);
            line-height: 1.1;
        }

        .success-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 4px;
            padding: 40px 36px;
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            position: relative;
            overflow: hidden;
            text-align: center;
        }

        .success-card::before,
        .success-card::after {
            content: '';
            position: absolute;
            width: 50px;
            height: 50px;
            border: 1.5px solid var(--gold-primary);
            opacity: 0.4;
        }

        .success-card::before {
            top: 10px;
            left: 10px;
            border-right: none;
            border-bottom: none;
        }

        .success-card::after {
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

        .success-icon {
            width: 80px;
            height: 80px;
            margin: 0 auto 24px;
            border-radius: 50%;
            background: rgba(201, 168, 76, 0.1);
            border: 2px solid var(--gold-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            animation: pulseIcon 2s ease-in-out infinite;
        }

        .success-icon svg {
            width: 40px;
            height: 40px;
        }

        @keyframes pulseIcon {
            0%, 100% { box-shadow: 0 0 0 0 rgba(201, 168, 76, 0.3); }
            50% { box-shadow: 0 0 0 15px rgba(201, 168, 76, 0); }
        }

        .success-heading {
            font-family: 'Great Vibes', cursive;
            font-size: 2rem;
            font-weight: 400;
            color: var(--gold-light);
            margin-bottom: 8px;
        }

        .order-number {
            font-size: 0.85rem;
            color: var(--text-muted);
            margin-bottom: 28px;
            letter-spacing: 0.05em;
        }

        .order-summary {
            background: rgba(201, 168, 76, 0.08);
            border: 1px solid rgba(201, 168, 76, 0.25);
            border-radius: 4px;
            padding: 24px;
            margin-bottom: 28px;
            text-align: left;
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

        .status-badge {
            display: inline-block;
            padding: 6px 20px;
            border-radius: 50px;
            background: rgba(201, 168, 76, 0.15);
            border: 1px solid rgba(201, 168, 76, 0.3);
            color: var(--gold-light);
            font-size: 0.82rem;
            font-weight: 500;
            letter-spacing: 0.05em;
            margin-bottom: 24px;
        }

        .success-message {
            font-size: 0.88rem;
            color: var(--text-secondary);
            line-height: 1.6;
            margin-bottom: 32px;
        }

        .btn-home {
            display: inline-block;
            padding: 14px 40px;
            background: var(--gold-gradient);
            border: none;
            border-radius: 50px;
            color: var(--bg-primary);
            font-family: 'Great Vibes', cursive;
            font-size: 1.4rem;
            font-weight: 400;
            text-decoration: none;
            letter-spacing: 0.03em;
            transition: all 0.4s ease;
            box-shadow: 0 4px 20px rgba(201, 168, 76, 0.25);
        }

        .btn-home:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 30px rgba(201, 168, 76, 0.35);
        }

        .success-footer {
            text-align: center;
            margin-top: 28px;
        }

        .success-footer p {
            font-size: 0.72rem;
            color: var(--text-muted);
            letter-spacing: 0.05em;
        }

        @media (max-width: 520px) {
            .success-card {
                padding: 32px 24px;
            }

            .success-subtitle {
                font-size: 2rem;
            }

            .success-heading {
                font-size: 1.7rem;
            }
        }

        @media (max-width: 380px) {
            .success-container {
                padding: 10px;
            }

            .success-card {
                padding: 28px 18px;
            }

            .logo-tree {
                width: 70px;
                height: 70px;
                margin-bottom: 14px;
            }

            .success-subtitle {
                font-size: 1.7rem;
            }

            .success-heading {
                font-size: 1.5rem;
            }

            .order-summary {
                padding: 16px;
            }

            .summary-row {
                font-size: 0.82rem;
            }

            .btn-home {
                padding: 12px 30px;
                font-size: 1.2rem;
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
    <div class="particles" id="particles"></div>

    <div class="success-container">
        <div class="success-header">
            <img src="/images/logo-fecoer.png" alt="FECOER" style="height: 160px; width: auto; filter: drop-shadow(0 0 10px rgba(201,168,76,0.35)); margin-bottom: 8px;">
            <div class="success-subtitle">Gracias</div>
        </div>

        <div class="success-card">
            <div class="card-corner-tr"></div>
            <div class="card-corner-bl"></div>

            <!-- Icono check -->
            <div class="success-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="#c9a84c" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="20 6 9 17 4 12"></polyline>
                </svg>
            </div>

            <h2 class="success-heading">Compra Registrada</h2>
            <p class="order-number">Orden #{{ $order->id }}</p>

            <!-- Resumen -->
            <div class="order-summary">
                <div class="summary-row">
                    <span>Tipo de entrada</span>
                    <span>{{ $order->ticket_type === 'presencial' ? 'Presencial' : 'Virtual' }}</span>
                </div>
                <div class="summary-row">
                    <span>Cantidad de boletas</span>
                    <span>{{ $order->quantity }}</span>
                </div>
                <div class="summary-row">
                    <span>Donaci&oacute;n</span>
                    <span>${{ number_format($order->donation, 0, ',', '.') }} COP</span>
                </div>
                <div class="summary-row summary-total">
                    <span>Total</span>
                    <span>${{ number_format($order->total, 0, ',', '.') }} COP</span>
                </div>
            </div>

            @switch($order->status)
                @case('paid')
                    <div class="status-badge" style="background: rgba(46, 204, 113, 0.15); border: 1px solid rgba(46, 204, 113, 0.3); color: #2ecc71;">
                        Pago Confirmado
                    </div>
                    <p class="success-message">
                        Tu pago ha sido confirmado exitosamente.<br>
                        @if($order->payment_reference)
                            Referencia: {{ $order->payment_reference }}
                        @endif
                    </p>
                @break
                @case('cancelled')
                    <div class="status-badge" style="background: rgba(231, 76, 60, 0.15); border: 1px solid rgba(231, 76, 60, 0.3); color: #e74c3c;">
                        Pago Cancelado
                    </div>
                    <p class="success-message">
                        Tu pago fue cancelado o rechazado.<br>
                        Si deseas intentar nuevamente, cont&aacute;ctanos.
                    </p>
                @break
                @default
                    <div class="status-badge">Pendiente de pago</div>
                    <p class="success-message">
                        Tu orden ha sido registrada exitosamente.<br>
                        Pronto habilitaremos el pago en l&iacute;nea para completar tu compra.
                    </p>
            @endswitch

            <a href="/" class="btn-home">Volver al inicio</a>
        </div>

        <div class="success-footer">
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
