<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\BukuResource;
use App\Models\Buku;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BukuApiController extends Controller
{
    use ApiResponse;

    /**
     * Menampilkan daftar buku.
     */
    public function index(Request $request)
    {
        $query = Buku::with('kategori')
            ->withCount('peminjamans');

        // Pencarian berdasarkan judul, penulis, atau ISBN
        if ($request->filled('search')) {
            $search = $request->input('search');

            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                    ->orWhere('penulis', 'like', "%{$search}%")
                    ->orWhere('isbn', 'like', "%{$search}%");
            });
        }

        // Filter berdasarkan kategori
        if ($request->filled('kategori_id')) {
            $query->where('kategori_id', $request->input('kategori_id'));
        }

        // Filter buku yang tersedia
        if ($request->input('tersedia') == '1') {
            $query->where('stok', '>', 0);
        }

        // Pengurutan berdasarkan kolom yang diizinkan
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

        // Pagination
        $bukus = $query->paginate(10)->withQueryString();

        $items = BukuResource::collection(
            $bukus->getCollection()
        )->resolve();

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

    /**
     * Menampilkan detail buku beserta riwayat peminjaman.
     */
    public function show(string $id)
    {
        $buku = Buku::with([
            'kategori',
            'peminjamans',
        ])
            ->withCount('peminjamans')
            ->find($id);

        if (!$buku) {
            return $this->errorResponse(
                'Buku tidak ditemukan',
                404
            );
        }

        return $this->successResponse(
            (new BukuResource($buku))->resolve(),
            'Detail buku berhasil diambil'
        );
    }

    /**
     * Menambahkan buku baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'isbn' => [
                'required',
                'string',
                'max:30',
                'unique:bukus,isbn',
            ],
            'judul' => 'required|string|max:255',
            'penulis' => 'required|string|max:150',
            'penerbit' => 'required|string|max:150',
            'tahun_terbit' => 'required|integer|min:1901|max:2155',
            'kategori_id' => 'required|exists:kategoris,id',
            'stok' => 'required|integer|min:0',
            'sinopsis' => 'nullable|string',
        ]);

        $buku = Buku::create($validated);

        $buku->load('kategori')
            ->loadCount('peminjamans');

        $response = $this->successResponse(
            (new BukuResource($buku))->resolve(),
            'Buku berhasil ditambahkan',
            201
        );

        // Location header menuju detail buku yang baru dibuat
        return $response->header(
            'Location',
            url("/api/v1/bukus/{$buku->id}")
        );
    }

    /**
     * Mengganti seluruh data buku (PUT).
     */
    public function update(Request $request, string $id)
    {
        $buku = Buku::find($id);

        if (!$buku) {
            return $this->errorResponse(
                'Buku tidak ditemukan',
                404
            );
        }

        $validated = $request->validate([
            'isbn' => [
                'required',
                'string',
                'max:30',
                Rule::unique('bukus', 'isbn')->ignore($buku->id),
            ],
            'judul' => 'required|string|max:255',
            'penulis' => 'required|string|max:150',
            'penerbit' => 'required|string|max:150',
            'tahun_terbit' => 'required|integer|min:1901|max:2155',
            'kategori_id' => 'required|exists:kategoris,id',
            'stok' => 'required|integer|min:0',
            'sinopsis' => 'required|nullable|string',
        ]);

        $buku->update($validated);

        $buku->load('kategori')
            ->loadCount('peminjamans');

        return $this->successResponse(
            (new BukuResource($buku))->resolve(),
            'Buku berhasil diganti'
        );
    }

    /**
     * Memperbarui sebagian data buku (PATCH).
     */
    public function partialUpdate(Request $request, string $id)
    {
        $buku = Buku::find($id);

        if (!$buku) {
            return $this->errorResponse(
                'Buku tidak ditemukan',
                404
            );
        }

        $validated = $request->validate([
            'isbn' => [
                'sometimes',
                'required',
                'string',
                'max:30',
                Rule::unique('bukus', 'isbn')->ignore($buku->id),
            ],
            'judul' => 'sometimes|required|string|max:255',
            'penulis' => 'sometimes|required|string|max:150',
            'penerbit' => 'sometimes|required|string|max:150',
            'tahun_terbit' => 'sometimes|required|integer|min:1901|max:2155',
            'kategori_id' => 'sometimes|required|exists:kategoris,id',
            'stok' => 'sometimes|required|integer|min:0',
            'sinopsis' => 'sometimes|nullable|string',
        ]);

        if (empty($validated)) {
            return $this->errorResponse(
                'Tidak ada data yang diperbarui',
                422
            );
        }

        $buku->update($validated);

        $buku->load('kategori')
            ->loadCount('peminjamans');

        return $this->successResponse(
            (new BukuResource($buku))->resolve(),
            'Buku berhasil diperbarui'
        );
    }

    /**
     * Menghapus buku.
     */
    public function destroy(string $id)
    {
        $buku = Buku::find($id);

        if (!$buku) {
            return $this->errorResponse(
                'Buku tidak ditemukan',
                404
            );
        }

        // Tolak penghapusan jika masih ada peminjaman aktif
        $hasActiveLoan = $buku->peminjamans()
            ->where('status', 'dipinjam')
            ->exists();

        if ($hasActiveLoan) {
            return $this->errorResponse(
                'Buku tidak dapat dihapus karena masih dipinjam',
                409
            );
        }

        $buku->delete();

        // Berhasil dihapus: HTTP 204 tanpa isi respons
        return response()->noContent();
    }
}
