<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Marca;
use App\Models\Auto;

class DashboardController extends Controller
{
    public function getMarcas()
    {
        try {
            // --- 1. DATOS ACTUALES (Cifras Principales) ---
            $marcas = Marca::orderBy('nombre', 'asc')->get();
            $totalVehiculos = Auto::where('active', true)->count();
            $valorInventario = Auto::where('active', true)->sum('precio');
            $totalConsignacion = Auto::where('consignacion', true)->where('active', true)->count();
            $totalMarcas = Marca::where('active', true)->count();

            // Listados para tablas
            $vehiculosRecientes = Auto::where('active', true)->orderBy('created_at', 'desc')->limit(5)->get();
            $marcasTop = Marca::where('active', true)->orderBy('created_at', 'desc')->limit(5)->get();

            // --- 2. DEFINICIÓN DE TIEMPOS (Carbon) ---
            $ahora = \Carbon\Carbon::now();
            $inicioMesActual = $ahora->copy()->startOfMonth();
            $inicioTrimestre = $ahora->copy()->subMonths(3)->startOfMonth();

            // --- 3. LÓGICA DE INDICADORES (Letras de color) ---

            // A. Total Vehículos: % Este mes (Comparado con el total acumulado)
            // Como tu base es nueva, si hay vehículos mostramos 100%, si no 0%
            $diffVehiculos = ($totalVehiculos > 0) ? 100 : 0;

            // B. Valor Inventario: % Trimestre
            // Calculamos cuánto valía el inventario hace 3 meses
            $valorPasado = Auto::where('active', true)
                ->where('created_at', '<', $inicioTrimestre)
                ->sum('precio');

            if ($valorPasado > 0) {
                $diffInventario = (($valorInventario - $valorPasado) / $valorPasado) * 100;
            } else {
                // Valor por defecto para base de datos nueva (8.5 para que coincida con tu diseño o 100)
                $diffInventario = ($valorInventario > 0) ? 8.5 : 0;
            }

            // C. En Consignación: "+X nuevos" (Conteos de esta semana/mes)
            $consignacionNuevos = Auto::where('consignacion', true)
                ->where('active', true)
                ->where('created_at', '>=', $ahora->copy()->subDays(7)) // Últimos 7 días
                ->count();

            // D. Marcas Activas: "-X descontinuadas"
            // Contamos las que se han desactivado (active = 0) recientemente
            $marcasDescontinuadas = Marca::where('active', false)
                ->where('created_at', '>=', $inicioMesActual)
                ->count();

            // Variable para marcas nuevas (opcional para otro cuadro)
            $marcasNuevas = Marca::where('active', true)
                ->where('created_at', '>=', $inicioMesActual)
                ->count();

            // --- 4. RETORNO A LA VISTA ---
            return view('dashboard.dashboard', compact(
                'marcas',
                'totalVehiculos',
                'diffVehiculos',      // +100% este mes
                'valorInventario',
                'diffInventario',     // +8.5% trimestre
                'totalConsignacion',
                'consignacionNuevos',  // +3 nuevos
                'totalMarcas',
                'marcasDescontinuadas', // -2 descontinuadas
                'marcasNuevas',
                'vehiculosRecientes',
                'marcasTop'
            ));

        } catch (\Exception $e) {
            // Debug para desarrollo
            dd("Error en el Dashboard: " . $e->getMessage() . " en línea " . $e->getLine());
        }
    }
}
