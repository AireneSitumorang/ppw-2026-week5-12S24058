<x-layout title="Dashboard">
    <!-- Header Sapaan -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
        <div>
            <h2 class="fw-bold text-dark mb-1">👋 Selamat Datang di SIPUS-Del</h2>
            <p class="text-muted mb-0">Kelola dan pantau koleksi literatur perpustakaan kampus Institut Teknologi Del.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('buku.create') }}" class="btn btn-del">
                <i class="bi bi-plus-lg me-1"></i> Tambah Buku
            </a>
            <a href="{{ route('kategori.index') }}" class="btn btn-outline-purple rounded-pill px-4 fw-semibold text-purple border-purple" style="border-color: #4C1D95; color: #4C1D95;">
                <i class="bi bi-tags me-1"></i> Kelola Kategori
            </a>
        </div>
    </div>

    <!-- 4 Card Statistik Dinamis -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card-custom p-4 border-start border-4 border-primary">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <span class="text-muted small text-uppercase fw-semibold">Total Buku</span>
                        <h3 class="fw-bold text-dark mt-1 mb-0">{{ $totalBuku }}</h3>
                    </div>
                    <div class="p-3 bg-primary bg-opacity-10 text-primary rounded-4 fs-4">
                        <i class="bi bi-journal-text"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card-custom p-4 border-start border-4 border-warning">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <span class="text-muted small text-uppercase fw-semibold">Total Kategori</span>
                        <h3 class="fw-bold text-dark mt-1 mb-0">{{ $totalKategori }}</h3>
                    </div>
                    <div class="p-3 bg-warning bg-opacity-10 text-warning rounded-4 fs-4">
                        <i class="bi bi-tags"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card-custom p-4 border-start border-4 border-success">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <span class="text-muted small text-uppercase fw-semibold">Total Stok Buku</span>
                        <h3 class="fw-bold text-dark mt-1 mb-0">{{ $totalStok }}</h3>
                    </div>
                    <div class="p-3 bg-success bg-opacity-10 text-success rounded-4 fs-4">
                        <i class="bi bi-box-seam"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card-custom p-4 border-start border-4 border-info">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <span class="text-muted small text-uppercase fw-semibold">Buku Terbaru</span>
                        <h3 class="fw-bold text-dark mt-1 mb-0">{{ $bukuTerbaru->count() }}</h3>
                    </div>
                    <div class="p-3 bg-info bg-opacity-10 text-info rounded-4 fs-4">
                        <i class="bi bi-clock-history"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bagian Buku Terbaru & Kategori -->
    <div class="row g-4">
        <!-- Tabel 5 Buku Terbaru -->
        <div class="col-lg-8">
            <div class="card-custom p-4 h-100">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold text-dark mb-0"><i class="bi bi-bookmark-star me-2 text-primary"></i> Buku Terbaru Ditambahkan</h5>
                    <a href="{{ route('buku.index') }}" class="small text-decoration-none fw-semibold text-purple" style="color: #4C1D95;">Lihat Semua Buku &rarr;</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-custom align-middle mb-0">
                        <thead>
                            <tr>
                                <th>ISBN</th>
                                <th>Judul Buku</th>
                                <th>Penulis</th>
                                <th>Kategori</th>
                                <th class="text-center">Stok</th>
                                <th class="text-end pe-3">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($bukuTerbaru as $buku)
                                <tr>
                                    <td><code>{{ $buku->isbn }}</code></td>
                                    <td class="fw-bold text-dark">{{ $buku->judul }}</td>
                                    <td class="small text-muted">{{ $buku->penulis }}</td>
                                    <td><span class="badge bg-light text-dark border">{{ $buku->kategori->nama_kategori ?? '-' }}</span></td>
                                    <td class="text-center"><span class="badge bg-secondary">{{ $buku->stok }}</span></td>
                                    <td class="text-end pe-3">
                                        <a href="{{ route('buku.show', $buku->id) }}" class="btn btn-sm btn-outline-primary border-0" title="Detail">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted fst-italic">Belum ada data buku.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Ringkasan Kategori -->
        <div class="col-lg-4">
            <div class="card-custom p-4 h-100">
                <h5 class="fw-bold text-dark mb-3"><i class="bi bi-pie-chart me-2 text-warning"></i> Ringkasan Kategori</h5>
                <div class="d-flex flex-column gap-3">
                    @forelse($kategoris as $kat)
                        <div class="d-flex justify-content-between align-items-center p-3 bg-light rounded-4 border">
                            <div>
                                <span class="fw-bold d-block text-dark">{{ $kat->nama_kategori }}</span>
                                <small class="text-muted font-monospace">Kode: {{ $kat->kode_kategori }}</small>
                            </div>
                            <span class="badge px-3 py-2 rounded-pill fw-semibold" style="background-color: #ede9fe; color: #4C1D95; border: 1px solid #ddd6fe;">
                                {{ $kat->bukus_count }} Buku
                            </span>
                        </div>
                    @empty
                        <p class="text-muted small fst-italic">Belum ada kategori terdaftar.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-layout>