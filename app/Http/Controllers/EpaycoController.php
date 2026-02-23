<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\SiteContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class EpaycoController extends Controller
{
    /**
     * Response URL: ePayco redirects the customer here after payment.
     */
    public function response(Request $request): View
    {
        $refPayco = $request->query('ref_payco');

        if (!$refPayco) {
            return view('checkout-result', [
                'status'  => 'error',
                'message' => 'No se recibi&oacute; referencia de pago.',
                'order'   => null,
            ]);
        }

        try {
            $response = Http::timeout(15)->get(
                "https://secure.epayco.co/validation/v1/reference/{$refPayco}"
            );

            $data = $response->json();

            if (!$data || !isset($data['data'])) {
                throw new \Exception('Invalid response from ePayco');
            }

            $txData    = $data['data'];
            $orderId   = $txData['x_extra1'] ?? null;
            $xResponse = $txData['x_response'] ?? '';

            $order = $orderId ? Order::find($orderId) : null;

            $statusMap = [
                'Aceptada'  => 'approved',
                'Rechazada' => 'rejected',
                'Pendiente' => 'pending',
                'Fallida'   => 'failed',
            ];

            $displayStatus = $statusMap[$xResponse] ?? 'unknown';

            return view('checkout-result', [
                'status'   => $displayStatus,
                'order'    => $order,
                'txData'   => $txData,
                'refPayco' => $refPayco,
            ]);

        } catch (\Exception $e) {
            Log::error('ePayco response error: ' . $e->getMessage());

            return view('checkout-result', [
                'status'  => 'error',
                'message' => 'Error verificando el estado del pago. Por favor contacta soporte.',
                'order'   => null,
            ]);
        }
    }

    /**
     * Confirmation URL: ePayco sends server-to-server webhook here.
     */
    public function confirmation(Request $request)
    {
        $refPayco       = $request->input('x_ref_payco');
        $xSignature     = $request->input('x_signature');
        $xCodResponse   = $request->input('x_cod_response');
        $xTransactionId = $request->input('x_transaction_id');
        $xAmount        = $request->input('x_amount');
        $extra1         = $request->input('x_extra1');

        Log::info('ePayco confirmation received', $request->all());

        if (!$refPayco) {
            return response('Missing ref_payco', 400);
        }

        // Validate signature
        $pCustId = SiteContent::get('epayco_p_cust_id', '');
        $pKey    = SiteContent::get('epayco_p_key', '');

        $signature = hash('sha256',
            $pCustId . '^' .
            $pKey . '^' .
            $refPayco . '^' .
            $xTransactionId . '^' .
            $xAmount . '^' .
            'COP'
        );

        if ($xSignature !== $signature) {
            Log::warning('ePayco invalid signature', [
                'expected'  => $signature,
                'received'  => $xSignature,
                'ref_payco' => $refPayco,
            ]);
            return response('Invalid signature', 400);
        }

        $order = Order::find($extra1);

        if (!$order) {
            Log::warning('ePayco order not found', ['extra1' => $extra1]);
            return response('Order not found', 404);
        }

        // Map x_cod_response to order status
        // 1=Aceptada, 2=Rechazada, 3=Pendiente, 4=Fallida,
        // 6=Reversada, 7=Retenida, 8=Iniciada, 9=Expirada, 10=Abandonada
        switch ((int) $xCodResponse) {
            case 1: // Aceptada
                $order->status            = 'paid';
                $order->payment_method    = 'epayco';
                $order->payment_reference = $refPayco;
                break;
            case 2:  // Rechazada
            case 4:  // Fallida
            case 6:  // Reversada
            case 10: // Abandonada
                if ($order->status !== 'paid') {
                    $order->status            = 'cancelled';
                    $order->payment_method    = 'epayco';
                    $order->payment_reference = $refPayco;
                }
                break;
            case 3:  // Pendiente
            case 7:  // Retenida
            case 8:  // Iniciada
            case 9:  // Expirada
                if ($order->status !== 'paid') {
                    $order->status            = 'pending';
                    $order->payment_method    = 'epayco';
                    $order->payment_reference = $refPayco;
                }
                break;
        }

        $order->save();

        Log::info('ePayco order updated', [
            'order_id'     => $order->id,
            'status'       => $order->status,
            'cod_response' => $xCodResponse,
        ]);

        return response('OK', 200);
    }
}
