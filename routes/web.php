<?php

use App\Http\Controllers\KategoriController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PenerimaanBarangController;



Route::get('/', function () {
    return view('auth.login');
})->middleware('guest');
Route::post('/login', [LoginController::class, 'handleLogin'])->name('login');
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::prefix('users')->as('users.')->controller(UserController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/store', 'store')->name('store');
        Route::get('/edit/{id}', 'edit')->name('edit');
        Route::put('/update/{id}', 'update')->name('update');
        Route::delete('/delete/{id}', 'destroy')->name('destroy');
        Route::get('/change-password-form', 'changePasswordForm')->name('change-password-form');
        Route::post('/update-password', 'updatePassword')->name('update-password');
    });

    Route::prefix('get-data')->as('get-data.')->controller(ProdukController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/produk', 'getdata')->name('produk');
        Route::get('/cek-stok', 'cekStok')->name('cek-stok');
    });

    Route::prefix('master-data/kategori')->as('master-data.kategori.')->controller(KategoriController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/edit/{id}', 'edit')->name('edit');
        Route::put('/update/{id}', 'update')->name('update');
        Route::delete('/delete/{id}', 'destroy')->name('destroy');
        Route::post('/create', 'create')->name('create');
    });
    Route::prefix('master-data/produk')->as('master-data.produk.')->controller(ProdukController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/store', 'store')->name('store');
        Route::delete('/delete/{id}', 'destroy')->name('destroy');
    });
    Route::prefix('penerimaan-barang')->as('penerimaan-barang.')->controller(PenerimaanBarangController::class)->group(function () {
        Route::get('/', 'index')->name('index');
    });
});

