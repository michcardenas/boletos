@extends('admin.layout')

@section('title', 'Clientes')

@section('content')
    <h1 class="page-title">Clientes</h1>
    <p class="page-subtitle">Registro de &oacute;rdenes y clientes del evento</p>

    <div class="table-container">
        <div class="table-header">
            <span class="table-title">{{ $ordenes->total() }} &oacute;rdenes registradas</span>
        </div>

        <div class="table-scroll">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>#Orden</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Documento</th>
                        <th>Celular</th>
                        <th>Tipo Entrada</th>
                        <th>Cantidad</th>
                        <th>Donaci&oacute;n</th>
                        <th>Total</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($ordenes as $orden)
                        <tr>
                            <td>{{ $orden->id }}</td>
                            <td>{{ $orden->name }}</td>
                            <td>{{ $orden->email }}</td>
                            <td>{{ $orden->tipo_documento }} {{ $orden->numero_documento }}</td>
                            <td>{{ $orden->celular }}</td>
                            <td>{{ ucfirst($orden->ticket_type) }}</td>
                            <td>{{ $orden->quantity }}</td>
                            <td>${{ number_format($orden->donation, 0, ',', '.') }}</td>
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
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10">
                                <div class="empty-state">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    <p>No hay &oacute;rdenes registradas a&uacute;n</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($ordenes->hasPages())
            <div class="pagination-wrapper">
                {{ $ordenes->links() }}
            </div>
        @endif
    </div>
@endsection
