@extends('admin.layout')

@section('title', 'Editar Aliado')

@section('content')
    <div style="margin-bottom: 24px;">
        <a href="{{ route('admin.aliados.index') }}" style="color: var(--text-secondary); text-decoration: none; font-size: 0.85rem; display: inline-flex; align-items: center; gap: 6px;">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Volver a aliados
        </a>
    </div>

    <h1 class="page-title">Editar Aliado</h1>
    <p class="page-subtitle">{{ $aliado->nombre }}</p>

    @if($errors->any())
        <div style="background: rgba(231, 76, 60, 0.15); border: 1px solid rgba(231, 76, 60, 0.3); color: #e74c3c; padding: 12px 20px; border-radius: 8px; margin-bottom: 24px; font-size: 0.88rem;">
            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <div class="table-container" style="padding: 24px; max-width: 600px;">
        <form method="POST" action="{{ route('admin.aliados.update', $aliado) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div style="margin-bottom: 20px;">
                <label style="display: block; font-size: 0.72rem; font-weight: 600; text-transform: uppercase; letter-spacing: 1.5px; color: var(--text-muted); margin-bottom: 10px;">Nombre del aliado</label>
                <input type="text" name="nombre" value="{{ old('nombre', $aliado->nombre) }}" required
                    style="width: 100%; padding: 13px 24px; background: rgba(255,255,255,0.93); border: none; border-radius: 50px; color: #333; font-family: 'Montserrat', sans-serif; font-size: 0.92rem; outline: none;"
                    onfocus="this.style.boxShadow='0 0 0 3px rgba(201,168,76,0.25)'" onblur="this.style.boxShadow='none'">
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; font-size: 0.72rem; font-weight: 600; text-transform: uppercase; letter-spacing: 1.5px; color: var(--text-muted); margin-bottom: 10px;">Logo actual</label>
                <div style="padding: 16px; background: rgba(255,255,255,0.05); border: 1px solid var(--border-gold); border-radius: 12px; text-align: center; margin-bottom: 12px;">
                    <img src="{{ asset('storage/' . $aliado->imagen) }}" alt="{{ $aliado->nombre }}" style="max-height: 80px; object-fit: contain;">
                </div>
                <label style="display: block; font-size: 0.72rem; font-weight: 600; text-transform: uppercase; letter-spacing: 1.5px; color: var(--text-muted); margin-bottom: 10px;">Cambiar imagen (opcional)</label>
                <input type="file" name="imagen" accept="image/*" id="imagenInput"
                    style="width: 100%; padding: 12px; background: rgba(255,255,255,0.08); border: 1px dashed var(--border-gold); border-radius: 12px; color: var(--text-secondary); font-family: 'Montserrat', sans-serif; font-size: 0.85rem; cursor: pointer;">
                <div id="preview" style="margin-top: 12px; display: none; text-align: center;">
                    <img id="previewImg" style="max-height: 100px; object-fit: contain; border-radius: 8px;">
                </div>
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; font-size: 0.72rem; font-weight: 600; text-transform: uppercase; letter-spacing: 1.5px; color: var(--text-muted); margin-bottom: 10px;">URL del aliado (opcional)</label>
                <input type="url" name="url" value="{{ old('url', $aliado->url) }}" placeholder="https://..."
                    style="width: 100%; padding: 13px 24px; background: rgba(255,255,255,0.93); border: none; border-radius: 50px; color: #333; font-family: 'Montserrat', sans-serif; font-size: 0.92rem; outline: none;"
                    onfocus="this.style.boxShadow='0 0 0 3px rgba(201,168,76,0.25)'" onblur="this.style.boxShadow='none'">
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; font-size: 0.72rem; font-weight: 600; text-transform: uppercase; letter-spacing: 1.5px; color: var(--text-muted); margin-bottom: 10px;">Orden de aparici&oacute;n</label>
                <input type="number" name="orden" value="{{ old('orden', $aliado->orden) }}" min="0"
                    style="width: 120px; padding: 13px 24px; background: rgba(255,255,255,0.93); border: none; border-radius: 50px; color: #333; font-family: 'Montserrat', sans-serif; font-size: 0.92rem; outline: none;"
                    onfocus="this.style.boxShadow='0 0 0 3px rgba(201,168,76,0.25)'" onblur="this.style.boxShadow='none'">
            </div>

            <div style="margin-bottom: 24px;">
                <label style="display: flex; align-items: center; gap: 10px; cursor: pointer; font-size: 0.88rem; color: var(--text-secondary);">
                    <input type="checkbox" name="activo" value="1" {{ old('activo', $aliado->activo) ? 'checked' : '' }}
                        style="width: 18px; height: 18px; accent-color: var(--gold-primary); cursor: pointer;">
                    Activo (visible en la p&aacute;gina)
                </label>
            </div>

            <div style="display: flex; gap: 12px; align-items: center;">
                <button type="submit" style="display: inline-flex; align-items: center; gap: 8px; padding: 12px 32px; background: var(--gold-gradient); border: none; border-radius: 50px; font-family: 'Montserrat', sans-serif; font-size: 0.9rem; font-weight: 600; color: var(--bg-deep); cursor: pointer; transition: all 0.3s ease; box-shadow: 0 4px 20px rgba(201,168,76,0.25);"
                    onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Guardar cambios
                </button>
                <a href="{{ route('admin.aliados.index') }}" style="color: var(--text-muted); text-decoration: none; font-size: 0.85rem; padding: 12px 20px;">Cancelar</a>
            </div>
        </form>
    </div>

    <script>
        document.getElementById('imagenInput').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(ev) {
                    document.getElementById('previewImg').src = ev.target.result;
                    document.getElementById('preview').style.display = 'block';
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
@endsection
