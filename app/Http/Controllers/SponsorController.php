<?php

namespace App\Http\Controllers;

use App\Models\Sponsor;
use Illuminate\Http\Request;

class SponsorController extends Controller
{
    public function index()
    {
        // Obtiene todos los sponsors y los muestra en una vista
        try {
            $sponsors = Sponsor::all();
            return response()->json($sponsors);
        } catch (\Exception $e) {
            return response()->json(['message' => "Error al obtener sponsors: " . $e->getMessage()], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Muestra el formulario para crear un nuevo sponsor
        return view('sponsors.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Valida los datos del formulario
        $request->validate([
            'nombre' => 'required',
            'url_pagina' => 'required|url',
            'url_imagen' => 'required|url',
        ]);

        // Crea un nuevo sponsor con los datos del formulario
        Sponsor::create([
            'nombre' => $request->nombre,
            'url_pagina' => $request->url_pagina,
            'url_imagen' => $request->url_imagen,
        ]);

        // Redirige a la página de índice de sponsors con un mensaje de éxito
        return redirect()->route('sponsors.index')->with('success', 'Sponsor creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Sponsor $sponsor)
    {
        // Muestra los detalles de un sponsor específico
        return view('sponsors.show', compact('sponsor'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sponsor $sponsor)
    {
        // Muestra el formulario para editar un sponsor específico
        return view('sponsors.edit', compact('sponsor'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sponsor $sponsor)
    {
        // Valida los datos del formulario
        $request->validate([
            'nombre' => 'required',
            'url_pagina' => 'required|url',
            'url_imagen' => 'required|url',
        ]);

        // Actualiza los campos del sponsor con los datos del formulario
        $sponsor->update([
            'nombre' => $request->nombre,
            'url_pagina' => $request->url_pagina,
            'url_imagen' => $request->url_imagen,
        ]);

        // Redirige a la página de detalles del sponsor con un mensaje de éxito
        return redirect()->route('sponsors.show', $sponsor)->with('success', 'Sponsor actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sponsor $sponsor)
    {
        // Elimina el sponsor de la base de datos
        $sponsor->delete();

        // Redirige a la página de índice de sponsors con un mensaje de éxito
        return redirect()->route('sponsors.index')->with('success', 'Sponsor eliminado exitosamente.');
    }
}
