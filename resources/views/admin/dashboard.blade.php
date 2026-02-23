@extends('admin.layout')

@section('title', 'Dashboard')

@section('content')
    <h1 class="page-title">Panel de Administraci&oacute;n</h1>
    <p class="page-subtitle">Bienvenido, {{ Auth::user()->name }}</p>

    <div class="stats-grid">
        <!-- Total Usuarios -->
        <div class="stat-card">
            <div class="stat-card-header">
                <div class="stat-card-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"/>
                    </svg>
                </div>
            </div>
            <div class="stat-card-value">{{ number_format($totalUsuarios) }}</div>
            <div class="stat-card-label">Total Usuarios</div>
        </div>

        <!-- Total Órdenes -->
        <div class="stat-card">
            <div class="stat-card-header">
                <div class="stat-card-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
            </div>
            <div class="stat-card-value">{{ number_format($totalOrdenes) }}</div>
            <div class="stat-card-label">Total &Oacute;rdenes</div>
        </div>

        <!-- Donaciones Recaudadas -->
        <div class="stat-card">
            <div class="stat-card-header">
                <div class="stat-card-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
            <div class="stat-card-value">${{ number_format($totalDonaciones, 0, ',', '.') }}</div>
            <div class="stat-card-label">Donaciones Recaudadas</div>
        </div>

        <!-- Órdenes Pendientes -->
        <div class="stat-card">
            <div class="stat-card-header">
                <div class="stat-card-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
            <div class="stat-card-value">{{ number_format($ordenesPendientes) }}</div>
            <div class="stat-card-label">&Oacute;rdenes Pendientes</div>
        </div>
    </div>
@endsection
