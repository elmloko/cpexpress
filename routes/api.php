<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PaqueteApiController;
use App\Http\Controllers\Api\EventoApiController;


// Ruta de prueba
Route::get('/test', function () {
    return response()->json(['message' => 'API funcionando']);
});

Route::get('/paquetes', [PaqueteApiController::class, 'index']);
Route::post('/paquetes/dar-baja', [PaqueteApiController::class, 'darBaja']);


Route::get('/eventos', [EventoApiController::class, 'eventosPorCodigo']);
