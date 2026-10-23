
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

            <div class="topbar-profile">
                <div class="profile-avatar">A</div>
                <div>
                    <span class="profile-name">Administrator</span>
                    <span class="profile-role">Manajemen Inventori</span>
                </div>
            </div>
        </header>

        <main class="main-content">
            <div class="content-container">

                {{-- Notifikasi global: tampilkan sekali saja --}}
                @if (session('success'))
                    <div class="alert alert-success">
                        ✓ {{ session('success') }}
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
