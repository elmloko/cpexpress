<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PaqueteApiController;
use App\Http\Controllers\Api\EventoApiController;
use App\Http\Controllers\Auth\DashboardController;
use App\Http\Controllers\Api\KardexApiController;

// Ruta de prueba
Route::get('/test', function () {
    return response()->json(['message' => 'API funcionando']);
});

Route::get('/paquetes', [PaqueteApiController::class, 'index']);
Route::post('/paquetes/dar-baja', [PaqueteApiController::class, 'darBaja']);


Route::get('/eventos', [EventoApiController::class, 'eventosPorCodigo']);

/* Route::middleware('auth:sanctum')->group(function () { */
Route::get('/kardex-bajas', [KardexApiController::class, 'getBajas']);
/* }); */
Route::get('/kardex-bajas', [KardexApiController::class, 'getBajasPorFecha']);
