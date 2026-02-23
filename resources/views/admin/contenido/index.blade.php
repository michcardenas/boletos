@extends('admin.layout')

@section('title', 'Configuración de Contenido')

@section('content')
    <h1 class="page-title">Configuraci&oacute;n de Contenido</h1>
    <p class="page-subtitle">Edita los textos y contenidos visibles en el sitio web</p>

    @if(session('success'))
        <div style="background: rgba(46, 204, 113, 0.15); border: 1px solid rgba(46, 204, 113, 0.3); color: #2ecc71; padding: 12px 20px; border-radius: 8px; margin-bottom: 24px; font-size: 0.88rem;">
            {{ session('success') }}
        </div>
    @endif

    @forelse($sections as $sectionName => $contents)
        <div class="table-container" style="margin-bottom: 24px;">
            <div class="table-header">
                <span class="table-title">{{ $sectionName }}</span>
            </div>

            <div class="table-scroll">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th style="width: 200px;">Campo</th>
                            <th>Contenido actual</th>
                            <th style="width: 100px;">Tipo</th>
                            <th style="width: 100px;">Acci&oacute;n</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($contents as $content)
                            <tr>
                                <td style="font-weight: 500; color: var(--text-primary);">{{ $content->label }}</td>
                                <td>
                                    <div style="max-height: 60px; overflow: hidden; line-height: 1.4;">
                                        {{ Str::limit(strip_tags($content->value), 120) }}
                                    </div>
                                </td>
                                <td>
                                    <span class="badge" style="background: rgba(201, 168, 76, 0.15); color: var(--gold-primary); border: 1px solid var(--border-gold);">
                                        {{ $content->type }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.contenido.edit', $content) }}" class="btn-action">Editar</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @empty
        <div class="table-container">
            <div class="empty-state">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                <p>No hay contenido configurado. Ejecuta el seeder para cargar el contenido inicial.</p>
            </div>
        </div>
    @endforelse
@endsection
