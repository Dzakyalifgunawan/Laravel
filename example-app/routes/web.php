<?php

use App\Http\Controllers\DosenController;
use App\Http\Controllers\PegawaiController;
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

Route::get('halo', function(){
    return 'Halo, Selamat datang di tutorial laravel ASE-S02';
});

Route::get('blog', function(){
    return view('blog');
});

Route::get('index', function(){
    return view('index');
});

Route::get('dosen', [DosenController::class, 'index']);

Route::get('/pegawai/{nama}', [PegawaiController::class, 'index']);

Route::get('/formulir',[PegawaiController::class, 'formulir']);

Route::get('/formulir/proses', [PegawaiController::class, 'proses']);

Route::resource('/posts', \App\Http\Controllers\Postcontrollers::class);

Route::resource('/mahasiswa', \App\Http\Controllers\MahasiswaController::class);
