<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Juego;
use App\Models\Sponsor;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Application;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;

class WelcomeController extends Controller
{

    public function index()
    {
        $userId = Auth::id();

        $juegosGrupo = Juego::where('modalidad', 'grupo')->get()->map(function ($juego) use ($userId) {
            return [
                'id' => $juego->id,
                'nombre' => $juego->nombre,
                'costo_inscripcion' => $juego->costo_inscripcion,
                'img_id' => $juego->img_id,
                'estaInscrito' => $juego->inscripcionesGrupales->pluck('equipo')->where('user_id', $userId)->count() > 0
            ];
        });
    
        $juegosIndividual = Juego::where('modalidad', 'individual')->get()->map(function ($juego) use ($userId) {
            return [
                'id' => $juego->id,
                'nombre' => $juego->nombre,
                'costo_inscripcion' => $juego->costo_inscripcion,
                'img_id' => $juego->img_id,
                'estaInscrito' => $juego->inscripcionesIndividuales->where('user_id', $userId)->count() > 0
            ];
        });

        $sponsors = Sponsor::all();
    
        return Inertia::render('Welcome', [
            'role' => Auth::check() && Auth::user()->hasRole("admin"),
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
            'juegosGrupo' => $juegosGrupo,
            'juegosIndividual' => $juegosIndividual,
            'sponsors' => $sponsors,
        ]);
    }

}
