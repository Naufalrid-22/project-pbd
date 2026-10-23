
@extends('layouts.app')

@section('title', 'DVD Hub - Inventory')

@section('content')

<div class="mb-8">
    <p class="mb-2 text-sm font-semibold uppercase tracking-wider text-blue-600">
        Overview
    </p>

    <h1 class="text-3xl font-bold tracking-tight text-slate-900">
        Dashboard Inventori DVD Hub
    </h1>

    <p class="mt-2 text-slate-500">
        Selamat datang di sistem informasi persediaan DVD Hub.
    </p>
</div>

{{-- Ringkasan data --}}
<div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">

    <div class="relative rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-slate-500">
                    Total Barang
                </p>

                <h2 class="mt-3 text-3xl font-bold text-slate-900">
                    {{ number_format($stats['barang']) }}
                </h2>
            </div>

            <div class="rounded-xl bg-blue-100 p-3 text-blue-700">
                <svg xmlns="http://www.w3.org/2000/svg"
                        width="28" height="28" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor"
                        stroke-width="1.8">
                    <path stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M3 7l9-4 9 4-9 4-9-4z"/>
                    <path stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M3 7v10l9 4 9-4V7M12 11v10"/>
                </svg>
            </div>
        </div>

        <p class="mt-5 text-sm text-slate-500">
            Produk kami
        </p>
    </div>

    <div class="relative rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
        <p class="text-sm font-medium text-slate-500">
            Total Satuan
        </p>

        <h2 class="mt-3 text-3xl font-bold text-slate-900">
            {{ number_format($stats['satuan']) }}
        </h2>


        <div class="absolute right-6 top-6 rounded-xl bg-emerald-100 p-3 text-emerald-700">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 8 8 21l-5-5L16 3l5 5Z"/>
                <path d="m7 10 2 2m2-7 2 2m-7 7 2 2"/>
            </svg>
        </div>

        <p class="mt-5 text-sm text-slate-500">
            Satuan barang yang digunakan
        </p>
    </div>

    <div class="relative rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
        <p class="text-sm font-medium text-slate-500">
            Total Vendor
        </p>

        <h2 class="mt-3 text-3xl font-bold text-slate-900">
            {{ number_format($stats['vendor']) }}
        </h2>

        <div class="absolute right-6 top-6 rounded-xl bg-purple-100 p-3 text-purple-700">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M3 21h18M5 21V7l8-4v18M19 21V11l-6-4"/>
                <path d="M8 9h1m-1 4h1m-1 4h1m7-4h1m-1 4h1"/>
            </svg>
        </div>

        <p class="mt-5 text-sm text-slate-500">
            Vendor supermarket
        </p>
    </div>

    <div class="relative rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
        <p class="text-sm font-medium text-slate-500">
            Total User
        </p>

        <h2 class="mt-3 text-3xl font-bold text-slate-900">
            {{ number_format($stats['user']) }}
        </h2>


        <div class="absolute right-6 top-6 rounded-xl bg-orange-100 p-3 text-orange-700">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M16 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                <circle cx="10" cy="7" r="4"/>
                <path d="M20 21v-2a4 4 0 0 0-3-3.87"/>
                <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
            </svg>
        </div>


        <p class="mt-5 text-sm text-slate-500">
            Pengguna aplikasi
        </p>
    </div>

    <div class="relative rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
        <p class="text-sm font-medium text-slate-500">
            Total Role
        </p>

        <h2 class="mt-3 text-3xl font-bold text-slate-900">
            {{ number_format($stats['role']) }}
        </h2>


    <div class="absolute right-6 top-6 rounded-xl bg-pink-100 p-3 text-pink-700">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
            viewBox="0 0 24 24" fill="none" stroke="currentColor"
            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M12 22s8-4 8-11V5l-8-3-8 3v6c0 7 8 11 8 11Z"/>
            <path d="m9 12 2 2 4-4"/>
        </svg>
    </div>

        <p class="mt-5 text-sm text-slate-500">
            Hak akses pengguna
        </p>
    </div>

    <div class="relative rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
        <p class="text-sm font-medium text-slate-500">
            Margin Penjualan
        </p>

        <h2 class="mt-3 text-3xl font-bold text-slate-900">
            {{ number_format($stats['margin']) }}
        </h2>

    <div class="absolute right-6 top-6 rounded-xl bg-amber-100 p-3 text-amber-700">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
            viewBox="0 0 24 24" fill="none" stroke="currentColor"
            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M3 3v18h18"/>
            <path d="m19 9-5 5-4-4-4 4"/>
            <path d="M15 9h4v4"/>
        </svg>
    </div>

        <p class="mt-5 text-sm text-slate-500">
            Data pengaturan margin
        </p>
    </div>

</div>

{{-- Akses cepat --}}
<div class="mt-8 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
    <h2 class="text-lg font-bold text-slate-900">
        Akses Cepat
    </h2>

    <p class="mt-1 text-sm text-slate-500">
        Pilih modul yang ingin kamu kelola.
    </p>

    <div class="mt-5 flex flex-wrap gap-3">
        <a href="{{ route('barang.index') }}"
            class="rounded-lg bg-blue-600 px-5 py-3 text-sm
                    font-semibold text-white transition hover:bg-blue-700">
            Data Barang
        </a>

        <a href="{{ route('barang.create') }}"
            class="rounded-lg border border-slate-300 px-5 py-3
                    text-sm font-semibold text-slate-700 transition
                    hover:bg-slate-50">
            + Tambah Barang
        </a>
    </div>
</div>

@endsection
