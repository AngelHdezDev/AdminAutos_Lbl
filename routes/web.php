<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('auth.login'); 
})->name('login');

Route::post('/login', [LoginController::class, 'login'])->name('login.authenticate');

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


Route::get('/dashboard', function () {
    return "¡Bienvenido al sistema de inventario!";
})->middleware('auth')->name('dashboard');

Route::get('/dashboard', function () {
    return view('dashboard.dashboard'); 
})->name('dashboard.view');