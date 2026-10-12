<x-layout title="Data Buku">
    <div class="row mb-4 align-items-center">
        <div class="col-md-7">
            <h2 class="fw-bold text-dark mb-1">📚 Data Buku</h2>
            <p class="text-muted mb-0">Kelola dan pantau koleksi buku perpustakaan secara terstruktur.</p>
        </div>
        <div class="col-md-5 text-md-end mt-3 mt-md-0">
            <a href="{{ route('buku.create') }}" class="btn btn-del">
                <i class="bi bi-plus-lg me-1"></i> + Tambah Buku
            </a>
        </div>
    </div>

    <!-- Area Pencarian dan Filter -->
    <div class="card-custom p-3 mb-4">
        <form action="{{ route('buku.index') }}" method="GET" class="row g-3 align-items-center">
            <div class="col-md-7">
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" name="search" value="{{ request('search') }}" class="form-control border-start-0 bg-light" placeholder="Cari berdasarkan judul atau ISBN...">
                </div>
            </div>
            <div class="col-md-3">
                <select name="kategori_id" class="form-select bg-light">
                    <option value="">-- Semua Kategori --</option>
                    @foreach($kategoris as $kategori)
                        <option value="{{ $kategori->id }}" {{ request('kategori_id') == $kategori->id ? 'selected' : '' }}>
                            {{ $kategori->nama_kategori }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 d-flex gap-2">
                <button type="submit" class="btn btn-del w-100">Filter</button>
                @if(request('search') || request('kategori_id'))
                    <a href="{{ route('buku.index') }}" class="btn btn-outline-secondary" title="Reset Filter"><i class="bi bi-arrow-clockwise"></i></a>
                @endif
            </div>
        </form>
    </div>

    <!-- Tabel Buku -->
    <div class="card-custom p-4">
        <div class="table-responsive">
            <table class="table table-custom align-middle mb-0">
                <thead>
                    <tr>
                        <th class="ps-3">No</th>
                        <th>ISBN</th>
                        <th>Judul Buku</th>
                        <th>Penulis</th>
                        <th>Kategori</th>
                        <th>Tahun</th>
                        <th class="text-center">Stok</th>
                        <th class="text-end pe-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bukus as $index => $buku)
                        <tr>
                            <td class="ps-3 fw-semibold text-secondary">{{ $bukus->firstItem() + $index }}</td>
                            <td><code>{{ $buku->isbn }}</code></td>
                            <td>
                                <span class="fw-bold text-dark d-block">{{ $buku->judul }}</span>
                                <small class="text-muted">Penerbit: {{ $buku->penerbit }}</small>
                            </td>
                            <td>{{ $buku->penulis }}</td>
                            <td><span class="badge bg-light text-dark border">{{ $buku->kategori->nama_kategori ?? 'Umum' }}</span></td>
                            <td>{{ $buku->tahun_terbit }}</td>
                            <td class="text-center">
                                @if($buku->stok > 0)
                                    <span class="badge bg-success bg-opacity-10 text-success border border-success-subtle px-2 py-1">Tersedia ({{ $buku->stok }})</span>
                                @else
                                    <span class="badge bg-danger bg-opacity-10 text-danger border border-danger-subtle px-2 py-1">Habis</span>
                                @endif
                            </td>
                            <td class="text-end pe-3">
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('buku.show', $buku->id) }}" class="btn btn-outline-secondary border-0" title="Detail"><i class="bi bi-eye text-primary"></i></a>
                                    <a href="{{ route('buku.edit', $buku->id) }}" class="btn btn-outline-secondary border-0" title="Edit"><i class="bi bi-pencil-square text-warning"></i></a>
                                    <form action="{{ route('buku.destroy', $buku->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus buku ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-secondary border-0" title="Hapus"><i class="bi bi-trash text-danger"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-5 text-muted fst-italic">
                                <i class="bi bi-inbox fs-2 d-block mb-2 text-secondary"></i>
                                Tidak ada data buku yang ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-4 d-flex justify-content-between align-items-center flex-column flex-md-row gap-3">
            <div class="text-muted small">
                Menampilkan data <strong>{{ $bukus->firstItem() ?? 0 }}</strong> - <strong>{{ $bukus->lastItem() ?? 0 }}</strong> dari total <strong>{{ $bukus->total() }}</strong> buku.
            </div>
            <div>
                {{ $bukus->links() }}
            </div>
        </div>
    </div>
</x-layout>