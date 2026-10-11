<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIPUS-Del | Sistem Informasi Perpustakaan</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome untuk Icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50 font-sans antialiased">

    <div class="flex h-screen overflow-hidden">
        
        <!-- Sidebar -->
        <aside class="w-64 bg-slate-900 text-slate-300 flex flex-col hidden md:flex shadow-xl">
            <div class="px-6 py-5 border-b border-slate-800">
                <h1 class="text-2xl font-black tracking-wider text-white">SIPUS<span class="text-blue-500">-Del</span></h1>
                <p class="text-xs text-slate-400 mt-1">Sistem Informasi Perpustakaan</p>
            </div>
            
            <nav class="flex-1 px-4 py-6 space-y-1 text-sm font-medium">
                <a href="/" class="flex items-center gap-3 px-4 py-3 rounded-xl bg-blue-600 text-white shadow-lg shadow-blue-600/30 transition">
                    <i class="fa-solid fa-book text-lg"></i>
                    <span>Koleksi Buku</span>
                </a>
                <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-800 text-slate-400 hover:text-white transition">
                    <i class="fa-solid fa-chart-pie text-lg"></i>
                    <span>Kategori</span>
                </a>
                <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-800 text-slate-400 hover:text-white transition">
                    <i class="fa-solid fa-users text-lg"></i>
                    <span>Anggota</span>
                </a>
            </nav>

            <div class="p-4 border-t border-slate-800 text-xs text-slate-500 text-center">
                &copy; 2026 Institut Teknologi Del
            </div>
        </aside>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col overflow-y-auto">
            
            <!-- Top Navbar -->
            <header class="bg-white shadow-sm h-16 flex items-center justify-between px-8 border-b border-gray-100">
                <div class="flex items-center gap-3">
                    <span class="text-gray-800 font-semibold text-lg">Manajemen Koleksi Buku</span>
                </div>
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-full bg-blue-600 text-white flex items-center font-bold justify-center shadow">
                        A
                    </div>
                    <span class="text-sm font-medium text-gray-700">Airene (Admin)</span>
                </div>
            </header>

            <!-- Page Content -->
            <main class="p-8">
                
                <!-- Welcome Banner -->
                <div class="bg-gradient-to-r from-blue-700 to-indigo-800 rounded-2xl p-6 text-white shadow-lg mb-8 flex justify-between items-center">
                    <div>
                        <h2 class="text-2xl font-bold mb-2">📚 Katalog Perpustakaan SIPUS-Del</h2>
                        <p class="text-blue-100 text-sm max-w-xl">Kelola data referensi buku perkuliahan dan literatur umum dengan cepat, terstruktur, dan efisien.</p>
                    </div>
                    <div class="hidden lg:block bg-white/10 backdrop-blur-md px-5 py-4 rounded-xl border border-white/20 text-center">
                        <span class="block text-2xl font-black">{{ count($bukus) }}</span>
                        <span class="text-xs text-blue-200 uppercase tracking-wider">Total Buku</span>
                    </div>
                </div>

                <!-- Table Card -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                        <h3 class="font-bold text-gray-800 text-base">Daftar Seluruh Buku</h3>
                        <span class="text-xs text-gray-500 bg-gray-100 px-3 py-1 rounded-full font-medium">Database Aktif: MySQL</span>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50 text-gray-400 text-xs uppercase tracking-wider font-semibold border-b border-gray-100">
                                    <th class="px-6 py-4">No</th>
                                    <th class="px-6 py-4">ISBN</th>
                                    <th class="px-6 py-4">Judul & Penulis</th>
                                    <th class="px-6 py-4">Penerbit / Tahun</th>
                                    <th class="px-6 py-4">Kategori</th>
                                    <th class="px-6 py-4 text-center">Stok</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 text-sm text-gray-600">
                                @foreach($bukus as $index => $buku)
                                <tr class="hover:bg-blue-50/40 transition">
                                    <td class="px-6 py-4 font-medium text-gray-500">{{ $index + 1 }}</td>
                                    <td class="px-6 py-4 font-mono text-xs text-gray-500">{{ $buku->isbn }}</td>
                                    <td class="px-6 py-4">
                                        <div class="font-bold text-gray-900">{{ $buku->judul }}</div>
                                        <div class="text-xs text-gray-400 mt-0.5"><i class="fa-solid fa-pen-nib mr-1"></i> {{ $buku->penulis }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-gray-800">{{ $buku->penerbit }}</div>
                                        <div class="text-xs text-gray-400">{{ $buku->tahun_terbit }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="bg-blue-50 text-blue-700 text-xs font-semibold px-3 py-1 rounded-full border border-blue-100">
                                            {{ $buku->kategori->nama_kategori ?? '-' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="bg-emerald-50 text-emerald-700 font-bold text-xs px-2.5 py-1 rounded-lg">
                                            {{ $buku->stok }} Eks
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </main>
        </div>
    </div>

</body>
</html