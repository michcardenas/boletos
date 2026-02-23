@extends('admin.layout')

@section('title', 'Configuración')

@section('content')
    <h1 class="page-title">Configuraci&oacute;n</h1>
    <p class="page-subtitle">Administra los ajustes del sistema y del evento</p>

    <div class="config-grid">
        <!-- Pasarela de Pagos -->
        <a href="{{ route('admin.pasarela.edit') }}" class="config-card" style="text-decoration: none; cursor: pointer; transition: all 0.3s ease;">
            <div class="config-card-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                </svg>
            </div>
            <h4>Pasarela de Pagos</h4>
            <p>Configuraci&oacute;n de ePayco y credenciales de integraci&oacute;n</p>
            @if(App\Models\SiteContent::isEpaycoConfigured())
                <span class="config-badge" style="background: rgba(46, 204, 113, 0.15); color: #2ecc71; border-color: rgba(46, 204, 113, 0.3);">Activo</span>
            @else
                <span class="config-badge" style="background: rgba(243, 156, 18, 0.15); color: #f39c12; border-color: rgba(243, 156, 18, 0.3);">Pendiente</span>
            @endif
        </a>

        <!-- Configuración de Contenido -->
        <a href="{{ route('admin.contenido.index') }}" class="config-card" style="text-decoration: none; cursor: pointer; transition: all 0.3s ease;">
            <div class="config-card-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
            </div>
            <h4>Configuraci&oacute;n de Contenido</h4>
            <p>Textos, im&aacute;genes, secciones y contenido visible en el sitio del evento</p>
            <span class="config-badge" style="background: rgba(46, 204, 113, 0.15); color: #2ecc71; border-color: rgba(46, 204, 113, 0.3);">Activo</span>
        </a>

        <!-- Configuración Streaming -->
        <a href="{{ route('admin.streaming.config') }}" class="config-card" style="text-decoration: none; cursor: pointer; transition: all 0.3s ease;">
            <div class="config-card-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                </svg>
            </div>
            <h4>Configuraci&oacute;n Streaming</h4>
            <p>Configuraci&oacute;n de la transmisi&oacute;n en vivo del evento</p>
            @if(App\Models\SiteContent::isStreamingActive())
                <span class="config-badge" style="background: rgba(231, 76, 60, 0.15); color: #e74c3c; border-color: rgba(231, 76, 60, 0.3);">En Vivo</span>
            @else
                <span class="config-badge" style="background: rgba(149, 165, 166, 0.15); color: #95a5a6; border-color: rgba(149, 165, 166, 0.3);">Inactivo</span>
            @endif
        </a>
    </div>
@endsection
