<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\Kategori;

class BukuController extends Controller
{
    public function index(Request $request)
    {
        $bukus = Buku::with('kategori')
            ->when($request->search, function ($q, $search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('penulis', 'like', "%{$search}%")
                  ->orWhere('isbn', 'like', "%{$search}%");
            })
            ->when($request->kategori_id, function ($q, $catId) {
                $q->where('kategori_id', $catId);
            })
            ->orderBy('id', 'desc')
            ->paginate(10)
            ->withQueryString();

        $kategoris = Kategori::all();

        return view('buku.index', compact('bukus', 'kategoris'));
    }

    public function create()
    {
        $kategoris = Kategori::all();
        return view('buku.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'isbn' => 'required|string|unique:bukus,isbn',
            'judul' => 'required|string|max:255',
            'penulis' => 'required|string|max:255',
            'penerbit' => 'nullable|string|max:150',
            'kategori_id' => 'required|exists:kategoris,id',
            'tahun_terbit' => 'required|digits:4|integer',
            'stok' => 'required|integer|min:0',
            'sinopsis' => 'nullable|string',
        ]);

        Buku::create($validated);

        return redirect()->route('buku.index')->with('success', 'Data buku berhasil ditambahkan.');
    }
}