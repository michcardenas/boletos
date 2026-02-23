<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="/images/logo.png">
    <title>Pagar - FECOER</title>
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

        .pay-container {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 520px;
            padding: 20px;
            animation: fadeInUp 0.8s ease-out;
        }

        .pay-header {
            text-align: center;
            margin-bottom: 36px;
        }

        .pay-title {
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

        .pay-subtitle {
            font-family: 'Great Vibes', cursive;
            font-size: 2.2rem;
            font-weight: 400;
            color: var(--gold-light);
            line-height: 1.1;
        }

        .pay-card {
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

        .pay-card::before, .pay-card::after {
            content: '';
            position: absolute;
            width: 50px; height: 50px;
            border: 1.5px solid var(--gold-primary);
            opacity: 0.4;
        }
        .pay-card::before { top: 10px; left: 10px; border-right: none; border-bottom: none; }
        .pay-card::after { bottom: 10px; right: 10px; border-left: none; border-top: none; }

        .card-corner-tr, .card-corner-bl {
            position: absolute; width: 50px; height: 50px;
            border: 1.5px solid var(--gold-primary); opacity: 0.4;
        }
        .card-corner-tr { top: 10px; right: 10px; border-left: none; border-bottom: none; }
        .card-corner-bl { bottom: 10px; left: 10px; border-right: none; border-top: none; }

        .test-badge {
            display: inline-block;
            padding: 6px 18px;
            border-radius: 50px;
            background: rgba(243, 156, 18, 0.15);
            border: 1px solid rgba(243, 156, 18, 0.3);
            color: #f39c12;
            font-size: 0.72rem;
            font-weight: 600;
            letter-spacing: 1px;
            text-transform: uppercase;
            margin-bottom: 20px;
        }

        .order-info {
            margin-bottom: 24px;
        }

        .order-info h2 {
            font-family: 'Great Vibes', cursive;
            font-size: 1.8rem;
            color: var(--gold-light);
            margin-bottom: 8px;
        }

        .order-number {
            font-size: 0.85rem;
            color: var(--text-muted);
            letter-spacing: 0.05em;
        }

        .order-summary {
            background: rgba(201, 168, 76, 0.08);
            border: 1px solid rgba(201, 168, 76, 0.25);
            border-radius: 4px;
            padding: 20px;
            margin-bottom: 28px;
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

        .pay-message {
            font-size: 0.88rem;
            color: var(--text-secondary);
            line-height: 1.6;
            margin-bottom: 28px;
        }

        .btn-pay {
            display: inline-block;
            padding: 14px 40px;
            background: var(--gold-gradient);
            border: none;
            border-radius: 50px;
            color: var(--bg-primary);
            font-family: 'Montserrat', sans-serif;
            font-size: 1rem;
            font-weight: 600;
            text-decoration: none;
            letter-spacing: 0.03em;
            cursor: pointer;
            transition: all 0.4s ease;
            box-shadow: 0 4px 20px rgba(201, 168, 76, 0.25);
        }
        .btn-pay:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 30px rgba(201, 168, 76, 0.35);
        }

        .loading-spinner {
            display: inline-block;
            width: 48px;
            height: 48px;
            border: 3px solid rgba(201, 168, 76, 0.2);
            border-top-color: var(--gold-primary);
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin-bottom: 16px;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .pay-footer {
            text-align: center;
            margin-top: 28px;
        }
        .pay-footer p {
            font-size: 0.72rem;
            color: var(--text-muted);
            letter-spacing: 0.05em;
        }
        .pay-footer a {
            color: var(--gold-primary);
            text-decoration: none;
            font-size: 0.82rem;
        }
        .pay-footer a:hover {
            text-decoration: underline;
        }

        @media (max-width: 520px) {
            .pay-card { padding: 32px 24px; }
            .pay-subtitle { font-size: 1.8rem; }
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to   { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
    <div class="particles" id="particles"></div>

    <div class="pay-container">
        <div class="pay-header">
            <img src="/images/logo-fecoer.png" alt="FECOER" style="height: 160px; width: auto; filter: drop-shadow(0 0 10px rgba(201,168,76,0.35)); margin-bottom: 8px;">
            <div class="pay-subtitle">Completar Pago</div>
        </div>

        <div class="pay-card">
            <div class="card-corner-tr"></div>
            <div class="card-corner-bl"></div>

            @if($epaycoTestMode)
                <div class="test-badge">Modo de prueba</div>
            @endif

            <div class="order-info">
                <h2>Orden #{{ $order->id }}</h2>
                <p class="order-number">{{ $order->name }}</p>
            </div>

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
                    <span>Total a pagar</span>
                    <span>${{ number_format($order->total, 0, ',', '.') }} COP</span>
                </div>
            </div>

            <div id="loading-state">
                <div class="loading-spinner"></div>
                <p class="pay-message">Abriendo pasarela de pago...</p>
            </div>

            <div id="button-state" style="display: none;">
                <p class="pay-message">
                    Ser&aacute;s redirigido a ePayco para completar tu pago de forma segura.
                </p>
                <button type="button" class="btn-pay" id="payButton">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="vertical-align: middle; margin-right: 6px;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                    Pagar con ePayco
                </button>
            </div>
        </div>

        <div class="pay-footer">
            <p style="margin-bottom: 12px;">
                <a href="/">&larr; Volver al inicio</a>
            </p>
            <p>Copyright &copy; {{ date('Y') }} Todos los derechos reservados FECOER</p>
        </div>
    </div>

    <!-- ePayco Checkout JS -->
    <script src="https://checkout.epayco.co/checkout.js"></script>

    <script>
        (function() {
            // Particles
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

            // ePayco configuration
            var handler = ePayco.checkout.configure({
                key: '{{ $epaycoPublicKey }}',
                test: {{ $epaycoTestMode ? 'true' : 'false' }}
            });

            var paymentData = {
                name: 'Boleta FECOER - {{ $order->ticket_type === "presencial" ? "Presencial" : "Virtual" }}',
                description: 'Orden #{{ $order->id }} - {{ $order->quantity }} boleta(s) Segunda Gala FECOER',
                invoice: '{{ $order->id }}',
                currency: 'cop',
                amount: '{{ intval($order->total) }}',
                tax_base: '0',
                tax: '0',
                tax_ico: '0',
                country: 'co',
                lang: 'es',
                external: 'false',

                // Customer info
                name_billing: '{{ addslashes($order->name) }}',
                type_doc_billing: '{{ $order->tipo_documento }}',
                number_doc_billing: '{{ $order->numero_documento }}',
                mobilephone_billing: '{{ $order->celular }}',
                email_billing: '{{ $order->email }}',

                // URLs
                response: '{{ route("epayco.response") }}',
                confirmation: '{{ route("epayco.confirmation") }}',

                // Extra fields
                extra1: '{{ $order->id }}',
                extra2: '{{ $order->email }}'
            };

            function openPayment() {
                handler.open(paymentData);
            }

            // Auto-open after a short delay
            setTimeout(function() {
                try {
                    openPayment();
                } catch (e) {
                    console.error('Error opening ePayco:', e);
                }
                // Show fallback button after trying to auto-open
                document.getElementById('loading-state').style.display = 'none';
                document.getElementById('button-state').style.display = 'block';
            }, 1500);

            // Manual button
            document.getElementById('payButton').addEventListener('click', function() {
                openPayment();
            });
        })();
    </script>
</body>
</html>
