<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AutoController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('auth.login'); 
})->name('login');

Route::post('/login', [LoginController::class, 'login'])->name('login.authenticate');

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/dashboard', function () {
    return view('dashboard.dashboard'); 
})->middleware('auth')->name('dashboard.view');

Route::post('/marcas', [MarcaController::class, 'store'])->middleware('auth')->name('marcas.store');
Route::get('/dashboard', [DashboardController::class, 'getMarcas'])->middleware('auth')->name('dashboard');


//rutas para autos
Route::get('/autos', [AutoController::class, 'index'])->middleware('auth')->name('autos.index');
Route::post('/autos', [AutoController::class, 'store'])->middleware('auth')->name('autos.store');
Route::delete('/autos/{id}', [AutoController::class, 'destroy'])->middleware('auth')->name('autos.destroy');
Route::put('/autos/{id}', [AutoController::class, 'update'])->middleware('auth')->name('autos.update');


// Ruta para marcas
Route::get('/marcas', [MarcaController::class, 'index'])->middleware('auth')->name('marcas.index');
Route::post('/marcas', [MarcaController::class, 'store'])->middleware('auth')->name('marcas.store');
Route::put('/marcas/{id}', [MarcaController::class, 'update'])->middleware('auth')->name('marcas.update');
Route::delete('/marcas/{id}', [MarcaController::class, 'changeStatus'])->middleware('auth')->name('marcas.changeStatus');