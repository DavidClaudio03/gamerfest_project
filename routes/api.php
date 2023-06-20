<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\CertificadoController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\EquipoController;
use App\Http\Controllers\JuegoController;
use App\Http\Controllers\SponsorController;
use App\Http\Controllers\ParticipanteController;


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

Route::middleware('auth')->get('/user', function (Request $request) {
    return $request->user();
});

/** ------------------------------ ENDPOINTS ABIERTOS ---------------------------------------- **/
// Juego
Route::get('/juegos',      [JuegoController::class, 'index']);
Route::get('/juegos/{id}', [JuegoController::class, 'show']);
Route::post('/juegos/cargar-carrito', [JuegoController::class, 'cargarCarrito']);

Route::get('api/sponsors',      [SponsorController::class, 'index']);

//Roles y Permisos
Route::get('/roles', [RoleController::class, 'index']);
Route::get('/roles/{role}', [RoleController::class, 'show']);
Route::get('/roles/{role}/hasPermission/{permissionName}', [RoleController::class, 'hasPermission']);

Route::get('/permissions', [PermissionController::class, 'index']);
Route::get('/permissions/{permission}', [PermissionController::class, 'show']);


/** ------------------------------ ENDPOINTS AUTH  ---------------------------------------- **/

Route::middleware(['auth'])->group(function () {
    
    //Certificados
    Route::get('/certificado', [CertificadoController::class, 'index']);
    
    // Equipo
    Route::get('/equipos', [EquipoController::class, 'index']);
    Route::get('/equipos/{id}', [EquipoController::class, 'show']);
    Route::get('/equipos/{id}/miembros', [EquipoController::class, 'getMiembros']);
    Route::post('/equipos', [EquipoController::class, 'store']);
    Route::delete('/equipos/{id}', [EquipoController::class, 'destroy']);
    Route::put('/equipos/{id}', [EquipoController::class, 'update']);

    // Ganadores Individuales
    Route::get('/ganadores_individuales', [GanadorIndividualController::class, 'index']);
    Route::get('/ganadores_individuales/{id}', [GanadorIndividualController::class, 'show']);
    
    // Ganadores Grupales
    Route::get('/ganadores_grupales', [GanadorGrupalController::class, 'index']);
    Route::get('/ganadores_grupales/{id}', [GanadorGrupalController::class, 'show']);

    // Inscripcion Individual
    Route::get('/inscripciones_individuales', [InscripcionIndividualController::class, 'index']);
    Route::get('/inscripciones_individuales/{id}', [InscripcionIndividualController::class, 'show']);
    Route::post('/inscripciones_individuales', [InscripcionIndividualController::class, 'store']);
    Route::delete('/inscripciones_individuales/{id}', [InscripcionIndividualController::class, 'destroy']);
    Route::put('/inscripciones_individuales/{id}', [InscripcionIndividualController::class, 'update']);
    


    // Inscripcion Grupal
    Route::get('/inscripciones_grupales', [InscripcionGrupalController::class, 'index']);
    Route::get('/inscripciones_grupales/{id}', [InscripcionGrupalController::class, 'show']);
    Route::post('/inscripciones_grupales', [InscripcionGrupalController::class, 'store']);
    Route::delete('/inscripciones_grupales/{id}', [InscripcionGrupalController::class, 'destroy']);
    Route::put('/inscripciones_grupales/{id}', [InscripcionGrupalController::class, 'update']);

});

/** ------------------------------ ENDPOINTS ADMIN ---------------------------------------- **/


Route::middleware(['auth:sanctum', 'checkrole:admin'])->group(function () {
    // Juego    
    Route::post('/juegos', [JuegoController::class, 'store']);
    Route::delete('/juegos/{id}', [JuegoController::class, 'destroy']);
    Route::put('/juegos/{id}', [JuegoController::class, 'update']);

    // Ganadores Individuales
    Route::post('/ganadores_individuales', [GanadorIndividualController::class, 'store']);
    Route::delete('/ganadores_individuales/{id}', [GanadorIndividualController::class, 'destroy']);
    Route::put('/ganadores_individuales/{id}', [GanadorIndividualController::class, 'update']);

    // Ganadores Grupales
    Route::post('/ganadores_grupales', [GanadorGrupalController::class, 'store']);
    Route::delete('/ganadores_grupales/{id}', [GanadorGrupalController::class, 'destroy']);
    Route::put('/ganadores_grupales/{id}', [GanadorGrupalController::class, 'update']);

});

