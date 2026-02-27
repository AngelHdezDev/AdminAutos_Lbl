<?php

use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AutoController;
use App\Http\Controllers\GalleryController;


Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', [LoginController::class, 'login'])->name('login.authenticate');

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/dashboard', [DashboardController::class, 'getMarcas'])
    ->middleware('auth')
    ->name('dashboard');

Route::post('/marcas', [MarcaController::class, 'store'])->middleware('auth')->name('marcas.store');
// Route::get('/dashboard', [DashboardController::class, 'getMarcas'])->middleware('auth')->name('dashboard');


//rutas para autos
Route::get('/autos', [AutoController::class, 'index'])->middleware('auth')->name('autos.index');
Route::post('/autos', [AutoController::class, 'store'])->middleware('auth')->name('autos.store');
Route::delete('/autos/{id}', [AutoController::class, 'destroy'])->middleware('auth')->name('autos.destroy');
Route::put('/autos/{id}', [AutoController::class, 'update'])->middleware('auth')->name('autos.update');
Route::get('/autos/details/{id_auto}', [AutoController::class, 'showDetail'])->middleware('auth')->name('autos.show');
Route::delete('/autos/imagen/{id}', [AutoController::class, 'eliminarImagen'])->middleware('auth')->name('autos.imagen.delete');
Route::patch('/autos/imagen/{id}/portada', [GalleryController::class, 'setPortada'])->name('autos.imagen.portada');


// Ruta para marcas
Route::get('/marcas', [MarcaController::class, 'index'])->middleware('auth')->name('marcas.index');
Route::post('/marcas', [MarcaController::class, 'store'])->middleware('auth')->name('marcas.store');
Route::put('/marcas/{id}', [MarcaController::class, 'update'])->middleware('auth')->name('marcas.update');
Route::delete('/marcas/{id}', [MarcaController::class, 'changeStatus'])->middleware('auth')->name('marcas.changeStatus');

// Ruta para galería
Route::get('/galeria', [GalleryController::class, 'index'])->middleware('auth')->name('galeria.index');
Route::post('/admin/asignar-foto/{id}', [GalleryController::class, 'asignar'])->middleware('auth')->name('galeria.asignar');
Route::delete('/admin/eliminar-foto-temporal/{id}', [GalleryController::class, 'destroy'])->middleware('auth')->name('galeria.destroy');
