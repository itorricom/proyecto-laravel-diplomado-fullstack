<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductoApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('api')->group(function () {
    // API de Productos (CRUD RESTful)
    Route::prefix('productos')->group(function () {
        Route::get('/', [ProductoApiController::class, 'index'])->name('api.productos.index');
        Route::post('/', [ProductoApiController::class, 'store'])->name('api.productos.store');
        Route::get('{id}', [ProductoApiController::class, 'show'])->name('api.productos.show');
        Route::put('{id}', [ProductoApiController::class, 'update'])->name('api.productos.update');
        Route::patch('{id}', [ProductoApiController::class, 'update'])->name('api.productos.patch');
        Route::delete('{id}', [ProductoApiController::class, 'destroy'])->name('api.productos.destroy');
    });
});
