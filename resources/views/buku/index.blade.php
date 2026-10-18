<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Buku - SIPUS-Del</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">
    <div class="flex h-screen">
        <aside class="w-64 bg-white shadow-md p-6">
            <h1 class="text-2xl font-bold text-blue-600 mb-6">SIPUS-Del</h1>
            <nav class="space-y-2">
                <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-gray-600 hover:bg-gray-50 rounded">Dashboard</a>
                <a href="{{ route('buku.index') }}" class="block px-4 py-2 bg-blue-50 text-blue-600 rounded font-semibold">Buku</a>
                <a href="{{ route('kategori.index') }}" class="block px-4 py-2 text-gray-600 hover:bg-gray-50 rounded">Kategori</a>
                <a href="{{ route('peminjaman.index') }}" class="block px-4 py-2 text-gray-600 hover:bg-gray-50 rounded">Peminjaman</a>
            </nav>
        </aside>

        <main class="flex-1 p-8 overflow-y-auto">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-3xl font-bold text-gray-800">Daftar Buku</h2>
                <a href="{{ route('buku.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-blue-700">+ Tambah Buku</a>
            </div>

            @if(session('success'))
                <div class="bg-green-100 text-green-700 p-3 rounded mb-4">{{ session('success') }}</div>
            @endif

            <div class="bg-white rounded-lg shadow overflow-hidden">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-200 text-gray-700 text-sm">
                            <th class="p-3">No</th>
                            <th class="p-3">ISBN</th>
                            <th class="p-3">Judul Buku</th>
                            <th class="p-3">Penulis</th>
                            <th class="p-3">Kategori</th>
                            <th class="p-3">Stok</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 text-sm divide-y">
                        @forelse($bukus as $index => $buku)
                            <tr>
                                <td class="p-3">{{ $bukus->firstItem() + $index }}</td>
                                <td class="p-3">{{ $buku->isbn }}</td>
                                <td class="p-3 font-semibold text-gray-800">{{ $buku->judul }}</td>
                                <td class="p-3">{{ $buku->penulis }}</td>
                                <td class="p-3">{{ $buku->kategori->nama_kategori ?? '-' }}</td>
                                <td class="p-3">{{ $buku->stok }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="p-4 text-center text-gray-500">Belum ada data buku.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                {{ $bukus->links() }}
            </div>
        </main>
    </div>
</body>
</html>