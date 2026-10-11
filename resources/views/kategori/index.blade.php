<x-layout>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="h3 fw-bold text-dark mb-1">
                <i class="bi bi-tags-fill text-primary me-2"></i>Kategori Buku
            </h2>
            <p class="text-muted small mb-0">Manajemen klasifikasi dan kategori buku perpustakaan</p>
        </div>
        <a href="{{ route('kategori.create') }}" class="btn btn-del shadow-sm">
            <i class="bi bi-plus-circle me-1"></i> Tambah Kategori
        </a>
    </div>

    <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-3" style="width: 8%;">#</th>
                        <th style="width: 25%;">Kode Kategori</th>
                        <th style="width: 40%;">Nama Kategori</th>
                        <th class="text-center" style="width: 15%;">Jumlah Koleksi</th>
                        <th class="text-end pe-3" style="width: 12%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kategoris as $index => $kategori)
                        <tr>
                            <td class="ps-3 text-muted">{{ $kategoris->firstItem() + $index }}</td>
                            <td><span class="badge badge-del px-2 py-1 rounded">{{ $kategori->kode_kategori }}</span></td>
                            <td class="fw-semibold">{{ $kategori->nama_kategori }}</td>
                            <td class="text-center">
                                <span class="badge bg-secondary-subtle text-dark border px-2 py-1 rounded-pill">
                                    {{ $kategori->bukus_count ?? $kategori->bukus()->count() }} buku
                                </span>
                            </td>
                            <td class="text-end pe-3">
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('kategori.show', $kategori) }}" class="btn btn-outline-secondary" title="Detail">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('kategori.edit', $kategori) }}" class="btn btn-outline-primary" title="Ubah">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('kategori.destroy', $kategori) }}" method="POST" class="d-inline" onsubmit="return confirm('Menghapus kategori akan menghapus semua buku di dalamnya. Lanjutkan?');">
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
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                Belum ada kategori yang terdaftar.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($kategoris->hasPages())
            <div class="card-footer bg-white py-3">
                <div class="d-flex justify-content-end">
                    {{ $kategoris->links('pagination::bootstrap-5') }}
                </div>
            </div>
        @endif
    </div>
</x-layout>