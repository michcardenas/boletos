<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="/images/logo.png">
    <title>Segunda Gala de Reconocimientos - FECOER</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400;1,600&family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;1,300;1,400;1,500;1,600&family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

        :root {
            --bg-primary: #152536;
            --bg-deep: #0e1c2a;
            --bg-mid: #1a2d3e;
            --gold-primary: #c9a84c;
            --gold-light: #e8d48b;
            --gold-dark: #a07c2a;
            --gold-gradient: linear-gradient(135deg, #a07c2a 0%, #c9a84c 25%, #e8d48b 50%, #c9a84c 75%, #a07c2a 100%);
            --text-primary: #eae6dc;
            --text-secondary: #bfc5cc;
            --text-muted: #607080;
            --border-gold: rgba(201, 168, 76, 0.45);
            --border-gold-strong: rgba(232, 212, 139, 0.7);
        }

        html { scroll-behavior: smooth; }

        body {
            font-family: 'Montserrat', sans-serif;
            background: var(--bg-primary);
            color: var(--text-primary);
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* ═══ PARTÍCULAS ═══ */
        .particles-container {
            position: fixed; top: 0; left: 0;
            width: 100%; height: 100%;
            z-index: 1; pointer-events: none; overflow: hidden;
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

        /* ═══ NAVBAR ═══ */
        .navbar {
            position: fixed; top: 0; left: 0; right: 0; z-index: 100;
            background: url('/images/fondo-menu.png') center / cover no-repeat;
            background-color: var(--bg-deep);
            transition: all 0.3s ease;
        }

        .navbar-inner {
            display: flex; align-items: center; justify-content: center;
            padding: 18px 40px; position: relative;
        }

        .navbar.scrolled .navbar-inner { padding: 12px 40px; }

        .nav-links { display: flex; align-items: center; gap: 44px; }

        .nav-link {
            font-family: 'Montserrat', sans-serif; font-size: 0.84rem; font-weight: 500;
            color: var(--text-primary); text-decoration: none; letter-spacing: 0.03em;
            transition: color 0.3s ease; white-space: nowrap; text-align: center; line-height: 1.4;
        }
        .nav-link:hover { color: var(--gold-light); }

        .nav-btn-acceso {
            display: inline-flex; align-items: center; justify-content: center;
            padding: 8px 30px; background: var(--gold-gradient);
            border: none; border-radius: 50px;
            font-family: 'Cormorant Garamond', serif; font-size: 1.05rem;
            font-weight: 600; font-style: italic; color: var(--bg-deep);
            text-decoration: none; letter-spacing: 0.04em;
            transition: all 0.4s ease; box-shadow: 0 3px 15px rgba(201,168,76,0.3);
            position: relative; overflow: hidden;
        }
        .nav-btn-acceso::before {
            content: ''; position: absolute; top: 0; left: -100%;
            width: 100%; height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.35), transparent);
            transition: left 0.5s ease;
        }
        .nav-btn-acceso:hover { transform: translateY(-1px); box-shadow: 0 5px 25px rgba(201,168,76,0.4); }
        .nav-btn-acceso:hover::before { left: 100%; }

        .nav-hamburger {
            display: none; flex-direction: column; gap: 5px; cursor: pointer; padding: 5px;
            z-index: 110; position: absolute; right: 20px; top: 50%; transform: translateY(-50%);
        }
        .nav-hamburger span { display: block; width: 26px; height: 2px; background: var(--gold-primary); transition: all 0.3s ease; }
        .nav-hamburger.active span:nth-child(1) { transform: rotate(45deg) translateY(7px); }
        .nav-hamburger.active span:nth-child(2) { opacity: 0; }
        .nav-hamburger.active span:nth-child(3) { transform: rotate(-45deg) translateY(-7px); }

        /* ═══ HERO ═══ */
        .hero {
            position: relative; z-index: 2;
            min-height: 100vh; display: flex; flex-direction: column;
            justify-content: center; align-items: center;
            padding: 100px 60px 60px;
            background:
                radial-gradient(ellipse at 20% 45%, rgba(201,168,76,0.05) 0%, transparent 50%),
                radial-gradient(ellipse at 80% 20%, rgba(201,168,76,0.03) 0%, transparent 40%),
                linear-gradient(180deg, var(--bg-deep) 0%, var(--bg-primary) 30%, var(--bg-mid) 70%, var(--bg-primary) 100%);
        }

        .hero-content {
            display: flex; align-items: center; justify-content: center;
            gap: 50px; max-width: 1200px; width: 100%; margin-bottom: 50px;
        }

        .hero-left { flex: 1; display: flex; align-items: center; justify-content: center; }

        .tree-logo {
            max-width: 500px; width: 100%; height: auto;
            filter: drop-shadow(0 0 40px rgba(201,168,76,0.12));
        }

        .hero-right { flex: 1; max-width: 540px; }

        .gold-frame { position: relative; padding: 42px 40px; overflow: visible; }
        .gold-frame::before {
            content: ''; position: absolute; inset: 0;
            border: 1.5px solid var(--border-gold); pointer-events: none;
            transition: all 0.5s ease;
        }
        .gold-frame::after {
            content: ''; position: absolute; inset: 7px;
            border: 1px solid var(--border-gold-strong); pointer-events: none;
            transition: all 0.5s ease;
        }
        .gold-frame:hover::before {
            border-width: 2.5px;
            border-color: rgba(232,212,139,0.8);
            box-shadow: 0 0 15px rgba(201,168,76,0.4), inset 0 0 15px rgba(201,168,76,0.15);
        }
        .gold-frame:hover::after {
            border-width: 2px;
            border-color: rgba(232,212,139,0.9);
            box-shadow: 0 0 20px rgba(232,212,139,0.5), inset 0 0 20px rgba(232,212,139,0.2);
        }

        /* Partículas que salen del cuadro */
        .frame-particles {
            position: absolute; top: 0; right: -60px;
            width: 120px; height: 100%;
            pointer-events: none; overflow: visible; z-index: 5;
        }
        .frame-particle {
            position: absolute; border-radius: 50%;
            background: radial-gradient(circle, rgba(232,212,139,1) 0%, rgba(201,168,76,0.6) 40%, transparent 70%);
            box-shadow: 0 0 6px 2px rgba(232,212,139,0.4);
            animation: frameFloat linear infinite;
        }
        @keyframes frameFloat {
            0%   { transform: translate(0, 0) scale(0.3); opacity: 0; }
            10%  { opacity: 1; }
            50%  { opacity: 0.9; }
            100% { transform: translate(80px, -120px) scale(0.8); opacity: 0; }
        }

        .gold-frame p {
            font-family: 'Montserrat', sans-serif; font-size: 1.02rem;
            font-weight: 400; color: var(--text-primary); line-height: 1.75;
        }
        .gold-frame p + p { margin-top: 22px; }

        .hero-date { text-align: center; width: 100%; }
        .hero-date-text {
            font-family: 'Playfair Display', serif; font-weight: 700;
            font-size: 1.35rem; color: var(--gold-light); margin-bottom: 4px;
        }
        .hero-date-venue {
            font-family: 'Playfair Display', serif; font-weight: 600;
            font-size: 1.2rem; color: var(--gold-light);
        }

        /* ═══ SECCIONES ═══ */
        .section { position: relative; z-index: 2; padding: 80px 60px; max-width: 1200px; margin: 0 auto; }

        .section-title {
            font-family: 'Great Vibes', cursive;
            font-weight: 400; font-size: 3rem; color: var(--gold-light); margin-bottom: 40px;
        }

        /* ═══ ENTRADAS ═══ */
        .entradas-content { display: flex; align-items: stretch; gap: 50px; }

        .ticket-visual {
            flex: 1; display: flex; align-items: center; justify-content: center;
        }
        .ticket-img {
            width: 100%; height: auto; display: block;
            filter: drop-shadow(0 8px 40px rgba(201,168,76,0.2));
        }

        .entradas-form { flex: 1; }

        .form-group { margin-bottom: 22px; position: relative; }
        .form-label {
            display: block; font-size: 0.78rem; font-weight: 500;
            color: var(--text-secondary); margin-bottom: 8px;
            letter-spacing: 0.08em; text-transform: uppercase;
        }
        .form-input, .form-select {
            width: 100%; padding: 13px 24px;
            background: rgba(255,255,255,0.93);
            border: none; border-radius: 50px; color: #333;
            font-family: 'Montserrat', sans-serif; font-size: 0.92rem;
            font-weight: 400; letter-spacing: 0.02em;
            outline: none; transition: all 0.35s ease;
        }
        .form-input::placeholder { color: #999; font-weight: 300; }
        .form-input:focus, .form-select:focus {
            box-shadow: 0 0 0 3px rgba(201,168,76,0.25), 0 0 20px rgba(201,168,76,0.1);
        }
        .form-select {
            -webkit-appearance: none; appearance: none; cursor: pointer;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath d='M1 1l5 5 5-5' stroke='%23666' stroke-width='1.5' fill='none' stroke-linecap='round'/%3E%3C/svg%3E");
            background-repeat: no-repeat; background-position: right 20px center;
            padding-right: 48px;
        }

        .btn-gold {
            display: inline-flex; align-items: center; gap: 10px;
            padding: 12px 32px; background: var(--gold-gradient);
            border: none; border-radius: 50px;
            font-family: 'Cormorant Garamond', serif; font-size: 1.05rem;
            font-weight: 600; font-style: italic; color: var(--bg-deep);
            cursor: pointer; letter-spacing: 0.05em;
            transition: all 0.4s ease; box-shadow: 0 4px 20px rgba(201,168,76,0.25);
            position: relative; overflow: hidden; margin-top: 10px;
        }
        .btn-gold::before {
            content: ''; position: absolute; top: 0; left: -100%;
            width: 100%; height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.35), transparent);
            transition: left 0.5s ease;
        }
        .btn-gold:hover { transform: translateY(-2px); box-shadow: 0 6px 30px rgba(201,168,76,0.4); }
        .btn-gold:hover::before { left: 100%; }

        .btn-pago {
            display: inline-flex; align-items: center; gap: 16px;
            background: none; border: none; cursor: pointer;
            padding: 10px 0; margin-top: 10px; transition: all 0.4s ease;
            position: relative;
        }
        .btn-pago:hover { transform: translateY(-3px); }
        .btn-pago:hover .btn-pago-img {
            filter: drop-shadow(0 0 12px rgba(232,212,139,0.7)) drop-shadow(0 0 25px rgba(201,168,76,0.4));
            transform: scale(1.1);
        }
        .btn-pago:hover .btn-pago-text {
            text-shadow: 0 0 15px rgba(232,212,139,0.6), 0 0 30px rgba(201,168,76,0.3);
        }
        .btn-pago-img {
            width: 44px; height: 44px; object-fit: contain; flex-shrink: 0;
            filter: drop-shadow(0 0 6px rgba(201,168,76,0.3));
            transition: all 0.4s ease;
            animation: pulseGlow 2.5s ease-in-out infinite;
        }
        @keyframes pulseGlow {
            0%, 100% { filter: drop-shadow(0 0 6px rgba(201,168,76,0.3)); }
            50%      { filter: drop-shadow(0 0 14px rgba(232,212,139,0.6)); }
        }
        .btn-pago-text {
            font-family: 'Cormorant Garamond', serif; font-size: 1.3rem;
            font-weight: 600; font-style: italic; color: var(--gold-light);
            letter-spacing: 0.04em; transition: all 0.4s ease;
        }

        .entradas-note { text-align: center; margin-top: 50px; font-size: 0.95rem; color: var(--text-secondary); line-height: 1.6; }
        .entradas-note strong { color: var(--gold-light); font-weight: 600; }

        /* ═══ PROGRAMACIÓN ═══ */
        #programacion { text-align: center; }
        .programacion-img {
            width: 280px; height: 280px; object-fit: contain;
            margin: 0 auto 30px; display: block;
            filter: drop-shadow(0 8px 30px rgba(201,168,76,0.3));
        }

        /* ═══ ALIADOS ═══ */
        .aliados-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 30px; }
        .aliado-card {
            height: 100px; background: rgba(255,255,255,0.04);
            border: 1px solid rgba(255,255,255,0.07); border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            font-size: 0.85rem; font-weight: 500; color: var(--text-muted);
            letter-spacing: 0.05em; transition: all 0.3s ease;
        }
        .aliado-card:hover { border-color: rgba(201,168,76,0.3); background: rgba(201,168,76,0.05); color: var(--text-secondary); }

        /* ═══ CONTACTO ═══ */
        #contacto { text-align: center; }
        .contacto-subtitle { font-size: 1rem; color: var(--text-secondary); margin-bottom: 40px; line-height: 1.6; }
        .contacto-form { max-width: 520px; margin: 0 auto; text-align: left; }
        .form-textarea {
            width: 100%; padding: 16px 24px;
            background: rgba(255,255,255,0.93);
            border: none; border-radius: 20px; color: #333;
            font-family: 'Montserrat', sans-serif; font-size: 0.92rem;
            font-weight: 400; letter-spacing: 0.02em;
            outline: none; resize: vertical; min-height: 120px;
            transition: all 0.35s ease;
        }
        .form-textarea::placeholder { color: #999; font-weight: 300; }
        .form-textarea:focus {
            box-shadow: 0 0 0 3px rgba(201,168,76,0.25), 0 0 20px rgba(201,168,76,0.1);
        }

        /* ═══ FOOTER ═══ */
        .site-footer {
            position: relative; z-index: 2; padding: 30px 60px;
            border-top: 2px solid;
            border-image: linear-gradient(90deg, var(--gold-dark), var(--gold-light), var(--gold-primary), var(--gold-dark)) 1;
            display: flex; align-items: center; justify-content: space-between;
        }
        .footer-copy { font-size: 0.82rem; font-weight: 600; color: var(--text-primary); }
        .footer-socials { display: flex; gap: 14px; }
        .social-btn {
            width: 40px; height: 40px; background: var(--gold-gradient);
            border-radius: 50%; display: flex; align-items: center; justify-content: center;
            text-decoration: none; color: var(--bg-deep); font-weight: 700; font-size: 0.9rem;
            transition: all 0.3s ease; box-shadow: 0 2px 10px rgba(201,168,76,0.2);
        }
        .social-btn:hover { transform: translateY(-3px); box-shadow: 0 4px 20px rgba(201,168,76,0.4); }

        /* ═══ FADE IN ═══ */
        .fade-in { opacity: 0; transform: translateY(35px); transition: opacity 0.8s ease-out, transform 0.8s ease-out; }
        .fade-in.visible { opacity: 1; transform: translateY(0); }

        /* ═══ RESPONSIVE ═══ */
        @media (max-width: 900px) {
            .navbar-inner { padding: 22px 20px; }
            .navbar.scrolled .navbar-inner { padding: 16px 20px; }
            .nav-links {
                display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0;
                background: rgba(14,28,42,0.97); flex-direction: column;
                align-items: center; justify-content: center; gap: 30px; z-index: 105;
            }
            .nav-links.open { display: flex; }
            .nav-link { font-size: 1.1rem; }
            .nav-link br { display: none; }
            .nav-hamburger { display: flex; }
            .hero { padding: 100px 24px 50px; }
            .hero-content { flex-direction: column; gap: 40px; }
            .tree-logo { max-width: 300px; }
            .gold-frame { padding: 28px 24px; }
            .gold-frame p { font-size: 0.92rem; }
            .frame-particles { display: none; }
            .section { padding: 60px 24px; }
            .section-title { font-size: 1.8rem; }
            .entradas-content { flex-direction: column; }
            .ticket-visual { width: 100%; max-width: 500px; margin: 0 auto; }
            .entradas-form { width: 100%; }
            .btn-pago { justify-content: center; width: 100%; }
            .programacion-img { width: 200px; height: 200px; }
            .aliados-grid { grid-template-columns: repeat(2, 1fr); }
            .contacto-form { padding: 0 10px; }
            .site-footer { flex-direction: column; gap: 20px; text-align: center; padding: 30px 24px; }
        }
        @media (max-width: 500px) {
            .hero { padding: 90px 16px 40px; }
            .hero-content { gap: 28px; margin-bottom: 30px; }
            .tree-logo { max-width: 220px; }
            .gold-frame { padding: 22px 18px; }
            .gold-frame p { font-size: 0.85rem; }
            .section { padding: 50px 16px; }
            .section-title { font-size: 1.5rem; }
            .form-input, .form-select { padding: 11px 18px; font-size: 0.85rem; }
            .form-textarea { border-radius: 16px; }
            .programacion-img { width: 160px; height: 160px; }
            .btn-pago-text { font-size: 1.1rem; }
            .btn-pago-img { width: 38px; height: 38px; }
            .entradas-note { font-size: 0.85rem; }
            .aliados-grid { grid-template-columns: 1fr; }
            .hero-date-text { font-size: 1.1rem; }
            .hero-date-venue { font-size: 1rem; }
            .site-footer { padding: 24px 16px; }
        }
        @media (max-width: 360px) {
            .hero { padding: 80px 12px 30px; }
            .tree-logo { max-width: 180px; }
            .gold-frame { padding: 18px 14px; }
            .gold-frame p { font-size: 0.8rem; line-height: 1.6; }
            .section-title { font-size: 1.3rem; }
            .form-label { font-size: 0.72rem; }
        }
    </style>
</head>
<body>

    <div class="particles-container" id="particles"></div>

    <!-- ═══ NAVBAR ═══ -->
    <nav class="navbar" id="navbar">
        <div class="navbar-inner">
            <div class="nav-hamburger" id="navHamburger" onclick="toggleMenu()">
                <span></span><span></span><span></span>
            </div>
            <div class="nav-links" id="navLinks">
                <a href="#entradas" class="nav-link" onclick="closeMenu()">Adquiere tus<br>entradas</a>
                <a href="#programacion" class="nav-link" onclick="closeMenu()">Programación<br>del evento</a>
                <a href="#aliados" class="nav-link" onclick="closeMenu()">Aliados</a>
                <a href="#contacto" class="nav-link" onclick="closeMenu()">Contáctenos</a>
                @auth
                    <a href="{{ route('dashboard') }}" class="nav-btn-acceso">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="nav-btn-acceso">Acceso</a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- ═══ HERO ═══ -->
    <section class="hero">
        <div class="hero-content">
            <div class="hero-left">
                <img src="/images/logo-fecoer.png" alt="Segunda Gala de Reconocimientos FECOER" class="tree-logo">
            </div>
            <div class="hero-right fade-in">
                <div class="gold-frame">
                    <div class="frame-particles" id="frameParticles"></div>
                    <p>{{ App\Models\SiteContent::get('hero_parrafo_1') }}</p>
                    <p>{{ App\Models\SiteContent::get('hero_parrafo_2') }}</p>
                </div>
            </div>
        </div>
        <div class="hero-date fade-in">
            <div class="hero-date-text">{{ App\Models\SiteContent::get('hero_fecha') }}</div>
            <div class="hero-date-venue">{{ App\Models\SiteContent::get('hero_lugar') }}</div>
        </div>
    </section>

    <!-- ═══ ENTRADAS ═══ -->
    <section class="section" id="entradas">
        <div class="section-title fade-in">Adquiere tus entradas</div>
        <div class="entradas-content">
            <div class="ticket-visual fade-in">
                <img src="/images/boleto.png" alt="Boleto Segunda Gala de Reconocimientos FECOER" class="ticket-img">
            </div>
            <div class="entradas-form fade-in">
                <form method="GET" action="{{ route('checkout') }}">
                    <div class="form-group">
                        <label class="form-label">Tipo de entrada</label>
                        <select name="ticket_type" class="form-select" required>
                            <option value="">Seleccionar...</option>
                            <option value="presencial">Presencial</option>
                            <option value="virtual">Virtual</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Cantidad de boletas</label>
                        <input type="number" name="quantity" class="form-input" min="1" max="11" value="1" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Donación</label>
                        <input type="text" id="donationDisplay" class="form-input" value="0" placeholder="$ 0" inputmode="numeric">
                        <input type="hidden" name="donation" id="donationValue" value="0">
                    </div>
                    <button type="submit" class="btn-pago">
                        <img src="/images/pago.png" alt="Pago seguro" class="btn-pago-img">
                        <span class="btn-pago-text">Comprar ahora</span>
                    </button>
                </form>
            </div>
        </div>
        <p class="entradas-note fade-in">{!! App\Models\SiteContent::get('entradas_nota') !!}</p>
    </section>

    <!-- ═══ PROGRAMACIÓN ═══ -->
    <section class="section" id="programacion">
        <div class="section-title fade-in">Programación del evento</div>
        <div class="fade-in" style="text-align: center;">
            <img src="/images/programacion.png" alt="Programación del evento" class="programacion-img">
            <a href="#" class="btn-gold">Descargar</a>
        </div>
    </section>

    <!-- ═══ ALIADOS ═══ -->
    <section class="section" id="aliados">
        <div class="section-title fade-in">Aliados</div>
        <div class="aliados-grid fade-in">
            @forelse(App\Models\Aliado::where('activo', true)->orderBy('orden')->get() as $aliado)
                <div class="aliado-card">
                    <img src="{{ asset('storage/' . $aliado->imagen) }}" alt="{{ $aliado->nombre }}" style="max-width: 100%; max-height: 80px; object-fit: contain;">
                </div>
            @empty
                <div class="aliado-card">Sin aliados</div>
            @endforelse
        </div>
    </section>

    <!-- ═══ CONTACTO ═══ -->
    <section class="section" id="contacto">
        <div class="section-title fade-in">Contáctenos</div>
        <p class="contacto-subtitle fade-in">¿Tienes preguntas o deseas más información sobre nosotros?<br>No dudes en contactarnos</p>
        <div class="contacto-form fade-in">
            <form>
                <div class="form-group">
                    <label class="form-label">Nombres y apellidos</label>
                    <input type="text" class="form-input">
                </div>
                <div class="form-group">
                    <label class="form-label">Correo electrónico</label>
                    <input type="email" class="form-input">
                </div>
                <div class="form-group">
                    <label class="form-label">Mensaje</label>
                    <textarea class="form-textarea"></textarea>
                </div>
                <button type="submit" class="btn-gold">Enviar</button>
            </form>
        </div>
    </section>

    <!-- ═══ FOOTER ═══ -->
    <footer class="site-footer">
        <div class="footer-copy">Copyright &copy; {{ date('Y') }} Todos los derechos reservados FECOER</div>
        <div class="footer-socials">
            <a href="{{ App\Models\SiteContent::get('facebook_url', '#') }}" class="social-btn" title="Facebook" target="_blank">f</a>
            <a href="{{ App\Models\SiteContent::get('x_url', '#') }}" class="social-btn" title="X" target="_blank">&#x1d54f;</a>
            <a href="{{ App\Models\SiteContent::get('instagram_url', '#') }}" class="social-btn" title="Instagram" target="_blank">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><rect x="2" y="2" width="20" height="20" rx="5" stroke="currentColor" stroke-width="2" fill="none"/><circle cx="12" cy="12" r="5" stroke="currentColor" stroke-width="2" fill="none"/><circle cx="18" cy="6" r="1.5" fill="currentColor"/></svg>
            </a>
            <a href="{{ App\Models\SiteContent::get('tiktok_url', '#') }}" class="social-btn" title="TikTok" target="_blank">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M19.59 6.69a4.83 4.83 0 01-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 01-2.88 2.5 2.89 2.89 0 01-2.89-2.89 2.89 2.89 0 012.89-2.89c.28 0 .54.04.79.1v-3.52a6.37 6.37 0 00-.79-.05A6.34 6.34 0 003.15 15.2a6.34 6.34 0 006.34 6.34 6.34 6.34 0 006.34-6.34V9.19a8.16 8.16 0 004.76 1.52v-3.4a4.85 4.85 0 01-1-.62z"/></svg>
            </a>
        </div>
    </footer>

    <script>
        // ═══ PARTÍCULAS MEJORADAS ═══
        (function() {
            const c = document.getElementById('particles');
            const types = ['particle--glow', 'particle--soft', 'particle--bright'];

            // 100 partículas flotantes
            for (let i = 0; i < 100; i++) {
                const p = document.createElement('div');
                p.className = 'particle ' + types[Math.floor(Math.random() * types.length)];
                const s = Math.random() * 6 + 2.5;
                p.style.width = s + 'px';
                p.style.height = s + 'px';
                p.style.left = Math.random() * 100 + '%';
                p.style.top = Math.random() * 100 + '%';
                p.style.animationDuration = (Math.random() * 12 + 10) + 's';
                p.style.animationDelay = (Math.random() * 12) + 's';
                c.appendChild(p);
            }

            // 50 partículas estáticas que titilan
            for (let i = 0; i < 50; i++) {
                const p = document.createElement('div');
                p.className = 'particle particle--static';
                const s = Math.random() * 4 + 2;
                p.style.width = s + 'px';
                p.style.height = s + 'px';
                p.style.left = Math.random() * 100 + '%';
                p.style.top = Math.random() * 100 + '%';
                p.style.animationDuration = (Math.random() * 4 + 2) + 's';
                p.style.animationDelay = (Math.random() * 5) + 's';
                c.appendChild(p);
            }
        })();

        // ═══ PARTÍCULAS DEL CUADRO DORADO ═══
        (function() {
            const fc = document.getElementById('frameParticles');
            if (!fc) return;
            for (let i = 0; i < 35; i++) {
                const p = document.createElement('div');
                p.className = 'frame-particle';
                const s = Math.random() * 5 + 2;
                p.style.width = s + 'px';
                p.style.height = s + 'px';
                p.style.top = Math.random() * 70 + '%';
                p.style.left = Math.random() * 50 + '%';
                p.style.animationDuration = (Math.random() * 6 + 4) + 's';
                p.style.animationDelay = (Math.random() * 10) + 's';
                fc.appendChild(p);
            }
        })();

        // ═══ NAVBAR SCROLL ═══
        window.addEventListener('scroll', function() {
            document.getElementById('navbar').classList.toggle('scrolled', window.scrollY > 50);
        });

        // ═══ MOBILE MENU ═══
        function toggleMenu() {
            document.getElementById('navLinks').classList.toggle('open');
            document.getElementById('navHamburger').classList.toggle('active');
        }
        function closeMenu() {
            document.getElementById('navLinks').classList.remove('open');
            document.getElementById('navHamburger').classList.remove('active');
        }

        // ═══ DONACIÓN CON SEPARADOR DE MILES ═══
        (function() {
            const display = document.getElementById('donationDisplay');
            const hidden = document.getElementById('donationValue');

            function formatNumber(n) {
                return n.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            }

            display.addEventListener('input', function() {
                let raw = this.value.replace(/\./g, '').replace(/[^0-9]/g, '');
                let num = parseInt(raw) || 0;
                hidden.value = num;
                this.value = formatNumber(num);
            });

            display.addEventListener('focus', function() {
                if (this.value === '0') this.value = '';
            });

            display.addEventListener('blur', function() {
                if (this.value === '') {
                    this.value = '0';
                    hidden.value = 0;
                }
            });
        })();

        // ═══ FADE IN ═══
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(e => { if (e.isIntersecting) e.target.classList.add('visible'); });
        }, { threshold: 0.12 });
        document.querySelectorAll('.fade-in').forEach(el => observer.observe(el));
    </script>
</body>
</html>