<x-layout title="Edit Kategori">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="card-custom p-4">
                <h3 class="fw-bold text-dark mb-4">✏️ Edit Kategori: {{ $kategori->nama_kategori }}</h3>

                @if ($errors->any())
                    <div class="alert alert-danger rounded-3 small mb-4">
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('kategori.update', $kategori->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Kode Kategori <span class="text-danger">*</span></label>
                        <input type="text" name="kode_kategori" value="{{ old('kode_kategori', $kategori->kode_kategori) }}" class="form-control bg-light @error('kode_kategori') is-invalid @enderror" required>
                        @error('kode_kategori')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Nama Kategori <span class="text-danger">*</span></label>
                        <input type="text" name="nama_kategori" value="{{ old('nama_kategori', $kategori->nama_kategori) }}" class="form-control bg-light @error('nama_kategori') is-invalid @enderror" required>
                        @error('nama_kategori')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('kategori.index') }}" class="btn btn-outline-secondary rounded-pill px-4">Batal</a>
                        <button type="submit" class="btn btn-del px-4">Perbarui Kategori</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layout>