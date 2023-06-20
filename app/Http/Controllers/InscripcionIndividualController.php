<?php

namespace App\Http\Controllers;

use App\Models\InscripcionIndividual;
use App\Models\InscripcionGrupal;
use App\Models\Equipo;
use App\Models\Juego;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Pagination\Paginator;

class InscripcionIndividualController extends Controller
{
    public function index()
    {
        try {
            $inscripciones = InscripcionIndividual::all();
            return response()->json($inscripciones);
        } catch (\Exception $e) {
            return response()->json(['message' => "Error al obtener las inscripciones: " . $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'user_id' => 'required|integer',
                'id_juego' => 'required|integer',
                'estado' => 'required|string',
                'comprobante_pago' => 'required|string',
                'nro_comprobante' => 'required|string',
            ]);

            $inscripcion = InscripcionIndividual::create($data);

            return response()->json([
                'data' => $inscripcion,
                'message' => 'Inscripcion creada exitosamente'
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => "Error al crear la inscripcion: " . $e->getMessage()], 500);
        }
    }

    public function show(InscripcionIndividual $inscripcionIndividual)
    {
        try {
            return response()->json($inscripcionIndividual);
        } catch (\Exception $e) {
            return response()->json(['message' => "Error al obtener la inscripcion: " . $e->getMessage()], 500);
        }
    }

    public function update(Request $request, InscripcionIndividual $inscripcionIndividual)
    {
        try {
            $data = $request->validate([
                'user_id' => 'required|integer',
                'id_juego' => 'required|integer',
                'estado' => 'required|string',
                'comprobante_pago' => 'required|string',
                'nro_comprobante' => 'required|string',
            ]);

            $inscripcionIndividual->update($data);

            return response()->json([
                'data' => $inscripcionIndividual,
                'message' => 'Inscripcion actualizada exitosamente'
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => "Error al actualizar la inscripcion: " . $e->getMessage()], 500);
        }
    }

    public function destroy(InscripcionIndividual $inscripcionIndividual)
    {
        try {
            $inscripcionIndividual->delete();

            return response()->json([
                'message' => 'Inscripcion eliminada exitosamente'
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => "Error al eliminar la inscripcion: " . $e->getMessage()], 500);
        }
    }

    public function guardar_all_inscripciones(Request $request)
{
    try {
        $data = $request->validate([
            'user_id' => 'required|integer',
            'juegos' => 'present',
            'comprobante_pago' => 'mimes:jpeg,png|max:2048',
            'nro_comprobante' => 'string',
            'valor_comprobante' => 'required|numeric',
        ]);

        // Define $path as null
        $path = null;

        // Check if 'comprobante_pago' is present in the request
        if ($request->hasFile('comprobante_pago')) {
            // Hacer el guardado de la imagen aquí, por ejemplo:
            $comprobante = $request->file('comprobante_pago');
            $extension = $comprobante->getClientOriginalExtension();
            $nombreArchivo = 'comprobante_' . uniqid() . '.' . $extension;
            $path = $comprobante->storeAs('public/comprobantes', $nombreArchivo);
            $path = str_replace('public/', '', $path); // remove 'public/' from the path
        }

        $arrayJuegos = json_decode($data['juegos']);

        foreach ($arrayJuegos as $juego) {            
            $juegoData = [
                'user_id' => $data['user_id'],
                'id_juego' => $juego->id,
                'nro_comprobante' => $data['nro_comprobante'],
                'valor_comprobante' => $data['valor_comprobante'],
            ];
                
            
                if ($juego->modalidad == 'grupo') {
                    // Verificar si el usuario tiene un equipo
                    $equipo = Equipo::where('user_id', $data['user_id'])->first();
            
                    if (!$equipo) {
                        return response()->json(['message' => "El usuario no tiene un equipo asociado para el juego {$juego->nombre}."], 400);
                    }
            
                    // Buscar inscripción existente o crear una nueva instancia
                    $inscripcion = InscripcionGrupal::firstOrNew([
                        'id_equipo' => $equipo->id,
                        'id_juego' => $juego->id,
                    ]);
                } else {
                    // Buscar inscripción existente o crear una nueva instancia
                    $inscripcion = InscripcionIndividual::firstOrNew([
                        'user_id' => $data['user_id'],
                        'id_juego' => $juego->id,
                    ]);
                }
            
                // Verificar si es una nueva instancia de inscripción
                if (!$inscripcion->exists) {
                    // Asignar la ruta del comprobante de pago solo para nuevas instancias
                    $inscripcion->comprobante_pago = $path;
                }
            
                // Asignar el número de comprobante a todas las instancias
                $inscripcion->nro_comprobante = $data['nro_comprobante'];
                $inscripcion->valor_comprobante = $data['valor_comprobante'];

                // Guardar la instancia de inscripción si es nueva
                if (!$inscripcion->exists) {
                    $inscripcion->save();
                }
            }

            return response()->json([
                'data' => $data,
                'message' => 'Inscripcion creada exitosamente'
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => "Error al crear la inscripcion: " . $e->getMessage()], 500);
        }
    }

    public function get_inscripciones_by_game(Request $request)
{
    try {
        $idJuego = $request->input('game');

        if ($idJuego) {
            $juego = Juego::find($idJuego);
            if (!$juego) {
                return response()->json(['error' => 'Juego no encontrado'], 404);
            }

            // Obtiene las inscripciones individuales y grupales basadas en el juego
            $inscripcionesIndividuales = $juego->inscripcionesIndividuales()
                ->with(['user' => function($query) {
                    $query->select('id', 'name', 'phone');
                }])
                ->select('id', 'user_id', 'estado_pago', 'id_juego', 'nro_comprobante', 'comprobante_pago', 'valor_comprobante') // incluye nro_comprobante y valor_comprobante
                ->paginate(10)
                ->map(function ($inscripcion) use ($juego) {
                    $inscripcion->nombre_juego = $juego->nombre; // incluye nombre del juego
                    return $inscripcion;
                });

                $inscripcionesGrupales = $juego->inscripcionesGrupales()
                ->with([
                    'equipo' => function($query) {
                        $query->select('id', 'nombre_equipo', 'miembros','user_id')
                            ->with(['user' => function($query) {
                                $query->select('id', 'name', 'phone');
                            }]);
                    }
                ])
                ->select('id', 'id_equipo', 'estado_pago', 'id_juego', 'nro_comprobante', 'comprobante_pago', 'valor_comprobante') // incluye nro_comprobante y valor_comprobante
                ->paginate(10)
                ->map(function ($inscripcion) use ($juego) {
                    $inscripcion->nombre_juego = $juego->nombre; // incluye nombre del juego
                    // incluye los datos del equipo y el usuario
                    if ($inscripcion->equipo) {
                        $inscripcion->nombre_equipo = $inscripcion->equipo->nombre_equipo;
                        $inscripcion->miembros = $inscripcion->equipo->miembros;
                        if ($inscripcion->equipo->user) {
                            $inscripcion->nombre_usuario = $inscripcion->equipo->user->nombre;
                        }
                    }
                    return $inscripcion;
                });            

            // puedes personalizar los datos que envías aquí, según tus necesidades
            return response()->json([
                'inscripcionesIndividuales' => $inscripcionesIndividuales,
                'inscripcionesGrupales' => $inscripcionesGrupales
            ]);
        }

        return response()->json(['error' => 'ID de juego no especificado'], 400);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Ha ocurrido un error: ' . $e->getMessage()], 500);
    }
}

    

    public function get_mis_inscripciones(Request $request): Response
    {
        // Obteniendo el usuario autenticado
        $user = Auth::user();

        // Recuperando las inscripciones individuales
        $inscripcionesIndividuales = InscripcionIndividual::where('user_id', $user->id)
                                                        ->with('juego')
                                                        ->get()
                                                        ->map(function($inscripcion) {
                                                                return [
                                                                    'tipo' => 'Individual',
                                                                    'juego_nombre' => $inscripcion->juego->nombre,
                                                                    'img_id' => $inscripcion->juego->img_id,
                                                                    'estado_pago' => $inscripcion->estado_pago,
                                                                ];
                                                            });

        // Recuperando los equipos del usuario
        $equipos = Equipo::where('user_id', $user->id)->get();

        // Recuperando las inscripciones grupales
        $inscripcionesGrupales = collect();
        foreach ($equipos as $equipo) {
            $inscripcionesDelEquipo = InscripcionGrupal::where('id_equipo', $equipo->id)
                                                    ->with('juego')
                                                    ->get()
                                                    ->map(function($inscripcion) use ($equipo) {
                                                            return [
                                                                'tipo' => 'Grupal',
                                                                'juego_nombre' => $inscripcion->juego->nombre,
                                                                'img_id' => $inscripcion->juego->img_id,
                                                                'equipo_nombre' => $equipo->nombre_equipo,
                                                                'equipo_id' => $equipo->id,
                                                                'estado_pago' => $inscripcion->estado_pago,
                                                            ];
                                                        });
            $inscripcionesGrupales = $inscripcionesGrupales->concat($inscripcionesDelEquipo);
        }

        // Fusionando las inscripciones
        $inscripciones = $inscripcionesIndividuales->concat($inscripcionesGrupales);

        // Enviando a la vista
        return Inertia::render('DashboardPage/Inscripciones/MisInscripciones', [
            'role' => $user->hasRole("admin"),
            'inscripciones' => $inscripciones,
        ]);
    }




}
