
<x-layout title="Data Peminjaman">
    <div class="row mb-4 align-items-center">
        <div class="col-md-7">
            <h2 class="fw-bold text-dark mb-1">Data Peminjaman Buku</h2>
            <p class="text-muted mb-0">
                Kelola transaksi peminjaman dan pengembalian buku perpustakaan.
            </p>
        </div>
    </div>

    {{-- Pesan berhasil --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-3" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"
                aria-label="Tutup"></button>
        </div>
    @endif

    {{-- Pesan error --}}
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show rounded-3" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"
                aria-label="Tutup"></button>
        </div>
    @endif

    {{-- Pesan validasi --}}
    @if ($errors->any())
        <div class="alert alert-danger rounded-3">
            <strong>Data belum dapat diproses:</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Form tambah peminjaman --}}
    <div class="card-custom p-4 mb-4">
        <h4 class="fw-bold text-dark mb-3">Tambah Peminjaman</h4>

        @if ($bukus->isEmpty())
            <div class="alert alert-warning mb-0">
                Belum ada buku yang memiliki stok. Tambahkan kategori dan buku
                terlebih dahulu sebelum melakukan peminjaman.
            </div>
        @else
            <form action="{{ route('peminjaman.store') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="buku_id" class="form-label fw-semibold">
                            Pilih Buku <span class="text-danger">*</span>
                        </label>

                        <select name="buku_id" id="buku_id"
                            class="form-select @error('buku_id') is-invalid @enderror"
                            required>
                            <option value="">-- Pilih Buku --</option>

                            @foreach ($bukus as $buku)
                                <option value="{{ $buku->id }}"
                                    {{ old('buku_id') == $buku->id ? 'selected' : '' }}>
                                    {{ $buku->judul }} — Stok: {{ $buku->stok }}
                                </option>
                            @endforeach
                        </select>

                        @error('buku_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="nim_peminjam" class="form-label fw-semibold">
                            NIM Peminjam <span class="text-danger">*</span>
                        </label>

                        <input type="text" name="nim_peminjam" id="nim_peminjam"
                            value="{{ old('nim_peminjam') }}"
                            class="form-control @error('nim_peminjam') is-invalid @enderror"
                            maxlength="20" required>

                        @error('nim_peminjam')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="nama_peminjam" class="form-label fw-semibold">
                            Nama Peminjam <span class="text-danger">*</span>
                        </label>

                        <input type="text" name="nama_peminjam" id="nama_peminjam"
                            value="{{ old('nama_peminjam') }}"
                            class="form-control @error('nama_peminjam') is-invalid @enderror"
                            maxlength="150" required>

                        @error('nama_peminjam')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="tanggal_jatuh_tempo" class="form-label fw-semibold">
                            Tanggal Jatuh Tempo <span class="text-danger">*</span>
                        </label>

                        <input type="date" name="tanggal_jatuh_tempo"
                            id="tanggal_jatuh_tempo"
                            value="{{ old('tanggal_jatuh_tempo') }}"
                            class="form-control @error('tanggal_jatuh_tempo') is-invalid @enderror"
                            min="{{ date('Y-m-d') }}" required>

                        @error('tanggal_jatuh_tempo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <button type="submit" class="btn btn-del px-4">
                    Simpan Peminjaman
                </button>
            </form>
        @endif
    </div>

    {{-- Tabel data peminjaman --}}
    <div class="card-custom p-4">
        <h4 class="fw-bold text-dark mb-3">Riwayat Peminjaman</h4>

        <div class="table-responsive">
            <table class="table table-custom align-middle mb-0">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Kode Peminjaman</th>
                        <th>Buku</th>
                        <th>NIM</th>
                        <th>Nama Peminjam</th>
                        <th>Tanggal Pinjam</th>
                        <th>Jatuh Tempo</th>
                        <th>Tanggal Kembali</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($peminjamans as $index => $peminjaman)
                        <tr>
                            <td>
                                {{ $peminjamans->firstItem() + $index }}
                            </td>

                            <td>
                                <code>{{ $peminjaman->kode_pinjam }}</code>
                            </td>

                            <td>
                                {{ $peminjaman->buku->judul ?? 'Buku tidak tersedia' }}
                            </td>

                            <td>{{ $peminjaman->nim_peminjam }}</td>

                            <td>{{ $peminjaman->nama_peminjam }}</td>

                            <td>
                                {{ \Illuminate\Support\Carbon::parse($peminjaman->tanggal_pinjam)->format('d-m-Y') }}
                            </td>

                            <td>
                                {{ \Illuminate\Support\Carbon::parse($peminjaman->tanggal_jatuh_tempo)->format('d-m-Y') }}
                            </td>

                            <td>
                                @if ($peminjaman->tanggal_kembali)
                                    {{ \Illuminate\Support\Carbon::parse($peminjaman->tanggal_kembali)->format('d-m-Y') }}
                                @else
                                    <span class="text-muted">Belum kembali</span>
                                @endif
                            </td>

                            <td>
                                @if ($peminjaman->status === 'dipinjam')
                                    <span class="badge bg-warning text-dark">
                                        Dipinjam
                                    </span>
                                @else
                                    <span class="badge bg-success">
                                        Dikembalikan
                                    </span>
                                @endif
                            </td>

                            <td>
                                @if ($peminjaman->status === 'dipinjam')
                                    <form
                                        action="{{ route('peminjaman.kembali', $peminjaman->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Apakah buku ini sudah dikembalikan?')">
                                        @csrf
                                        @method('PUT')

                                        <button type="submit"
                                            class="btn btn-sm btn-success">
                                            Kembalikan
                                        </button>
                                    </form>
                                @else
                                    <span class="text-muted">Selesai</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10"
                                class="text-center py-5 text-muted">
                                Belum ada data peminjaman.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4 d-flex justify-content-end">
            {{ $peminjamans->links() }}
        </div>
    </div>
</x-layout>
