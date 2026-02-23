@extends('admin.layout')

@section('title', 'Aliados')

@section('content')
    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 8px; flex-wrap: wrap; gap: 12px;">
        <h1 class="page-title" style="margin-bottom: 0;">Aliados</h1>
        <a href="{{ route('admin.aliados.create') }}" style="display: inline-flex; align-items: center; gap: 8px; padding: 10px 24px; background: var(--gold-gradient); border: none; border-radius: 50px; font-family: 'Montserrat', sans-serif; font-size: 0.85rem; font-weight: 600; color: var(--bg-deep); text-decoration: none; transition: all 0.3s ease; box-shadow: 0 4px 20px rgba(201,168,76,0.25);">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Agregar aliado
        </a>
    </div>
    <p class="page-subtitle">Gestiona los logos de los aliados del evento</p>

    @if(session('success'))
        <div style="background: rgba(46, 204, 113, 0.15); border: 1px solid rgba(46, 204, 113, 0.3); color: #2ecc71; padding: 12px 20px; border-radius: 8px; margin-bottom: 24px; font-size: 0.88rem;">
            {{ session('success') }}
        </div>
    @endif

    @if($aliados->count())
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 20px;">
            @foreach($aliados as $aliado)
                <div class="stat-card" style="text-align: center; position: relative; {{ !$aliado->activo ? 'opacity: 0.5;' : '' }}">
                    @if(!$aliado->activo)
                        <span class="badge badge-cancelled" style="position: absolute; top: 12px; right: 12px;">Inactivo</span>
                    @endif
                    <div style="height: 100px; display: flex; align-items: center; justify-content: center; margin-bottom: 12px;">
                        <img src="{{ asset('storage/' . $aliado->imagen) }}" alt="{{ $aliado->nombre }}" style="max-width: 100%; max-height: 100px; object-fit: contain;">
                    </div>
                    <h4 style="font-size: 0.88rem; font-weight: 600; color: var(--text-primary); margin-bottom: 4px;">{{ $aliado->nombre }}</h4>
                    <p style="font-size: 0.72rem; color: var(--text-muted); margin-bottom: 12px;">Orden: {{ $aliado->orden }}</p>
                    <div style="display: flex; gap: 8px; justify-content: center;">
                        <a href="{{ route('admin.aliados.edit', $aliado) }}" class="btn-action">Editar</a>
                        <form method="POST" action="{{ route('admin.aliados.destroy', $aliado) }}" onsubmit="return confirm('&iquest;Eliminar este aliado?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-action" style="color: #e74c3c; border-color: rgba(231, 76, 60, 0.3);">Eliminar</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="table-container">
            <div class="empty-state">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <p>No hay aliados registrados. Agrega el primero.</p>
            </div>
        </div>
    @endif
@endsection
