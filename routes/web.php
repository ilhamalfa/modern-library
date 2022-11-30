<?php

use App\Http\Controllers\BukuController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\UserController;
use App\Models\Buku;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    $datas = Buku::where('tampil', true)->get();
    
    return view('index',[
        'datas' => $datas
    ]);
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('buku/tampil/{id}', [BukuController::class, 'tampil']);

    Route::resource('user', UserController::class);
});

Route::middleware(['auth'])->group(function () {
    Route::resource('kategori', KategoriController::class);

    Route::resource('buku', BukuController::class);
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
