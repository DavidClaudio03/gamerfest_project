<?php

namespace App\Http\Controllers;

use App\Models\GanadorIndividual;
use Illuminate\Http\Request;

class GanadorIndividualController extends Controller
{

    public function index()
    {
        try {
            $ganadores = GanadorIndividual::all();
            return response()->json($ganadores);
        } catch (\Exception $e) {
            return response()->json(['message' => "Error al obtener ganadores individuales: " . $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'id_juego' => 'required|integer',
                'id_participante' => 'required|integer',
                'posicion' => 'required|integer',
            ]);

            $ganador = GanadorIndividual::create($data);

            return response()->json([
                'data' => $ganador,
                'message' => 'Ganador individual creado exitosamente'
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => "Error al crear el ganador individual: " . $e->getMessage()], 500);
        }
    }

    public function show(GanadorIndividual $ganadorIndividual)
    {
        try {
            return response()->json($ganadorIndividual);
        } catch (\Exception $e) {
            return response()->json(['message' => "Error al obtener el ganador individual: " . $e->getMessage()], 500);
        }
    }

    public function update(Request $request, GanadorIndividual $ganadorIndividual)
    {
        try {
            $data = $request->validate([
                'id_juego' => 'required|integer',
                'id_participante' => 'required|integer',
                'posicion' => 'required|integer',
            ]);

            $ganadorIndividual->update($data);

            return response()->json([
                'data' => $ganadorIndividual,
                'message' => 'Ganador individual actualizado exitosamente'
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => "Error al actualizar el ganador individual: " . $e->getMessage()], 500);
        }
    }

    public function destroy(GanadorIndividual $ganadorIndividual)
    {
        try {
            $ganadorIndividual->delete();

            return response()->json([
                'message' => 'Ganador individual eliminado exitosamente'
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => "Error al eliminar el ganador individual: " . $e->getMessage()], 500);
        }
    }
}
