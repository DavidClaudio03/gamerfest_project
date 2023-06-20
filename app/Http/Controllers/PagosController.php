<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InscripcionIndividual;
use App\Models\InscripcionGrupal;
use Exception;

class PagosController extends Controller
{
    public function update_pago(Request $request)
    {
        // Valida los datos de entrada
        $request->validate([
            'id' => 'required|integer',
            'user_id' => 'required|integer',
            'id_juego' => 'required|integer',
            'estado_pago' => 'required|string|in:verificado,pendiente,cancelado',
        ]);
    
        try {
            // Busca la inscripción por ID, user_id y id_juego
            $inscripcion = InscripcionIndividual::where([
                ['id', '=', $request->id],
                ['user_id', '=', $request->user_id],
                ['id_juego', '=', $request->id_juego],
            ])->firstOrFail();  // Esto lanzará una excepción si no se encuentra ninguna inscripción correspondiente
    
            // Actualiza el estado de pago
            $inscripcion->estado_pago = $request->estado_pago;
    
            // Guarda los cambios en la base de datos
            $inscripcion->save();
    
            // Devuelve una respuesta
            return response()->json([
                'message' => 'El estado del pago ha sido actualizado.',
            ]);
    
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'No se encontró ninguna inscripción correspondiente.',
            ], 404);
        }
    }
    
}
