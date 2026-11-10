
<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Peminjaman;
use App\Http\Resources\Api\V1\PeminjamanResource;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PeminjamanApiController extends Controller
{
    use ApiResponse;

    // Menampilkan daftar peminjaman
    public function index(Request $request)
    {
        $query = Peminjaman::with('buku');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('nim')) {
            $query->where('nim_peminjam', $request->nim);
        }

        $peminjamans = $query
            ->latest()
            ->paginate(10);

        return PeminjamanResource::collection($peminjamans);
    }

    // Menampilkan detail peminjaman
    public function show($id)
    {
        $peminjaman = Peminjaman::with('buku')->find($id);

        if (!$peminjaman) {
            return $this->errorResponse(
                'Data peminjaman tidak ditemukan.',
                404
            );
        }

        return new PeminjamanResource($peminjaman);
    }

    // Membuat peminjaman dengan transaksi ACID
    public function store(Request $request)
    {
        $validated = $request->validate([
            'buku_id' => 'required|exists:bukus,id',
            'nim_peminjam' => 'required|string|max:50',
            'nama_peminjam' => 'required|string|max:255',
            'durasi_hari' => 'required|integer|min:1|max:365',
        ]);

        $result = DB::transaction(function () use ($validated) {

            $buku = Buku::where('id', $validated['buku_id'])
                ->lockForUpdate()
                ->first();

            if (!$buku) {
                return ['error' => 'Buku tidak ditemukan.', 'status' => 404];
            }

            if ($buku->stok < 1) {
                return ['error' => 'Stok buku tidak tersedia.', 'status' => 422];
            }

            $existingLoan = Peminjaman::where(
                'buku_id',
                $buku->id
            )
                ->where('nim_peminjam', $validated['nim_peminjam'])
                ->where('status', 'dipinjam')
                ->exists();

            if ($existingLoan) {
                return [
                    'error' => 'Mahasiswa masih memiliki peminjaman aktif untuk buku ini.',
                    'status' => 409
                ];
            }

            $tanggalPinjam = now();

            $peminjaman = Peminjaman::create([
                'kode_pinjam' => 'PJM-' . $tanggalPinjam->format('YmdHis') . '-' . strtoupper(Str::random(4)),
                'buku_id' => $buku->id,
                'nim_peminjam' => $validated['nim_peminjam'],
                'nama_peminjam' => $validated['nama_peminjam'],
                'tanggal_pinjam' => $tanggalPinjam->toDateString(),
                'tanggal_jatuh_tempo' => $tanggalPinjam
                    ->copy()
                    ->addDays($validated['durasi_hari'])
                    ->toDateString(),
                'tanggal_kembali' => null,
                'status' => 'dipinjam',
            ]);

            $buku->decrement('stok');

            return [
                'data' => $peminjaman->load('buku'),
                'status' => 201
            ];
        });

        if (isset($result['error'])) {
            return $this->errorResponse(
                $result['error'],
                $result['status']
            );
        }

        $peminjaman = $result['data'];

        return (new PeminjamanResource($peminjaman))
            ->response()
            ->setStatusCode(201)
            ->header(
                'Location',
                url('/api/v1/peminjamans/' . $peminjaman->id)
            );
    }

    // Mengembalikan buku dengan transaksi ACID
    public function kembalikan($id)
    {
        $result = DB::transaction(function () use ($id) {

            $peminjaman = Peminjaman::where('id', $id)
                ->lockForUpdate()
                ->first();

            if (!$peminjaman) {
                return [
                    'error' => 'Data peminjaman tidak ditemukan.',
                    'status' => 404
                ];
            }

            if ($peminjaman->status === 'dikembalikan') {
                return [
                    'error' => 'Buku sudah dikembalikan sebelumnya.',
                    'status' => 409
                ];
            }

            $buku = Buku::where('id', $peminjaman->buku_id)
                ->lockForUpdate()
                ->first();

            if (!$buku) {
                return [
                    'error' => 'Data buku tidak ditemukan.',
                    'status' => 404
                ];
            }

            $peminjaman->update([
                'status' => 'dikembalikan',
                'tanggal_kembali' => now()->toDateString(),
            ]);

            $buku->increment('stok');

            return [
                'data' => $peminjaman->fresh()->load('buku'),
                'status' => 200
            ];
        });

        if (isset($result['error'])) {
            return $this->errorResponse(
                $result['error'],
                $result['status']
            );
        }

        return new PeminjamanResource($result['data']);
    }
}
