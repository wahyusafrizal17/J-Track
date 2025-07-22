<?php

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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

use App\Http\Controllers\BarangController;
use App\Http\Controllers\StokController;
use App\Http\Controllers\PenjualanController;

Route::middleware(['auth'])->group(function () {
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);

    Route::resource('users', 'App\Http\Controllers\UsersController');
    Route::post('users/delete', 'App\Http\Controllers\UsersController@delete')->name('users.delete');

    Route::resource('barangs', BarangController::class);
    Route::resource('stoks', StokController::class);
    Route::resource('penjualans', PenjualanController::class);
    Route::get('laporan/stok', [StokController::class, 'laporanStok'])->name('laporan.stok');
    Route::get('laporan/penjualan', [PenjualanController::class, 'laporanPenjualan'])->name('laporan.penjualan');
});