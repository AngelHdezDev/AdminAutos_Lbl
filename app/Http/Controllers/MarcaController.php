<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Marca;
use App\Http\Requests\Marca\StoreMarcaRequest;
use App\Http\Requests\Marca\UpdateMarcaRequest;
use Exception;
use Illuminate\Support\Facades\Log;


class MarcaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $query = Marca::query()->where('active', 1);

            if ($request->has('search') && $request->search != '') {
                $query->where('nombre', 'LIKE', '%' . $request->search . '%');
            }

            $marcas = $query->latest()->paginate(12);

            return view('marcas.marcas', compact('marcas'));
        } catch (Exception $e) {
            Log::error("Error al cargar marcas: " . $e->getMessage());
            return back()->with('error', 'Error al cargar las marcas.');
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
    public function update(UpdateMarcaRequest $request, $id)
    {
        try {

            $marca = Marca::findOrFail($id);
            $marca->nombre = $request->nombre;

            $marca->active = $request->has('active') ? 1 : 0;

            if ($request->hasFile('imagen')) {
                if ($marca->imagen && file_exists(public_path($marca->imagen))) {
                    unlink(public_path($marca->imagen));
                }

                $file = $request->file('imagen');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads/marcas'), $filename);

                $marca->imagen = 'uploads/marcas/' . $filename;
            }
            $marca->save();

            return redirect()->route('marcas.index')
                ->with('success', 'La marca se ha actualizado correctamente.');

        } catch (Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error al actualizar la marca: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {

            $marca = Marca::where('id_marca', $id)->firstOrFail();

            $marca->update(['active' => 0]);

            return redirect()->route('marcas.index')
                ->with('success', 'La marca "' . $marca->nombre . '" ha sido desactivada correctamente.');

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {

            return redirect()->route('marcas.index')
                ->with('error', 'No se pudo encontrar la marca para desactivar.');

        } catch (Exception $e) {
            return redirect()->route('marcas.index')
                ->with('error', 'Ocurrió un error inesperado: ' . $e->getMessage());
        }
    }
}
