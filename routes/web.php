<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\EpaycoController;
use App\Http\Controllers\PaymentSettingsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AliadoController;
use App\Http\Controllers\SiteContentController;
use App\Http\Controllers\StreamingController;
use App\Models\Order;
use App\Models\SiteContent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    if (Auth::check() && Auth::user()->hasRole('admin')) {
        return redirect()->route('admin.dashboard');
    }
    $user = Auth::user();
    $orders = Order::where('user_id', $user->id)
        ->orWhere('email', $user->email)
        ->latest()
        ->get();
    $hasPaidVirtualTicket = $orders->where('status', 'paid')->where('ticket_type', 'virtual')->isNotEmpty();
    $streamingActive = SiteContent::isStreamingActive();
    return view('dashboard', compact('user', 'orders', 'hasPaidVirtualTicket', 'streamingActive'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Checkout (accesible para guests y usuarios logueados)
Route::get('/checkout', [CheckoutController::class, 'show'])->name('checkout');
Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
Route::get('/checkout/{order}/pay', [CheckoutController::class, 'pay'])->name('checkout.pay');
Route::get('/checkout/{order}/success', [CheckoutController::class, 'success'])->name('checkout.success');

// ePayco (respuesta y webhook)
Route::get('/epayco/response', [EpaycoController::class, 'response'])->name('epayco.response');
Route::post('/epayco/confirmation', [EpaycoController::class, 'confirmation'])->name('epayco.confirmation');

// Streaming (requiere autenticación)
Route::get('/streaming', [StreamingController::class, 'watch'])->middleware('auth')->name('streaming.watch');

// Rutas de administración (solo admin)
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/usuarios', [AdminController::class, 'usuarios'])->name('usuarios');
    Route::get('/clientes', [AdminController::class, 'clientes'])->name('clientes');
    Route::get('/pagos', [AdminController::class, 'pagos'])->name('pagos');
    Route::patch('/pagos/{order}/status', [AdminController::class, 'updateOrderStatus'])->name('pagos.updateStatus');
    Route::post('/pagos/{order}/resend', [AdminController::class, 'resendTicket'])->name('pagos.resend');
    Route::get('/configuracion', [AdminController::class, 'configuracion'])->name('configuracion');
    Route::get('/contenido', [SiteContentController::class, 'index'])->name('contenido.index');
    Route::get('/contenido/{content}/editar', [SiteContentController::class, 'edit'])->name('contenido.edit');
    Route::put('/contenido/{content}', [SiteContentController::class, 'update'])->name('contenido.update');
    Route::get('/aliados', [AliadoController::class, 'index'])->name('aliados.index');
    Route::get('/aliados/crear', [AliadoController::class, 'create'])->name('aliados.create');
    Route::post('/aliados', [AliadoController::class, 'store'])->name('aliados.store');
    Route::get('/aliados/{aliado}/editar', [AliadoController::class, 'edit'])->name('aliados.edit');
    Route::put('/aliados/{aliado}', [AliadoController::class, 'update'])->name('aliados.update');
    Route::delete('/aliados/{aliado}', [AliadoController::class, 'destroy'])->name('aliados.destroy');
    Route::get('/pasarela', [PaymentSettingsController::class, 'edit'])->name('pasarela.edit');
    Route::put('/pasarela', [PaymentSettingsController::class, 'update'])->name('pasarela.update');
    Route::get('/streaming', [StreamingController::class, 'config'])->name('streaming.config');
    Route::put('/streaming', [StreamingController::class, 'updateConfig'])->name('streaming.update');
});

// Rutas de gestión (admin y editor)
Route::middleware(['auth', 'role:admin|editor'])->prefix('gestion')->name('gestion.')->group(function () {
    // Aquí irán las rutas de gestión (registros, boletas, donaciones, etc.)
});

require __DIR__.'/auth.php';