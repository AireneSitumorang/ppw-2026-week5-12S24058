<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BukuController extends Controller
{
    /**
     * Tampilkan daftar buku dengan optimasi Eager Loading mitigasi N+1 problem.
     */
    public function index()
    {
        $bukus = Buku::with('kategori')->latest()->paginate(10);
        return view('buku.index', compact('bukus'));
    }

    /**
     * Tampilkan form tambah buku baru beserta list kategori pilihan.
     */
    public function create()
    {
        $kategoris = Kategori::orderBy('nama_kategori')->get();
        return view('buku.create', compact('kategoris'));
    }

    /**
     * Simpan buku baru ke database dengan validasi ketat sisi server.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'isbn'         => 'required|string|max:20|unique:bukus,isbn',
            'judul'        => 'required|string|min:5|max:255',
            'penulis'      => 'required|string|min:3|max:150',
            'penerbit'     => 'required|string|min:3|max:150',
            'tahun_terbit' => 'required|integer|digits:4|min:1900|max:' . date('Y'),
            'kategori_id'  => 'required|exists:kategoris,id',
            'stok'         => 'required|integer|min:0',
            'sinopsis'     => 'nullable|string',
        ], [
            'isbn.required'         => 'Nomor ISBN wajib diisi.',
            'isbn.unique'           => 'ISBN sudah pernah didaftarkan.',
            'judul.required'        => 'Judul buku wajib diisi.',
            'judul.min'             => 'Judul buku minimal 5 karakter sesuai standar perpustakaan.',
            'penulis.required'      => 'Nama penulis wajib diisi.',
            'penerbit.required'     => 'Nama penerbit wajib diisi.',
            'tahun_terbit.required' => 'Tahun terbit wajib diisi.',
            'tahun_terbit.digits'   => 'Format tahun terbit harus 4 digit angka.',
            'kategori_id.required'  => 'Pilih kategori buku.',
            'kategori_id.exists'    => 'Kategori yang dipilih tidak valid.',
            'stok.required'         => 'Jumlah stok wajib diisi.',
            'stok.min'              => 'Jumlah stok minimal 0.',
        ]);

        Buku::create($validated);

        return redirect()->route('buku.index')->with('success', 'Buku baru berhasil ditambahkan ke katalog!');
    }

    /**
     * Tampilkan detail lengkap satu buku dengan relasi kategorinya.
     */
    public function show(Buku $buku)
    {
        $buku->load('kategori');
        return view('buku.show', compact('buku'));
    }

    /**
     * Tampilkan form edit buku.
     */
    public function edit(Buku $buku)
    {
        $kategoris = Kategori::orderBy('nama_kategori')->get();
        return view('buku.edit', compact('buku', 'kategoris'));
    }

    /**
     * Perbarui data buku di database.
     */
    public function update(Request $request, Buku $buku)
    {
        $validated = $request->validate([
            'isbn'         => [
                'required',
                'string',
                'max:20',
                Rule::unique('bukus', 'isbn')->ignore($buku->id),
            ],
            'judul'        => 'required|string|min:5|max:255',
            'penulis'      => 'required|string|min:3|max:150',
            'penerbit'     => 'required|string|min:3|max:150',
            'tahun_terbit' => 'required|integer|digits:4|min:1900|max:' . date('Y'),
            'kategori_id'  => 'required|exists:kategoris,id',
            'stok'         => 'required|integer|min:0',
            'sinopsis'     => 'nullable|string',
        ], [
            'isbn.required'         => 'Nomor ISBN wajib diisi.',
            'isbn.unique'           => 'ISBN sudah digunakan buku lain.',
            'judul.required'        => 'Judul buku wajib diisi.',
            'judul.min'             => 'Judul buku minimal 5 karakter.',
            'stok.min'              => 'Jumlah stok tidak boleh bernilai negatif.',
        ]);

        $buku->update($validated);

        return redirect()->route('buku.index')->with('success', 'Data buku berhasil diperbarui!');
    }

    /**
     * Hapus buku dari katalog.
     */
    public function destroy(Buku $buku)
    {
        $buku->delete();
        return redirect()->route('buku.index')->with('success', 'Buku berhasil dihapus dari sistem!');
    }
}