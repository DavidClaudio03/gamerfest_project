<?php

namespace App\Http\Controllers;

use App\Models\Equipo;
use Illuminate\Http\Request;

class EquipoController extends Controller
{
    public function index()
    {
        try {
            $equipos = Equipo::all();
            return response()->json($equipos);
        } catch (\Exception $e) {
            return response()->json(['message' => "Error al obtener los equipos: " . $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'user_id' => 'required|integer',
                'id_juego' => 'required|integer',
                'nombre_equipo' => 'required|string|max:255|unique:equipos',
                'miembros' => 'required|string'
            ]);

            $equipo = Equipo::create($data);

            return response()->json([
                'data' => $equipo,
                'message' => 'Equipo creado exitosamente'
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => "Error al crear el equipo: " . $e->getMessage()], 500);
        }
    }

    public function show(Equipo $equipo)
    {
        try {
            return response()->json($equipo);
        } catch (\Exception $e) {
            return response()->json(['message' => "Error al obtener el equipo: " . $e->getMessage()], 500);
        }
    }

    public function update(Request $request)
{
    try {
        $data = $request->validate([
            'id' => 'required|integer',
            'id_juego' => 'required|integer',
            'user_id' => 'required|integer',
            'nombre_equipo' => 'required|string|max:255',
            'miembros' => 'required|string'
        ]);

        $equipo = Equipo::findOrFail($data['id']);
        $equipo->update($data);

        return response()->json([
            'data' => $equipo,
            'message' => 'Equipo actualizado exitosamente'
        ]);
    } catch (\Exception $e) {
        return response()->json(['message' => "Error al actualizar el equipo: " . $e->getMessage()], 500);
    }
}

    public function getMiembros($id)
    {
        try {
            $equipo = Equipo::findOrFail($id);
            $miembros = explode(',', $equipo->miembros);
            
            return response()->json([
                'data' => $miembros,
                'message' => 'Miembros obtenidos exitosamente'
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => "Error al obtener los miembros: " . $e->getMessage()], 500);
        }
    }


    public function equipo_por_juego(Request $request)
    {
        try {
            $equipo = Equipo::where('user_id', $request->user_id)->get();
            return response()->json($equipo);
        } catch (\Exception $e) {
            return response()->json(['message' => "Error al obtener el equipo: " . $e->getMessage()], 500);
        }
    }


    public function destroy(Equipo $equipo)
    {
        try {
            $equipo->delete();

            return response()->json([
                'message' => 'Equipo eliminado exitosamente'
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => "Error al eliminar el equipo: " . $e->getMessage()], 500);
        }
    }
}
