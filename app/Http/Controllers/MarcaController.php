<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Marca;
use App\Http\Requests\Marca\StoreMarcaRequest;
use Exception;
use Illuminate\Support\Facades\Log;


class MarcaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $marcas = Marca::all();
            return view('marcas.marcas', compact('marcas'));
        } catch (Exception $e) {
            Log::error("Error al cargar marcas: " . $e->getMessage());
            return back()->with('error', 'Ocurrió un error inesperado al cargar las marcas. Por favor, intente de nuevo.');
        }
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
    public function store(StoreMarcaRequest $request)
    {
        try {
            $rutaBaseDatos = null;
            if ($request->hasFile('imagen')) {
                $file = $request->file('imagen');
                $nombreImagen = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads/marcas'), $nombreImagen);
                $rutaBaseDatos = 'uploads/marcas/' . $nombreImagen;
            }

            Marca::create([
                'nombre' => $request->nombre,
                'imagen' => $rutaBaseDatos,
                'created_by' => auth()->id()
            ]);

            return back()->with('success', '¡Marca registrada exitosamente!');

        } catch (Exception $e) {
            Log::error("Error al guardar marca: " . $e->getMessage());
            return back()
                ->withInput() 
                ->with('error', 'Ocurrió un error inesperado al guardar la marca. Por favor, intente de nuevo.');
        }
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
