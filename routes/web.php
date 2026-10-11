<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\KategoriController;

// Redirect root URL ke daftar katalog buku
Route::get('/', function () {
    return redirect()->route('buku.index');
});

// 7 Aksi Baku RESTful Resource Controller untuk Kategori & Buku
Route::resource('kategori', KategoriController::class);
Route::resource('buku', BukuController::class);