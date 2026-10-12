<x-layout title="Edit Buku">
    <div class="row justify-content-center">
        <div class="col-md-9">
            <div class="card-custom p-4">
                <h3 class="fw-bold text-dark mb-4">✏️ Edit Buku: {{ $buku->judul }}</h3>

                @if ($errors->any())
                    <div class="alert alert-danger rounded-3 small">
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('buku.update', $buku->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">ISBN <span class="text-danger">*</span></label>
                            <input type="text" name="isbn" value="{{ old('isbn', $buku->isbn) }}" class="form-control bg-light" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Kategori <span class="text-danger">*</span></label>
                            <select name="kategori_id" class="form-select bg-light" required>
                                <option value="">Pilih Kategori Buku</option>
                                @foreach($kategoris as $kategori)
                                    <option value="{{ $kategori->id }}" {{ old('kategori_id', $buku->kategori_id) == $kategori->id ? 'selected' : '' }}>
                                        {{ $kategori->nama_kategori }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Judul Buku <span class="text-danger">*</span></label>
                        <input type="text" name="judul" value="{{ old('judul', $buku->judul) }}" class="form-control bg-light" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Penulis <span class="text-danger">*</span></label>
                            <input type="text" name="penulis" value="{{ old('penulis', $buku->penulis) }}" class="form-control bg-light" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Penerbit <span class="text-danger">*</span></label>
                            <input type="text" name="penerbit" value="{{ old('penerbit', $buku->penerbit) }}" class="form-control bg-light" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Tahun Terbit <span class="text-danger">*</span></label>
                            <input type="number" name="tahun_terbit" value="{{ old('tahun_terbit', $buku->tahun_terbit) }}" class="form-control bg-light" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Stok Buku <span class="text-danger">*</span></label>
                            <input type="number" name="stok" value="{{ old('stok', $buku->stok) }}" class="form-control bg-light" min="0" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Sinopsis</label>
                        <textarea name="sinopsis" rows="4" class="form-control bg-light">{{ old('sinopsis', $buku->sinopsis) }}</textarea>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('buku.index') }}" class="btn btn-outline-secondary rounded-pill px-4">Batal</a>
                        <button type="submit" class="btn btn-del px-4">Perbarui Buku</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layout>