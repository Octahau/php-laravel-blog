<?php

use App\Http\Controllers\AdministradoresController;
use App\Http\Controllers\AnunciosController;
use App\Http\Controllers\ArticulosController;
use App\Http\Controllers\BannerController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth; // Add this line
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CategoriasController;
use App\Http\Controllers\OpinionesController;

//Route::get('/', [BlogController::class, 'index']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('/anuncios', AnunciosController::class);
Route::resource('/administradores', AdministradoresController::class)->names([
    'index' => 'administradores.index'
]);
Route::resource('/categorias', CategoriasController::class);
Route::resource('/articulos', ArticulosController::class);
Route::resource('/opiniones', OpinionesController::class);
Route::resource('/banner', BannerController::class);
Route::resource('/blog', BlogController::class);
Route::resource('/', BlogController::class);