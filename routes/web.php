<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\ProductoController;

// Ruta principal redirige al login
Route::get('/', function () {
    return redirect('/login');
});

// Rutas de autenticación
Route::get('/login', [UsuarioController::class, 'login'])->name('login');
Route::post('/login', [UsuarioController::class, 'verificarLogin'])->name('login.verificar');
Route::get('/logout', [UsuarioController::class, 'logout'])->name('logout');

// Rutas protegidas por middleware
Route::middleware('verify')->group(function () {
    Route::get('/dashboard', [UsuarioController::class, 'dashboard'])->name('dashboard');
    Route::resource('productos', ProductoController::class);
});
