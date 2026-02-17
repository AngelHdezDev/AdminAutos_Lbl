<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Auto\StoreAutoRequest;
use App\Models\Auto;
use Exception;
use Illuminate\Support\Facades\Log;

class AutoController extends Controller
{
    public function store(StoreAutoRequest $request)
    {
        try {
            // Debug: Ver qué datos están llegando
            \Log::info('Datos recibidos:', $request->all());

            $auto = Auto::create([
                'id_marca' => $request->id_marca,
                'modelo' => $request->modelo,
                'year' => $request->year,
                'color' => $request->color,
                'transmision' => $request->transmision,
                'combustible' => $request->combustible,
                'kilometraje' => $request->kilometraje,
                'precio' => $request->precio,
                'tipo' => $request->tipo,
                'descripcion' => $request->descripcion,
                'ocultar_kilometraje' => $request->has('ocultar_kilometraje') ? 1 : 0,
                'consignacion' => $request->has('consignacion') ? 1 : 0,
                'created_by' => auth()->id(),
            ]);

            \Log::info('Vehículo creado:', ['id' => $auto->id]);

            return redirect()->back()->with('success', 'Vehículo registrado correctamente en el inventario.');

        } catch (\Illuminate\Database\QueryException $e) {
            \Log::error("Error de BD al registrar vehículo: " . $e->getMessage());

            return redirect()->back()
                ->withInput()
                ->with('error', 'Error en la base de datos: ' . $e->getMessage());

        } catch (Exception $e) {
            \Log::error("Error al registrar vehículo: " . $e->getMessage());

            return redirect()->back()
                ->withInput()
                ->with('error', 'No se pudo guardar el vehículo. Revisa los datos e intenta de nuevo.');
        }
    }
}
