<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\SiteContent;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    public function show(Request $request): View|RedirectResponse
    {
        $ticketType = $request->query('ticket_type');
        $quantity   = (int) $request->query('quantity', 1);
        $donation   = (float) $request->query('donation', 0);

        if (!$ticketType || !in_array($ticketType, ['presencial', 'virtual'])) {
            return redirect('/#entradas');
        }

        $quantity = max(1, min(10, $quantity));
        $donation = max(0, $donation);
        $total    = $donation;

        $epaycoConfigured = SiteContent::isEpaycoConfigured();
        $epaycoTestMode   = SiteContent::get('epayco_test_mode', 'true') === 'true';

        return view('checkout', [
            'ticketType'        => $ticketType,
            'quantity'          => $quantity,
            'donation'          => $donation,
            'total'             => $total,
            'user'              => Auth::user(),
            'epaycoConfigured'  => $epaycoConfigured,
            'epaycoTestMode'    => $epaycoTestMode,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name'             => ['required', 'string', 'max:255'],
            'email'            => ['required', 'string', 'email', 'max:255'],
            'tipo_documento'   => ['required', 'string', 'in:CC,CE,TI,PP,NIT'],
            'numero_documento' => ['required', 'string', 'max:50'],
            'celular'          => ['required', 'string', 'max:20'],
            'organizacion'     => ['nullable', 'string', 'max:255'],
            'ticket_type'      => ['required', 'in:presencial,virtual'],
            'quantity'         => ['required', 'integer', 'min:1', 'max:10'],
            'donation'         => ['required', 'numeric', 'min:0'],
        ]);

        $total = $validated['donation'];

        $order = Order::create([
            'user_id'           => Auth::id(),
            'name'              => $validated['name'],
            'email'             => $validated['email'],
            'tipo_documento'    => $validated['tipo_documento'],
            'numero_documento'  => $validated['numero_documento'],
            'celular'           => $validated['celular'],
            'organizacion'      => $validated['organizacion'],
            'ticket_type'       => $validated['ticket_type'],
            'quantity'          => $validated['quantity'],
            'donation'          => $validated['donation'],
            'unit_price'        => 0,
            'subtotal'          => 0,
            'total'             => $total,
            'status'            => 'pending',
        ]);

        if (SiteContent::isEpaycoConfigured() && $total > 0) {
            return redirect()->route('checkout.pay', $order);
        }

        return redirect()->route('checkout.success', $order);
    }

    public function pay(Order $order): View|RedirectResponse
    {
        if ($order->status !== 'pending') {
            return redirect()->route('checkout.success', $order);
        }

        $epaycoPublicKey = SiteContent::get('epayco_public_key', '');
        $epaycoTestMode  = SiteContent::get('epayco_test_mode', 'true') === 'true';

        if (empty($epaycoPublicKey)) {
            return redirect()->route('checkout.success', $order);
        }

        return view('checkout-pay', [
            'order'           => $order,
            'epaycoPublicKey' => $epaycoPublicKey,
            'epaycoTestMode'  => $epaycoTestMode,
        ]);
    }

    public function success(Order $order): View
    {
        return view('checkout-success', ['order' => $order]);
    }
}
