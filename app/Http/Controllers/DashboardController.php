<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Buku;
use App\Models\Kategori;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // 1. Statistik menggunakan Fluent Query Builder (DB::table) sesuai Modul Minggu 6
        $stats = [
            'total_buku' => DB::table('bukus')->count(),
            'total_kategori' => DB::table('kategoris')->count(),
            'total_stok' => DB::table('bukus')->sum('stok'),
            'total_dipinjam' => DB::table('peminjamans')->where('status', 'dipinjam')->count(),
            'total_dikembalikan' => DB::table('peminjamans')->where('status', 'dikembalikan')->count(),
        ];

        // 2. Data buku terbaru dengan withCount('peminjamans') dan pencarian dinamis when()
        $search = $request->input('search');
        $bukus = Buku::with('kategori')
            ->withCount('peminjamans')
            ->when($search, function ($query, $search) {
                return $query->where('judul', 'like', "%{$search}%")
                             ->orWhere('penulis', 'like', "%{$search}%")
                             ->orWhere('isbn', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $kategoris = Kategori::withCount('bukus')->get();

        return view('dashboard', compact('stats', 'bukus', 'kategoris'));
    }
}