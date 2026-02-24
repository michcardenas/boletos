<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="/images/logo.png">
    <title>{{ $title }} - FECOER</title>
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

        .stream-container {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 900px;
            padding: 20px;
            animation: fadeInUp 0.8s ease-out;
        }

        .stream-container.narrow {
            max-width: 520px;
        }

        .stream-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .stream-logo {
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

        .stream-title {
            font-family: 'Great Vibes', cursive;
            font-size: 2.2rem;
            font-weight: 400;
            color: var(--gold-light);
            line-height: 1.1;
        }

        .live-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 5px 16px;
            border-radius: 50px;
            background: rgba(231, 76, 60, 0.2);
            border: 1px solid rgba(231, 76, 60, 0.4);
            color: #e74c3c;
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            margin-top: 12px;
            animation: pulse-live 2s ease-in-out infinite;
        }

        .live-badge::before {
            content: '';
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #e74c3c;
        }

        @keyframes pulse-live {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.6; }
        }

        .stream-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 4px;
            padding: 0;
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            position: relative;
            overflow: hidden;
        }

        .stream-card--padded {
            padding: 40px 36px;
            text-align: center;
        }

        .stream-card::before, .stream-card::after {
            content: '';
            position: absolute;
            width: 50px; height: 50px;
            border: 1.5px solid var(--gold-primary);
            opacity: 0.4;
            z-index: 2;
        }
        .stream-card::before { top: 10px; left: 10px; border-right: none; border-bottom: none; }
        .stream-card::after { bottom: 10px; right: 10px; border-left: none; border-top: none; }

        .card-corner-tr, .card-corner-bl {
            position: absolute; width: 50px; height: 50px;
            border: 1.5px solid var(--gold-primary); opacity: 0.4; z-index: 2;
        }
        .card-corner-tr { top: 10px; right: 10px; border-left: none; border-bottom: none; }
        .card-corner-bl { bottom: 10px; left: 10px; border-right: none; border-top: none; }

        .video-wrapper {
            position: relative;
            padding-bottom: 56.25%;
            height: 0;
            overflow: hidden;
        }

        .video-wrapper iframe {
            position: absolute;
            top: -60px;
            left: 0;
            width: 100%;
            height: calc(100% + 120px);
            border: none;
        }

        .video-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 80px;
            z-index: 10;
            background: linear-gradient(to top, var(--bg-primary) 0%, transparent 100%);
            pointer-events: none;
        }

        .video-overlay-top {
            position: absolute;
            top: 0;
            right: 0;
            width: 200px;
            height: 60px;
            z-index: 10;
            background: transparent;
            cursor: default;
        }

        .stream-description {
            padding: 24px 30px;
            font-size: 0.88rem;
            color: var(--text-secondary);
            line-height: 1.7;
            border-top: 1px solid var(--border-color);
        }

        .status-icon {
            width: 80px; height: 80px;
            margin: 0 auto 24px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .status-icon svg { width: 40px; height: 40px; }

        .status-icon--lock {
            background: rgba(243, 156, 18, 0.1);
            border: 2px solid #f39c12;
        }

        .status-icon--offline {
            background: rgba(149, 165, 166, 0.1);
            border: 2px solid #95a5a6;
        }

        .status-icon--pending {
            background: rgba(201, 168, 76, 0.1);
            border: 2px solid var(--gold-primary);
        }

        .message-heading {
            font-family: 'Great Vibes', cursive;
            font-size: 1.8rem;
            font-weight: 400;
            margin-bottom: 16px;
        }

        .message-heading--lock { color: #f39c12; }
        .message-heading--offline { color: #95a5a6; }
        .message-heading--pending { color: var(--gold-light); }

        .message-text {
            font-size: 0.88rem;
            color: var(--text-secondary);
            line-height: 1.6;
            margin-bottom: 28px;
        }

        .btn-gold {
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
        .btn-gold:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 30px rgba(201, 168, 76, 0.35);
        }

        .stream-footer {
            text-align: center;
            margin-top: 28px;
        }
        .stream-footer p {
            font-size: 0.72rem;
            color: var(--text-muted);
            letter-spacing: 0.05em;
        }
        .stream-footer a {
            color: var(--gold-primary);
            text-decoration: none;
            font-size: 0.82rem;
        }
        .stream-footer a:hover { text-decoration: underline; }

        @media (max-width: 520px) {
            .stream-card--padded { padding: 32px 24px; }
            .stream-title { font-size: 1.8rem; }
            .stream-description { padding: 20px; }
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to   { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
    <div class="particles" id="particles"></div>

    @if($access === 'granted')
        {{-- ===== ACCESO CONCEDIDO: Mostrar player ===== --}}
        <div class="stream-container">
            <div class="stream-header">
                <img src="/images/logo-fecoer.png" alt="FECOER" style="height: 160px; width: auto; filter: drop-shadow(0 0 10px rgba(201,168,76,0.35)); margin-bottom: 8px;">
                <div class="stream-title">{{ $title }}</div>
                <span class="live-badge">En Vivo</span>
            </div>

            <div class="stream-card">
                <div class="card-corner-tr"></div>
                <div class="card-corner-bl"></div>

                <div class="video-wrapper" oncontextmenu="return false;">
                    <iframe id="ytplayer"
                        src="{{ $embedUrl }}?autoplay=1&mute=1&rel=0&modestbranding=1&iv_load_policy=3&playsinline=1&disablekb=1&origin={{ urlencode(config('app.url')) }}"
                        allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen>
                    </iframe>
                    <div class="video-overlay"></div>
                    <div class="video-overlay-top" oncontextmenu="return false;"></div>
                </div>

                @if(!empty($description))
                    <div class="stream-description">
                        {!! nl2br(e($description)) !!}
                    </div>
                @endif
            </div>

            <div class="stream-footer">
                <p style="margin-bottom: 12px;"><a href="/">&larr; Volver al inicio</a></p>
                <p>Copyright &copy; {{ date('Y') }} Todos los derechos reservados FECOER</p>
            </div>
        </div>

    @elseif($access === 'inactive')
        {{-- ===== STREAMING INACTIVO ===== --}}
        <div class="stream-container narrow">
            <div class="stream-header">
                <img src="/images/logo-fecoer.png" alt="FECOER" style="height: 160px; width: auto; filter: drop-shadow(0 0 10px rgba(201,168,76,0.35)); margin-bottom: 8px;">
                <div class="stream-title">Transmisi&oacute;n</div>
            </div>

            <div class="stream-card stream-card--padded">
                <div class="card-corner-tr"></div>
                <div class="card-corner-bl"></div>

                <div class="status-icon status-icon--offline">
                    <svg viewBox="0 0 24 24" fill="none" stroke="#95a5a6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="2" y="7" width="20" height="15" rx="2" ry="2"/>
                        <polyline points="17 2 12 7 7 2"/>
                    </svg>
                </div>

                <h2 class="message-heading message-heading--offline">No disponible</h2>
                <p class="message-text">
                    La transmisi&oacute;n en vivo a&uacute;n no est&aacute; disponible.<br>
                    Te notificaremos cuando comience el evento.
                </p>

                <a href="/" class="btn-gold">Volver al inicio</a>
            </div>

            <div class="stream-footer">
                <p style="margin-top: 28px;">Copyright &copy; {{ date('Y') }} Todos los derechos reservados FECOER</p>
            </div>
        </div>

    @elseif($access === 'pending')
        {{-- ===== BOLETA PENDIENTE DE PAGO ===== --}}
        <div class="stream-container narrow">
            <div class="stream-header">
                <img src="/images/logo-fecoer.png" alt="FECOER" style="height: 160px; width: auto; filter: drop-shadow(0 0 10px rgba(201,168,76,0.35)); margin-bottom: 8px;">
                <div class="stream-title">Transmisi&oacute;n</div>
            </div>

            <div class="stream-card stream-card--padded">
                <div class="card-corner-tr"></div>
                <div class="card-corner-bl"></div>

                <div class="status-icon status-icon--pending">
                    <svg viewBox="0 0 24 24" fill="none" stroke="#c9a84c" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"/>
                        <polyline points="12 6 12 12 16 14"/>
                    </svg>
                </div>

                <h2 class="message-heading message-heading--pending">Pago pendiente</h2>
                <p class="message-text">
                    Tu boleta virtual est&aacute; pendiente de pago.<br>
                    Una vez confirmado el pago, podr&aacute;s acceder a la transmisi&oacute;n en vivo.
                </p>

                <a href="/" class="btn-gold">Volver al inicio</a>
            </div>

            <div class="stream-footer">
                <p style="margin-top: 28px;">Copyright &copy; {{ date('Y') }} Todos los derechos reservados FECOER</p>
            </div>
        </div>

    @else
        {{-- ===== ACCESO DENEGADO: Sin boleta ===== --}}
        <div class="stream-container narrow">
            <div class="stream-header">
                <img src="/images/logo-fecoer.png" alt="FECOER" style="height: 160px; width: auto; filter: drop-shadow(0 0 10px rgba(201,168,76,0.35)); margin-bottom: 8px;">
                <div class="stream-title">Transmisi&oacute;n</div>
            </div>

            <div class="stream-card stream-card--padded">
                <div class="card-corner-tr"></div>
                <div class="card-corner-bl"></div>

                <div class="status-icon status-icon--lock">
                    <svg viewBox="0 0 24 24" fill="none" stroke="#f39c12" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                        <path d="M7 11V7a5 5 0 0110 0v4"/>
                    </svg>
                </div>

                <h2 class="message-heading message-heading--lock">Acceso restringido</h2>
                <p class="message-text">
                    Necesitas una boleta <strong>virtual</strong> pagada para acceder a la transmisi&oacute;n en vivo del evento.
                </p>

                <a href="/#entradas" class="btn-gold">Adquirir boleta</a>
            </div>

            <div class="stream-footer">
                <p style="margin-top: 28px;">Copyright &copy; {{ date('Y') }} Todos los derechos reservados FECOER</p>
            </div>
        </div>
    @endif

    <script>
        (function() {
            var container = document.getElementById('particles');
            var types = ['glow', 'soft', 'bright'];

            for (var i = 0; i < 50; i++) {
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

            for (var j = 0; j < 25; j++) {
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
