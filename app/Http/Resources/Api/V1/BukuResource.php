<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BukuResource extends JsonResource
{
    /**
     * Mengubah data buku menjadi format JSON.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'isbn' => $this->isbn,
            'judul' => $this->judul,
            'penulis' => $this->penulis,
            'penerbit' => $this->penerbit,
            'tahun_terbit' => $this->tahun_terbit,
            'stok' => $this->stok,
            'sinopsis' => $this->sinopsis,

            // Informasi kategori buku
            'kategori' => $this->whenLoaded('kategori', function () {
                return [
                    'id' => $this->kategori->id,
                    'kode_kategori' => $this->kategori->kode_kategori,
                    'nama_kategori' => $this->kategori->nama_kategori,
                ];
            }),

            // Jumlah seluruh peminjaman buku
            'peminjamans_count' => $this->whenCounted('peminjamans'),

            // Riwayat peminjaman jika relasi dimuat
            'riwayat_peminjaman' => PeminjamanResource::collection(
                $this->whenLoaded('peminjamans')
            ),

            // HATEOAS: link peminjaman hanya jika stok tersedia
            '_links' => $this->when(
                (int) $this->stok > 0,
                [
                    'pinjam_buku' => [
                        'href' => url('/api/v1/peminjamans'),
                        'method' => 'POST',
                    ],
                ]
            ),
        ];
    }
}
