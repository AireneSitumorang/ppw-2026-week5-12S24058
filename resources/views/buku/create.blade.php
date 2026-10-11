<x-layout>
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header card-header-del py-3">
                    <h5 class="card-title mb-0"><i class="bi bi-plus-circle me-2"></i>Tambah Koleksi Buku Baru</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('buku.store') }}" method="POST">
                        @csrf
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="isbn" class="form-label fw-semibold">Nomor ISBN <span class="text-danger">*</span></label>
                                <input type="text" name="isbn" id="isbn" value="{{ old('isbn') }}" class="form-control @error('isbn') is-invalid @enderror" placeholder="Contoh: 978-602-03-8822-1">
                                @error('isbn')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="kategori_id" class="form-label fw-semibold">Kategori <span class="text-danger">*</span></label>
                                <select name="kategori_id" id="kategori_id" class="form-select @error('kategori_id') is-invalid @enderror">
                                    <option value="">-- Pilih Kategori --</option>
                                    @foreach($kategoris as $kategori)
                                        <option value="{{ $kategori->id }}" {{ old('kategori_id') == $kategori->id ? 'selected' : '' }}>
                                            {{ $kategori->nama_kategori }} ({{ $kategori->kode_kategori }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('kategori_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="judul" class="form-label fw-semibold">Judul Buku <span class="text-danger">*</span></label>
                            <input type="text" name="judul" id="judul" value="{{ old('judul') }}" class="form-control @error('judul') is-invalid @enderror" placeholder="Masukkan judul buku">
                            @error('judul')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="penulis" class="form-label fw-semibold">Penulis <span class="text-danger">*</span></label>
                                <input type="text" name="penulis" id="penulis" value="{{ old('penulis') }}" class="form-control @error('penulis') is-invalid @enderror" placeholder="Nama penulis">
                                @error('penulis')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="penerbit" class="form-label fw-semibold">Penerbit <span class="text-danger">*</span></label>
                                <input type="text" name="penerbit" id="penerbit" value="{{ old('penerbit') }}" class="form-control @error('penerbit') is-invalid @enderror" placeholder="Nama penerbit">
                                @error('penerbit')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="tahun_terbit" class="form-label fw-semibold">Tahun Terbit <span class="text-danger">*</span></label>
                                <input type="number" name="tahun_terbit" id="tahun_terbit" value="{{ old('tahun_terbit', date('Y')) }}" min="1900" max="{{ date('Y') }}" class="form-control @error('tahun_terbit') is-invalid @enderror">
                                @error('tahun_terbit')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="stok" class="form-label fw-semibold">Jumlah Stok <span class="text-danger">*</span></label>
                                <input type="number" name="stok" id="stok" value="{{ old('stok', 1) }}" min="0" class="form-control @error('stok') is-invalid @enderror">
                                @error('stok')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="sinopsis" class="form-label fw-semibold">Sinopsis / Deskripsi Buku</label>
                            <textarea name="sinopsis" id="sinopsis" rows="4" class="form-control @error('sinopsis') is-invalid @enderror" placeholder="Ringkasan atau sinopsis buku...">{{ old('sinopsis') }}</textarea>
                            @error('sinopsis')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('buku.index') }}" class="btn btn-light border">Batal</a>
                            <button type="submit" class="btn btn-del"><i class="bi bi-save me-1"></i> Simpan Buku</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-layout>