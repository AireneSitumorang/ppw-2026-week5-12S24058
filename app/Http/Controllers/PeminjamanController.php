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
    // 1. Proses Peminjaman Buku (ACID & lockForUpdate)
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
                // Pessimistic Locking untuk mencegah race condition stok
                $buku = Buku::where('id', $validated['buku_id'])->lockForUpdate()->firstOrFail();

                if ($buku->stok < 1) {
                    throw new \RuntimeException("Maaf, stok buku '{$buku->judul}' telah habis!");
                }

                // Cek peminjaman aktif ganda oleh NIM yang sama
                $cekPinjamAktif = Peminjaman::where('buku_id', $buku->id)
                    ->where('nim_peminjam', $validated['nim_peminjam'])
                    ->where('status', 'dipinjam')
                    ->exists();

                if ($cekPinjamAktif) {
                    throw new \RuntimeException("Anda sudah meminjam buku ini dan belum mengembalikannya.");
                }

                // Kurangi stok dan catat peminjaman secara atomik
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

    // 2. Proses Pengembalian Buku (ACID, lockForUpdate, & Increment Stok)
    public function kembalikan($id)
    {
        try {
            DB::transaction(function () use ($id) {
                // Kunci data peminjaman dan buku terkait
                $peminjaman = Peminjaman::where('id', $id)->lockForUpdate()->firstOrFail();

                if ($peminjaman->status === 'dikembalikan') {
                    throw new \RuntimeException("Buku ini sudah dikembalikan sebelumnya.");
                }

                $buku = Buku::where('id', $peminjaman->buku_id)->lockForUpdate()->firstOrFail();

                // Ubah status peminjaman dan isi tanggal kembali
                $peminjaman->update([
                    'status' => 'dikembalikan',
                    'tanggal_kembali' => now(),
                ]);

                // Kembalikan stok buku
                $buku->increment('stok');
            }, 3);

            return back()->with('success', 'Pengembalian buku berhasil diproses dan stok telah diperbarui!');

        } catch (\RuntimeException $e) {
            return back()->with('error', $e->getMessage());
        } catch (QueryException $e) {
            Log::error('[DB EXCEPTION Pengembalian]: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan pada basis data saat pengembalian.');
        }
    }
}