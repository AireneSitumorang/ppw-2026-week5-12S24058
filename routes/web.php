<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PeminjamanController;

/*
|--------------------------------------------------------------------------
| Route Login dan Logout
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'login']);
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

/*
|--------------------------------------------------------------------------
| Dashboard
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard.index');

    /*
    |--------------------------------------------------------------------------
    | Route Buku
    |--------------------------------------------------------------------------
    */

    Route::get('/buku', [BukuController::class, 'index'])
        ->name('buku.index');

    Route::get('/buku/create', [BukuController::class, 'create'])
        ->name('buku.create');

    Route::post('/buku', [BukuController::class, 'store'])
        ->name('buku.store');

    /*
    |--------------------------------------------------------------------------
    | Route Kategori
    |--------------------------------------------------------------------------
    */

    Route::get('/kategori', [KategoriController::class, 'index'])
        ->name('kategori.index');

    Route::get('/kategori/create', [KategoriController::class, 'create'])
        ->name('kategori.create');

    Route::post('/kategori', [KategoriController::class, 'store'])
        ->name('kategori.store');

    Route::get('/kategori/{id}/edit', [KategoriController::class, 'edit'])
        ->name('kategori.edit');

    Route::put('/kategori/{id}', [KategoriController::class, 'update'])
        ->name('kategori.update');

    Route::delete('/kategori/{id}', [KategoriController::class, 'destroy'])
        ->name('kategori.destroy');

    /*
    |--------------------------------------------------------------------------
    | Route Peminjaman
    |--------------------------------------------------------------------------
    */

    Route::get('/peminjaman', [PeminjamanController::class, 'index'])
        ->name('peminjaman.index');

    Route::post('/peminjaman', [PeminjamanController::class, 'store'])
        ->name('peminjaman.store');

    Route::put('/peminjaman/{id}/kembali', [PeminjamanController::class, 'kembali'])
        ->name('peminjaman.kembali');
});