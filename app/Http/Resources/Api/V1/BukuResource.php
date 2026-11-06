
<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BukuResource extends JsonResource
{
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

            'kategori' => $this->whenLoaded('kategori', function () {
                return [
                    'id' => $this->kategori->id,
                    'kode_kategori' => $this->kategori->kode_kategori,
                    'nama_kategori' => $this->kategori->nama_kategori,
                ];
            }),

            'peminjamans_count' => $this->whenCounted('peminjamans'),
        ];
    }
}
