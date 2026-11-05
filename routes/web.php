<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\Soap\LibrarySoapController;

// Halaman Dashboard Utama
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// Resource Controller Buku (CRUD + Pencarian & Filter)
Route::resource('buku', BukuController::class);

// Resource Controller Kategori
Route::resource('kategori', KategoriController::class)->except(['show']);

// Endpoint SOAP untuk pengecekan bebas pustaka (Modul Minggu 9)
Route::post('/soap/library', [LibrarySoapController::class, 'checkBebasPustaka']);