<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KategoriController extends Controller
{
    /**
     * Menampilkan seluruh data kategori.
     */
    public function index(Request $request)
    {
        $kategoris = DB::table('kategoris')
            ->leftJoin('bukus', 'kategoris.id', '=', 'bukus.kategori_id')
            ->select(
                'kategoris.id',
                'kategoris.kode_kategori',
                'kategoris.nama_kategori',
                'kategoris.created_at',
                'kategoris.updated_at',
                DB::raw('COUNT(bukus.id) as bukus_count')
            )
            ->groupBy(
                'kategoris.id',
                'kategoris.kode_kategori',
                'kategoris.nama_kategori',
                'kategoris.created_at',
                'kategoris.updated_at'
            )
            ->orderBy('kategoris.id', 'desc')
            ->paginate(10)
            ->appends($request->query());

        return view('kategori.index', compact('kategoris'));
    }

    /**
     * Menampilkan formulir tambah kategori.
     */
    public function create()
    {
        return view('kategori.create');
    }

    /**
     * Menyimpan kategori baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_kategori' => [
                'required',
                'string',
                'max:10',
                'unique:kategoris,kode_kategori',
            ],
            'nama_kategori' => [
                'required',
                'string',
                'max:100',
                'unique:kategoris,nama_kategori',
            ],
        ]);

        DB::table('kategoris')->insert([
            'kode_kategori' => strtoupper(trim($validated['kode_kategori'])),
            'nama_kategori' => trim($validated['nama_kategori']),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()
            ->route('kategori.index')
            ->with('success', 'Kategori berhasil ditambahkan!');
    }

    /**
     * Menampilkan formulir edit kategori.
     */
    public function edit($id)
    {
        $kategori = Kategori::findOrFail($id);

        return view('kategori.edit', compact('kategori'));
    }

    /**
     * Memperbarui data kategori.
     */
    public function update(Request $request, $id)
    {
        $kategori = Kategori::findOrFail($id);

        $validated = $request->validate([
            'kode_kategori' => [
                'required',
                'string',
                'max:10',
                'unique:kategoris,kode_kategori,' . $kategori->id,
            ],
            'nama_kategori' => [
                'required',
                'string',
                'max:100',
                'unique:kategoris,nama_kategori,' . $kategori->id,
            ],
        ]);

        $kategori->update([
            'kode_kategori' => strtoupper(trim($validated['kode_kategori'])),
            'nama_kategori' => trim($validated['nama_kategori']),
        ]);

        return redirect()
            ->route('kategori.index')
            ->with('success', 'Kategori berhasil diperbarui!');
    }

    /**
     * Menghapus kategori.
     */
    public function destroy($id)
    {
        $kategori = Kategori::findOrFail($id);

        $kategori->delete();

        return redirect()
            ->route('kategori.index')
            ->with('success', 'Kategori berhasil dihapus!');
    }
}