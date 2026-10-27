
@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-8">

    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">
                Pengadaan Barang
            </h1>
            <p class="text-gray-500 mt-1">
                Daftar transaksi pengadaan barang dari vendor.
            </p>
        </div>

        <a href="{{ route('pengadaan.create') }}"
            class="btn btn-primary">
            + Tambah Pengadaan
        </a>
    </div>

    @if (session('success'))
        <div class="bg-green-100 text-green-700 p-4 rounded-xl mb-5">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm border
                border-gray-100 overflow-x-auto">

        <table class="w-full text-sm text-left">
            <thead class="bg-gray-50 text-gray-600">
                <tr>
                    <th class="px-5 py-4">ID</th>
                    <th class="px-5 py-4">Tanggal</th>
                    <th class="px-5 py-4">Vendor</th>
                    <th class="px-5 py-4">User</th>
                    <th class="px-5 py-4">Subtotal</th>
                    <th class="px-5 py-4">PPN</th>
                    <th class="px-5 py-4">Total</th>
                    <th class="px-5 py-4">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-100">
                @forelse ($pengadaan as $item)
                    <tr class="hover:bg-gray-50">
                        <td class="px-5 py-4">
                            {{ $item->idpengadaan }}
                        </td>
                        <td class="px-5 py-4">
                            {{ $item->timestamp }}
                        </td>
                        <td class="px-5 py-4">
                            {{ $item->nama_vendor ?? '-' }}
                        </td>
                        <td class="px-5 py-4">
                            {{ $item->username ?? '-' }}
                        </td>
                        <td class="px-5 py-4">
                            Rp {{ number_format($item->sub_total ?? 0, 0, ',', '.') }}
                        </td>
                        <td class="px-5 py-4">
                            Rp {{ number_format($item->ppn ?? 0, 0, ',', '.') }}
                        </td>
                        <td class="px-5 py-4 font-semibold">
                            Rp {{ number_format($item->total_nilai ?? 0, 0, ',', '.') }}
                        </td>
                        <td class="px-5 py-4">
                            <a href="{{ route('pengadaan.show', $item->idpengadaan) }}"
                                class="inline-block bg-blue-50 text-blue-700 hover:bg-blue-100 px-4 py-2 rounded-lg font-medium">
                                Detail
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8"
                            class="px-5 py-10 text-center text-gray-500">
                            Belum ada transaksi pengadaan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection
