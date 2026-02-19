<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [UsuarioController::class, 'login'])->name('login');
Route::post('/login', [UsuarioController::class, 'verificarLogin'])->name('login.verificar');
Route::get('/logout', [UsuarioController::class, 'logout'])->name('logout');
//Route::post('/logout', [UsuarioController::class, 'logout'])->name('logout');

Route::get('/verificar', [UsuarioController::class, 'verificador'])->middleware('verify');
Route::get('/dashboard', [UsuarioController::class, 'dashboard'])->middleware('verify')->name('dashboard');
