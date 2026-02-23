<?php

namespace App\Http\Controllers;

use App\Mail\OrderApprovedMail;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function dashboard(): View
    {
        $totalUsuarios = User::count();
        $totalOrdenes = Order::count();
        $totalDonaciones = Order::where('status', 'paid')->sum('total');
        $ordenesPendientes = Order::where('status', 'pending')->count();

        return view('admin.dashboard', compact(
            'totalUsuarios',
            'totalOrdenes',
            'totalDonaciones',
            'ordenesPendientes'
        ));
    }

    public function usuarios(): View
    {
        $usuarios = User::with('roles')->latest()->paginate(15);

        return view('admin.usuarios', compact('usuarios'));
    }

    public function clientes(): View
    {
        $ordenes = Order::latest()->paginate(15);

        return view('admin.clientes', compact('ordenes'));
    }

    public function pagos(Request $request): View
    {
        $query = Order::latest();

        if ($request->filled('status')) {
            $query->where('status', $request->query('status'));
        }

        $ordenes = $query->paginate(15);
        $statusActual = $request->query('status', 'todos');

        return view('admin.pagos', compact('ordenes', 'statusActual'));
    }

    public function updateOrderStatus(Request $request, Order $order): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'in:pending,paid,cancelled,refunded'],
        ]);

        $newStatus = $validated['status'];

        if ($order->status === $newStatus) {
            return redirect()->route('admin.pagos')
                ->with('info', 'La orden ya tiene el estado seleccionado.');
        }

        $order->status = $newStatus;

        if ($newStatus === 'paid' && !$order->payment_method) {
            $order->payment_method = 'manual';
        }

        $order->save();

        $statusLabels = [
            'pending'   => 'Pendiente',
            'paid'      => 'Pagado',
            'cancelled' => 'Cancelado',
            'refunded'  => 'Reembolsado',
        ];

        $message = "Orden #{$order->id} actualizada a \"{$statusLabels[$newStatus]}\".";

        if ($newStatus === 'paid') {
            Mail::to($order->email)->send(new OrderApprovedMail($order));
            $message .= ' Se ha enviado el correo de confirmacion con la boleta al cliente.';
        }

        return redirect()->route('admin.pagos')
            ->with('success', $message);
    }

    public function configuracion(): View
    {
        return view('admin.configuracion');
    }
}
