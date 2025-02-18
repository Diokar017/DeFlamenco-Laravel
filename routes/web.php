<?php

use App\Http\Controllers\ClienteController;
use App\Models\Cliente;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StripeController;

Route::get('/', function () {
    return view('main');
})->name('main');

Route::post('/checkout', [StripeController::class, "checkout"])->name('checkout');
Route::get('/success', [StripeController::class, 'success'])->name('success');

Route::prefix('empresa')->group(function () {
    Route::get('/create', [EmpresaController::class, 'create'])->name('empresas.create'); // Debe ir antes
    Route::get('/', [EmpresaController::class, 'index'])->name('empresas.index');
    Route::get('/actualizar/{id}', [EmpresaController::class, 'edit'])->name('empresas.edit');

    Route::put('/{id}', [EmpresaController::class, 'update'])->name('empresas.update');
    // Actualizar empresa (PUT o PATCH)
    Route::get('/eliminar/{id}', [EmpresaController::class, 'destroy'])->name('empresas.eliminar');
    Route::get('/{id}', [EmpresaController::class, 'show'])->name('empresas.show'); // Debe ir al final
});

Route::get('/card', [ClienteController::class, 'getAll'] )->name('card');
