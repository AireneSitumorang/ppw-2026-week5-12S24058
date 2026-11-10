<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PeminjamanResource extends JsonResource
{
    /**
     * Mengubah data peminjaman menjadi format JSON.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'kode_pinjam' => $this->kode_pinjam,
            'buku_id' => $this->buku_id,
            'nim_peminjam' => $this->nim_peminjam,
            'nama_peminjam' => $this->nama_peminjam,
            'tanggal_pinjam' => $this->tanggal_pinjam,
            'tanggal_jatuh_tempo' => $this->tanggal_jatuh_tempo,
            'tanggal_kembali' => $this->tanggal_kembali,
            'status' => $this->status,

            // Informasi buku jika relasi sudah dimuat
            'buku' => $this->whenLoaded('buku', function () {
                return [
                    'id' => $this->buku->id,
                    'isbn' => $this->buku->isbn,
                    'judul' => $this->buku->judul,
                    'stok' => $this->buku->stok,
                ];
            }),

            // Link pengembalian hanya untuk peminjaman aktif
            '_links' => $this->when(
                $this->status === 'dipinjam',
                [
                    'kembalikan_buku' => [
                        'href' => url(
                            "/api/v1/peminjamans/{$this->id}/kembalikan"
                        ),
                        'method' => 'PATCH',
                    ],
                ]
            ),
        ];
    }
}
