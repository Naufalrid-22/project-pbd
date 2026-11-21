@extends('layouts.app')

@section('content')

<div class="max-w-7xl mx-auto px-6 py-8">

    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-800">
            Manajemen Stok
        </h1>
        <p class="text-gray-500 mt-1">
            Informasi stok barang dan riwayat kartu stok.
        </p>
    </div>

    {{-- STOK BARANG --}}
    <div class="mb-6">
        <h2 class="text-xl font-bold text-gray-800">
            Stok Barang
        </h2>
        <p class="text-gray-500 text-sm mt-1">
            Jumlah stok barang yang tersedia saat ini.
        </p>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-x-auto mb-10">

        <table class="w-full text-sm text-left">
            <thead class="bg-gray-50 text-gray-600">
                <tr>
                    <th class="px-5 py-4">ID Barang</th>
                    <th class="px-5 py-4">Nama Barang</th>
                    <th class="px-5 py-4">Harga Modal</th>
                    <th class="px-5 py-4">Stok Tersedia</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-100">

                @forelse ($barang as $b)
                    <tr class="hover:bg-gray-50">
                        <td class="px-5 py-4">
                            {{ $b->idbarang }}
                        </td>

                        <td class="px-5 py-4 font-medium">
                            {{ $b->nama }}
                        </td>

                        <td class="px-5 py-4">
                            Rp {{ number_format($b->harga, 0, ',', '.') }}
                        </td>

                        <td class="px-5 py-4">
                            <span class="px-3 py-2 rounded-lg
                                {{ $b->stok > 0
                                    ? 'bg-green-50 text-green-700'
                                    : 'bg-red-50 text-red-700' }}">
                                {{ $b->stok }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-5 py-8 text-center text-gray-500">
                            Belum ada data barang.
                        </td>
                    </tr>
                @endforelse

            </tbody>
        </table>
    </div>


    {{-- DATA KARTU STOK --}}
    <div class="mb-6">
        <h2 class="text-xl font-bold text-gray-800">
            Data Kartu Stok
        </h2>
        <p class="text-gray-500 text-sm mt-1">
            Riwayat seluruh transaksi barang masuk dan keluar.
        </p>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-x-auto">

        <table class="w-full text-sm text-left">
            <thead class="bg-gray-50 text-gray-600">
                <tr>
                    <th class="px-5 py-4">ID Kartu Stok</th>
                    <th class="px-5 py-4">ID Barang</th>
                    <th class="px-5 py-4">Nama Barang</th>
                    <th class="px-5 py-4">Jenis Transaksi</th>
                    <th class="px-5 py-4">Masuk</th>
                    <th class="px-5 py-4">Keluar</th>
                    <th class="px-5 py-4">Stok</th>
                    <th class="px-5 py-4">Tanggal</th>
                    <th class="px-5 py-4">ID Transaksi</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-100">

                @forelse ($kartuStok as $k)
                    <tr class="hover:bg-gray-50">

                        <td class="px-5 py-4">
                            {{ $k->idkartu_stok }}
                        </td>

                        <td class="px-5 py-4">
                            {{ $k->idbarang }}
                        </td>

                        <td class="px-5 py-4">
                            {{ $k->nama ?? '-' }}
                        </td>

                        <td class="px-5 py-4">
                            @if ($k->jenis_transaksi == 'M')
                                <span class="bg-green-50 text-green-700 px-3 py-2 rounded-lg">
                                    Masuk
                                </span>
                            @elseif ($k->jenis_transaksi == 'K')
                                <span class="bg-red-50 text-red-700 px-3 py-2 rounded-lg">
                                    Keluar
                                </span>
                            @else
                                {{ $k->jenis_transaksi }}
                            @endif
                        </td>

                        <td class="px-5 py-4">
                            {{ $k->masuk }}
                        </td>

                        <td class="px-5 py-4">
                            {{ $k->keluar }}
                        </td>

                        <td class="px-5 py-4 font-semibold">
                            {{ $k->stock }}
                        </td>

                        <td class="px-5 py-4">
                            {{ $k->created_at }}
                        </td>

                        <td class="px-5 py-4">
                            {{ $k->idtransaksi }}
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="px-5 py-8 text-center text-gray-500">
                            Belum ada riwayat kartu stok.
                        </td>
                    </tr>
                @endforelse

            </tbody>
        </table>
    </div>

</div>

@endsection
