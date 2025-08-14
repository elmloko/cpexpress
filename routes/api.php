<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PaqueteApiController;

// Ruta de prueba
Route::get('/test', function () {
    return response()->json(['message' => 'API funcionando']);
});

// Ruta real para paquetes

Route::middleware('auth:sanctum')->group(function() {
    Route::get('/paquetes', [PaqueteApiController::class, 'index']);
    Route::post('/paquetes/dar-baja', [PaqueteApiController::class, 'darBaja']);
});