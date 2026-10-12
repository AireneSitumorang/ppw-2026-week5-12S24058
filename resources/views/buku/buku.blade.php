<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Buku | SIPUS-Del</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 font-sans p-8">
    <div class="max-w-6xl mx-auto bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">📚 Daftar Koleksi Buku SIPUS-Del</h1>
                <p class="text-sm text-gray-500">Sistem Informasi Perpustakaan Institut Teknologi Del</p>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-100 text-gray-700 text-sm uppercase tracking-wider">
                        <th class="p-3 rounded-l-xl">No</th>
                        <th class="p-3">ISBN</th>
                        <th class="p-3">Judul Buku</th>
                        <th class="p-3">Penulis</th>
                        <th class="p-3">Kategori</th>
                        <th class="p-3 rounded-r-xl">Stok</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm text-gray-600">
                    @forelse($bukus ?? [] as $index => $buku)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="p-3 font-medium">{{ $index + 1 }}</td>
                            <td class="p-3">{{ $buku->isbn }}</td>
                            <td class="p-3 font-semibold text-gray-800">{{ $buku->judul }}</td>
                            <td class="p-3">{{ $buku->penulis }}</td>
                            <td class="p-3">
                                <span class="px-3 py-1 bg-blue-50 text-blue-600 rounded-full text-xs font-semibold">
                                    {{ $buku->kategori->nama_kategori ?? 'Umum' }}
                                </span>
                            </td>
                            <td class="p-3">{{ $buku->stok }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-6 text-center text-gray-400 italic">
                                Belum ada data buku di database. Silakan jalankan seeder atau tambah data baru.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>