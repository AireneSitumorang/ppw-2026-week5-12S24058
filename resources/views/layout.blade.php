<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIPUS-Del - Dashboard Pustakawan</title>
    
    <!-- Bootstrap 5 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    
    <style>
        body {
            background-color: #f8f9fa;
        }
        .sidebar {
            width: 260px;
            background: #ffffff;
            box-shadow: 2px 0 5px rgba(0,0,0,0.05);
        }
        .sidebar-brand {
            font-size: 1.25rem;
            color: #4e73df;
            font-weight: 700;
        }
        .sidebar-menu .nav-link {
            padding: 10px 15px;
            border-radius: 6px;
            color: #333;
            font-weight: 500;
            margin-bottom: 5px;
            transition: all 0.2s;
        }
        .sidebar-menu .nav-link:hover, .sidebar-menu .nav-link.active {
            background-color: #f1f3f9;
            color: #4e73df;
        }
    </style>
</head>
<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <aside class="sidebar d-flex flex-column p-3 vh-100 position-fixed">
            <a href="{{ route('dashboard') }}" class="sidebar-brand d-flex align-items-center text-decoration-none mb-4 px-2">
                <i class="bi bi-book-fill fs-3 me-2"></i>SIPUS-Del
            </a>
            <div class="sidebar-menu flex-grow-1">
                <ul class="nav flex-column gap-1">
                    <li class="nav-item">
                        <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard*') ? 'active' : '' }}">
                            <i class="bi bi-grid-1x2-fill me-2"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('buku.index') }}" class="nav-link {{ request()->routeIs('buku*') ? 'active' : '' }}">
                            <i class="bi bi-book me-2"></i> Buku
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('kategori.index') }}" class="nav-link {{ request()->routeIs('kategori*') ? 'active' : '' }}">
                            <i class="bi bi-tags me-2"></i> Kategori
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('peminjaman.index') }}" class="nav-link {{ request()->routeIs('peminjaman*') ? 'active' : '' }}">
                            <i class="bi bi-arrow-left-right me-2"></i> Peminjaman
                        </a>
                    </li>
                </ul>
            </div>
            <!-- Tombol Logout -->
            <div class="mt-auto pt-3 border-top">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="nav-link text-danger border-0 bg-transparent w-100 text-start px-2">
                        <i class="bi bi-box-arrow-right me-2"></i> Logout
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content Wrapper -->
        <div class="flex-grow-1" style="margin-left: 260px;">
            <!-- Header Navbar -->
            <header class="navbar navbar-expand navbar-light bg-white border-bottom px-4 py-2 d-flex justify-content-end shadow-sm">
                <div class="d-flex align-items-center gap-3">
                    <span class="text-muted small"><i class="bi bi-calendar3 me-1"></i> {{ date('d M Y') }}</span>
                    <div class="bg-primary bg-opacity-10 text-primary p-2 rounded-circle border d-flex align-items-center justify-content-center fw-bold" style="width: 38px; height: 38px;">
                        AD
                    </div>
                </div>
            </header>

            <!-- Dynamic Content Area -->
            <main class="p-4">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Bootstrap JS Bundle CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>