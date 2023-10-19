<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::resource('/makan', \App\Http\Controllers\MakananController::class);
Route::resource('/minum', \App\Http\Controllers\MinumanController::class);
Route::resource('/alat', \App\Http\Controllers\AlatController::class);
Route::resource('/bahan', \App\Http\Controllers\BahanController::class);
Route::resource('produk', 'ProdukController');

