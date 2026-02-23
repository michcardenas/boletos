@extends('admin.layout')

@section('title', 'Usuarios')

@section('content')
    <h1 class="page-title">Usuarios</h1>
    <p class="page-subtitle">Gestiona los usuarios registrados en el sistema</p>

    <div class="table-container">
        <div class="table-header">
            <span class="table-title">{{ $usuarios->total() }} usuarios registrados</span>
        </div>

        <div class="table-scroll">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Documento</th>
                        <th>Celular</th>
                        <th>Rol</th>
                        <th>Registro</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($usuarios as $usuario)
                        <tr>
                            <td>{{ $usuario->id }}</td>
                            <td>{{ $usuario->name }}</td>
                            <td>{{ $usuario->email }}</td>
                            <td>
                                @if($usuario->tipo_documento && $usuario->numero_documento)
                                    {{ $usuario->tipo_documento }} {{ $usuario->numero_documento }}
                                @else
                                    <span style="color: var(--text-muted);">—</span>
                                @endif
                            </td>
                            <td>{{ $usuario->celular ?? '—' }}</td>
                            <td>
                                @foreach($usuario->roles as $role)
                                    <span class="badge badge-{{ $role->name }}">{{ ucfirst($role->name) }}</span>
                                @endforeach
                                @if($usuario->roles->isEmpty())
                                    <span class="badge badge-viewer">Usuario</span>
                                @endif
                            </td>
                            <td>{{ $usuario->created_at->format('d/m/Y') }}</td>
                            <td>
                                <button class="btn-action" title="Ver detalle">Ver</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8">
                                <div class="empty-state">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197"/>
                                    </svg>
                                    <p>No hay usuarios registrados</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($usuarios->hasPages())
            <div class="pagination-wrapper">
                {{ $usuarios->links() }}
            </div>
        @endif
    </div>
@endsection
