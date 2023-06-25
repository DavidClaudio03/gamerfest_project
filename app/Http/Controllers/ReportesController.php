<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InscripcionIndividual;
use App\Models\InscripcionGrupal;
use App\Models\GanadorGrupal;
use App\Models\GanadorIndividual;
use App\Models\User;
use App\Models\Juego;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use PDF;
use DB;

class ReportesController extends Controller
{
    // Esta función devuelve un reporte de todos participantes de un juego
    // cuyo estado_pago sea verificado.
    
    public function report_participantes_by_game(Request $request){
        try
        {
            $idJuego = $request->input('game');
            if ($idJuego) {
                $juego = Juego::find($idJuego);
                if (!$juego) {
                    return response()->json(['error' => 'Juego no encontrado'], 404);
                }
    
                if($juego->modalidad == "grupo"){
                    $inscripciones = $this->get_inscripciones_grupo($idJuego);
                    $data = [
                        'title' => 'Reporte participantes '.$juego->nombre,
                        'inscripciones' => $inscripciones
                    ];    
                    $pdf = PDF::loadView('reportes.reporte_inscripciones_grupales', $data); 
                    $pdf->setPaper('A4', 'landscape');
                    return $pdf->download('PARTICIPANTES-' .  Str::upper($juego->nombre) . '-' . date('YmdHis') . '.pdf'); 
                }
    
                $inscripciones = $this->get_inscripciones_individual($idJuego);
                $data = [
                    'title' => 'Reporte participantes '.$juego->nombre,
                    'inscripciones' => $inscripciones
                ];
    
                $pdf = PDF::loadView('reportes.reporte_inscripciones_individuales', $data); 
                return $pdf->download('PARTICIPANTES-' .  Str::upper($juego->nombre) . '-' . date('YmdHis') . '.pdf'); 
            }

        }
        catch (\Exception $e) {
            return response()->json(['error' => 'Ha ocurrido un error: ' . $e->getMessage()], 500);
        }
    }

    public function generar_certificado(Request $request){
        try{
            $tipo_certificado = $request->input('tipo_certificado', 'diploma');
    
            //obtiene el usuario autenticado
            $user = Auth::user();
        
            // Obtiene las inscripciones individuales
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
        
            // Obtiene las inscripciones grupales
            $inscripcionesGrupales = InscripcionGrupal::whereHas('equipo', function($query) use ($user) {
                $query->where('user_id', $user->id);
            })
                ->with(['juego', 'equipo'])
                ->get()
                ->map(function($inscripcion) {
                    return [
                        'tipo' => 'Grupal',
                        'juego_nombre' => $inscripcion->juego->nombre,
                        'img_id' => $inscripcion->juego->img_id,
                        'equipo_nombre' => $inscripcion->equipo->nombre_equipo,
                        'equipo_id' => $inscripcion->equipo->id,
                        'estado_pago' => $inscripcion->estado_pago,
                    ];
                });
    
            // Comprueba si el usuario se ha inscrito en algún juego
            if($inscripcionesIndividuales->isEmpty() && $inscripcionesGrupales->isEmpty()) {
                return response()->json(['success' => false,'error' => 'Vaya, pero si no te inscribiste en ningún juego :('],400);
            }
        
            // Verificar si el usuario es ganador
            $ganadorIndividual = GanadorIndividual::where('user_id', $user->id)->first();
            $ganadorGrupal = GanadorGrupal::whereHas('equipo', function($query) use ($user) {
                $query->where('user_id', $user->id);
            })->first();
        
            $esGanador = $ganadorIndividual || $ganadorGrupal;
        
            // Obtener la posición del ganador
            $posicionGanador = $ganadorIndividual ? $ganadorIndividual->posicion : ($ganadorGrupal ? $ganadorGrupal->posicion : null);
        
            // Fusiona las inscripciones
            $inscripciones = $inscripcionesIndividuales->concat($inscripcionesGrupales);
        
            $data = [
                'title' => 'Diploma de ' . $user->name,
                'inscripciones' => $inscripciones,
                'esGanador' => $esGanador,
                'posicionGanador' => $posicionGanador,
                'user' => $user
            ];    

            if($tipo_certificado == "diploma"){ 
                $pdf = PDF::loadView('reportes.diploma', $data); 
                $pdf->setPaper('A4', 'landscape');
                return $pdf->download('DIPLOMA-' .  Str::upper($user->name) . '-' . date('YmdHis') . '.pdf'); 
            }

            $pdf = PDF::loadView('reportes.certificado', $data); 
            return $pdf->download('DIPLOMA-' .  Str::upper($user->name) . '-' . date('YmdHis') . '.pdf'); 
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ha ocurrido un error: ' . $e->getMessage()], 500);
        }
    }    
    
    private function get_inscripciones_grupo(int $idJuego){
        return DB::table('inscripciones_grupales as ig')
        ->join('equipos as e', 'ig.id_equipo', '=', 'e.id')
        ->join('users as u', 'e.user_id', '=', 'u.id')
        ->join('juegos as j', 'j.id', '=', 'ig.id_juego')
        ->where('ig.id_juego', $idJuego)
        ->select('e.nombre_equipo', 'u.phone', 'u.name', 'e.miembros', 'ig.estado_pago', 'j.nombre')
        ->get();
    }

    private function get_inscripciones_individual(int $idJuego){
        return $inscripciones = DB::table('inscripciones_individuales as ii')
        ->join('users as u', 'ii.user_id', '=', 'u.id')
        ->join('juegos as j', 'ii.id_juego', '=', 'j.id')
        ->select('ii.id', 'u.id as user_id', 'u.name', 'u.phone', 'ii.estado_pago', 'ii.id_juego', 'j.nombre as nombre_juego') 
        ->where('ii.id_juego', $idJuego)
        ->get();
    }
}
