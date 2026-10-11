<x-layout>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="h3 fw-bold text-dark mb-1">
                <i class="bi bi-journal-bookmark-fill text-primary me-2"></i>Katalog Koleksi Buku
            </h2>
            <p class="text-muted small mb-0">Daftar koleksi buku terdaftar pada Sistem Informasi Perpustakaan Del</p>
        </div>
        <a href="{{ route('buku.create') }}" class="btn btn-del shadow-sm">
            <i class="bi bi-plus-circle me-1"></i> Tambah Buku Baru
        </a>
    </div>

    <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-3" style="width: 5%;">#</th>
                        <th style="width: 15%;">ISBN</th>
                        <th style="width: 30%;">Judul Buku</th>
                        <th style="width: 15%;">Penulis</th>
                        <th style="width: 15%;">Kategori</th>
                        <th class="text-center" style="width: 8%;">Stok</th>
                        <th class="text-end pe-3" style="width: 12%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bukus as $index => $buku)
                        <tr>
                            <td class="ps-3 text-muted">{{ $bukus->firstItem() + $index }}</td>
                            <td><code>{{ $buku->isbn }}</code></td>
                            <td>
                                <a href="{{ route('buku.show', $buku) }}" class="fw-semibold text-decoration-none text-dark">
                                    {{ $buku->judul }}
                                </a>
                                <div class="text-muted small">{{ $buku->penerbit }} ({{ $buku->tahun_terbit }})</div>
                            </td>
                            <td>{{ $buku->penulis }}</td>
                            <td>
                                <span class="badge badge-del px-2 py-1 rounded-pill">
                                    {{ $buku->kategori->nama_kategori ?? 'Tanpa Kategori' }}
                                </span>
                            </td>
                            <td class="text-center">
                                @if($buku->stok > 0)
                                    <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1 rounded-pill">{{ $buku->stok }} eks</span>
                                @else
                                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1 rounded-pill">Habis</span>
                                @endif
                            </td>
                            <td class="text-end pe-3">
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('buku.show', $buku) }}" class="btn btn-outline-secondary" title="Detail">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('buku.edit', $buku) }}" class="btn btn-outline-primary" title="Ubah">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('buku.destroy', $buku) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus buku ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger" title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                Belum ada koleksi buku yang tersedia.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($bukus->hasPages())
            <div class="card-footer bg-white py-3">
                <div class="d-flex justify-content-end">
                    {{ $bukus->links('pagination::bootstrap-5') }}
                </div>
            </div>
        @endif
    </div>
</x-layout>