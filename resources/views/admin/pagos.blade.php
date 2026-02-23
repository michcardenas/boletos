@extends('admin.layout')

@section('title', 'Detalles de Pago')

@section('content')
    <h1 class="page-title">Detalles de Pago</h1>
    <p class="page-subtitle">Seguimiento de pagos y transacciones</p>

    @if(session('success'))
        <div style="background: rgba(46, 204, 113, 0.15); border: 1px solid rgba(46, 204, 113, 0.3); color: #2ecc71; padding: 12px 20px; border-radius: 8px; margin-bottom: 24px; font-size: 0.88rem;">
            {{ session('success') }}
        </div>
    @endif

    @if(session('info'))
        <div style="background: rgba(201, 168, 76, 0.15); border: 1px solid rgba(201, 168, 76, 0.3); color: #c9a84c; padding: 12px 20px; border-radius: 8px; margin-bottom: 24px; font-size: 0.88rem;">
            {{ session('info') }}
        </div>
    @endif

    @if(session('error'))
        <div style="background: rgba(231, 76, 60, 0.15); border: 1px solid rgba(231, 76, 60, 0.3); color: #e74c3c; padding: 12px 20px; border-radius: 8px; margin-bottom: 24px; font-size: 0.88rem;">
            {{ session('error') }}
        </div>
    @endif

    <!-- Filtros por estado -->
    <div class="filters-bar">
        <a href="{{ route('admin.pagos') }}" class="filter-btn {{ $statusActual === 'todos' ? 'active' : '' }}">Todos</a>
        <a href="{{ route('admin.pagos', ['status' => 'pending']) }}" class="filter-btn {{ $statusActual === 'pending' ? 'active' : '' }}">Pendientes</a>
        <a href="{{ route('admin.pagos', ['status' => 'paid']) }}" class="filter-btn {{ $statusActual === 'paid' ? 'active' : '' }}">Pagados</a>
        <a href="{{ route('admin.pagos', ['status' => 'cancelled']) }}" class="filter-btn {{ $statusActual === 'cancelled' ? 'active' : '' }}">Cancelados</a>
        <a href="{{ route('admin.pagos', ['status' => 'refunded']) }}" class="filter-btn {{ $statusActual === 'refunded' ? 'active' : '' }}">Reembolsados</a>
    </div>

    <div class="table-container">
        <div class="table-header">
            <span class="table-title">{{ $ordenes->total() }} registros</span>
        </div>

        <div class="table-scroll">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>#Orden</th>
                        <th>Cliente</th>
                        <th>Email</th>
                        <th>Total</th>
                        <th>Estado</th>
                        <th>M&eacute;todo de Pago</th>
                        <th>Referencia</th>
                        <th>Fecha</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($ordenes as $orden)
                        <tr>
                            <td>{{ $orden->id }}</td>
                            <td>{{ $orden->name }}</td>
                            <td>{{ $orden->email }}</td>
                            <td>${{ number_format($orden->total, 0, ',', '.') }}</td>
                            <td>
                                <span class="badge badge-{{ $orden->status }}">
                                    @switch($orden->status)
                                        @case('pending') Pendiente @break
                                        @case('paid') Pagado @break
                                        @case('cancelled') Cancelado @break
                                        @case('refunded') Reembolsado @break
                                        @default {{ $orden->status }}
                                    @endswitch
                                </span>
                            </td>
                            <td>{{ $orden->payment_method ?? '—' }}</td>
                            <td>{{ $orden->payment_reference ?? '—' }}</td>
                            <td>{{ $orden->created_at->format('d/m/Y H:i') }}</td>
                            <td style="white-space: nowrap;">
                                @if($orden->status !== 'paid')
                                    <form method="POST" action="{{ route('admin.pagos.updateStatus', $orden) }}" style="display: inline;">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="paid">
                                        <button type="submit" class="btn-action" style="background: rgba(46, 204, 113, 0.15); border: 1px solid rgba(46, 204, 113, 0.3); color: #2ecc71; cursor: pointer;"
                                            onclick="return confirm('¿Aprobar pago de orden #{{ $orden->id }}?\n\nSe enviará un correo con la boleta al cliente ({{ $orden->email }}).')">
                                            Aprobar
                                        </button>
                                    </form>
                                @endif

                                @if($orden->status === 'pending')
                                    <form method="POST" action="{{ route('admin.pagos.updateStatus', $orden) }}" style="display: inline; margin-left: 4px;">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="cancelled">
                                        <button type="submit" class="btn-action" style="color: #e74c3c; border: 1px solid rgba(231, 76, 60, 0.3); background: rgba(231, 76, 60, 0.1); cursor: pointer;"
                                            onclick="return confirm('¿Cancelar la orden #{{ $orden->id }}?')">
                                            Cancelar
                                        </button>
                                    </form>
                                @endif

                                @if($orden->status === 'paid')
                                    <form method="POST" action="{{ route('admin.pagos.resend', $orden) }}" style="display: inline;">
                                        @csrf
                                        <button type="submit" class="btn-action" style="background: rgba(52, 152, 219, 0.15); border: 1px solid rgba(52, 152, 219, 0.3); color: #3498db; cursor: pointer;"
                                            onclick="return confirm('¿Reenviar boleta a {{ $orden->email }}?')">
                                            Reenviar
                                        </button>
                                    </form>

                                    <form method="POST" action="{{ route('admin.pagos.updateStatus', $orden) }}" style="display: inline; margin-left: 4px;">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="refunded">
                                        <button type="submit" class="btn-action" style="color: #9b59b6; border: 1px solid rgba(155, 89, 182, 0.3); background: rgba(155, 89, 182, 0.1); cursor: pointer;"
                                            onclick="return confirm('¿Reembolsar la orden #{{ $orden->id }}?')">
                                            Reembolsar
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9">
                                <div class="empty-state">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                    </svg>
                                    <p>No hay registros de pago</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($ordenes->hasPages())
            <div class="pagination-wrapper">
                {{ $ordenes->appends(['status' => $statusActual !== 'todos' ? $statusActual : null])->links() }}
            </div>
        @endif
    </div>
@endsection
