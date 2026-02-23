<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        @page {
            margin: 0;
            size: letter;
        }

        body {
            margin: 0;
            padding: 0;
            background-color: #152536;
            font-family: 'Helvetica', 'Arial', sans-serif;
            color: #eae6dc;
        }

        .ticket-page {
            width: 100%;
            padding: 40px;
            page-break-after: always;
        }

        .ticket-page:last-child {
            page-break-after: auto;
        }

        .ticket-card {
            background-color: #0e1c2a;
            border: 2px solid #c9a84c;
            border-radius: 12px;
            padding: 40px;
        }

        .header {
            text-align: center;
            border-bottom: 1px solid rgba(201, 168, 76, 0.3);
            padding-bottom: 20px;
            margin-bottom: 28px;
        }

        .header img {
            height: 80px;
        }

        .header h1 {
            color: #c9a84c;
            font-size: 24px;
            margin: 14px 0 4px;
            letter-spacing: 1px;
        }

        .header p {
            color: #607080;
            font-size: 13px;
            margin: 0;
        }

        .ticket-type-badge {
            display: inline-block;
            padding: 6px 24px;
            border-radius: 50px;
            font-size: 14px;
            font-weight: 600;
            letter-spacing: 1px;
            text-transform: uppercase;
            margin-top: 12px;
        }

        .badge-presencial {
            background-color: rgba(201, 168, 76, 0.15);
            border: 1px solid rgba(201, 168, 76, 0.4);
            color: #c9a84c;
        }

        .badge-virtual {
            background-color: rgba(46, 204, 113, 0.15);
            border: 1px solid rgba(46, 204, 113, 0.4);
            color: #2ecc71;
        }

        .details-table {
            width: 100%;
            border-collapse: collapse;
            margin: 24px 0;
        }

        .details-table td {
            padding: 11px 16px;
            font-size: 13px;
            border-bottom: 1px solid rgba(201, 168, 76, 0.1);
        }

        .details-table .label {
            color: #607080;
            width: 35%;
        }

        .details-table .value {
            color: #eae6dc;
            font-weight: 600;
        }

        .reference-box {
            text-align: center;
            background-color: rgba(201, 168, 76, 0.1);
            border: 1px solid rgba(201, 168, 76, 0.3);
            border-radius: 8px;
            padding: 24px;
            margin: 28px 0;
        }

        .reference-label {
            font-size: 11px;
            color: #607080;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 8px;
        }

        .reference-code {
            font-size: 32px;
            color: #c9a84c;
            font-weight: 700;
            letter-spacing: 6px;
        }

        .footer {
            text-align: center;
            margin-top: 24px;
            padding-top: 16px;
            border-top: 1px solid rgba(201, 168, 76, 0.3);
        }

        .footer p {
            color: #607080;
            font-size: 10px;
            margin: 4px 0;
        }

        .corner-decoration {
            position: absolute;
            width: 40px;
            height: 40px;
            border: 1.5px solid #c9a84c;
            opacity: 0.4;
        }
    </style>
</head>
<body>
    @for($i = 1; $i <= $order->quantity; $i++)
    <div class="ticket-page">
        <div class="ticket-card">
            <div class="header">
                <img src="{{ public_path('images/logo-fecoer.png') }}" alt="FECOER">
                <h1>Boleta de Entrada</h1>
                <p>Segunda Gala de Reconocimientos FECOER</p>
                <div class="ticket-type-badge {{ $order->ticket_type === 'presencial' ? 'badge-presencial' : 'badge-virtual' }}">
                    {{ $order->ticket_type === 'presencial' ? 'Presencial' : 'Virtual' }}
                </div>
            </div>

            <table class="details-table">
                <tr>
                    <td class="label">Orden</td>
                    <td class="value">#{{ $order->id }}</td>
                </tr>
                <tr>
                    <td class="label">Nombre</td>
                    <td class="value">{{ $order->name }}</td>
                </tr>
                <tr>
                    <td class="label">Documento</td>
                    <td class="value">{{ $order->tipo_documento }} {{ $order->numero_documento }}</td>
                </tr>
                <tr>
                    <td class="label">Tipo de Entrada</td>
                    <td class="value">{{ $order->ticket_type === 'presencial' ? 'Presencial' : 'Virtual' }}</td>
                </tr>
                <tr>
                    <td class="label">Boleta</td>
                    <td class="value">{{ $i }} de {{ $order->quantity }}</td>
                </tr>
                <tr>
                    <td class="label">Fecha del Evento</td>
                    <td class="value">{{ \App\Models\SiteContent::get('hero_fecha', 'Viernes 27 de febrero de 2026 - 6:00 p. m.') }}</td>
                </tr>
                <tr>
                    <td class="label">Lugar</td>
                    <td class="value">{{ \App\Models\SiteContent::get('hero_lugar', 'Hotel Sonesta, Bogota') }}</td>
                </tr>
            </table>

            <div class="reference-box">
                <div class="reference-label">Codigo de Referencia</div>
                <div class="reference-code">{{ strtoupper(substr(md5($order->id . '-' . $i . '-' . $order->created_at), 0, 8)) }}</div>
            </div>

            <div class="footer">
                <p><strong>FECOER</strong> - Federacion Colombiana de Enfermedades Raras</p>
                @if($order->ticket_type === 'presencial')
                    <p>Presenta esta boleta impresa o digital al ingreso del evento</p>
                @else
                    <p>Recibiras el enlace de acceso al streaming antes del evento</p>
                @endif
            </div>
        </div>
    </div>
    @endfor
</body>
</html>
