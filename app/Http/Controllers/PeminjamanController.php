<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\QueryException;
use App\Models\Peminjaman;
use App\Models\Buku;
use RuntimeException;

class PeminjamanController extends Controller
{
    public function index()
    {
        $peminjamans = Peminjaman::with('buku')->orderBy('created_at', 'desc')->paginate(10);
        $bukus = Buku::where('stok', '>', 0)->get();
        return view('peminjaman.index', compact('peminjamans', 'bukus'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'buku_id' => 'required|exists:bukus,id',
            'nim_peminjam' => 'required|string|max:20',
            'nama_peminjam' => 'required|string|max:150',
            'tanggal_jatuh_tempo' => 'required|date',
        ]);

        try {
            DB::transaction(function () use ($validated) {
                // Pessimistic Locking untuk mencegah race condition stok buku
                $buku = Buku::where('id', $validated['buku_id'])->lockForUpdate()->firstOrFail();

                if ($buku->stok < 1) {
                    throw new RuntimeException("Stok buku '{$buku->judul}' telah habis!");
                }

                // Cek apakah NIM yang sama meminjam buku yang sama dan belum dikembalikan
                $existingActiveLoan = Peminjaman::where('buku_id', $validated['buku_id'])
                    ->where('nim_peminjam', $validated['nim_peminjam'])
                    ->where('status', 'dipinjam')
                    ->exists();

                if ($existingActiveLoan) {
                    throw new RuntimeException("NIM ini sedang meminjam buku tersebut dan belum mengembalikannya.");
                }

                $buku->decrement('stok');

                Peminjaman::create([
                    'kode_pinjam' => 'PINJAM-' . strtoupper(uniqid()),
                    'buku_id' => $buku->id,
                    'nim_peminjam' => strtoupper(trim($validated['nim_peminjam'])),
                    'nama_peminjam' => $validated['nama_peminjam'],
                    'tanggal_pinjam' => now(),
                    'tanggal_jatuh_tempo' => $validated['tanggal_jatuh_tempo'],
                    'status' => 'dipinjam',
                ]);
            }, 3);

            return back()->with('success', 'Transaksi peminjaman berhasil dicatat secara atomik!');
        } catch (RuntimeException $e) {
            return back()->withInput()->with('error', $e->getMessage());
        } catch (QueryException $e) {
            Log::error('[DB EXCEPTION] ' . $e->getMessage());
            return back()->withInput()->with('error', 'Terjadi kesalahan basis data.');
        }
    }

    public function kembali(int $id)
    {
        try {
            DB::transaction(function () use ($id) {
                $peminjaman = Peminjaman::where('id', $id)->lockForUpdate()->firstOrFail();

                if ($peminjaman->status === 'dikembalikan') {
                    throw new RuntimeException("Buku ini sudah dikembalikan sebelumnya.");
                }

                $buku = Buku::where('id', $peminjaman->buku_id)->lockForUpdate()->firstOrFail();
                $buku->increment('stok');

                $peminjaman->update([
                    'status' => 'dikembalikan',
                    'tanggal_kembali' => now(),
                ]);
            }, 3);

            return back()->with('success', 'Buku berhasil dikembalikan dan stok diperbarui.');
        } catch (RuntimeException $e) {
            return back()->with('error', $e->getMessage());
        } catch (QueryException $e) {
            Log::error('[DB EXCEPTION RETURN] ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat memproses pengembalian.');
        }
    }
}