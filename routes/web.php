<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\PagosController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CertificadoController;
use App\Http\Controllers\EquipoController;
use App\Http\Controllers\InscripcionIndividualController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\ReportesController;
use Illuminate\Foundation\Application;
use Inertia\Inertia;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/',[WelcomeController::class, 'index']);

Route::middleware(['auth', 'checkrole:admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/participantes', [DashboardController::class, 'list_participantes'])->name('participantes');
    Route::post('/get_inscripciones_by_game', [InscripcionIndividualController::class, 'get_inscripciones_by_game']); 
    Route::post('/update_pago', [PagosController::class, 'update_pago']); 
});

Route::middleware('auth')->group(function () {
    Route::get('/certificado', [CertificadoController::class, 'index'])->name('certificado');;
    Route::get('/carrito', [CarritoController::class, 'index'])->name('carrito');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/guardar_all_inscripciones', [InscripcionIndividualController::class, 'guardar_all_inscripciones'])->name('inscripciones');
    // EQUIPO
    Route::get('/equipos', [EquipoController::class, 'index']);
    Route::get('/mis_equipos', [DashboardController::class, 'mis_equipos'])->name('mis_equipos');
    Route::get('/get_comprobante/{rutaImagen}', [DashboardController::class, 'get_comprobante']);
    Route::get('/equipos/{id}', [EquipoController::class, 'show']);
    Route::get('/equipos/{id}/miembros', [EquipoController::class, 'getMiembros']);
    Route::post('/equipos', [EquipoController::class, 'store']);
    Route::post('/equipo_por_juego', [EquipoController::class, 'equipo_por_juego']);
    Route::delete('/equipos/{id}', [EquipoController::class, 'destroy']);
    Route::put('/equipos/{id}', [EquipoController::class, 'update']);

    //Inscripciones
    Route::get('/get_mis_inscripciones', [InscripcionIndividualController::class, 'get_mis_inscripciones'])->name('inscripciones');
    Route::post('/report_participantes_by_game', [ReportesController::class, 'report_participantes_by_game']); 
});

require __DIR__.'/auth.php';
