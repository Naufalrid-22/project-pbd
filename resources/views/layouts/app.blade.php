
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Inventori')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-100 text-slate-800">


    <header class="border-b border-slate-200 bg-white">
        <div class="mx-auto flex max-w-7xl flex-col gap-4 px-6 py-4 sm:flex-row sm:items-center sm:justify-between">

            <a href="{{ route('dashboard') }}"
            class="text-xl font-bold tracking-tight text-blue-700">
                Inventori<span class="text-slate-800">App</span>
            </a>

            <nav class="flex flex-wrap items-center gap-2">
                <a href="{{ route('dashboard') }}"
                class="rounded-lg px-4 py-2 text-sm font-medium
                        {{ request()->routeIs('dashboard*')
                            ? 'bg-blue-50 text-blue-700'
                            : 'text-slate-600 hover:bg-slate-100' }}">
                    Dashboard
                </a>

                <a href="{{ route('barang.index') }}"
                class="rounded-lg px-4 py-2 text-sm font-medium
                        {{ request()->routeIs('barang.*')
                            ? 'bg-blue-50 text-blue-700'
                            : 'text-slate-600 hover:bg-slate-100' }}">
                    Data Barang
                </a>
                <a href="{{ route('satuan.index') }}"
                class="rounded-lg px-4 py-2 text-sm font-medium
                        {{ request()->routeIs('satuan.*')
                            ? 'bg-blue-50 text-blue-700'
                            : 'text-slate-600 hover:bg-slate-100'}}">
                    Data Satuan
                </a>
                <a href="{{ route('vendor.index') }}"
                    class="rounded-lg px-4 py-2 text-sm font-medium
                            {{ request()->routeIs('vendor.*')
                                ? 'bg-blue-50 text-blue-700'
                                : 'text-slate-600 hover:bg-slate-100' }}">
                    Data Vendor
                </a>
                <a href="{{ route('role.index') }}"
                    class="rounded-lg px-4 py-2 text-sm font-medium
                            {{ request()->routeIs('role.*')
                                ? 'bg-blue-50 text-blue-700'
                                : 'text-slate-600 hover:bg-slate-100' }}">
                    Data Role
                </a>
                <a href="{{ route('user.index') }}"
                    class="rounded-lg px-4 py-2 text-sm font-medium
                            {{ request()->routeIs('user.*')
                                ? 'bg-blue-50 text-blue-700'
                                : 'text-slate-600 hover:bg-slate-100' }}">
                    Data User
                </a>
                <a href="{{ route('margin_penjualan.index') }}"
                class="rounded-lg px-4 py-2 text-sm font-medium
                        {{ request()->routeIs('margin-penjualan.*')
                            ? 'bg-blue-50 text-blue-700'
                            : 'text-slate-600 hover:bg-slate-100' }}">
                    Margin Penjualan
                </a>
            </nav>

        </div>
    </header>

    <main class="mx-auto max-w-7xl px-6 py-8">

        @if (session('success'))
            <div class="mb-6 rounded-lg border border-green-200
                        bg-green-50 px-4 py-3 text-sm text-green-700">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-6 rounded-lg border border-red-200
                        bg-red-50 px-4 py-3 text-sm text-red-700">
                <p class="mb-2 font-semibold">
                    Data belum berhasil diproses:
                </p>

                <ul class="list-inside list-disc">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')

    </main>

</body>
</html>
