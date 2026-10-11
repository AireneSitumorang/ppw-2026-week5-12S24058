<x-layout>
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header card-header-del d-flex justify-content-between align-items-center py-3">
                    <h5 class="card-title mb-0"><i class="bi bi-book me-2"></i>Detail Informasi Buku</h5>
                    <a href="{{ route('buku.index') }}" class="btn btn-sm btn-light">
                        <i class="bi bi-arrow-left me-1"></i> Kembali
                    </a>
                </div>
                <div class="card-body p-4">
                    <h3 class="fw-bold text-dark mb-2">{{ $buku->judul }}</h3>
                    <div class="mb-4">
                        <span class="badge badge-del px-3 py-2 fs-6 rounded-pill">
                            <i class="bi bi-tag-fill me-1"></i> {{ $buku->kategori->nama_kategori ?? 'Tanpa Kategori' }}
                        </span>
                    </div>

                    <table class="table table-bordered mb-4">
                        <tbody>
                            <tr>
                                <th class="bg-light" style="width: 30%;">Nomor ISBN</th>
                                <td><code>{{ $buku->isbn }}</code></td>
                            </tr>
                            <tr>
                                <th class="bg-light">Penulis</th>
                                <td>{{ $buku->penulis }}</td>
                            </tr>
                            <tr>
                                <th class="bg-light">Penerbit</th>
                                <td>{{ $buku->penerbit }}</td>
                            </tr>
                            <tr>
                                <th class="bg-light">Tahun Terbit</th>
                                <td>{{ $buku->tahun_terbit }}</td>
                            </tr>
                            <tr>
                                <th class="bg-light">Ketersediaan Stok</th>
                                <td>
                                    @if($buku->stok > 0)
                                        <span class="badge bg-success">{{ $buku->stok }} eksemplar tersedia</span>
                                    @else
                                        <span class="badge bg-danger">Stok Kosong</span>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <h6 class="fw-bold text-secondary mb-2">Sinopsis Buku:</h6>
                    <div class="p-3 bg-light rounded-3 text-secondary lh-base mb-4">
                        {{ $buku->sinopsis ?: 'Tidak ada sinopsis untuk buku ini.' }}
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('buku.edit', $buku) }}" class="btn btn-outline-primary">
                            <i class="bi bi-pencil me-1"></i> Edit Buku
                        </a>
                        <form action="{{ route('buku.destroy', $buku) }}" method="POST" onsubmit="return confirm('Hapus buku ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger">
                                <i class="bi bi-trash me-1"></i> Hapus Buku
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>