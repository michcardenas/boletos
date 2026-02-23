@extends('admin.layout')

@section('title', 'Editar: ' . $content->label)

@section('content')
    <div style="margin-bottom: 24px;">
        <a href="{{ route('admin.contenido.index') }}" style="color: var(--text-secondary); text-decoration: none; font-size: 0.85rem; display: inline-flex; align-items: center; gap: 6px; transition: color 0.2s;">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Volver a contenidos
        </a>
    </div>

    <h1 class="page-title">Editar contenido</h1>
    <p class="page-subtitle">{{ $content->label }} &mdash; Secci&oacute;n: {{ $content->section }}</p>

    @if($errors->any())
        <div style="background: rgba(231, 76, 60, 0.15); border: 1px solid rgba(231, 76, 60, 0.3); color: #e74c3c; padding: 12px 20px; border-radius: 8px; margin-bottom: 24px; font-size: 0.88rem;">
            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <div class="table-container" style="padding: 24px;">
        <form method="POST" action="{{ route('admin.contenido.update', $content) }}">
            @csrf
            @method('PUT')

            <div style="margin-bottom: 8px;">
                <label style="display: block; font-size: 0.72rem; font-weight: 600; text-transform: uppercase; letter-spacing: 1.5px; color: var(--text-muted); margin-bottom: 10px;">
                    Clave: <span style="color: var(--gold-primary);">{{ $content->key }}</span>
                </label>
            </div>

            <div style="margin-bottom: 20px;">
                @if($content->type === 'text')
                    <input
                        type="text"
                        name="value"
                        value="{{ old('value', $content->value) }}"
                        style="width: 100%; padding: 13px 24px; background: rgba(255,255,255,0.93); border: none; border-radius: 50px; color: #333; font-family: 'Montserrat', sans-serif; font-size: 0.92rem; outline: none; transition: all 0.35s ease;"
                        onfocus="this.style.boxShadow='0 0 0 3px rgba(201,168,76,0.25), 0 0 20px rgba(201,168,76,0.1)'"
                        onblur="this.style.boxShadow='none'"
                    >
                @else
                    <textarea
                        name="value"
                        rows="{{ $content->type === 'html' ? 10 : 5 }}"
                        style="width: 100%; padding: 16px 24px; background: rgba(255,255,255,0.93); border: none; border-radius: 16px; color: #333; font-family: 'Montserrat', sans-serif; font-size: 0.92rem; outline: none; resize: vertical; min-height: 120px; transition: all 0.35s ease;"
                        onfocus="this.style.boxShadow='0 0 0 3px rgba(201,168,76,0.25), 0 0 20px rgba(201,168,76,0.1)'"
                        onblur="this.style.boxShadow='none'"
                    >{{ old('value', $content->value) }}</textarea>
                @endif
            </div>

            <div style="display: flex; gap: 12px; align-items: center;">
                <button type="submit" style="display: inline-flex; align-items: center; gap: 8px; padding: 12px 32px; background: var(--gold-gradient); border: none; border-radius: 50px; font-family: 'Montserrat', sans-serif; font-size: 0.9rem; font-weight: 600; color: var(--bg-deep); cursor: pointer; transition: all 0.3s ease; box-shadow: 0 4px 20px rgba(201,168,76,0.25);"
                    onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 30px rgba(201,168,76,0.4)'"
                    onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 20px rgba(201,168,76,0.25)'"
                >
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Guardar cambios
                </button>
                <a href="{{ route('admin.contenido.index') }}" style="color: var(--text-muted); text-decoration: none; font-size: 0.85rem; padding: 12px 20px;">Cancelar</a>
            </div>
        </form>
    </div>

    <!-- Vista previa -->
    <div style="margin-top: 24px;">
        <div class="table-container" style="padding: 24px;">
            <h3 style="font-size: 0.72rem; font-weight: 600; text-transform: uppercase; letter-spacing: 1.5px; color: var(--text-muted); margin-bottom: 16px;">Vista previa actual</h3>
            <div style="padding: 20px; background: rgba(201, 168, 76, 0.04); border: 1px solid var(--border-gold); border-radius: 8px; color: var(--text-primary); font-size: 0.92rem; line-height: 1.7;">
                {!! nl2br(e($content->value)) !!}
            </div>
        </div>
    </div>
@endsection
