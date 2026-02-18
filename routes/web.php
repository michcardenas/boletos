<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Rutas de administración (solo admin)
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    // Aquí irán las rutas de admin (usuarios, configuración, etc.)
});

// Rutas de gestión (admin y editor)
Route::middleware(['auth', 'role:admin|editor'])->prefix('gestion')->name('gestion.')->group(function () {
    // Aquí irán las rutas de gestión (registros, boletas, donaciones, etc.)
});

require __DIR__.'/auth.php';