<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'SIPUS-Del' }} — Institut Teknologi Del</title>
    <!-- Bootstrap 5.3.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        :root {
            --del-purple: #4C1D95;
            --del-purple-dark: #3B0764;
            --del-purple-light: #7C3AED;
            --del-purple-subtle: #F3E8FF;
        }
        .navbar-del {
            background-color: var(--del-purple);
        }
        .btn-del {
            background-color: var(--del-purple);
            color: #ffffff;
            border: none;
            transition: all 0.2s ease-in-out;
        }
        .btn-del:hover {
            background-color: var(--del-purple-dark);
            color: #ffffff;
        }
        .btn-outline-del {
            border: 1px solid var(--del-purple);
            color: var(--del-purple);
            background-color: transparent;
        }
        .btn-outline-del:hover {
            background-color: var(--del-purple);
            color: #ffffff;
        }
        .badge-del {
            background-color: var(--del-purple-subtle);
            color: var(--del-purple-dark);
            border: 1px solid #DDD6FE;
            font-weight: 600;
        }
        .card-header-del {
            background-color: var(--del-purple);
            color: #ffffff;
            font-weight: 600;
        }
        .pagination .page-item.active .page-link {
            background-color: var(--del-purple);
            border-color: var(--del-purple);
        }
        .pagination .page-link {
            color: var(--del-purple);
        }
    </style>
</head>
<body class="bg-light min-vh-100 d-flex flex-column">

    <!-- Top Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-del shadow-sm mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold d-flex align-items-center gap-2" href="{{ route('buku.index') }}">
                <i class="bi bi-book-half fs-4"></i>
                <span>SIPUS-Del</span>
                <span class="badge bg-light text-dark ms-1 d-none d-sm-inline" style="font-size: 0.65rem;">IT Del</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navMenu">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0 fw-semibold">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('buku.*') ? 'active text-warning' : '' }}" href="{{ route('buku.index') }}">
                            <i class="bi bi-journal-album me-1"></i> Katalog Buku
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('kategori.*') ? 'active text-warning' : '' }}" href="{{ route('kategori.index') }}">
                            <i class="bi bi-tags me-1"></i> Kategori
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content Container -->
    <main class="container flex-grow-1 pb-5">
        <!-- Flash Session Success Notification -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm d-flex align-items-center gap-2" role="alert">
                <i class="bi bi-check-circle-fill fs-5"></i>
                <div class="flex-grow-1">{{ session('success') }}</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Flash Session Error Notification -->
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show shadow-sm d-flex align-items-center gap-2" role="alert">
                <i class="bi bi-exclamation-octagon-fill fs-5"></i>
                <div class="flex-grow-1">{{ session('error') }}</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer class="bg-white border-top py-3 mt-auto text-center text-muted small">
        <div class="container">
            &copy; {{ date('Y') }} <strong>SIPUS-Del</strong> — Institut Teknologi Del (Sistem Informasi Perpustakaan Kampus)
        </div>
    </footer>

    <!-- Bootstrap 5.3.3 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>