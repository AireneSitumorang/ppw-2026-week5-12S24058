<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriController;

// Halaman Dashboard Utama
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// Resource Controller Buku (CRUD + Pencarian & Filter)
Route::resource('buku', BukuController::class);

// Resource Controller Kategori
Route::resource('kategori', KategoriController::class)->except(['show']);