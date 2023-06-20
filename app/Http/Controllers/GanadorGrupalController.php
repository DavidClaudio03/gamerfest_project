<?php

namespace App\Http\Controllers;

use App\Models\GanadorGrupal;
use Illuminate\Http\Request;

class GanadorGrupalController extends Controller
{
    public function index()
    {
        try {
            $ganadores = GanadorGrupal::all();
            return response()->json($ganadores);
        } catch (\Exception $e) {
            return response()->json(['message' => "Error al obtener ganadores grupales: " . $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'id_juego' => 'required|integer',
                'id_equipo' => 'required|integer',
                'posicion' => 'required|integer',
            ]);

            $ganador = GanadorGrupal::create($data);

            return response()->json([
                'data' => $ganador,
                'message' => 'Ganador grupal creado exitosamente'
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => "Error al crear el ganador grupal: " . $e->getMessage()], 500);
        }
    }

    public function show(GanadorGrupal $ganadorGrupal)
    {
        try {
            return response()->json($ganadorGrupal);
        } catch (\Exception $e) {
            return response()->json(['message' => "Error al obtener el ganador grupal: " . $e->getMessage()], 500);
        }
    }

    public function update(Request $request, GanadorGrupal $ganadorGrupal)
    {
        try {
            $data = $request->validate([
                'id_juego' => 'required|integer',
                'id_equipo' => 'required|integer',
                'posicion' => 'required|integer',
            ]);

            $ganadorGrupal->update($data);

            return response()->json([
                'data' => $ganadorGrupal,
                'message' => 'Ganador grupal actualizado exitosamente'
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => "Error al actualizar el ganador grupal: " . $e->getMessage()], 500);
        }
    }

    public function destroy(GanadorGrupal $ganadorGrupal)
    {
        try {
            $ganadorGrupal->delete();

            return response()->json([
                'message' => 'Ganador grupal eliminado exitosamente'
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => "Error al eliminar el ganador grupal: " . $e->getMessage()], 500);
        }
    }
}
