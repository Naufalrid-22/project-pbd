
@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 py-6">

    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold">Detail Penjualan</h1>
            <p class="text-gray-500">
                Informasi transaksi penjualan
            </p>
        </div>

        <a href="{{ route('penjualan.index') }}"
           class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">
            Kembali
        </a>
    </div>

    <div class="bg-white rounded-xl shadow p-6 mb-6">
        <h2 class="font-bold text-lg mb-4">Informasi Transaksi</h2>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <p class="text-gray-500">ID Penjualan</p>
                <p class="font-semibold">{{ $penjualan->idpenjualan }}</p>
            </div>

            <div>
                <p class="text-gray-500">Tanggal</p>
                <p class="font-semibold">{{ $penjualan->created_at }}</p>
            </div>

            <div>
                <p class="text-gray-500">Kasir</p>
                <p class="font-semibold">{{ $penjualan->username }}</p>
            </div>

            <div>
                <p class="text-gray-500">Total Pembayaran</p>
                <p class="font-semibold">
                    Rp {{ number_format($penjualan->total_nilai, 0, ',', '.') }}
                </p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow overflow-x-auto">
        <div class="p-6">
            <h2 class="font-bold text-lg">Barang yang Dibeli</h2>
        </div>

        <table class="w-full text-sm text-left">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-3">No</th>
                    <th class="px-4 py-3">Nama Barang</th>
                    <th class="px-4 py-3">Harga Satuan</th>
                    <th class="px-4 py-3">Jumlah</th>
                    <th class="px-4 py-3">Subtotal</th>
                </tr>
            </thead>

            <tbody>
                @forelse($detail as $item)
                    <tr class="border-b">
                        <td class="px-4 py-3">{{ $loop->iteration }}</td>
                        <td class="px-4 py-3">{{ $item->nama }}</td>
                        <td class="px-4 py-3">
                            Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}
                        </td>
                        <td class="px-4 py-3">{{ $item->jumlah }}</td>
                        <td class="px-4 py-3">
                            Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-6 text-gray-500">
                            Detail barang tidak ditemukan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="p-6 border-t">
            <div class="flex justify-end">
                <div class="w-72 space-y-2">
                    <div class="flex justify-between">
                        <span>Subtotal</span>
                        <span>
                            Rp {{ number_format($penjualan->subtotal_nilai, 0, ',', '.') }}
                        </span>
                    </div>

                    <div class="flex justify-between">
                        <span>PPN</span>
                        <span>
                            Rp {{ number_format($penjualan->ppn, 0, ',', '.') }}
                        </span>
                    </div>

                    <div class="flex justify-between font-bold text-lg border-t pt-3">
                        <span>Total</span>
                        <span>
                            Rp {{ number_format($penjualan->total_nilai, 0, ',', '.') }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
