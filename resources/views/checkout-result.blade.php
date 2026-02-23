<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="/images/logo.png">
    <title>Resultado del Pago - FECOER</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400;1,600&family=Montserrat:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

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
            top: 0; left: 0; width: 100%; height: 100%;
            background:
                radial-gradient(ellipse at 20% 45%, rgba(201,168,76,0.05) 0%, transparent 50%),
                radial-gradient(ellipse at 80% 20%, rgba(201,168,76,0.03) 0%, transparent 40%),
                linear-gradient(180deg, var(--bg-deep) 0%, var(--bg-primary) 30%, var(--bg-mid) 70%, var(--bg-primary) 100%);
            z-index: 0;
        }

        .particles { position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: 1; pointer-events: none; overflow: hidden; }
        .particle { position: absolute; border-radius: 50%; }
        .particle--glow { background: radial-gradient(circle, rgba(232,212,139,1) 0%, rgba(201,168,76,0.8) 40%, transparent 70%); animation: floatUp linear infinite; box-shadow: 0 0 6px 2px rgba(232,212,139,0.4); }
        .particle--soft { background: radial-gradient(circle, rgba(255,240,180,1) 0%, rgba(201,168,76,0.5) 50%, transparent 70%); animation: floatUp linear infinite; box-shadow: 0 0 4px 1px rgba(255,240,180,0.3); }
        .particle--bright { background: radial-gradient(circle, rgba(255,255,220,1) 0%, rgba(232,212,139,0.9) 30%, transparent 60%); animation: floatUp linear infinite; box-shadow: 0 0 8px 3px rgba(255,255,220,0.5); }
        .particle--static { background: radial-gradient(circle, rgba(232,212,139,1) 0%, rgba(201,168,76,0.4) 50%, transparent 70%); animation: twinkle ease-in-out infinite; box-shadow: 0 0 5px 2px rgba(232,212,139,0.3); }

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

        .result-container {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 520px;
            padding: 20px;
            animation: fadeInUp 0.8s ease-out;
        }

        .result-header {
            text-align: center;
            margin-bottom: 36px;
        }

        .result-title {
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

        .result-subtitle {
            font-family: 'Great Vibes', cursive;
            font-size: 2.4rem;
            font-weight: 400;
            color: var(--gold-light);
            line-height: 1.1;
        }

        .result-card {
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

        .result-card::before, .result-card::after {
            content: '';
            position: absolute;
            width: 50px; height: 50px;
            border: 1.5px solid var(--gold-primary);
            opacity: 0.4;
        }
        .result-card::before { top: 10px; left: 10px; border-right: none; border-bottom: none; }
        .result-card::after { bottom: 10px; right: 10px; border-left: none; border-top: none; }

        .card-corner-tr, .card-corner-bl {
            position: absolute; width: 50px; height: 50px;
            border: 1.5px solid var(--gold-primary); opacity: 0.4;
        }
        .card-corner-tr { top: 10px; right: 10px; border-left: none; border-bottom: none; }
        .card-corner-bl { bottom: 10px; left: 10px; border-right: none; border-top: none; }

        .status-icon {
            width: 80px; height: 80px;
            margin: 0 auto 24px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            animation: pulseIcon 2s ease-in-out infinite;
        }

        .status-icon svg { width: 40px; height: 40px; }

        .status-icon--approved {
            background: rgba(46, 204, 113, 0.1);
            border: 2px solid #2ecc71;
        }
        .status-icon--pending {
            background: rgba(201, 168, 76, 0.1);
            border: 2px solid var(--gold-primary);
        }
        .status-icon--rejected, .status-icon--failed, .status-icon--error {
            background: rgba(231, 76, 60, 0.1);
            border: 2px solid #e74c3c;
        }

        @keyframes pulseIcon {
            0%, 100% { box-shadow: 0 0 0 0 rgba(201, 168, 76, 0.3); }
            50% { box-shadow: 0 0 0 15px rgba(201, 168, 76, 0); }
        }

        .result-heading {
            font-family: 'Great Vibes', cursive;
            font-size: 2rem;
            font-weight: 400;
            margin-bottom: 8px;
        }

        .result-heading--approved { color: #2ecc71; }
        .result-heading--pending { color: var(--gold-light); }
        .result-heading--rejected, .result-heading--failed, .result-heading--error { color: #e74c3c; }

        .order-number {
            font-size: 0.85rem;
            color: var(--text-muted);
            margin-bottom: 24px;
            letter-spacing: 0.05em;
        }

        .status-badge {
            display: inline-block;
            padding: 6px 20px;
            border-radius: 50px;
            font-size: 0.82rem;
            font-weight: 500;
            letter-spacing: 0.05em;
            margin-bottom: 20px;
        }

        .badge--approved { background: rgba(46, 204, 113, 0.15); border: 1px solid rgba(46, 204, 113, 0.3); color: #2ecc71; }
        .badge--pending { background: rgba(201, 168, 76, 0.15); border: 1px solid rgba(201, 168, 76, 0.3); color: var(--gold-light); }
        .badge--rejected, .badge--failed { background: rgba(231, 76, 60, 0.15); border: 1px solid rgba(231, 76, 60, 0.3); color: #e74c3c; }
        .badge--error { background: rgba(231, 76, 60, 0.15); border: 1px solid rgba(231, 76, 60, 0.3); color: #e74c3c; }

        .order-summary {
            background: rgba(201, 168, 76, 0.08);
            border: 1px solid rgba(201, 168, 76, 0.25);
            border-radius: 4px;
            padding: 20px;
            margin-bottom: 24px;
            text-align: left;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 6px 0;
            font-size: 0.88rem;
            color: var(--text-secondary);
            border-bottom: 1px solid rgba(201, 168, 76, 0.1);
        }
        .summary-row:last-child { border-bottom: none; }

        .summary-total {
            margin-top: 8px;
            padding-top: 10px;
            border-top: 1px solid rgba(201, 168, 76, 0.3);
            border-bottom: none;
            font-size: 1.05rem;
            font-weight: 600;
            color: var(--gold-light);
        }

        .result-message {
            font-size: 0.88rem;
            color: var(--text-secondary);
            line-height: 1.6;
            margin-bottom: 28px;
        }

        .ref-info {
            font-size: 0.78rem;
            color: var(--text-muted);
            margin-bottom: 24px;
            padding: 10px 16px;
            background: rgba(255,255,255,0.03);
            border-radius: 8px;
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

        .btn-retry {
            display: inline-block;
            padding: 12px 32px;
            background: rgba(231, 76, 60, 0.15);
            border: 1px solid rgba(231, 76, 60, 0.4);
            border-radius: 50px;
            color: #e74c3c;
            font-family: 'Montserrat', sans-serif;
            font-size: 0.88rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            margin-right: 12px;
        }
        .btn-retry:hover {
            background: rgba(231, 76, 60, 0.25);
            transform: translateY(-1px);
        }

        .result-footer {
            text-align: center;
            margin-top: 28px;
        }
        .result-footer p {
            font-size: 0.72rem;
            color: var(--text-muted);
            letter-spacing: 0.05em;
        }

        @media (max-width: 520px) {
            .result-card { padding: 32px 24px; }
            .result-subtitle { font-size: 2rem; }
            .result-heading { font-size: 1.7rem; }
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to   { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
    <div class="particles" id="particles"></div>

    <div class="result-container">
        <div class="result-header">
            <img src="/images/logo-fecoer.png" alt="FECOER" style="height: 160px; width: auto; filter: drop-shadow(0 0 10px rgba(201,168,76,0.35)); margin-bottom: 8px;">
            @if($status === 'approved')
                <div class="result-subtitle">Gracias</div>
            @elseif($status === 'pending')
                <div class="result-subtitle">Procesando</div>
            @else
                <div class="result-subtitle">Resultado</div>
            @endif
        </div>

        <div class="result-card">
            <div class="card-corner-tr"></div>
            <div class="card-corner-bl"></div>

            {{-- Status Icon --}}
            @if($status === 'approved')
                <div class="status-icon status-icon--approved">
                    <svg viewBox="0 0 24 24" fill="none" stroke="#2ecc71" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="20 6 9 17 4 12"></polyline>
                    </svg>
                </div>
                <h2 class="result-heading result-heading--approved">Pago Exitoso</h2>
            @elseif($status === 'pending')
                <div class="status-icon status-icon--pending">
                    <svg viewBox="0 0 24 24" fill="none" stroke="#c9a84c" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"></circle>
                        <polyline points="12 6 12 12 16 14"></polyline>
                    </svg>
                </div>
                <h2 class="result-heading result-heading--pending">Pago Pendiente</h2>
            @elseif($status === 'rejected')
                <div class="status-icon status-icon--rejected">
                    <svg viewBox="0 0 24 24" fill="none" stroke="#e74c3c" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="15" y1="9" x2="9" y2="15"></line>
                        <line x1="9" y1="9" x2="15" y2="15"></line>
                    </svg>
                </div>
                <h2 class="result-heading result-heading--rejected">Pago Rechazado</h2>
            @elseif($status === 'failed')
                <div class="status-icon status-icon--failed">
                    <svg viewBox="0 0 24 24" fill="none" stroke="#e74c3c" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="15" y1="9" x2="9" y2="15"></line>
                        <line x1="9" y1="9" x2="15" y2="15"></line>
                    </svg>
                </div>
                <h2 class="result-heading result-heading--failed">Pago Fallido</h2>
            @else
                <div class="status-icon status-icon--error">
                    <svg viewBox="0 0 24 24" fill="none" stroke="#e74c3c" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"></path>
                        <line x1="12" y1="9" x2="12" y2="13"></line>
                        <line x1="12" y1="17" x2="12.01" y2="17"></line>
                    </svg>
                </div>
                <h2 class="result-heading result-heading--error">Error</h2>
            @endif

            {{-- Order number --}}
            @if($order)
                <p class="order-number">Orden #{{ $order->id }}</p>
            @endif

            {{-- Status badge --}}
            @if($status === 'approved')
                <div class="status-badge badge--approved">Pago Confirmado</div>
            @elseif($status === 'pending')
                <div class="status-badge badge--pending">Pendiente de confirmaci&oacute;n</div>
            @elseif($status === 'rejected')
                <div class="status-badge badge--rejected">Rechazado</div>
            @elseif($status === 'failed')
                <div class="status-badge badge--failed">Fallido</div>
            @else
                <div class="status-badge badge--error">Error</div>
            @endif

            {{-- Order summary --}}
            @if($order)
                <div class="order-summary">
                    <div class="summary-row">
                        <span>Tipo de entrada</span>
                        <span>{{ $order->ticket_type === 'presencial' ? 'Presencial' : 'Virtual' }}</span>
                    </div>
                    <div class="summary-row">
                        <span>Cantidad</span>
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
            @endif

            {{-- Reference info --}}
            @if(isset($refPayco))
                <div class="ref-info">
                    Referencia ePayco: <strong>{{ $refPayco }}</strong>
                </div>
            @endif

            {{-- Message --}}
            @if($status === 'approved')
                <p class="result-message">
                    Tu pago ha sido procesado exitosamente.<br>
                    Recibir&aacute;s una confirmaci&oacute;n en tu correo electr&oacute;nico.
                </p>
            @elseif($status === 'pending')
                <p class="result-message">
                    Tu pago est&aacute; siendo procesado.<br>
                    Te notificaremos cuando se confirme la transacci&oacute;n.
                </p>
            @elseif($status === 'rejected' || $status === 'failed')
                <p class="result-message">
                    Tu pago no pudo ser procesado.<br>
                    Puedes intentar nuevamente o contactarnos para asistencia.
                </p>
            @else
                <p class="result-message">
                    {{ $message ?? 'Ocurri&oacute; un error al verificar el estado del pago.' }}<br>
                    Por favor contacta soporte si el problema persiste.
                </p>
            @endif

            {{-- Actions --}}
            <div>
                @if(($status === 'rejected' || $status === 'failed') && $order)
                    <a href="{{ route('checkout.pay', $order) }}" class="btn-retry">Reintentar pago</a>
                @endif
                <a href="/" class="btn-home">Volver al inicio</a>
            </div>
        </div>

        <div class="result-footer">
            <p>Copyright &copy; {{ date('Y') }} Todos los derechos reservados FECOER</p>
        </div>
    </div>

    <script>
        (function() {
            var container = document.getElementById('particles');
            var types = ['glow', 'soft', 'bright'];

            for (var i = 0; i < 60; i++) {
                var particle = document.createElement('div');
                var type = types[Math.floor(Math.random() * types.length)];
                particle.className = 'particle particle--' + type;
                var size = Math.random() * 4 + 1.5;
                particle.style.width = size + 'px';
                particle.style.height = size + 'px';
                particle.style.left = Math.random() * 100 + '%';
                particle.style.bottom = -(Math.random() * 20) + '%';
                particle.style.animationDuration = (Math.random() * 12 + 8) + 's';
                particle.style.animationDelay = (Math.random() * 15) + 's';
                container.appendChild(particle);
            }

            for (var j = 0; j < 30; j++) {
                var p = document.createElement('div');
                p.className = 'particle particle--static';
                var s = Math.random() * 3 + 1;
                p.style.width = s + 'px';
                p.style.height = s + 'px';
                p.style.left = Math.random() * 100 + '%';
                p.style.top = Math.random() * 100 + '%';
                p.style.animationDuration = (Math.random() * 4 + 2) + 's';
                p.style.animationDelay = (Math.random() * 5) + 's';
                container.appendChild(p);
            }
        })();
    </script>
</body>
</html>
