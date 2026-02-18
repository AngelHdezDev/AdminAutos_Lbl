<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Auto\StoreAutoRequest;
use App\Http\Requests\Auto\UpdateAutoRequest;
use App\Models\Auto;
use App\Models\Marca;
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

    public function index(Request $request)
    {
        $query = Auto::with('marca')->active();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('modelo', 'LIKE', "%{$search}%")
                    ->orWhere('color', 'LIKE', "%{$search}%")
                    ->orWhere('year', 'LIKE', "%{$search}%")

                    ->orWhereHas('marca', function ($q) use ($search) {
                        $q->where('nombre', 'LIKE', "%{$search}%");
                    });
            });
        }


        if ($request->filled('marca')) {
            $query->where('id_marca', $request->input('marca'));
        }

        if ($request->filled('tipo')) {
            $query->where('tipo', $request->input('tipo'));
        }


        if ($request->filled('consignacion')) {
            $query->where('consignacion', $request->input('consignacion'));
        }

        $vehiculos = $query->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        $marcas = Marca::orderBy('nombre', 'asc')->get();
        $tipos = Auto::select('tipo')->distinct()->orderBy('tipo', 'asc')->get();

        return view('autos.autos', compact('vehiculos', 'marcas', 'tipos'));
    }

    public function destroy($id)
    {
        // Buscamos específicamente por tu columna de llave primaria id_auto
        $auto = Auto::where('id_auto', $id)->firstOrFail();

        // Actualizamos el estado a inactivo
        $auto->update(['active' => 0]); // O false, dependiendo de tu DB

        return redirect()->route('autos.index')->with('success', 'Vehículo eliminado correctamente');
    }

    public function update(UpdateAutoRequest $request, $id)
    {
        $vehiculo = Auto::where('id_auto', $id)->firstOrFail();


        $data = $request->all();

        $data['ocultar_kilometraje'] = $request->has('ocultar_kilometraje') ? 1 : 0;
        $data['consignacion'] = $request->has('consignacion') ? 1 : 0;


        $vehiculo->update($data);

        // 6. Redirigir con mensaje de éxito
        return redirect()->route('autos.index')
            ->with('success', 'El vehículo ' . $vehiculo->modelo . ' ha sido actualizado correctamente.');
    }

}
