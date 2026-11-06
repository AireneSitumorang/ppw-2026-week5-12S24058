<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\BukuResource;
use App\Models\Buku;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class BukuApiController extends Controller
{
    use ApiResponse;

    /**
     * Menampilkan daftar buku.
     */
    public function index(Request $request)
    {
        // Mengambil data buku beserta kategori dan jumlah peminjaman
        $query = Buku::with('kategori')
            ->withCount('peminjamans');

        // 1. Pencarian berdasarkan judul, penulis, atau ISBN
        if ($request->filled('search')) {
            $search = $request->input('search');

            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                    ->orWhere('penulis', 'like', "%{$search}%")
                    ->orWhere('isbn', 'like', "%{$search}%");
            });
        }

        // 2. Filter berdasarkan kategori
        if ($request->filled('kategori_id')) {
            $query->where('kategori_id', $request->input('kategori_id'));
        }

        // 3. Filter buku yang tersedia
        if ($request->input('tersedia') == '1') {
            $query->where('stok', '>', 0);
        }

        // 4. Pengurutan data
        $allowedSorts = [
            'judul',
            'tahun_terbit',
            'stok',
            'created_at',
        ];

        $sort = $request->input('sort', 'created_at');

        if (!in_array($sort, $allowedSorts, true)) {
            $sort = 'created_at';
        }

        $order = strtolower($request->input('order', 'desc'));

        if (!in_array($order, ['asc', 'desc'], true)) {
            $order = 'desc';
        }

        $query->orderBy($sort, $order);

        // 5. Pagination: 10 buku setiap halaman
        $bukus = $query->paginate(10)->withQueryString();

        // 6. Mengubah data buku menjadi format Resource
        $items = BukuResource::collection(
            $bukus->getCollection()
        )->resolve();

        // 7. Mengirim respons JSON
        return $this->successResponse([
            'items' => $items,

            'pagination' => [
                'current_page' => $bukus->currentPage(),
                'last_page' => $bukus->lastPage(),
                'per_page' => $bukus->perPage(),
                'total' => $bukus->total(),
            ],
        ], 'Daftar buku berhasil diambil');
    }
}
