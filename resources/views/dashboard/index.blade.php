
@extends('layouts.app')

@section('title', 'Dashboard Inventori')

@section('content')

<div class="mb-8">
    <p class="mb-2 text-sm font-semibold uppercase tracking-wider text-blue-600">
        Overview
    </p>

    <h1 class="text-3xl font-bold tracking-tight text-slate-900">
        Dashboard Inventori
    </h1>

    <p class="mt-2 text-slate-500">
        Selamat datang di sistem informasi persediaan supermarket.
    </p>
</div>

{{-- Ringkasan data --}}
<div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">

    <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
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

    <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
        <p class="text-sm font-medium text-slate-500">
            Total Satuan
        </p>

        <h2 class="mt-3 text-3xl font-bold text-slate-900">
            {{ number_format($stats['satuan']) }}
        </h2>

        <p class="mt-5 text-sm text-slate-500">
            Satuan barang yang digunakan
        </p>
    </div>

    <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
        <p class="text-sm font-medium text-slate-500">
            Total Vendor
        </p>

        <h2 class="mt-3 text-3xl font-bold text-slate-900">
            {{ number_format($stats['vendor']) }}
        </h2>

        <p class="mt-5 text-sm text-slate-500">
            Vendor supermarket
        </p>
    </div>

    <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
        <p class="text-sm font-medium text-slate-500">
            Total User
        </p>

        <h2 class="mt-3 text-3xl font-bold text-slate-900">
            {{ number_format($stats['user']) }}
        </h2>

        <p class="mt-5 text-sm text-slate-500">
            Pengguna aplikasi
        </p>
    </div>

    <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
        <p class="text-sm font-medium text-slate-500">
            Total Role
        </p>

        <h2 class="mt-3 text-3xl font-bold text-slate-900">
            {{ number_format($stats['role']) }}
        </h2>

        <p class="mt-5 text-sm text-slate-500">
            Hak akses pengguna
        </p>
    </div>

    <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
        <p class="text-sm font-medium text-slate-500">
            Margin Penjualan
        </p>

        <h2 class="mt-3 text-3xl font-bold text-slate-900">
            {{ number_format($stats['margin']) }}
        </h2>

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
