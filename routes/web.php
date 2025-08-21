<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TarifaController;
use App\Http\Controllers\PaqueteController;
use App\Http\Controllers\EventoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleHasPermissionController;
use App\Http\Controllers\DashboardController;

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

// ---------------------------
// Dashboard y Kardex
// ---------------------------
Route::middleware('auth')->group(function () {

    // Dashboard principal
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Kardex para todos los usuarios (solo hoy)
    Route::get('/dashboard/kardex/todos', [DashboardController::class, 'exportKardexTodos'])
        ->name('dashboard.kardex.todos');

    // Kardex para administradores (rango de fechas)
    Route::get('/dashboard/kardex/admin', [DashboardController::class, 'exportKardexAdmin'])
        //->middleware('role:Administrador') // opcional, solo administradores
        ->name('dashboard.kardex.admin');

    // Estadísticas por estado (AJAX)
    Route::get('/dashboard/state-stats', [DashboardController::class, 'stateStats'])->name('dashboard.stateStats');
    Route::get('/dashboard/state-detail', [DashboardController::class, 'detalleEstado'])->name('dashboard.stateDetail');
    Route::get('/dashboard/data/{estado}', [DashboardController::class, 'estadisticaEstado'])->name('dashboard.data');

    // Paquetes por estado y fecha
    Route::get('/paquetes/por-estado-fecha/{estado}/{fecha}', [DashboardController::class, 'paquetesPorEstadoFecha']);
});

// ---------------------------
// Eventos y Paquetes
// ---------------------------
Route::middleware('auth')->group(function () {
    Route::get('/eventos', [EventoController::class, 'getEventos']);

    Route::get('/almacen', [PaqueteController::class, 'getAlmacen']);
    Route::get('/recibir', [PaqueteController::class, 'getRecibir']);
    Route::get('/inventario', [PaqueteController::class, 'getInventario']);
    /* Route::get('/enviar', [PaqueteController::class, 'getEnviar']);
    Route::get('/despacho', [PaqueteController::class, 'getDespacho']); */
    Route::get('/todos', [PaqueteController::class, 'getTodos']);

    Route::get('/tarifa', [TarifaController::class, 'getTarifas']);
    Route::get('/peso', [TarifaController::class, 'getPesos']);
    Route::get('/empresa', [TarifaController::class, 'getEmpresas']);
});

// ---------------------------
// Usuarios
// ---------------------------
Route::middleware('auth')->group(function () {
    Route::resource('users', UserController::class);
    Route::get('users/{id}/delete', [UserController::class, 'delete'])->name('users.delete');
    Route::post('users/{id}/restore', [UserController::class, 'restore'])->name('users.restore');
    Route::put('utest/{id}/restoring', [UserController::class, 'restoring'])->name('users.restoring');
    Route::get('users/excel', [UserController::class, 'excel'])->name('users.excel');
    Route::get('users/pdf', [UserController::class, 'pdf'])->name('users.pdf');
});

// ---------------------------
// Roles
// ---------------------------
Route::middleware('auth')->group(function () {
    Route::resource('roles', RoleController::class)->except(['show']);
});

// ---------------------------
// Permisos
// ---------------------------
Route::middleware('auth')->group(function () {
    Route::resource('permissions', PermissionController::class)->except(['show']);
});

// ---------------------------
// Role Has Permission
// ---------------------------
Route::middleware('auth')->group(function () {
    Route::resource('role-has-permissions', RoleHasPermissionController::class)
        ->except(['show']);
});

// ---------------------------
// Perfil
// ---------------------------
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ---------------------------
// Vistas especiales
// ---------------------------
Route::middleware('auth')->group(function () {
    Route::view('/Rezago', 'rezago.index');
});

require __DIR__ . '/auth.php';
