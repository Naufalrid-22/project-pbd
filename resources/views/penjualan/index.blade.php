
@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 py-6">

    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold">Data Penjualan</h1>
            <p class="text-gray-500">Daftar transaksi penjualan supermarket</p>
        </div>

        <a href="{{ route('penjualan.create') }}" class="btn btn-primary">
            + Tambah Penjualan
        </a>
    </div>

    <div class="bg-white rounded-xl shadow overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-3">No</th>
                    <th class="px-4 py-3">ID Penjualan</th>
                    <th class="px-4 py-3">Tanggal</th>
                    <th class="px-4 py-3">Kasir</th>
                    <th class="px-4 py-3">Margin</th>
                    <th class="px-4 py-3">Subtotal</th>
                    <th class="px-4 py-3">PPN</th>
                    <th class="px-4 py-3">Total</th>
                    <th class="px-4 py-3">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($penjualan as $item)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-3">{{ $loop->iteration }}</td>
                        <td class="px-4 py-3">{{ $item->idpenjualan }}</td>
                        <td class="px-4 py-3">{{ $item->created_at }}</td>
                        <td class="px-4 py-3">{{ $item->username }}</td>
                        <td class="px-4 py-3">{{ $item->persen }}%</td>
                        <td class="px-4 py-3">
                            Rp {{ number_format($item->subtotal_nilai, 0, ',', '.') }}
                        </td>
                        <td class="px-4 py-3">
                            Rp {{ number_format($item->ppn, 0, ',', '.') }}
                        </td>
                        <td class="px-4 py-3 font-semibold">
                            Rp {{ number_format($item->total_nilai, 0, ',', '.') }}
                        </td>
                        <td class="px-4 py-3">
                            <a href="{{ route('penjualan.detail', $item->idpenjualan) }}"
                            class="btn btn-primary">
                                Detail
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center py-6 text-gray-500">
                            Belum ada transaksi penjualan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection
