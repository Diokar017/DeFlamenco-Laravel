<?php

use App\Http\Controllers\Api\ClienteController;
use App\Http\Controllers\EmpresaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StripeController;

Route::get('/', function () {
    return view('main');
})->name('main');

Route::post('/checkout', [StripeController::class, "checkout"])->name('checkout');
Route::get('/success', [StripeController::class, 'success'])->name('success');

Route::prefix('empresa')->group(function () {
    Route::get('/create', [EmpresaController::class, 'create'])->name('empresas.create');
    Route::post('/store', [EmpresaController::class, 'store'])->name('empresas.store');    Route::get('/', [EmpresaController::class, 'index'])->name('empresas.index');
    Route::get('/actualizar/{id}', [EmpresaController::class, 'edit'])->name('empresas.edit');

    // Actualizar empresa (PUT o PATCH)
    Route::put('/{id}', [EmpresaController::class, 'update'])->name('empresas.update');
    Route::delete('/{id}', [EmpresaController::class, 'destroy'])->name('empresas.destroy');
    // Ruta para buscar por ID
    Route::get('/{id}', [EmpresaController::class, 'show'])
        ->where('id', '[0-9]+') // Solo acepta números para ID
        ->name('empresas.show');
    // Ruta para buscar por nombre
    Route::get('/nombre/{nombre}', [EmpresaController::class, 'showByNombre'])
        ->where('nombre', '[a-zA-Z0-9\s\-]+')
        ->name('empresas.showByNombre');
    // Ruta para buscar por CIF
    Route::get('/cif/{cif}', [EmpresaController::class, 'showByCif'])
        ->where('cif', '[A-Za-z0-9]+') // Regla básica para CIF
        ->name('empresas.showByCif');
});
