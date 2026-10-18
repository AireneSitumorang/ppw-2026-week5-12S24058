<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard Perpustakaan - SIPUS-Del</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        body {
            font-family: 'Inter', 'Segoe UI', sans-serif;
        }

        .sidebar {
            background: linear-gradient(180deg, #ffffff, #f4f7ff);
        }

        .stat-card {
            transition: all 0.25s ease;
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 14px 28px rgba(30, 64, 175, 0.12);
        }

        .menu-link {
            transition: all 0.2s ease;
        }

        .menu-link:hover {
            transform: translateX(3px);
        }
    </style>
</head>

<body class="bg-slate-50 text-gray-800">

<div class="min-h-screen md:flex">

    <!-- SIDEBAR -->
    <aside class="sidebar w-full md:w-64 md:min-h-screen md:flex md:flex-col border-r border-gray-200 px-5 py-6">

        <!-- LOGO INSTITUT TEKNOLOGI DEL -->
        <div class="flex items-center gap-3 mb-9">

            <div class="w-14 h-14 rounded-2xl bg-white border border-gray-100 shadow-sm flex items-center justify-center overflow-hidden p-1">
                <img
                    src="{{ asset('images/logo-del.jpg') }}"
                    alt="Logo Institut Teknologi Del"
                    class="w-full h-full object-contain"
                    onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                >

                <span class="hidden items-center justify-center w-full h-full bg-blue-700 text-white font-extrabold text-sm">
                    DEL
                </span>
            </div>

            <div>
                <h1 class="text-xl font-extrabold text-blue-700">
                    SIPUS-Del
                </h1>

                <p class="text-xs text-gray-500 mt-1">
                    Sistem Informasi Perpustakaan
                </p>
            </div>

        </div>

        <!-- MENU UTAMA -->
        <p class="text-xs font-bold uppercase tracking-widest text-gray-400 mb-3 px-3">
            Menu Utama
        </p>

        <nav class="space-y-2">

            <a href="{{ route('dashboard') }}"
               class="menu-link flex items-center gap-3 px-4 py-3 rounded-xl bg-blue-600 text-white shadow-md shadow-blue-100 font-semibold">
                <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
                <span>Dashboard</span>
            </a>

            <a href="{{ route('buku.index') }}"
               class="menu-link flex items-center gap-3 px-4 py-3 rounded-xl text-gray-600 hover:bg-blue-50 hover:text-blue-700">
                <i data-lucide="book-open" class="w-5 h-5"></i>
                <span>Data Buku</span>
            </a>

            <a href="{{ route('kategori.index') }}"
               class="menu-link flex items-center gap-3 px-4 py-3 rounded-xl text-gray-600 hover:bg-blue-50 hover:text-blue-700">
                <i data-lucide="folders" class="w-5 h-5"></i>
                <span>Kategori Buku</span>
            </a>

            <a href="{{ route('peminjaman.index') }}"
               class="menu-link flex items-center gap-3 px-4 py-3 rounded-xl text-gray-600 hover:bg-blue-50 hover:text-blue-700">
                <i data-lucide="clipboard-list" class="w-5 h-5"></i>
                <span>Peminjaman</span>
            </a>

        </nav>

        <!-- INFORMASI -->
        <div class="mt-8 p-4 rounded-2xl bg-blue-50 border border-blue-100">

            <div class="flex items-center gap-2 text-blue-700 mb-2">
                <i data-lucide="library-big" class="w-5 h-5"></i>
                <span class="font-bold text-sm">Perpustakaan Del</span>
            </div>

            <p class="text-xs text-gray-600 leading-relaxed">
                Kelola koleksi buku, kategori, stok, dan peminjaman dalam satu sistem.
            </p>

        </div>

        <!-- LOGOUT -->
        <div class="mt-6 md:mt-auto md:pt-8">

            <form action="{{ route('logout') }}" method="POST">
                @csrf

                <button type="submit"
                        class="menu-link w-full flex items-center gap-3 px-4 py-3 rounded-xl text-red-600 hover:bg-red-50 font-semibold">
                    <i data-lucide="log-out" class="w-5 h-5"></i>
                    <span>Logout</span>
                </button>
            </form>

            <p class="text-xs text-gray-400 text-center mt-5">
                SIPUS-Del © {{ date('Y') }}
            </p>

        </div>

    </aside>

    <!-- KONTEN UTAMA -->
    <main class="flex-1 min-w-0 p-5 md:p-8 lg:p-10">

        <!-- HEADER -->
        <header class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">

            <div>
                <p class="text-sm text-blue-600 font-semibold mb-2">
                    SISTEM INFORMASI PERPUSTAKAAN
                </p>

                <h2 class="text-2xl md:text-3xl font-extrabold text-gray-800">
                    Dashboard Perpustakaan
                </h2>

                <p class="text-gray-500 mt-2">
                    Selamat datang kembali, Pustakawan!
                </p>
            </div>

            <div class="flex items-center gap-3 bg-white rounded-2xl px-4 py-3 shadow-sm border border-gray-100">

                <div class="w-11 h-11 rounded-full bg-blue-100 flex items-center justify-center text-blue-700">
                    <i data-lucide="user-round" class="w-6 h-6"></i>
                </div>

                <div>
                    <p class="font-bold text-sm text-gray-800">
                        Pustakawan
                    </p>

                    <p class="text-xs text-gray-500">
                        Administrator Perpustakaan
                    </p>
                </div>

            </div>

        </header>

        <!-- BANNER SELAMAT DATANG -->
        <section class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-blue-700 via-blue-600 to-indigo-600 p-6 md:p-8 mb-8 text-white shadow-lg shadow-blue-100">

            <div class="relative z-10 max-w-2xl">

                <span class="inline-flex items-center gap-2 rounded-full bg-white/15 px-3 py-1 text-sm mb-4">
                    <i data-lucide="sparkles" class="w-4 h-4"></i>
                    Dashboard SIPUS-Del
                </span>

                <h3 class="text-2xl md:text-3xl font-extrabold mb-3">
                    Selamat Datang di Perpustakaan!
                </h3>

                <p class="text-blue-100 leading-relaxed">
                    Pantau koleksi buku, kategori, stok, dan aktivitas peminjaman
                    melalui satu dashboard yang praktis dan mudah digunakan.
                </p>

            </div>

            <i data-lucide="book-open-check"
               class="absolute right-5 bottom-0 w-32 h-32 md:w-44 md:h-44 text-white/10"
               stroke-width="1.2"></i>

        </section>

        <!-- STATISTIK -->
        <section class="mb-9">

            <div class="mb-5">
                <h3 class="text-xl font-bold text-gray-800">
                    Ringkasan Perpustakaan
                </h3>

                <p class="text-sm text-gray-500 mt-1">
                    Informasi koleksi perpustakaan saat ini
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5">

                <!-- TOTAL BUKU -->
                <div class="stat-card bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">

                    <div class="flex items-center justify-between mb-5">
                        <div class="w-12 h-12 rounded-xl bg-blue-100 text-blue-700 flex items-center justify-center">
                            <i data-lucide="book-open" class="w-6 h-6"></i>
                        </div>

                        <span class="text-xs font-semibold text-blue-700 bg-blue-50 px-3 py-1 rounded-full">
                            Koleksi
                        </span>
                    </div>

                    <p class="text-sm text-gray-500">
                        Total Judul Buku
                    </p>

                    <h4 class="text-3xl font-extrabold text-gray-800 mt-2">
                        {{ number_format($totalBuku, 0, ',', '.') }}
                    </h4>

                    <p class="text-xs text-gray-400 mt-3">
                        Jumlah judul buku terdaftar
                    </p>

                </div>

                <!-- TOTAL STOK -->
                <div class="stat-card bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">

                    <div class="flex items-center justify-between mb-5">
                        <div class="w-12 h-12 rounded-xl bg-green-100 text-green-700 flex items-center justify-center">
                            <i data-lucide="layers" class="w-6 h-6"></i>
                        </div>

                        <span class="text-xs font-semibold text-green-700 bg-green-50 px-3 py-1 rounded-full">
                            Stok
                        </span>
                    </div>

                    <p class="text-sm text-gray-500">
                        Total Stok Buku
                    </p>

                    <h4 class="text-3xl font-extrabold text-gray-800 mt-2">
                        {{ number_format($totalStok, 0, ',', '.') }}
                    </h4>

                    <p class="text-xs text-gray-400 mt-3">
                        Jumlah seluruh eksemplar
                    </p>

                </div>

                <!-- KATEGORI -->
                <div class="stat-card bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">

                    <div class="flex items-center justify-between mb-5">
                        <div class="w-12 h-12 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center">
                            <i data-lucide="folders" class="w-6 h-6"></i>
                        </div>

                        <span class="text-xs font-semibold text-amber-700 bg-amber-50 px-3 py-1 rounded-full">
                            Kategori
                        </span>
                    </div>

                    <p class="text-sm text-gray-500">
                        Kategori Buku
                    </p>

                    <h4 class="text-3xl font-extrabold text-gray-800 mt-2">
                        {{ number_format($totalKategori, 0, ',', '.') }}
                    </h4>

                    <p class="text-xs text-gray-400 mt-3">
                        Kelompok koleksi buku
                    </p>

                </div>

                <!-- PEMINJAMAN -->
                <div class="stat-card bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">

                    <div class="flex items-center justify-between mb-5">
                        <div class="w-12 h-12 rounded-xl bg-rose-100 text-rose-700 flex items-center justify-center">
                            <i data-lucide="book-marked" class="w-6 h-6"></i>
                        </div>

                        <span class="text-xs font-semibold text-rose-700 bg-rose-50 px-3 py-1 rounded-full">
                            Transaksi
                        </span>
                    </div>

                    <p class="text-sm text-gray-500">
                        Sedang Dipinjam
                    </p>

                    <h4 class="text-3xl font-extrabold text-gray-800 mt-2">
                        {{ number_format($bukuDipinjam, 0, ',', '.') }}
                    </h4>

                    <p class="text-xs text-gray-400 mt-3">
                        Ringkasan peminjaman aktif
                    </p>

                </div>

            </div>

        </section>

        <!-- AKSES CEPAT -->
        <section class="mb-9">

            <div class="mb-5">
                <h3 class="text-xl font-bold text-gray-800">
                    Akses Cepat
                </h3>

                <p class="text-sm text-gray-500 mt-1">
                    Pilih menu untuk mulai mengelola perpustakaan
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-5">

                <!-- KELOLA BUKU -->
                <a href="{{ route('buku.index') }}"
                   class="stat-card group bg-white border border-gray-100 rounded-2xl p-5 shadow-sm flex items-center gap-4">

                    <div class="w-14 h-14 rounded-2xl bg-blue-100 text-blue-700 flex items-center justify-center group-hover:bg-blue-600 group-hover:text-white transition">
                        <i data-lucide="book-open" class="w-7 h-7"></i>
                    </div>

                    <div class="flex-1">
                        <h4 class="font-bold text-gray-800">
                            Kelola Buku
                        </h4>

                        <p class="text-sm text-gray-500 mt-1">
                            Lihat dan kelola koleksi
                        </p>
                    </div>

                    <i data-lucide="arrow-up-right" class="w-5 h-5 text-gray-400"></i>

                </a>

                <!-- KELOLA KATEGORI -->
                <a href="{{ route('kategori.index') }}"
                   class="stat-card group bg-white border border-gray-100 rounded-2xl p-5 shadow-sm flex items-center gap-4">

                    <div class="w-14 h-14 rounded-2xl bg-amber-100 text-amber-700 flex items-center justify-center group-hover:bg-amber-500 group-hover:text-white transition">
                        <i data-lucide="folders" class="w-7 h-7"></i>
                    </div>

                    <div class="flex-1">
                        <h4 class="font-bold text-gray-800">
                            Kelola Kategori
                        </h4>

                        <p class="text-sm text-gray-500 mt-1">
                            Atur kategori koleksi
                        </p>
                    </div>

                    <i data-lucide="arrow-up-right" class="w-5 h-5 text-gray-400"></i>

                </a>

                <!-- DATA PEMINJAMAN -->
                <a href="{{ route('peminjaman.index') }}"
                   class="stat-card group bg-white border border-gray-100 rounded-2xl p-5 shadow-sm flex items-center gap-4">

                    <div class="w-14 h-14 rounded-2xl bg-green-100 text-green-700 flex items-center justify-center group-hover:bg-green-600 group-hover:text-white transition">
                        <i data-lucide="clipboard-list" class="w-7 h-7"></i>
                    </div>

                    <div class="flex-1">
                        <h4 class="font-bold text-gray-800">
                            Data Peminjaman
                        </h4>

                        <p class="text-sm text-gray-500 mt-1">
                            Buka halaman transaksi
                        </p>
                    </div>

                    <i data-lucide="arrow-up-right" class="w-5 h-5 text-gray-400"></i>

                </a>

            </div>

        </section>

        <!-- INFORMASI TAMBAHAN -->
        <section class="grid grid-cols-1 lg:grid-cols-2 gap-5 mb-8">

            <!-- KOLEKSI PERPUSTAKAAN -->
            <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm">

                <div class="flex items-center gap-3 mb-6">

                    <div class="w-11 h-11 rounded-xl bg-indigo-100 text-indigo-700 flex items-center justify-center">
                        <i data-lucide="chart-no-axes-column" class="w-6 h-6"></i>
                    </div>

                    <div>
                        <h3 class="font-bold text-gray-800">
                            Koleksi Perpustakaan
                        </h3>

                        <p class="text-sm text-gray-500">
                            Ringkasan data buku
                        </p>
                    </div>

                </div>

                <div class="space-y-6">

                    <!-- JUDUL BUKU -->
                    <div>
                        <div class="flex justify-between text-sm mb-2">
                            <span class="text-gray-600">Judul buku terdaftar</span>

                            <span class="font-bold text-gray-800">
                                {{ number_format($totalBuku, 0, ',', '.') }}
                            </span>
                        </div>

                        <div class="w-full bg-gray-100 rounded-full h-2.5">
                            <div class="bg-blue-600 h-2.5 rounded-full"
                                 style="width: 100%"></div>
                        </div>
                    </div>

                    <!-- KATEGORI -->
                    <div>
                        <div class="flex justify-between text-sm mb-2">
                            <span class="text-gray-600">Kategori tersedia</span>

                            <span class="font-bold text-gray-800">
                                {{ number_format($totalKategori, 0, ',', '.') }}
                            </span>
                        </div>

                        <div class="w-full bg-gray-100 rounded-full h-2.5">
                            <div class="bg-amber-500 h-2.5 rounded-full"
                                 style="width: {{ min(100, ($totalKategori / 10) * 100) }}%"></div>
                        </div>
                    </div>

                    <!-- STOK -->
                    <div>
                        <div class="flex justify-between text-sm mb-2">
                            <span class="text-gray-600">Total eksemplar</span>

                            <span class="font-bold text-gray-800">
                                {{ number_format($totalStok, 0, ',', '.') }}
                            </span>
                        </div>

                        <div class="w-full bg-gray-100 rounded-full h-2.5">
                            <div class="bg-green-500 h-2.5 rounded-full"
                                 style="width: {{ $totalStok > 0 ? min(100, ($totalStok / 2000) * 100) : 0 }}%"></div>
                        </div>
                    </div>

                </div>

            </div>

            <!-- STATUS PEMINJAMAN -->
            <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm">

                <div class="flex items-center gap-3 mb-6">

                    <div class="w-11 h-11 rounded-xl bg-rose-100 text-rose-700 flex items-center justify-center">
                        <i data-lucide="clipboard-check" class="w-6 h-6"></i>
                    </div>

                    <div>
                        <h3 class="font-bold text-gray-800">
                            Status Peminjaman
                        </h3>

                        <p class="text-sm text-gray-500">
                            Ringkasan peminjaman saat ini
                        </p>
                    </div>

                </div>

                <div class="rounded-2xl bg-gray-50 p-5 mb-5">

                    <p class="text-sm text-gray-500">
                        Jumlah buku sedang dipinjam
                    </p>

                    <div class="flex items-end justify-between mt-3">

                        <h4 class="text-3xl font-extrabold text-gray-800">
                            {{ number_format($bukuDipinjam, 0, ',', '.') }}
                        </h4>

                        <div class="w-12 h-12 rounded-xl bg-white flex items-center justify-center text-rose-600 shadow-sm">
                            <i data-lucide="book-marked" class="w-6 h-6"></i>
                        </div>

                    </div>

                </div>

                <a href="{{ route('peminjaman.index') }}"
                   class="inline-flex items-center justify-center gap-2 w-full rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-3 transition">

                    Lihat Data Peminjaman

                    <i data-lucide="arrow-right" class="w-4 h-4"></i>

                </a>

            </div>

        </section>

        <!-- FOOTER -->
        <footer class="border-t border-gray-200 pt-5 pb-2 text-center">

            <p class="text-sm text-gray-500">
                <span class="font-semibold text-blue-700">SIPUS-Del</span>
                · Sistem Informasi Perpustakaan
            </p>

            <p class="text-xs text-gray-400 mt-1">
                Institut Teknologi Del · {{ date('Y') }}
            </p>

        </footer>

    </main>

</div>

<script>
    lucide.createIcons();
</script>

</body>
</html>