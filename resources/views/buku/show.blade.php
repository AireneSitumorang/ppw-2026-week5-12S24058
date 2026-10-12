<x-layout title="Detail Buku">
    <div class="row justify-content-center">
        <div class="col-md-9">
            <div class="card-custom p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3 class="fw-bold text-dark mb-0">📖 Detail Informasi Buku</h3>
                    <a href="{{ route('buku.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                        &larr; Kembali ke Daftar
                    </a>
                </div>

                <div class="row g-4 mb-4">
                    <div class="col-md-6">
                        <span class="text-muted small text-uppercase fw-semibold">ISBN</span>
                        <p class="fw-bold fs-6 font-monospace mb-3">{{ $buku->isbn }}</p>
                        
                        <span class="text-muted small text-uppercase fw-semibold">Judul Buku</span>
                        <h4 class="fw-bold text-dark mb-3">{{ $buku->judul }}</h4>

                        <span class="text-muted small text-uppercase fw-semibold">Kategori</span>
                        <p class="mb-3"><span class="badge bg-purple bg-opacity-10 text-purple border px-3 py-2">{{ $buku->kategori->nama_kategori ?? '-' }}</span></p>
                    </div>
                    <div class="col-md-6">
                        <span class="text-muted small text-uppercase fw-semibold">Penulis</span>
                        <p class="fw-medium mb-3">{{ $buku->penulis }}</p>

                        <span class="text-muted small text-uppercase fw-semibold">Penerbit & Tahun</span>
                        <p class="fw-medium mb-3">{{ $buku->penerbit }} ({{ $buku->tahun_terbit }})</p>

                        <span class="text-muted small text-uppercase fw-semibold">Stok Tersedia</span>
                        <p class="mb-3"><span class="badge bg-secondary px-3 py-2">{{ $buku->stok }} Eksemplar</span></p>
                    </div>
                </div>

                <div class="mb-4">
                    <span class="text-muted small text-uppercase fw-semibold">Sinopsis / Ringkasan</span>
                    <div class="p-3 bg-light rounded-4 mt-1 text-secondary">
                        {{ $buku->sinopsis ?: 'Tidak ada sinopsis yang tersedia untuk buku ini.' }}
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 border-top pt-3">
                    <a href="{{ route('buku.edit', $buku->id) }}" class="btn btn-warning px-4 text-white rounded-pill">
                        <i class="bi bi-pencil-square me-1"></i> Edit Buku
                    </a>
                    <form action="{{ route('buku.destroy', $buku->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus buku ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger px-4 rounded-pill">
                            <i class="bi bi-trash me-1"></i> Hapus Buku
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-layout>