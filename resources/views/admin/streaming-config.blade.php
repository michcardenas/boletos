@extends('admin.layout')

@section('title', 'Configuración Streaming')

@section('content')
    <div style="margin-bottom: 24px;">
        <a href="{{ route('admin.configuracion') }}" style="color: var(--text-secondary); text-decoration: none; font-size: 0.85rem; display: inline-flex; align-items: center; gap: 6px;">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Volver a configuraci&oacute;n
        </a>
    </div>

    <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 8px; flex-wrap: wrap;">
        <h1 class="page-title" style="margin-bottom: 0;">Configuraci&oacute;n Streaming</h1>
        @if($isActive)
            <span style="display: inline-flex; align-items: center; gap: 6px; padding: 4px 14px; border-radius: 50px; background: rgba(46, 204, 113, 0.15); border: 1px solid rgba(46, 204, 113, 0.3); color: #2ecc71; font-size: 0.75rem; font-weight: 600; letter-spacing: 0.5px; animation: pulse-live 2s ease-in-out infinite;">
                <span style="width: 8px; height: 8px; border-radius: 50%; background: #2ecc71;"></span>
                En Vivo
            </span>
        @else
            <span style="display: inline-flex; align-items: center; gap: 6px; padding: 4px 14px; border-radius: 50px; background: rgba(149, 165, 166, 0.15); border: 1px solid rgba(149, 165, 166, 0.3); color: #95a5a6; font-size: 0.75rem; font-weight: 600; letter-spacing: 0.5px;">
                <span style="width: 8px; height: 8px; border-radius: 50%; background: #95a5a6;"></span>
                Inactivo
            </span>
        @endif
    </div>
    <p class="page-subtitle">Configura la transmisi&oacute;n en vivo del evento por YouTube</p>

    <style>
        @keyframes pulse-live {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.6; }
        }
    </style>

    @if(session('success'))
        <div style="background: rgba(46, 204, 113, 0.15); border: 1px solid rgba(46, 204, 113, 0.3); color: #2ecc71; padding: 12px 20px; border-radius: 8px; margin-bottom: 24px; font-size: 0.88rem;">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div style="background: rgba(231, 76, 60, 0.15); border: 1px solid rgba(231, 76, 60, 0.3); color: #e74c3c; padding: 12px 20px; border-radius: 8px; margin-bottom: 24px; font-size: 0.88rem;">
            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <div class="table-container" style="padding: 24px; max-width: 650px;">
        <!-- YouTube icon -->
        <div style="text-align: center; margin-bottom: 24px; padding: 20px; background: rgba(255,255,255,0.05); border: 1px solid var(--border-gold); border-radius: 12px;">
            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#c9a84c" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M22.54 6.42a2.78 2.78 0 00-1.94-2C18.88 4 12 4 12 4s-6.88 0-8.6.46a2.78 2.78 0 00-1.94 2A29 29 0 001 11.75a29 29 0 00.46 5.33A2.78 2.78 0 003.4 19.1c1.72.46 8.6.46 8.6.46s6.88 0 8.6-.46a2.78 2.78 0 001.94-2 29 29 0 00.46-5.25 29 29 0 00-.46-5.43z"/>
                <polygon points="9.75 15.02 15.5 11.75 9.75 8.48 9.75 15.02" fill="#c9a84c"/>
            </svg>
            <p style="font-size: 0.78rem; color: var(--text-muted); margin-top: 8px;">Transmisi&oacute;n en vivo por YouTube</p>
        </div>

        <form method="POST" action="{{ route('admin.streaming.update') }}">
            @csrf
            @method('PUT')

            <!-- URL de YouTube -->
            <div style="margin-bottom: 20px;">
                <label style="display: block; font-size: 0.72rem; font-weight: 600; text-transform: uppercase; letter-spacing: 1.5px; color: var(--text-muted); margin-bottom: 10px;">
                    URL de YouTube
                </label>
                <input type="text" name="streaming_youtube_url" value="{{ old('streaming_youtube_url', $settings['streaming_youtube_url']) }}"
                    placeholder="https://www.youtube.com/watch?v=... o https://youtu.be/..."
                    style="width: 100%; padding: 13px 24px; background: rgba(255,255,255,0.93); border: none; border-radius: 50px; color: #333; font-family: 'Montserrat', sans-serif; font-size: 0.92rem; outline: none;"
                    onfocus="this.style.boxShadow='0 0 0 3px rgba(201,168,76,0.25)'" onblur="this.style.boxShadow='none'">
                <p style="font-size: 0.72rem; color: var(--text-muted); margin-top: 6px; padding-left: 24px;">
                    Formatos aceptados: youtube.com/watch?v=, youtu.be/, youtube.com/live/
                </p>
            </div>

            <!-- Título -->
            <div style="margin-bottom: 20px;">
                <label style="display: block; font-size: 0.72rem; font-weight: 600; text-transform: uppercase; letter-spacing: 1.5px; color: var(--text-muted); margin-bottom: 10px;">
                    T&iacute;tulo del streaming
                </label>
                <input type="text" name="streaming_title" value="{{ old('streaming_title', $settings['streaming_title']) }}"
                    placeholder="Ej: Segunda Gala FECOER - En Vivo"
                    style="width: 100%; padding: 13px 24px; background: rgba(255,255,255,0.93); border: none; border-radius: 50px; color: #333; font-family: 'Montserrat', sans-serif; font-size: 0.92rem; outline: none;"
                    onfocus="this.style.boxShadow='0 0 0 3px rgba(201,168,76,0.25)'" onblur="this.style.boxShadow='none'">
            </div>

            <!-- Descripción -->
            <div style="margin-bottom: 20px;">
                <label style="display: block; font-size: 0.72rem; font-weight: 600; text-transform: uppercase; letter-spacing: 1.5px; color: var(--text-muted); margin-bottom: 10px;">
                    Descripci&oacute;n / Mensaje
                </label>
                <textarea name="streaming_description" rows="4"
                    placeholder="Mensaje que aparecer&aacute; debajo del reproductor..."
                    style="width: 100%; padding: 13px 24px; background: rgba(255,255,255,0.93); border: none; border-radius: 16px; color: #333; font-family: 'Montserrat', sans-serif; font-size: 0.92rem; outline: none; resize: vertical;"
                    onfocus="this.style.boxShadow='0 0 0 3px rgba(201,168,76,0.25)'" onblur="this.style.boxShadow='none'">{{ old('streaming_description', $settings['streaming_description']) }}</textarea>
            </div>

            <!-- Streaming activo -->
            <div style="margin-bottom: 28px; padding: 16px 20px; background: rgba(46, 204, 113, 0.08); border: 1px solid rgba(46, 204, 113, 0.2); border-radius: 12px;">
                <label style="display: flex; align-items: center; gap: 12px; cursor: pointer; font-size: 0.88rem; color: var(--text-secondary);">
                    <input type="checkbox" name="streaming_enabled" value="1"
                        {{ $settings['streaming_enabled'] === 'true' ? 'checked' : '' }}
                        style="width: 20px; height: 20px; accent-color: #2ecc71; cursor: pointer;">
                    <div>
                        <span style="font-weight: 600; display: block;">Activar streaming</span>
                        <span style="font-size: 0.78rem; color: var(--text-muted);">
                            Al activar, los usuarios con boleta pagada podr&aacute;n acceder a la transmisi&oacute;n en vivo.
                        </span>
                    </div>
                </label>
            </div>

            <!-- Info -->
            <div style="margin-bottom: 24px; padding: 14px 20px; background: rgba(201, 168, 76, 0.08); border: 1px solid rgba(201, 168, 76, 0.2); border-radius: 12px; font-size: 0.82rem; color: var(--text-secondary); line-height: 1.6;">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="vertical-align: middle; margin-right: 6px; color: var(--gold-primary);">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Pega la URL de un video o transmisi&oacute;n en vivo de YouTube (no listado). Solo los usuarios registrados con boleta pagada podr&aacute;n ver el streaming en <strong>/streaming</strong>.
            </div>

            @if($isActive && !empty($settings['streaming_youtube_url']))
                @php
                    $previewEmbed = App\Models\SiteContent::getYoutubeEmbedUrl($settings['streaming_youtube_url']);
                @endphp
                @if($previewEmbed)
                    <div style="margin-bottom: 24px;">
                        <label style="display: block; font-size: 0.72rem; font-weight: 600; text-transform: uppercase; letter-spacing: 1.5px; color: var(--text-muted); margin-bottom: 10px;">
                            Vista previa
                        </label>
                        <div style="position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden; border-radius: 12px; border: 1px solid var(--border-gold);">
                            <iframe src="{{ $previewEmbed }}" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: none;" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        </div>
                    </div>
                @endif
            @endif

            <div style="display: flex; gap: 12px; align-items: center;">
                <button type="submit" style="display: inline-flex; align-items: center; gap: 8px; padding: 12px 32px; background: var(--gold-gradient); border: none; border-radius: 50px; font-family: 'Montserrat', sans-serif; font-size: 0.9rem; font-weight: 600; color: var(--bg-deep); cursor: pointer; transition: all 0.3s ease; box-shadow: 0 4px 20px rgba(201,168,76,0.25);"
                    onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Guardar configuraci&oacute;n
                </button>
                <a href="{{ route('admin.configuracion') }}" style="color: var(--text-muted); text-decoration: none; font-size: 0.85rem; padding: 12px 20px;">Cancelar</a>
            </div>
        </form>
    </div>
@endsection
