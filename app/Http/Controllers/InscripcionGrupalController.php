<?php

namespace App\Http\Controllers;

use App\Models\InscripcionGrupal;
use Illuminate\Http\Request;

class InscripcionGrupalController extends Controller
{
    public function index()
    {
        try {
            $inscripciones = InscripcionGrupal::all();
            return response()->json($inscripciones);
        } catch (\Exception $e) {
            return response()->json(['message' => "Error al obtener las inscripciones: " . $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'id_equipo' => 'required|integer',
                'id_juego' => 'required|integer',
                'estado' => 'required|string',
                'comprobante_pago' => 'required|string',
                'nro_comprobante' => 'required|string',
            ]);

            $inscripcion = InscripcionGrupal::create($data);

            return response()->json([
                'data' => $inscripcion,
                'message' => 'Inscripcion creada exitosamente'
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => "Error al crear la inscripcion: " . $e->getMessage()], 500);
        }
    }

    public function show(InscripcionGrupal $inscripcionGrupal)
    {
        try {
            return response()->json($inscripcionGrupal);
        } catch (\Exception $e) {
            return response()->json(['message' => "Error al obtener la inscripcion: " . $e->getMessage()], 500);
        }
    }

    public function update(Request $request, InscripcionGrupal $inscripcionGrupal)
    {
        try {
            $data = $request->validate([
                'id_equipo' => 'required|integer',
                'id_juego' => 'required|integer',
                'estado' => 'required|string',
                'comprobante_pago' => 'required|string',
                'nro_comprobante' => 'required|string',
            ]);

            $inscripcionGrupal->update($data);

            return response()->json([
                'data' => $inscripcionGrupal,
                'message' => 'Inscripcion actualizada exitosamente'
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => "Error al actualizar la inscripcion: " . $e->getMessage()], 500);
        }
    }

    public function destroy(InscripcionGrupal $inscripcionGrupal)
    {
        try {
            $inscripcionGrupal->delete();

            return response()->json([
                'message' => 'Inscripcion eliminada exitosamente'
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => "Error al eliminar la inscripcion: " . $e->getMessage()], 500);
        }
    }
}
