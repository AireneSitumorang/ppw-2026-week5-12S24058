<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\Kategori;
use App\Models\Peminjaman;

class DashboardController extends Controller
{
    public function index()
    {
        $totalBuku = Buku::count();
        $totalStok = Buku::sum('stok');
        $totalKategori = Kategori::count();
        $bukuDipinjam = Peminjaman::where('status', 'dipinjam')->count();

        $peminjamanTerbaru = Peminjaman::with('buku')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('dashboard', compact(
            'totalBuku',
            'totalStok',
            'totalKategori',
            'bukuDipinjam',
            'peminjamanTerbaru'
        ));
    }
}