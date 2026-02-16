<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; 
use App\Http\Requests;
use App\Models\Marca;


class MarcaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
            'nombre' => 'required',
            'imagen' => 'required|image|mimes:jpeg,png,jpg|max:2048' // Validamos que sea foto
        ]);

        if ($request->hasFile('imagen')) {
            // 1. Obtenemos el archivo
            $file = $request->file('imagen');

            // 2. Le damos un nombre único para que no se sobrescriba
            $nombreImagen = time() . '_' . $file->getClientOriginalName();

            // 3. Movemos el archivo a public/uploads/marcas/
            $file->move(public_path('uploads/marcas'), $nombreImagen);

            // 4. Esta es la ruta que guardaremos en la DB
            $rutaBaseDatos = 'uploads/marcas/' . $nombreImagen;
        }

        // 5. Creamos el registro en la base de datos
        Marca::create([
            'nombre' => $request->nombre,
            'imagen' => $rutaBaseDatos,
            'created_by' => auth()->id()
        ]);

        return back()->with('success', 'Marca guardada con éxito');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
