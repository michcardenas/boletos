@extends('admin.layout')

@section('title', 'Pasarela de Pagos')

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
        <h1 class="page-title" style="margin-bottom: 0;">Pasarela de Pagos</h1>
        @if($isConfigured)
            <span style="display: inline-flex; align-items: center; gap: 6px; padding: 4px 14px; border-radius: 50px; background: rgba(46, 204, 113, 0.15); border: 1px solid rgba(46, 204, 113, 0.3); color: #2ecc71; font-size: 0.75rem; font-weight: 600; letter-spacing: 0.5px;">
                <span style="width: 8px; height: 8px; border-radius: 50%; background: #2ecc71;"></span>
                Activa
            </span>
        @else
            <span style="display: inline-flex; align-items: center; gap: 6px; padding: 4px 14px; border-radius: 50px; background: rgba(243, 156, 18, 0.15); border: 1px solid rgba(243, 156, 18, 0.3); color: #f39c12; font-size: 0.75rem; font-weight: 600; letter-spacing: 0.5px;">
                <span style="width: 8px; height: 8px; border-radius: 50%; background: #f39c12;"></span>
                Pendiente de configuraci&oacute;n
            </span>
        @endif
    </div>
    <p class="page-subtitle">Configura las credenciales de ePayco para recibir pagos en l&iacute;nea</p>

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
        <!-- Logo ePayco -->
        <div style="text-align: center; margin-bottom: 24px; padding: 20px; background: rgba(255,255,255,0.05); border: 1px solid var(--border-gold); border-radius: 12px;">
            <svg width="140" height="40" viewBox="0 0 140 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                <text x="10" y="28" font-family="Montserrat, sans-serif" font-size="22" font-weight="700" fill="#c9a84c">ePayco</text>
            </svg>
            <p style="font-size: 0.78rem; color: var(--text-muted); margin-top: 8px;">Pasarela de pagos colombiana</p>
        </div>

        <form method="POST" action="{{ route('admin.pasarela.update') }}">
            @csrf
            @method('PUT')

            <!-- Llave pública -->
            <div style="margin-bottom: 20px;">
                <label style="display: block; font-size: 0.72rem; font-weight: 600; text-transform: uppercase; letter-spacing: 1.5px; color: var(--text-muted); margin-bottom: 10px;">
                    Llave p&uacute;blica (PUBLIC_KEY)
                </label>
                <input type="text" name="epayco_public_key" value="{{ old('epayco_public_key', $settings['epayco_public_key']) }}"
                    placeholder="Ingresa la llave p&uacute;blica de ePayco"
                    style="width: 100%; padding: 13px 24px; background: rgba(255,255,255,0.93); border: none; border-radius: 50px; color: #333; font-family: 'Montserrat', sans-serif; font-size: 0.92rem; outline: none;"
                    onfocus="this.style.boxShadow='0 0 0 3px rgba(201,168,76,0.25)'" onblur="this.style.boxShadow='none'">
            </div>

            <!-- Llave privada -->
            <div style="margin-bottom: 20px;">
                <label style="display: block; font-size: 0.72rem; font-weight: 600; text-transform: uppercase; letter-spacing: 1.5px; color: var(--text-muted); margin-bottom: 10px;">
                    Llave privada (PRIVATE_KEY)
                </label>
                <input type="password" name="epayco_private_key" value="{{ old('epayco_private_key', $settings['epayco_private_key']) }}"
                    placeholder="Ingresa la llave privada de ePayco"
                    style="width: 100%; padding: 13px 24px; background: rgba(255,255,255,0.93); border: none; border-radius: 50px; color: #333; font-family: 'Montserrat', sans-serif; font-size: 0.92rem; outline: none;"
                    onfocus="this.style.boxShadow='0 0 0 3px rgba(201,168,76,0.25)'" onblur="this.style.boxShadow='none'">
            </div>

            <!-- P_CUST_ID_CLIENTE -->
            <div style="margin-bottom: 20px;">
                <label style="display: block; font-size: 0.72rem; font-weight: 600; text-transform: uppercase; letter-spacing: 1.5px; color: var(--text-muted); margin-bottom: 10px;">
                    P_CUST_ID_CLIENTE
                </label>
                <input type="text" name="epayco_p_cust_id" value="{{ old('epayco_p_cust_id', $settings['epayco_p_cust_id']) }}"
                    placeholder="Ingresa el P_CUST_ID_CLIENTE"
                    style="width: 100%; padding: 13px 24px; background: rgba(255,255,255,0.93); border: none; border-radius: 50px; color: #333; font-family: 'Montserrat', sans-serif; font-size: 0.92rem; outline: none;"
                    onfocus="this.style.boxShadow='0 0 0 3px rgba(201,168,76,0.25)'" onblur="this.style.boxShadow='none'">
            </div>

            <!-- P_KEY -->
            <div style="margin-bottom: 20px;">
                <label style="display: block; font-size: 0.72rem; font-weight: 600; text-transform: uppercase; letter-spacing: 1.5px; color: var(--text-muted); margin-bottom: 10px;">
                    P_KEY
                </label>
                <input type="password" name="epayco_p_key" value="{{ old('epayco_p_key', $settings['epayco_p_key']) }}"
                    placeholder="Ingresa el P_KEY"
                    style="width: 100%; padding: 13px 24px; background: rgba(255,255,255,0.93); border: none; border-radius: 50px; color: #333; font-family: 'Montserrat', sans-serif; font-size: 0.92rem; outline: none;"
                    onfocus="this.style.boxShadow='0 0 0 3px rgba(201,168,76,0.25)'" onblur="this.style.boxShadow='none'">
            </div>

            <!-- Modo de prueba -->
            <div style="margin-bottom: 28px; padding: 16px 20px; background: rgba(243, 156, 18, 0.08); border: 1px solid rgba(243, 156, 18, 0.2); border-radius: 12px;">
                <label style="display: flex; align-items: center; gap: 12px; cursor: pointer; font-size: 0.88rem; color: var(--text-secondary);">
                    <input type="checkbox" name="epayco_test_mode" value="1"
                        {{ $settings['epayco_test_mode'] === 'true' ? 'checked' : '' }}
                        style="width: 20px; height: 20px; accent-color: #f39c12; cursor: pointer;">
                    <div>
                        <span style="font-weight: 600; display: block;">Modo de prueba</span>
                        <span style="font-size: 0.78rem; color: var(--text-muted);">
                            Activa este modo para usar el sandbox de ePayco. Los pagos no ser&aacute;n reales.
                        </span>
                    </div>
                </label>
            </div>

            <!-- Info -->
            <div style="margin-bottom: 24px; padding: 14px 20px; background: rgba(201, 168, 76, 0.08); border: 1px solid rgba(201, 168, 76, 0.2); border-radius: 12px; font-size: 0.82rem; color: var(--text-secondary); line-height: 1.6;">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="vertical-align: middle; margin-right: 6px; color: var(--gold-primary);">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Obt&eacute;n tus credenciales en el panel de ePayco: <strong>Dashboard &rarr; Integraci&oacute;n &rarr; Llaves API</strong>.
                Aseg&uacute;rate de usar las llaves correctas seg&uacute;n el modo (prueba o producci&oacute;n).
            </div>

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
