<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Keuangan - Inovindo Digital Media</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <style>
    :root {
        --brand: #1a3fa0;
        --brand-light: #eaf0fb;
        --brand-accent: #2fb32f;
        --bg: #f4f6fb;
    }

    body { background: var(--bg); font-family: 'Segoe UI', system-ui, sans-serif; }

    .sidebar {
        width: 230px; min-height: 100vh; background: #fff;
        border-right: 1px solid #eaecf3; position: fixed; top: 0; left: 0;
        box-shadow: 2px 0 8px rgba(0,0,0,0.03);
    }
    .sidebar-header {
        background: linear-gradient(135deg, var(--brand) 0%, #1a5a5d 100%);
        padding: 1.25rem 1.3rem;
        color: #fff;
    }
    .sidebar-header .text-muted { color: rgba(255,255,255,0.8) !important; }
    .sidebar .nav-link {
        color: #555; padding: .65rem 1.3rem; border-radius: 0;
        font-size: .92rem; border-left: 3px solid transparent;
        transition: all .15s ease;
    }
    .sidebar .nav-link i { margin-right: .5rem; width: 18px; display: inline-block; }
    .sidebar .nav-link.active {
        background: var(--brand-light); font-weight: 600; color: var(--brand);
        border-left: 3px solid var(--brand);
    }
    .sidebar .nav-link:hover:not(.active) { background: #f8f9fc; color: var(--brand); }

    .main-content { margin-left: 230px; padding: 1.75rem 2.25rem; }

    .topbar {
        display: flex; justify-content: space-between; align-items: center;
        padding-bottom: 1.1rem; margin-bottom: 1.75rem; border-bottom: 1px solid #eaecf3;
    }
    .topbar h5 { font-weight: 700; color: #1f2937; }

        .card-metric, .card {
        border: 1px solid #eaecf3; border-radius: 10px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.04);
    }

        .card-body > h6.d-flex.align-items-center {
        background: linear-gradient(135deg, var(--brand) 0%, #1a5a5d 100%);
        color: #fff;
        margin: -1rem -1rem 1.5rem;
        padding: 1rem 1.25rem;
        border-radius: 9px 9px 0 0;
    }
    .card-body > h6.d-flex.align-items-center .card-header-icon {
        background: rgba(255,255,255,0.2);
        color: #fff;
    }
    
    .card-metric { padding: 1rem 1.15rem; background: #fff; }
    .card-metric .label {
        font-size: .72rem; color: #8b93a7; text-transform: uppercase;
        letter-spacing: .04em; font-weight: 600;
    }
    .card-metric .value { font-size: 1.4rem; font-weight: 700; color: #1f2937; margin-top: .25rem; }
    .card-metric .value.positive { color: #15803d; }
    .card-metric .value.negative { color: #dc2626; }

    .form-label i { color: var(--brand); margin-right: .4rem; }
    .card-header-icon {
        width: 38px; height: 38px; border-radius: 10px;
        background: var(--brand-light); color: var(--brand);
        display: inline-flex; align-items: center; justify-content: center;
        margin-right: .6rem; font-size: 1.05rem;
    }

    .metric-icon {
        width: 42px; height: 42px; border-radius: 12px;
        background: var(--brand-light); color: var(--brand);
        display: flex; align-items: center; justify-content: center;
        font-size: 1.15rem; flex-shrink: 0;
    }
    .table { border-radius: 10px; overflow: hidden; }
    .table thead th {
        background: var(--brand-light); color: var(--brand);
        font-size: .8rem; text-transform: uppercase; letter-spacing: .03em;
        border-bottom: none; font-weight: 600;
    }
    .table td, .table th { vertical-align: middle; padding: .75rem .9rem; }

    .btn-dark { background: var(--brand); border-color: var(--brand); }
    .btn-dark:hover { background: #1f2b4d; border-color: #1f2b4d; }
    .btn-outline-primary { color: var(--brand); border-color: var(--brand); }
    .btn-outline-primary:hover { background: var(--brand); border-color: var(--brand); }

    /* Perbaikan ukuran ikon panah pagination Laravel */
    nav[role="navigation"] svg { width: 20px; height: 20px; }
     /* Sembunyikan versi mobile pagination yang dobel */
    nav[role="navigation"] > div:first-child { display: none !important; }
    </style>
</head>
<body>

    <div class="sidebar">
        <div class="sidebar-header d-flex align-items-center gap-2">
            <img src="{{ asset('images/logo.jpeg') }}" alt="Logo" style="width: 36px; height: 36px; border-radius: 8px; background: #fff; padding: 2px;">
            <div>
                <strong style="font-size: .95rem; line-height: 1.1; display: block; color: #fff;">Sistem Keuangan</strong>
                <div class="text-muted" style="font-size: .72rem;">Inovindo Digital Media</div>
            </div>
        </div>
        <nav class="nav flex-column pt-2">
            @if (Route::has('dashboard'))
                <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
            @endif

            
            {{-- Riwayat Transaksi bisa dilihat Owner dan Finance --}}
            @if (Route::has('transaksi.index'))
                <a class="nav-link {{ request()->routeIs('transaksi.index') ? 'active' : '' }}"
                href="{{ route('transaksi.index') }}">
                    <i class="bi bi-clock-history"></i> Riwayat Transaksi
                </a>
            @endif


            @if (auth()->user()->isFinance())
                @if (Route::has('transaksi.create-pemasukan'))
                    <a class="nav-link {{ request()->routeIs('transaksi.create-pemasukan') ? 'active' : '' }}" href="{{ route('transaksi.create-pemasukan') }}">
                        <i class="bi bi-arrow-down-circle text-success"></i> Input Pemasukan
                    </a>
                @endif
                @if (Route::has('transaksi.create-pengeluaran'))
                    <a class="nav-link {{ request()->routeIs('transaksi.create-pengeluaran') ? 'active' : '' }}" href="{{ route('transaksi.create-pengeluaran') }}">
                        <i class="bi bi-arrow-up-circle text-danger"></i> Input Pengeluaran
                    </a>
                @endif
                {{-- Riwayat transaksi bisa dilihat Owner dan Finance --}}
                @if (Route::has('transaksi.index'))
                    <a class="nav-link {{ request()->routeIs('transaksi.index') ? 'active' : '' }}"
                    href="{{ route('transaksi.index') }}">
                        <i class="bi bi-clock-history"></i> Riwayat Transaksi
                    </a>
                @endif
                @if (Route::has('kategori.index'))
                    <a class="nav-link {{ request()->routeIs('kategori.index') ? 'active' : '' }}" href="{{ route('kategori.index') }}">
                        <i class="bi bi-tags"></i> Kelola Kategori
                    </a>
                @endif
                @if (Route::has('proyek.index'))
                    <a class="nav-link {{ request()->routeIs('proyek.index') ? 'active' : '' }}" href="{{ route('proyek.index') }}">
                        <i class="bi bi-kanban"></i> Kelola Proyek
                    </a>
                @endif
            @endif

            @if (Route::has('ranking-roi.index'))
                <a class="nav-link {{ request()->routeIs('ranking-roi.index') ? 'active' : '' }}" href="{{ route('ranking-roi.index') }}">
                    <i class="bi bi-bar-chart"></i> Ranking ROI
                </a>
            @endif

            @if (auth()->user()->isFinance())
                @if (Route::has('alert.index'))
                    <a class="nav-link {{ request()->routeIs('alert.index') ? 'active' : '' }}" href="{{ route('alert.index') }}">
                        <i class="bi bi-bell"></i> Pengaturan Alert
                    </a>
                @endif
            @endif

            @if (Route::has('export.index'))
                <a class="nav-link {{ request()->routeIs('export.index') ? 'active' : '' }}" href="{{ route('export.index') }}">
                    <i class="bi bi-download"></i> Export Laporan
                </a>
            @endif
        </nav>
    </div>

    <div class="main-content">
        <div class="topbar">
            <h5 class="mb-0">@yield('title', 'Dashboard')</h5>
            <div class="text-muted">
                {{ ucfirst(auth()->user()->role) }} &middot; {{ auth()->user()->name }}
                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                    @csrf
                    <button class="btn btn-sm btn-outline-secondary ms-2">Logout</button>
                </form>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </div>

</body>
</html>