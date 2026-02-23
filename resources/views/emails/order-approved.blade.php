<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body style="margin: 0; padding: 0; background-color: #152536; font-family: Arial, Helvetica, sans-serif;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #152536; padding: 40px 20px;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="background-color: #0e1c2a; border: 1px solid rgba(201,168,76,0.3); border-radius: 8px; overflow: hidden;">

                    <!-- Header -->
                    <tr>
                        <td align="center" style="padding: 32px 40px 20px; border-bottom: 1px solid rgba(201,168,76,0.2);">
                            <img src="{{ $message->embed(public_path('images/logo-fecoer.png')) }}" alt="FECOER" height="80" style="height: 80px; width: auto;">
                            <h1 style="color: #c9a84c; font-size: 22px; margin: 16px 0 4px; font-family: Arial, Helvetica, sans-serif; letter-spacing: 1px;">Pago Confirmado</h1>
                            <p style="color: #607080; font-size: 13px; margin: 0;">Segunda Gala de Reconocimientos FECOER</p>
                        </td>
                    </tr>

                    <!-- Greeting -->
                    <tr>
                        <td style="padding: 28px 40px 0;">
                            <p style="color: #eae6dc; font-size: 15px; font-family: Arial, Helvetica, sans-serif; margin: 0 0 12px;">
                                Hola <strong style="color: #c9a84c;">{{ $order->name }}</strong>,
                            </p>
                            <p style="color: #bfc5cc; font-size: 14px; line-height: 1.6; font-family: Arial, Helvetica, sans-serif; margin: 0;">
                                Tu pago ha sido confirmado exitosamente. Adjunto encontrar&aacute;s tu(s) boleta(s) para el evento.
                            </p>
                        </td>
                    </tr>

                    <!-- Order Details -->
                    <tr>
                        <td style="padding: 24px 40px;">
                            <table width="100%" cellpadding="0" cellspacing="0" style="background-color: rgba(201,168,76,0.08); border: 1px solid rgba(201,168,76,0.25); border-radius: 6px;">
                                <!-- Order Number -->
                                <tr>
                                    <td style="padding: 12px 20px; color: #607080; font-size: 13px; font-family: Arial, Helvetica, sans-serif; border-bottom: 1px solid rgba(201,168,76,0.1); width: 45%;">
                                        N&uacute;mero de Orden
                                    </td>
                                    <td style="padding: 12px 20px; color: #eae6dc; font-size: 13px; font-weight: 600; font-family: Arial, Helvetica, sans-serif; border-bottom: 1px solid rgba(201,168,76,0.1);">
                                        #{{ $order->id }}
                                    </td>
                                </tr>
                                <!-- Ticket Type -->
                                <tr>
                                    <td style="padding: 12px 20px; color: #607080; font-size: 13px; font-family: Arial, Helvetica, sans-serif; border-bottom: 1px solid rgba(201,168,76,0.1);">
                                        Tipo de Entrada
                                    </td>
                                    <td style="padding: 12px 20px; color: #eae6dc; font-size: 13px; font-weight: 600; font-family: Arial, Helvetica, sans-serif; border-bottom: 1px solid rgba(201,168,76,0.1);">
                                        {{ $order->ticket_type === 'presencial' ? 'Presencial' : 'Virtual' }}
                                    </td>
                                </tr>
                                <!-- Quantity -->
                                <tr>
                                    <td style="padding: 12px 20px; color: #607080; font-size: 13px; font-family: Arial, Helvetica, sans-serif; border-bottom: 1px solid rgba(201,168,76,0.1);">
                                        Cantidad de Boletas
                                    </td>
                                    <td style="padding: 12px 20px; color: #eae6dc; font-size: 13px; font-weight: 600; font-family: Arial, Helvetica, sans-serif; border-bottom: 1px solid rgba(201,168,76,0.1);">
                                        {{ $order->quantity }}
                                    </td>
                                </tr>
                                <!-- Total -->
                                <tr>
                                    <td style="padding: 14px 20px; color: #c9a84c; font-size: 14px; font-weight: 600; font-family: Arial, Helvetica, sans-serif;">
                                        Total Pagado
                                    </td>
                                    <td style="padding: 14px 20px; color: #c9a84c; font-size: 16px; font-weight: 700; font-family: Arial, Helvetica, sans-serif;">
                                        ${{ number_format($order->total, 0, ',', '.') }} COP
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Instructions -->
                    <tr>
                        <td style="padding: 0 40px 28px;">
                            @if($order->ticket_type === 'presencial')
                                <p style="color: #bfc5cc; font-size: 13px; line-height: 1.7; font-family: Arial, Helvetica, sans-serif; margin: 0;">
                                    Presenta tu boleta impresa o digital al ingreso del evento. La boleta est&aacute; adjunta en formato PDF.
                                </p>
                            @else
                                <p style="color: #bfc5cc; font-size: 13px; line-height: 1.7; font-family: Arial, Helvetica, sans-serif; margin: 0;">
                                    Tu entrada virtual incluye acceso a la transmisi&oacute;n en vivo del evento. Recibir&aacute;s el enlace de acceso al streaming antes de la fecha del evento. Tu boleta est&aacute; adjunta en formato PDF.
                                </p>
                            @endif
                        </td>
                    </tr>

                    <!-- Event Info Box -->
                    <tr>
                        <td style="padding: 0 40px 28px;">
                            <table width="100%" cellpadding="0" cellspacing="0" style="background-color: rgba(201,168,76,0.06); border: 1px solid rgba(201,168,76,0.15); border-radius: 6px;">
                                <tr>
                                    <td align="center" style="padding: 20px;">
                                        <p style="color: #c9a84c; font-size: 14px; font-weight: 600; font-family: Arial, Helvetica, sans-serif; margin: 0 0 4px;">
                                            Segunda Gala de Reconocimientos FECOER
                                        </p>
                                        <p style="color: #bfc5cc; font-size: 12px; font-family: Arial, Helvetica, sans-serif; margin: 0;">
                                            {{ \App\Models\SiteContent::get('hero_fecha', 'Viernes 27 de febrero de 2026 - 6:00 p. m.') }}
                                            &bull;
                                            {{ \App\Models\SiteContent::get('hero_lugar', 'Hotel Sonesta, Bogota') }}
                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="padding: 20px 40px; border-top: 1px solid rgba(201,168,76,0.2); text-align: center;">
                            <p style="color: #607080; font-size: 11px; font-family: Arial, Helvetica, sans-serif; margin: 0 0 4px;">
                                FECOER - Federaci&oacute;n Colombiana de Enfermedades Raras
                            </p>
                            <p style="color: #4a5568; font-size: 10px; font-family: Arial, Helvetica, sans-serif; margin: 0;">
                                &copy; {{ date('Y') }} Todos los derechos reservados
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>
