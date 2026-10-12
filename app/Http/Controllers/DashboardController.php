<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kategori;

class DashboardController extends Controller
{
    public function index()
    {
        $totalBuku = Buku::count();
        $totalStok = Buku::sum('stok');
        $totalKategori = Kategori::count();
        
        $bukuTerbaru = Buku::with('kategori')->latest()->take(5)->get();
        $kategoris = Kategori::withCount('bukus')->get();

        return view('dashboard', compact('totalBuku', 'totalStok', 'totalKategori', 'bukuTerbaru', 'kategoris'));
    }
}