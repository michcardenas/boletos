<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="/images/logo.png">
    <title>@yield('title', 'Admin') - FECOER</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Playfair+Display:wght@400;600;700&family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
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
            --border-gold: rgba(201, 168, 76, 0.3);
            --border-gold-strong: rgba(232, 212, 139, 0.7);
            --sidebar-width: 260px;
        }

        body {
            font-family: 'Montserrat', sans-serif;
            background: var(--bg-primary);
            color: var(--text-primary);
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* ── Sidebar ── */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: var(--bg-deep);
            border-right: 1px solid var(--border-gold);
            display: flex;
            flex-direction: column;
            z-index: 100;
            transition: transform 0.3s ease;
        }

        .sidebar-header {
            padding: 24px 20px;
            border-bottom: 1px solid var(--border-gold);
            text-align: center;
        }

        .sidebar-logo {
            width: 140px;
            height: auto;
            filter: drop-shadow(0 0 8px rgba(201, 168, 76, 0.3));
        }

        .sidebar-user {
            padding: 16px 20px;
            border-bottom: 1px solid var(--border-gold);
        }

        .sidebar-user-name {
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 4px;
        }

        .sidebar-user-role {
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: var(--gold-primary);
            font-weight: 500;
        }

        .sidebar-nav {
            flex: 1;
            padding: 16px 0;
            overflow-y: auto;
        }

        .sidebar-nav-label {
            padding: 8px 20px 6px;
            font-size: 0.65rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: var(--text-muted);
            font-weight: 600;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 20px;
            color: var(--text-secondary);
            text-decoration: none;
            font-size: 0.88rem;
            font-weight: 400;
            transition: all 0.2s ease;
            border-left: 3px solid transparent;
        }

        .nav-link:hover {
            color: var(--gold-light);
            background: rgba(201, 168, 76, 0.06);
            border-left-color: rgba(201, 168, 76, 0.3);
        }

        .nav-link.active {
            color: var(--gold-light);
            background: rgba(201, 168, 76, 0.1);
            border-left-color: var(--gold-primary);
            font-weight: 500;
        }

        .nav-link svg {
            width: 20px;
            height: 20px;
            flex-shrink: 0;
            opacity: 0.7;
        }

        .nav-link.active svg,
        .nav-link:hover svg {
            opacity: 1;
        }

        .sidebar-footer {
            padding: 16px 20px;
            border-top: 1px solid var(--border-gold);
        }

        .btn-logout {
            display: flex;
            align-items: center;
            gap: 10px;
            width: 100%;
            padding: 10px 16px;
            background: transparent;
            border: 1px solid rgba(231, 76, 60, 0.3);
            color: #e74c3c;
            border-radius: 8px;
            font-family: 'Montserrat', sans-serif;
            font-size: 0.85rem;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-logout:hover {
            background: rgba(231, 76, 60, 0.1);
            border-color: rgba(231, 76, 60, 0.5);
        }

        .btn-logout svg {
            width: 18px;
            height: 18px;
        }

        .btn-back-site {
            display: flex;
            align-items: center;
            gap: 10px;
            width: 100%;
            padding: 10px 16px;
            margin-bottom: 8px;
            background: transparent;
            border: 1px solid var(--border-gold);
            color: var(--text-secondary);
            border-radius: 8px;
            font-family: 'Montserrat', sans-serif;
            font-size: 0.85rem;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .btn-back-site:hover {
            background: rgba(201, 168, 76, 0.08);
            color: var(--gold-light);
        }

        .btn-back-site svg {
            width: 18px;
            height: 18px;
        }

        /* ── Main content ── */
        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            position: relative;
        }

        .main-content::before {
            content: '';
            position: fixed;
            top: 0;
            left: var(--sidebar-width);
            width: calc(100% - var(--sidebar-width));
            height: 100%;
            background:
                radial-gradient(ellipse at 20% 45%, rgba(201,168,76,0.04) 0%, transparent 50%),
                radial-gradient(ellipse at 80% 20%, rgba(201,168,76,0.02) 0%, transparent 40%),
                linear-gradient(180deg, var(--bg-deep) 0%, var(--bg-primary) 30%, var(--bg-mid) 70%, var(--bg-primary) 100%);
            z-index: 0;
            pointer-events: none;
        }

        /* ── Partículas (reducidas) ── */
        .particles {
            position: fixed;
            top: 0;
            left: var(--sidebar-width);
            width: calc(100% - var(--sidebar-width));
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

        /* ── Topbar móvil ── */
        .topbar-mobile {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 56px;
            background: var(--bg-deep);
            border-bottom: 1px solid var(--border-gold);
            z-index: 99;
            align-items: center;
            justify-content: space-between;
            padding: 0 16px;
        }

        .topbar-brand {
            font-family: 'Great Vibes', cursive;
            font-size: 1.3rem;
            background: var(--gold-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .btn-hamburger {
            background: none;
            border: none;
            color: var(--gold-primary);
            cursor: pointer;
            padding: 8px;
        }

        .btn-hamburger svg {
            width: 24px;
            height: 24px;
        }

        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 99;
        }

        /* ── Page content wrapper ── */
        .page-content {
            position: relative;
            z-index: 2;
            padding: 32px;
            max-width: 1400px;
        }

        .page-title {
            font-family: 'Great Vibes', cursive;
            font-size: 2.2rem;
            background: var(--gold-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 8px;
        }

        .page-subtitle {
            font-size: 0.85rem;
            color: var(--text-muted);
            margin-bottom: 28px;
        }

        /* ── Cards ── */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
            margin-bottom: 32px;
        }

        .stat-card {
            background: var(--bg-card);
            border: 1px solid var(--border-gold);
            border-radius: 12px;
            padding: 20px;
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            border-color: var(--gold-primary);
            box-shadow: 0 0 20px rgba(201, 168, 76, 0.1);
        }

        .stat-card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 12px;
        }

        .stat-card-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: rgba(201, 168, 76, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .stat-card-icon svg {
            width: 20px;
            height: 20px;
            color: var(--gold-primary);
        }

        .stat-card-value {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 4px;
        }

        .stat-card-label {
            font-size: 0.78rem;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* ── Tablas ── */
        .table-container {
            background: var(--bg-card);
            border: 1px solid var(--border-gold);
            border-radius: 12px;
            overflow: hidden;
        }

        .table-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px 20px;
            border-bottom: 1px solid var(--border-gold);
        }

        .table-title {
            font-size: 1rem;
            font-weight: 600;
            color: var(--text-primary);
        }

        .admin-table {
            width: 100%;
            border-collapse: collapse;
        }

        .admin-table thead th {
            padding: 12px 16px;
            text-align: left;
            font-size: 0.72rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--gold-primary);
            background: rgba(201, 168, 76, 0.06);
            border-bottom: 1px solid var(--border-gold);
        }

        .admin-table tbody td {
            padding: 12px 16px;
            font-size: 0.85rem;
            color: var(--text-secondary);
            border-bottom: 1px solid rgba(201, 168, 76, 0.08);
        }

        .admin-table tbody tr:hover {
            background: rgba(201, 168, 76, 0.04);
        }

        .admin-table tbody tr:last-child td {
            border-bottom: none;
        }

        /* ── Badges ── */
        .badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 50px;
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .badge-pending {
            background: rgba(241, 196, 15, 0.15);
            color: #f1c40f;
            border: 1px solid rgba(241, 196, 15, 0.3);
        }

        .badge-paid {
            background: rgba(46, 204, 113, 0.15);
            color: #2ecc71;
            border: 1px solid rgba(46, 204, 113, 0.3);
        }

        .badge-cancelled {
            background: rgba(231, 76, 60, 0.15);
            color: #e74c3c;
            border: 1px solid rgba(231, 76, 60, 0.3);
        }

        .badge-refunded {
            background: rgba(155, 89, 182, 0.15);
            color: #9b59b6;
            border: 1px solid rgba(155, 89, 182, 0.3);
        }

        .badge-admin {
            background: rgba(231, 76, 60, 0.15);
            color: #e74c3c;
            border: 1px solid rgba(231, 76, 60, 0.3);
        }

        .badge-editor {
            background: rgba(52, 152, 219, 0.15);
            color: #3498db;
            border: 1px solid rgba(52, 152, 219, 0.3);
        }

        .badge-viewer {
            background: rgba(149, 165, 166, 0.15);
            color: #95a5a6;
            border: 1px solid rgba(149, 165, 166, 0.3);
        }

        /* ── Paginación ── */
        .pagination-wrapper {
            padding: 16px 20px;
            border-top: 1px solid var(--border-gold);
            display: flex;
            justify-content: center;
        }

        .pagination-wrapper nav {
            display: flex;
            gap: 4px;
        }

        .pagination-wrapper .page-link,
        .pagination-wrapper a,
        .pagination-wrapper span {
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 0.8rem;
            color: var(--text-secondary);
            text-decoration: none;
            border: 1px solid var(--border-gold);
            transition: all 0.2s ease;
        }

        .pagination-wrapper a:hover {
            background: rgba(201, 168, 76, 0.1);
            color: var(--gold-light);
            border-color: var(--gold-primary);
        }

        .pagination-wrapper .active span,
        .pagination-wrapper span[aria-current="page"] span {
            background: rgba(201, 168, 76, 0.2);
            color: var(--gold-light);
            border-color: var(--gold-primary);
        }

        .pagination-wrapper svg {
            width: 16px;
            height: 16px;
        }

        /* ── Filtros ── */
        .filters-bar {
            display: flex;
            gap: 8px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .filter-btn {
            padding: 8px 18px;
            border-radius: 50px;
            font-size: 0.8rem;
            font-family: 'Montserrat', sans-serif;
            font-weight: 500;
            text-decoration: none;
            border: 1px solid var(--border-gold);
            color: var(--text-secondary);
            background: transparent;
            transition: all 0.2s ease;
            cursor: pointer;
        }

        .filter-btn:hover {
            background: rgba(201, 168, 76, 0.1);
            color: var(--gold-light);
            border-color: var(--gold-primary);
        }

        .filter-btn.active {
            background: rgba(201, 168, 76, 0.2);
            color: var(--gold-light);
            border-color: var(--gold-primary);
        }

        /* ── Config cards ── */
        .config-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
        }

        .config-card {
            background: var(--bg-card);
            border: 1px dashed var(--border-gold);
            border-radius: 12px;
            padding: 24px;
            text-align: center;
        }

        .config-card-icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: rgba(201, 168, 76, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 14px;
        }

        .config-card-icon svg {
            width: 24px;
            height: 24px;
            color: var(--gold-primary);
        }

        .config-card h4 {
            font-size: 1rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 8px;
        }

        .config-card p {
            font-size: 0.8rem;
            color: var(--text-muted);
            line-height: 1.5;
        }

        .config-badge {
            display: inline-block;
            margin-top: 12px;
            padding: 4px 14px;
            border-radius: 50px;
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            background: rgba(201, 168, 76, 0.1);
            color: var(--gold-primary);
            border: 1px solid var(--border-gold);
        }

        /* ── Acciones tabla ── */
        .btn-action {
            padding: 5px 12px;
            border-radius: 6px;
            font-size: 0.75rem;
            font-family: 'Montserrat', sans-serif;
            border: 1px solid var(--border-gold);
            color: var(--text-secondary);
            background: transparent;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .btn-action:hover {
            background: rgba(201, 168, 76, 0.1);
            color: var(--gold-light);
        }

        /* ── Empty state ── */
        .empty-state {
            text-align: center;
            padding: 48px 20px;
            color: var(--text-muted);
        }

        .empty-state svg {
            width: 48px;
            height: 48px;
            color: var(--text-muted);
            margin-bottom: 16px;
            opacity: 0.5;
        }

        .empty-state p {
            font-size: 0.9rem;
        }

        /* ── Responsive ── */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .sidebar-overlay.open {
                display: block;
            }

            .topbar-mobile {
                display: flex;
            }

            .main-content {
                margin-left: 0;
                padding-top: 56px;
            }

            .main-content::before {
                left: 0;
                width: 100%;
            }

            .particles {
                left: 0;
                width: 100%;
            }

            .page-content {
                padding: 20px 16px;
            }

            .page-title {
                font-size: 1.8rem;
            }

            .admin-table {
                font-size: 0.78rem;
            }

            .admin-table thead th,
            .admin-table tbody td {
                padding: 10px 12px;
            }

            /* Scroll horizontal en tablas */
            .table-scroll {
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }

            .table-scroll .admin-table {
                min-width: 600px;
            }
        }

        @media (max-width: 480px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }

            .page-title {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <!-- Topbar móvil -->
    <div class="topbar-mobile">
        <img src="{{ asset('images/logo-fecoer.png') }}" alt="FECOER" style="height: 36px; width: auto; filter: drop-shadow(0 0 6px rgba(201,168,76,0.3));">
        <button class="btn-hamburger" onclick="toggleSidebar()">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>
    </div>

    <!-- Overlay móvil -->
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <img src="{{ asset('images/logo-fecoer.png') }}" alt="FECOER" class="sidebar-logo" onerror="this.style.display='none'">
        </div>

        <div class="sidebar-user">
            <div class="sidebar-user-name">{{ Auth::user()->name }}</div>
            <div class="sidebar-user-role">
                @foreach(Auth::user()->roles as $role)
                    {{ ucfirst($role->name) }}
                @endforeach
            </div>
        </div>

        <nav class="sidebar-nav">
            <div class="sidebar-nav-label">Principal</div>

            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-4 0a1 1 0 01-1-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 01-1 1"/>
                </svg>
                Dashboard
            </a>

            <div class="sidebar-nav-label">Gesti&oacute;n</div>

            <a href="{{ route('admin.usuarios') }}" class="nav-link {{ request()->routeIs('admin.usuarios') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"/>
                </svg>
                Usuarios
            </a>

            <a href="{{ route('admin.clientes') }}" class="nav-link {{ request()->routeIs('admin.clientes') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                Clientes
            </a>

            <a href="{{ route('admin.pagos') }}" class="nav-link {{ request()->routeIs('admin.pagos') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                </svg>
                Detalles Pago
            </a>

            <div class="sidebar-nav-label">Contenido</div>

            <a href="{{ route('admin.aliados.index') }}" class="nav-link {{ request()->routeIs('admin.aliados.*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                Aliados
            </a>

            <div class="sidebar-nav-label">Sistema</div>

            <a href="{{ route('admin.configuracion') }}" class="nav-link {{ request()->routeIs('admin.configuracion') || request()->routeIs('admin.contenido.*') || request()->routeIs('admin.pasarela.*') || request()->routeIs('admin.streaming.*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                Configuraci&oacute;n
            </a>
        </nav>

        <div class="sidebar-footer">
            <a href="{{ url('/') }}" class="btn-back-site">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Volver al sitio
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-logout">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    Cerrar sesi&oacute;n
                </button>
            </form>
        </div>
    </aside>

    <!-- Partículas -->
    <div class="particles" id="particles"></div>

    <!-- Contenido principal -->
    <main class="main-content">
        <div class="page-content">
            @yield('content')
        </div>
    </main>

    <script>
        // Sidebar toggle móvil
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('open');
            document.getElementById('sidebarOverlay').classList.toggle('open');
        }

        // Partículas reducidas
        (function() {
            const container = document.getElementById('particles');
            const types = ['particle--glow', 'particle--soft', 'particle--bright'];

            // 30 floating
            for (let i = 0; i < 30; i++) {
                const p = document.createElement('div');
                const type = types[Math.floor(Math.random() * types.length)];
                p.classList.add('particle', type);
                const size = Math.random() * 3 + 1.5;
                p.style.width = size + 'px';
                p.style.height = size + 'px';
                p.style.left = Math.random() * 100 + '%';
                p.style.bottom = -(Math.random() * 20) + '%';
                p.style.animationDuration = (Math.random() * 12 + 10) + 's';
                p.style.animationDelay = (Math.random() * 12) + 's';
                container.appendChild(p);
            }

            // 15 static twinkle
            for (let i = 0; i < 15; i++) {
                const p = document.createElement('div');
                p.classList.add('particle', 'particle--static');
                const size = Math.random() * 2.5 + 1;
                p.style.width = size + 'px';
                p.style.height = size + 'px';
                p.style.left = Math.random() * 100 + '%';
                p.style.top = Math.random() * 100 + '%';
                p.style.animationDuration = (Math.random() * 4 + 2) + 's';
                p.style.animationDelay = (Math.random() * 4) + 's';
                container.appendChild(p);
            }
        })();
    </script>
</body>
</html>
