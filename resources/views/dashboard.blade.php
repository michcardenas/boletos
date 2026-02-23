<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="/images/logo.png">
    <title>Mi Cuenta - FECOER</title>
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
            overflow-x: hidden;
            position: relative;
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

        /* Navbar */
        .navbar {
            position: relative;
            z-index: 20;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px 30px;
            border-bottom: 1px solid var(--border-color);
            background: rgba(14, 28, 42, 0.8);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }

        .navbar-brand {
            font-family: 'Playfair Display', serif;
            font-size: 1.2rem;
            font-weight: 600;
            background: var(--gold-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-decoration: none;
        }

        .navbar-links {
            display: flex;
            align-items: center;
            gap: 24px;
        }

        .navbar-links a {
            color: var(--text-secondary);
            text-decoration: none;
            font-size: 0.82rem;
            font-weight: 500;
            transition: color 0.3s;
        }
        .navbar-links a:hover { color: var(--gold-light); }

        .navbar-links .btn-logout {
            color: var(--text-muted);
            background: none;
            border: 1px solid rgba(201,168,76,0.2);
            padding: 6px 16px;
            border-radius: 50px;
            font-family: 'Montserrat', sans-serif;
            font-size: 0.78rem;
            cursor: pointer;
            transition: all 0.3s;
        }
        .navbar-links .btn-logout:hover {
            border-color: var(--gold-primary);
            color: var(--gold-light);
        }

        /* Main */
        .main-content {
            position: relative;
            z-index: 10;
            max-width: 800px;
            margin: 0 auto;
            padding: 40px 20px 60px;
        }

        .page-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .page-title {
            font-family: 'Great Vibes', cursive;
            font-size: 2.6rem;
            color: var(--gold-light);
            margin-bottom: 6px;
        }

        .page-welcome {
            font-size: 0.92rem;
            color: var(--text-secondary);
        }

        .page-welcome strong {
            color: var(--gold-light);
        }

        /* Section */
        .section-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.15rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .section-title svg {
            width: 20px;
            height: 20px;
            color: var(--gold-primary);
        }

        /* Order card */
        .order-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 4px;
            padding: 24px 28px;
            margin-bottom: 16px;
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            position: relative;
            overflow: hidden;
            transition: border-color 0.3s;
        }
        .order-card:hover { border-color: rgba(201,168,76,0.4); }

        .order-card::before, .order-card::after {
            content: '';
            position: absolute;
            width: 30px; height: 30px;
            border: 1px solid var(--gold-primary);
            opacity: 0.3;
        }
        .order-card::before { top: 8px; left: 8px; border-right: none; border-bottom: none; }
        .order-card::after { bottom: 8px; right: 8px; border-left: none; border-top: none; }

        .order-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 16px;
            flex-wrap: wrap;
            gap: 8px;
        }

        .order-id {
            font-family: 'Playfair Display', serif;
            font-size: 1rem;
            font-weight: 600;
            color: var(--gold-light);
        }

        .order-date {
            font-size: 0.75rem;
            color: var(--text-muted);
        }

        .badge {
            display: inline-block;
            padding: 4px 14px;
            border-radius: 50px;
            font-size: 0.72rem;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        .badge-paid { background: rgba(46,204,113,0.15); border: 1px solid rgba(46,204,113,0.3); color: #2ecc71; }
        .badge-pending { background: rgba(201,168,76,0.15); border: 1px solid rgba(201,168,76,0.3); color: var(--gold-light); }
        .badge-cancelled { background: rgba(231,76,60,0.15); border: 1px solid rgba(231,76,60,0.3); color: #e74c3c; }

        .order-details {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }

        .order-detail {
            font-size: 0.82rem;
        }

        .order-detail-label {
            color: var(--text-muted);
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 2px;
        }

        .order-detail-value {
            color: var(--text-secondary);
        }

        .order-detail-value.total {
            color: var(--gold-light);
            font-weight: 600;
            font-size: 1.05rem;
        }

        .order-ref {
            margin-top: 12px;
            padding-top: 12px;
            border-top: 1px solid var(--border-color);
            font-size: 0.75rem;
            color: var(--text-muted);
        }

        /* Empty state */
        .empty-state {
            background: var(--bg-card);
            border: 1px dashed rgba(201,168,76,0.3);
            border-radius: 4px;
            padding: 48px 28px;
            text-align: center;
            backdrop-filter: blur(20px);
        }

        .empty-state svg {
            width: 48px;
            height: 48px;
            color: var(--text-muted);
            margin-bottom: 16px;
        }

        .empty-state p {
            color: var(--text-secondary);
            font-size: 0.92rem;
            margin-bottom: 20px;
        }

        /* Streaming card */
        .streaming-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 4px;
            padding: 24px 28px;
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .streaming-icon {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .streaming-icon svg { width: 28px; height: 28px; }

        .streaming-icon--live {
            background: rgba(231,76,60,0.15);
            border: 2px solid rgba(231,76,60,0.4);
        }

        .streaming-icon--off {
            background: rgba(149,165,166,0.1);
            border: 2px solid rgba(149,165,166,0.3);
        }

        .streaming-icon--lock {
            background: rgba(243,156,18,0.1);
            border: 2px solid rgba(243,156,18,0.3);
        }

        .streaming-info { flex: 1; }

        .streaming-info h4 {
            font-size: 0.95rem;
            color: var(--text-primary);
            margin-bottom: 4px;
        }

        .streaming-info p {
            font-size: 0.82rem;
            color: var(--text-muted);
        }

        .live-dot {
            display: inline-block;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #e74c3c;
            margin-right: 6px;
            animation: pulse-dot 2s ease-in-out infinite;
        }

        @keyframes pulse-dot {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.3; }
        }

        /* Buttons */
        .btn-gold {
            display: inline-block;
            padding: 10px 28px;
            background: var(--gold-gradient);
            border: none;
            border-radius: 50px;
            color: var(--bg-primary);
            font-family: 'Montserrat', sans-serif;
            font-size: 0.82rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.4s ease;
            box-shadow: 0 4px 15px rgba(201,168,76,0.2);
            flex-shrink: 0;
        }
        .btn-gold:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 25px rgba(201,168,76,0.3);
        }

        .btn-outline {
            display: inline-block;
            padding: 10px 28px;
            background: transparent;
            border: 1px solid rgba(201,168,76,0.3);
            border-radius: 50px;
            color: var(--gold-light);
            font-family: 'Montserrat', sans-serif;
            font-size: 0.82rem;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        .btn-outline:hover {
            border-color: var(--gold-primary);
            background: rgba(201,168,76,0.08);
        }

        .section-divider {
            margin: 36px 0;
            border: none;
            border-top: 1px solid var(--border-color);
        }

        /* Footer */
        .dash-footer {
            position: relative;
            z-index: 10;
            text-align: center;
            padding: 20px;
            font-size: 0.72rem;
            color: var(--text-muted);
            letter-spacing: 0.05em;
        }

        @media (max-width: 600px) {
            .navbar { padding: 14px 16px; }
            .navbar-links { gap: 14px; }
            .navbar-links a { font-size: 0.75rem; }
            .main-content { padding: 28px 14px 40px; }
            .page-title { font-size: 2rem; }
            .order-card { padding: 20px; }
            .order-details { grid-template-columns: 1fr; }
            .streaming-card { flex-direction: column; text-align: center; }
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
    <div class="particles" id="particles"></div>

    <!-- Navbar -->
    <nav class="navbar">
        <a href="/" class="navbar-brand">
            <img src="/images/logo-fecoer.png" alt="FECOER" style="height: 40px; width: auto; filter: drop-shadow(0 0 6px rgba(201,168,76,0.3));">
        </a>
        <div class="navbar-links">
            <a href="/">Inicio</a>
            <a href="{{ route('streaming.watch') }}">Streaming</a>
            <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                @csrf
                <button type="submit" class="btn-logout">Cerrar sesi&oacute;n</button>
            </form>
        </div>
    </nav>

    <!-- Content -->
    <div class="main-content" style="animation: fadeInUp 0.8s ease-out;">

        <div class="page-header">
            <h1 class="page-title">Mi Cuenta</h1>
            <p class="page-welcome">Bienvenido, <strong>{{ $user->name }}</strong></p>
        </div>

        <!-- Streaming section -->
        <div class="section-title">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
            </svg>
            Transmisi&oacute;n en vivo
        </div>

        <div class="streaming-card">
            @if($streamingActive && $hasPaidVirtualTicket)
                <div class="streaming-icon streaming-icon--live">
                    <svg fill="none" stroke="#e74c3c" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polygon points="5 3 19 12 5 21 5 3"/>
                    </svg>
                </div>
                <div class="streaming-info">
                    <h4><span class="live-dot"></span>Transmisi&oacute;n en vivo disponible</h4>
                    <p>Tienes acceso a la transmisi&oacute;n del evento.</p>
                </div>
                <a href="{{ route('streaming.watch') }}" class="btn-gold">Ver streaming</a>
            @elseif($streamingActive && !$hasPaidVirtualTicket)
                <div class="streaming-icon streaming-icon--lock">
                    <svg fill="none" stroke="#f39c12" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                        <path d="M7 11V7a5 5 0 0110 0v4"/>
                    </svg>
                </div>
                <div class="streaming-info">
                    <h4>Streaming disponible</h4>
                    <p>Necesitas una boleta <strong>virtual</strong> pagada para acceder a la transmisi&oacute;n.</p>
                </div>
                <a href="/#entradas" class="btn-outline">Adquirir boleta</a>
            @else
                <div class="streaming-icon streaming-icon--off">
                    <svg fill="none" stroke="#95a5a6" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="2" y="7" width="20" height="15" rx="2" ry="2"/>
                        <polyline points="17 2 12 7 7 2"/>
                    </svg>
                </div>
                <div class="streaming-info">
                    <h4>Transmisi&oacute;n no disponible</h4>
                    <p>La transmisi&oacute;n a&uacute;n no est&aacute; activa. Te notificaremos cuando comience.</p>
                </div>
            @endif
        </div>

        <hr class="section-divider">

        <!-- Orders section -->
        <div class="section-title">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
            </svg>
            Mis Boletas
        </div>

        @forelse($orders as $order)
            <div class="order-card">
                <div class="order-header">
                    <div>
                        <span class="order-id">Orden #{{ $order->id }}</span>
                        <span class="order-date">&mdash; {{ $order->created_at->format('d/m/Y H:i') }}</span>
                    </div>
                    @switch($order->status)
                        @case('paid')
                            <span class="badge badge-paid">Pagado</span>
                        @break
                        @case('cancelled')
                            <span class="badge badge-cancelled">Cancelado</span>
                        @break
                        @default
                            <span class="badge badge-pending">Pendiente</span>
                    @endswitch
                </div>

                <div class="order-details">
                    <div class="order-detail">
                        <div class="order-detail-label">Tipo de entrada</div>
                        <div class="order-detail-value">{{ $order->ticket_type === 'presencial' ? 'Presencial' : 'Virtual' }}</div>
                    </div>
                    <div class="order-detail">
                        <div class="order-detail-label">Cantidad</div>
                        <div class="order-detail-value">{{ $order->quantity }} boleta(s)</div>
                    </div>
                    <div class="order-detail">
                        <div class="order-detail-label">Donaci&oacute;n</div>
                        <div class="order-detail-value">${{ number_format($order->donation, 0, ',', '.') }} COP</div>
                    </div>
                    <div class="order-detail">
                        <div class="order-detail-label">Total</div>
                        <div class="order-detail-value total">${{ number_format($order->total, 0, ',', '.') }} COP</div>
                    </div>
                </div>

                @if($order->payment_reference)
                    <div class="order-ref">
                        M&eacute;todo: {{ $order->payment_method ?? 'N/A' }} &middot; Referencia: {{ $order->payment_reference }}
                    </div>
                @endif
            </div>
        @empty
            <div class="empty-state">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
                </svg>
                <p>A&uacute;n no tienes boletas adquiridas.</p>
                <a href="/#entradas" class="btn-gold">Adquirir boleta</a>
            </div>
        @endforelse
    </div>

    <!-- Footer -->
    <div class="dash-footer">
        <p>Copyright &copy; {{ date('Y') }} Todos los derechos reservados FECOER</p>
    </div>

    <script>
        (function() {
            var container = document.getElementById('particles');
            var types = ['glow', 'soft', 'bright'];

            for (var i = 0; i < 40; i++) {
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

            for (var j = 0; j < 20; j++) {
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
