
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
</head>
<body>
<div class="app-layout">

    {{-- SIDEBAR --}}
    <aside class="sidebar">
        <a href="{{ route('dashboard') }}" class="brand">
            <span class="brand-icon">🛒</span>
            <span>DVD Hub</span>
        </a>

        <div class="sidebar-section">Menu Utama</div>

        <nav class="sidebar-nav">
            <a href="{{ route('dashboard') }}"
                class="sidebar-link {{ request()->routeIs('dashboard*') ? 'active' : '' }}">
                <span class="nav-icon">⌂</span>
                Dashboard
            </a>
        </nav>

        <div class="sidebar-divider"></div>
        <div class="sidebar-section">Data Master</div>

        <nav class="sidebar-nav">
            <a href="{{ route('barang.index') }}"
                class="sidebar-link {{ request()->routeIs('barang.*') ? 'active' : '' }}">
                <span class="nav-icon">📦</span>
                Data Barang
            </a>

            <a href="{{ route('satuan.index') }}"
                class="sidebar-link {{ request()->routeIs('satuan.*') ? 'active' : '' }}">
                <span class="nav-icon">📏</span>
                Data Satuan
            </a>

            <a href="{{ route('vendor.index') }}"
                class="sidebar-link {{ request()->routeIs('vendor.*') ? 'active' : '' }}">
                <span class="nav-icon">🏢</span>
                Data Vendor
            </a>

            <a href="{{ route('role.index') }}"
                class="sidebar-link {{ request()->routeIs('role.*') ? 'active' : '' }}">
                <span class="nav-icon">🛡️</span>
                Data Role
            </a>

            <a href="{{ route('user.index') }}"
                class="sidebar-link {{ request()->routeIs('user.*') ? 'active' : '' }}">
                <span class="nav-icon">👥</span>
                Data User
            </a>

            <a href="{{ route('margin_penjualan.index') }}"
                class="sidebar-link {{ request()->routeIs('marginpenjualan.*') ? 'active' : '' }}">
                <span class="nav-icon">📈</span>
                Margin Penjualan
            </a>
        </nav>

        <div class="sidebar-divider"></div>
        <div class="sidebar-section">Data Transaksi</div>

        <nav class="sidebar-nav">

            @if (auth()->user()->iduser ==1)
            <a href="{{ route('pengadaan.index') }}" class="sidebar-link {{ request()->routeIs('pengadaan.*') ? 'active' : '' }}">
                <span class="nav-icon">🛒</span>
                Data Pengadaan
            </a>

            <a href="{{ route('penerimaan.index') }}" class="sidebar-link {{ request()->routeIs('penerimaan.*') ? 'active' : '' }}">
                <span class="nav-icon">📥</span>
                Data Penerimaan
            </a>

            @endif

            <a href="{{ route('penjualan.index') }}" class="sidebar-link {{ request()->routeIs('penjualan.*') ? 'active' : '' }}">
                <span class="nav-icon">🧾</span>
                Data Penjualan
            </a>

            @if (auth()->user()->idrole == 1)

                <div class="sidebar-divider"></div>

                <div class="sidebar-section">
                    Persediaan
                </div>

                <nav class="sidebar-nav">
                    <a href="{{ route('stok.index') }}"
                    class="sidebar-link {{ request()->routeIs('stok.*') ? 'active' : '' }}">

                        <span class="nav-icon">📦</span>
                        Stok Barang

                    </a>
                </nav>

            @endif

        </nav>

        <div class="sidebar-footer">
            <div class="sidebar-footer-card">
                <strong>DVD Hub Inventory</strong>
                <p>Kelola inventori DVD di sini.</p>
            </div>
        </div>
    </aside>

    {{-- AREA KONTEN --}}
    <div class="main-area">

        <header class="topbar">
            <form class="topbar-search" action="#" method="GET"
                onsubmit="return false;">
                <span>⌕</span>
                <input type="search"
                        placeholder="Cari menu atau data..."
                        aria-label="Cari menu atau data">
            </form>


<div class="flex items-center gap-4">

    {{-- Informasi Pengguna --}}
    <div class="text-right">
        <p class="font-semibold text-gray-800">
            {{ Auth::user()->username }}
        </p>

        <p class="text-sm text-gray-500">
            @if (Auth::user()->idrole == 1)
                Administrator
            @elseif (Auth::user()->idrole == 3)
                Kasir
            @else
                Pengguna
            @endif
        </p>
    </div>

    {{-- Foto Profil --}}
    <div class="w-10 h-10 rounded-full bg-blue-100
                flex items-center justify-center
                text-blue-600 font-bold">
        {{ strtoupper(substr(Auth::user()->username, 0, 1)) }}
    </div>

    {{-- Tombol Logout --}}
        <form action="{{ url('/logout') }}" method="POST">
            @csrf

            <button
                type="submit"
                class="bg-red-500 hover:bg-red-600
                    text-white px-4 py-2 rounded-lg
                    text-sm font-medium">
                Logout
            </button>
        </form>

    </div>

        </header>

        <main class="main-content">
            <div class="content-container">

                {{-- Notifikasi global: tampilkan sekali saja --}}
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-error">
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')

            </div>
        </main>
    </div>
</div>
</body>
</html>
