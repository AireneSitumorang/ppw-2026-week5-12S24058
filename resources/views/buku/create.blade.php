<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Buku - SIPUS-Del</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans p-8">
    <div class="max-w-xl mx-auto bg-white p-8 rounded-lg shadow">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Tambah Buku Baru</h2>

        <form action="{{ route('buku.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">ISBN</label>
                <input type="text" name="isbn" required class="w-full border px-3 py-2 rounded focus:outline-none focus:ring focus:border-blue-300">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Judul Buku</label>
                <input type="text" name="judul" required class="w-full border px-3 py-2 rounded focus:outline-none focus:ring focus:border-blue-300">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Penulis</label>
                <input type="text" name="penulis" required class="w-full border px-3 py-2 rounded focus:outline-none focus:ring focus:border-blue-300">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Penerbit</label>
                <input type="text" name="penerbit" class="w-full border px-3 py-2 rounded focus:outline-none focus:ring focus:border-blue-300">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Kategori</label>
                <select name="kategori_id" required class="w-full border px-3 py-2 rounded focus:outline-none focus:ring focus:border-blue-300">
                    <option value="">Pilih Kategori</option>
                    @foreach($kategoris as $kat)
                        <option value="{{ $kat->id }}">{{ $kat->nama_kategori }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Tahun Terbit</label>
                <input type="number" name="tahun_terbit" required class="w-full border px-3 py-2 rounded focus:outline-none focus:ring focus:border-blue-300">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Stok</label>
                <input type="number" name="stok" min="0" required class="w-full border px-3 py-2 rounded focus:outline-none focus:ring focus:border-blue-300">
            </div>
            <div class="mb-6">
                <label class="block text-gray-700 font-bold mb-2">Sinopsis</label>
                <textarea name="sinopsis" rows="3" class="w-full border px-3 py-2 rounded focus:outline-none focus:ring focus:border-blue-300"></textarea>
            </div>
            <div class="flex justify-between">
                <a href="{{ route('buku.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Kembali</a>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Simpan Buku</button>
            </div>
        </form>
    </div>
</body>
</html>