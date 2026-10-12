<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'SIPUS-Del' }} | Sistem Informasi Perpustakaan IT Del</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root {
            --del-purple: #4C1D95;
            --del-purple-dark: #3B0764;
            --del-bg: #f8fafc;
        }
        body { font-family: 'Inter', sans-serif; background-color: var(--del-bg); color: #334155; }
        
        /* Sidebar Styling */
        .sidebar {
            width: 260px;
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 100;
            background-color: #ffffff;
            border-right: 1px solid #e2e8f0;
            display: flex;
            flex-direction: column;
        }
        .sidebar-brand {
            padding: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            color: var(--del-purple);
            font-weight: 700;
            font-size: 1.25rem;
            text-decoration: none;
            border-bottom: 1px solid #f1f5f9;
        }
        .sidebar-menu {
            padding: 1rem;
            display: flex;
            flex-direction: column;
            gap: 0.5srem;
            flex-grow: 1;
        }
        .nav-item-custom {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
            color: #64748b;
            font-weight: 500;
            border-radius: 0.75rem;
            text-decoration: none;
            transition: all 0.2s ease;
        }
        .nav-item-custom:hover {
            background-color: #f1f5f9;
            color: var(--del-purple);
        }
        .nav-item-custom.active {
            background-color: var(--del-purple);
            color: #ffffff;
            box-shadow: 0 4px 6px -1px rgba(76, 29, 149, 0.2);
        }
        
        /* Main Content Wrapper */
        .main-wrapper {
            margin-left: 260px;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        
        /* Navbar Atas */
        .navbar-top {
            background-color: #ffffff;
            border-bottom: 1px solid #e2e8f0;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        /* Components */
        .card-custom {
            background-color: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 1rem;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05);
        }
        .btn-del {
            background-color: var(--del-purple);
            color: #ffffff;
            border-radius: 50rem;
            padding: 0.5rem 1.25rem;
            font-weight: 500;
            transition: all 0.2s;
            border: none;
        }
        .btn-del:hover {
            background-color: var(--del-purple-dark);
            color: #ffffff;
            transform: translateY(-1px);
        }
        .table-custom th {
            background-color: #f8fafc;
            color: #475569;
            font-weight: 600;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            border-bottom: 1px solid #e2e8f0;
        }
        .table-custom td {
            vertical-align: middle;
            font-size: 0.9rem;
            color: #334155;
            border-bottom: 1px solid #f1f5f9;
        }
    </style>
</head>
<body>

    <!-- Sidebar Kiri -->
    <aside class="sidebar">
        <a href="{{ route('dashboard') }}" class="sidebar-brand">
            <i class="bi bi-book-fill fs-3"></i>
            <div>
                <span>SIPUS-Del</span>
                <span class="d-block fw-light text-muted fs-7" style="font-size: 0.75rem;">Library Management System</span>
            </div>
        </a>
        <div class="sidebar-menu">
            <a href="{{ route('dashboard') }}" class="nav-item-custom {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="bi bi-grid-1x2-fill"></i> Dashboard
            </a>
            <a href="{{ route('buku.index') }}" class="nav-item-custom {{ request()->routeIs('buku.*') ? 'active' : '' }}">
                <i class="bi bi-journal-bookmark-fill"></i> Data Buku
            </a>
            <a href="{{ route('kategori.index') }}" class="nav-item-custom {{ request()->routeIs('kategori.*') ? 'active' : '' }}">
                <i class="bi bi-tags-fill"></i> Data Kategori
            </a>
        </div>
        <div class="p-3 border-top bg-light text-center small text-muted">
            <strong>Institut Teknologi Del</strong>
            <span class="d-block" style="font-size: 0.75rem;">Laravel 11 • v1.0.0</span>
        </div>
    </aside>

    <!-- Konten Utama di Kanan -->
    <div class="main-wrapper">
        <!-- Navbar Atas -->
        <header class="navbar-top">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 small">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none text-muted">SIPUS-Del</a></li>
                        <li class="breadcrumb-item active text-dark fw-semibold" aria-current="page">{{ $title ?? 'Halaman' }}</li>
                    </ol>
                </nav>
            </div>
            <div class="d-flex align-items-center gap-3">
                <span class="text-muted small"><i class="bi bi-calendar3 me-1"></i> {{ now()->translatedFormat('d F Y') }}</span>
                <div class="bg-purple bg-opacity-10 text-purple p-2 rounded-circle border d-flex align-items-center justify-content-center" style="width: 38px; height: 38px; background: #ede9fe; color: #4c1d95; font-weight: 600;">
                    AD
                </div>
            </div>
        </header>

        <!-- Area Konten Dinamis -->
        <main class="p-4 flex-grow-1">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show rounded-4 shadow-sm border-0 mb-4" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            {{ $slot }}
        </main>

        <!-- Footer -->
        <footer class="bg-white border-top py-3 text-center text-muted small">
            &copy; 2026 <strong>SIPUS-Del</strong> • Institut Teknologi Del. All rights reserved.
        </footer>
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>