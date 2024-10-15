<?php

use App\Http\Middleware\HandleModelNotFound;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ProdutoController;

Route::middleware([HandleModelNotFound::class])->group(function () {
    Route::apiResource('clientes', ClienteController::class);
    Route::apiResource('produtos', ProdutoController::class);
    Route::apiResource('pedidos', PedidoController::class);
});
