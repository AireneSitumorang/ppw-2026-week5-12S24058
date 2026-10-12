<x-layout title="Data Kategori">
    <div class="row mb-4 align-items-center">
        <div class="col-md-7">
            <h2 class="fw-bold text-dark mb-1">🏷️ Kategori Buku</h2>
            <p class="text-muted mb-0">Kelola klasifikasi dan genre literatur perpustakaan.</p>
        </div>
        <div class="col-md-5 text-md-end mt-3 mt-md-0">
            <a href="{{ route('kategori.create') }}" class="btn btn-del">
                <i class="bi bi-plus-lg me-1"></i> + Tambah Kategori
            </a>
        </div>
    </div>

    <div class="card-custom p-4">
        <div class="table-responsive">
            <table class="table table-custom align-middle mb-0">
                <thead>
                    <tr>
                        <th class="ps-3">No</th>
                        <th>Kode Kategori</th>
                        <th>Nama Kategori</th>
                        <th class="text-center">Jumlah Buku Terkait</th>
                        <th class="text-end pe-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kategoris as $index => $kat)
                        <tr>
                            <td class="ps-3 fw-semibold text-secondary">{{ $kategoris->firstItem() + $index }}</td>
                            <td><code>{{ $kat->kode_kategori }}</code></td>
                            <td class="fw-bold text-dark">{{ $kat->nama_kategori }}</td>
                            <td class="text-center">
                                <span class="badge border px-3 py-2 rounded-pill" style="background-color: #ede9fe; color: #4c1d95; border-color: #ddd6fe !important;">
                                    {{ $kat->bukus_count ?? $kat->bukus()->count() }} Buku
                                </span>
                            </td>
                            <td class="text-end pe-3">
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('kategori.edit', $kat->id) }}" class="btn btn-outline-secondary border-0" title="Edit"><i class="bi bi-pencil-square text-warning"></i></a>
                                    <form action="{{ route('kategori.destroy', $kat->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Menghapus kategori akan menghapus seluruh buku di dalamnya (Cascade Delete). Lanjutkan?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-secondary border-0" title="Hapus"><i class="bi bi-trash text-danger"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted fst-italic">Belum ada data kategori.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4 d-flex justify-content-end">
            {{ $kategoris->links() }}
        </div>
    </div>
</x-layout>