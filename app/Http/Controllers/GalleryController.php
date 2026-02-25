<?php

namespace App\Http\Controllers;

use App\Models\ImagenTemporal;
use App\Models\Imagen;
use App\Models\Auto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function index()
    {
        $imagenes = ImagenTemporal::orderBy('created_at', 'desc')->where('status', 0)->get();
        $vehiculos = Auto::where('active', 1)->get();

        return view('galeria.galeria', compact('imagenes', 'vehiculos'));
    }

    public function asignar(Request $request, $id)
    {
        // Log 1: Ver qué datos están llegando desde el formulario
        \Log::info("Iniciando asignación para ID Temporal: $id", $request->all());

        try {
            $request->validate([
                'id_auto' => 'required|exists:autos,id_auto' //
            ]);
            \Log::info("Validación exitosa para el auto: " . $request->id_auto);

            $temp = \App\Models\ImagenTemporal::find($id);

            if (!$temp) {
                \Log::error("No se encontró el registro temporal con ID: $id");
                return back()->with('error', 'Registro no encontrado');
            }

            \Illuminate\Support\Facades\DB::transaction(function () use ($temp, $request) {
                // Log 2: Datos antes de insertar
                \Log::info("Insertando en tabla imagenes...", [
                    'id_auto' => $request->id_auto,
                    'ruta' => $temp->ruta_archivo
                ]);

                \App\Models\Imagen::create([
                    'id_auto' => $request->id_auto,
                    'imagen' => $temp->ruta_archivo,
                    'thumbnail' => 0,
                    'created_by' => auth()->id() ?? 1 //
                ]);

                $temp->update(['status' => 1]);
                \Log::info("Tabla temporal actualizada: status = 1");
            });

            return redirect()->back()->with('success', 'Asignado correctamente');

        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::warning("Error de validación:", $e->errors());
            return redirect()->back()->withErrors($e->errors());

        } catch (\Exception $e) {
            \Log::error("ERROR CRÍTICO en asignación: " . $e->getMessage());
            return redirect()->back()->with('error', 'Error interno: ' . $e->getMessage());
        }
    }
}
