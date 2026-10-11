<x-layout>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="h3 fw-bold text-dark mb-1">
                Kategori: {{ $kategori->nama_kategori }} ({{ $kategori->kode_kategori }})
            </h2>
            <p class="text-muted small mb-0">Daftar buku yang termasuk dalam kategori ini</p>
        </div>
        <a href="{{ route('kategori.index') }}" class="btn btn-light border">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-3">ISBN</th>
                        <th>Judul Buku</th>
                        <th>Penulis</th>
                        <th>Penerbit</th>
                        <th class="text-center">Stok</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kategori->bukus as $buku)
                        <tr>
                            <td class="ps-3"><code>{{ $buku->isbn }}</code></td>
                            <td class="fw-semibold">
                                <a href="{{ route('buku.show', $buku) }}" class="text-decoration-none text-dark">{{ $buku->judul }}</a>
                            </td>
                            <td>{{ $buku->penulis }}</td>
                            <td>{{ $buku->penerbit }} ({{ $buku->tahun_terbit }})</td>
                            <td class="text-center">
                                <span class="badge bg-secondary-subtle text-dark border px-2 py-1">{{ $buku->stok }} eks</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">
                                Belum ada buku yang terkait dengan kategori ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-layout>