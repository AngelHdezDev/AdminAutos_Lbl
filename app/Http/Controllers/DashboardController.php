<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Marca;
use App\Models\Auto;

class DashboardController extends Controller
{
    public function getMarcas()
    {
        $marcas = Marca::orderBy('nombre', 'asc')->get();
        $totalVehiculos = Auto::count();
        $valorInventario = Auto::sum('precio');
        return view('dashboard.dashboard', compact('marcas', 'totalVehiculos', 'valorInventario'));
    }
}
