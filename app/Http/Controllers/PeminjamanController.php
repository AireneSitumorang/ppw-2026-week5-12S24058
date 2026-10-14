<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use App\Models\Buku;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\Log;

class PeminjamanController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'buku_id' => 'required|exists:bukus,id',
            'nim_peminjam' => 'required|string|max:15',
            'nama_peminjam' => 'required|string|max:150',
            'tanggal_jatuh_tempo' => 'required|date|after:today',
        ]);

        try {
            DB::transaction(function () use ($validated) {
                $buku = Buku::where('id', $validated['buku_id'])->lockForUpdate()->firstOrFail();

                if ($buku->stok < 1) {
                    throw new \RuntimeException("Maaf, stok buku '{$buku->judul}' telah habis!");
                }

                $cekPinjamAktif = Peminjaman::where('buku_id', $buku->id)
                    ->where('nim_peminjam', $validated['nim_peminjam'])
                    ->where('status', 'dipinjam')
                    ->exists();

                if ($cekPinjamAktif) {
                    throw new \RuntimeException("Anda sudah meminjam buku ini dan belum mengembalikannya.");
                }

                $buku->decrement('stok');

                Peminjaman::create([
                    'kode_pinjam' => 'PINJAM-' . date('Ymd') . '-' . strtoupper(uniqid()),
                    'buku_id' => $buku->id,
                    'nim_peminjam' => strtoupper(trim($validated['nim_peminjam'])),
                    'nama_peminjam' => $validated['nama_peminjam'],
                    'tanggal_pinjam' => now(),
                    'tanggal_jatuh_tempo' => $validated['tanggal_jatuh_tempo'],
                    'status' => 'dipinjam',
                ]);
            }, 3);

            return back()->with('success', 'Peminjaman buku berhasil dicatat secara atomik!');

        } catch (\RuntimeException $e) {
            return back()->withInput()->with('error', $e->getMessage());
        } catch (QueryException $e) {
            Log::error('[DB EXCEPTION Peminjaman]: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Terjadi kesalahan pada basis data.');
        }
    }
}