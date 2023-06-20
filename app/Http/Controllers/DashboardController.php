<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\InscripcionGrupal;
use App\Models\InscripcionIndividual;
use App\Models\Juego;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Application;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{

    public function index()
    {
        $inscripciones_data = $this->get_inscripciones_data();
    
        return Inertia::render('Dashboard', [
            'role' => Auth::check() && Auth::user()->hasRole("admin"),
            'canRegister' => Route::has('register'),
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
            'inscripciones_data' => $inscripciones_data
        ]);
    }
    

    private function get_inscripciones_data() {
        // Obtener el número de inscripciones grupales
        $numeroInscripcionesGrupales = InscripcionGrupal::count();

        // Obtener el número de inscripciones individuales
        $numeroInscripcionesIndividuales = InscripcionIndividual::count();

        // Obtener la suma de inscripciones grupales con el costo de inscripción del juego
        $sumaInscripcionesGrupales = InscripcionGrupal::join('juegos', 'inscripciones_grupales.id_juego', '=', 'juegos.id')
            ->sum('juegos.costo_inscripcion');

        // Obtener la suma de inscripciones individuales con el costo de inscripción del juego
        $sumaInscripcionesIndividuales = InscripcionIndividual::join('juegos', 'inscripciones_individuales.id_juego', '=', 'juegos.id')
            ->sum('juegos.costo_inscripcion');

        // Calcular el ingreso total
        $ingresosTotales = $sumaInscripcionesGrupales + $sumaInscripcionesIndividuales;

        return [
            'numero_inscripciones_grupales' => $numeroInscripcionesGrupales,
            'numero_inscripciones_individuales' => $numeroInscripcionesIndividuales,
            'numero_inscripciones_totales' => ($numeroInscripcionesGrupales+$numeroInscripcionesIndividuales),
            'suma_inscripciones_grupales' => $sumaInscripcionesGrupales,
            'suma_inscripciones_individuales' => $sumaInscripcionesIndividuales,
            'ingresos_totales' => $ingresosTotales
        ];
    }


    public function list_participantes()
    {
        return Inertia::render('DashboardPage/ParticipantesPage/ListParticipantes', [
            'role' => Auth::user()->hasRole("admin"),
        ]);
    }

    public function mis_equipos(){
        return Inertia::render('DashboardPage/ParticipantesPage/EquiposPage',[
            'user_id' => Auth::user()->id,
            'role' => Auth::user()->hasRole("admin"),
        ]);
    }


public function get_comprobante($rutaImagen) {
    // Verificamos que el archivo exista
    if(Storage::exists('/app/'+$rutaImagen)) {
        // Obtenemos el contenido del archivo
        $file = Storage::get('/app/'+$rutaImagen);
        
        // Creamos una respuesta con el contenido del archivo
        $response = new Response($file, 200);

        // Definimos el tipo de contenido en la respuesta
        $response->header("Content-Type", Storage::mimeType($rutaImagen));

        // Retornamos la respuesta
        return $response;
    } else {
        // Si el archivo no existe, retornamos un mensaje de error
        return response()->json(['error' => 'File not found.'], 404);
    }
}

}
