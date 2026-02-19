<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Persona;

class WSPersonaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $personas = Persona::all();
        //return $personas;
        return response()->json($personas);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'dni' => 'required|string|max:255',
            'paterno' => 'required|string|max:255',
            'materno' => 'required|string|max:255',
            'nombre' => 'required|string|max:255',
        ]);
        $persona = Persona::create([
            'dni' => $request->dni,
            'paterno' => $request->paterno,
            'materno' => $request->materno,
            'nombre' => $request->nombre,
        ]);
        return response()->json($persona, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $persona = Persona::find($id);
        if(!$persona){
            return response()->json(['message' => 'Persona no encontrada'], 404);
        }
        return response()->json($persona);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $persona = Persona::find($id);
        if(!$persona){
            return response()->json(['message' => 'Persona no encontrada'], 404);
        }
        $request->validate([
            'dni' => 'required|string|max:255',
            'paterno' => 'required|string|max:255',
            'materno' => 'required|string|max:255',
            'nombre' => 'required|string|max:255',
        ]);
        $persona->update([
            'dni' => $request->dni,
            'paterno' => $request->paterno,
            'materno' => $request->materno,
            'nombre' => $request->nombre,
        ]);
        return response()->json($persona);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $persona = Persona::find($id);
        if(!$persona){
            return response()->json(['message' => 'Persona no encontrada'], 404);
        }
        $persona->delete();
        return response()->json(['message' => 'Persona eliminada']);
    }
}
