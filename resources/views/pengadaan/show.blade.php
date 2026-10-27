
@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-8">

    <div class="mb-6">
        <a href="{{ route('pengadaan.index') }}"
            class="text-blue-600 hover:underline">
            &larr; Kembali ke Pengadaan
        </a>

        <h1 class="text-2xl font-bold text-gray-800 mt-3">
            Detail Pengadaan #{{ $item->idpengadaan }}
        </h1>

        <p class="text-gray-500 mt-1">
            Informasi transaksi dan daftar barang yang dipesan.
        </p>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100
                shadow-sm p-6 mb-6">

        <h2 class="text-lg font-semibold mb-5">
            Informasi Pengadaan
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

            <div>
                <p class="text-sm text-gray-500">ID Pengadaan</p>
                <p class="font-semibold mt-1">
                    {{ $item->idpengadaan }}
                </p>
            </div>

            <div>
                <p class="text-sm text-gray-500">Tanggal Pengadaan</p>
                <p class="font-semibold mt-1">
                    {{ $item->timestamp ?? '-' }}
                </p>
            </div>

            <div>
                <p class="text-sm text-gray-500">Vendor</p>
                <p class="font-semibold mt-1">
                    {{ $item->nama_vendor ?? '-' }}
                </p>
            </div>

            <div>
                <p class="text-sm text-gray-500">User</p>
                <p class="font-semibold mt-1">
                    {{ $item->username ?? '-' }}
                </p>
            </div>

            <div>
                <p class="text-sm text-gray-500">Status</p>
                <p class="font-semibold mt-1">
                    {{ $item->status ?? '-' }}
                </p>
            </div>

        </div>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100
                shadow-sm overflow-hidden">

        <div class="p-6 border-b border-gray-100">
            <h2 class="text-lg font-semibold">Daftar Barang</h2>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-50 text-gray-600">
                    <tr>
                        <th class="px-5 py-4">No.</th>
                        <th class="px-5 py-4">Nama Barang</th>
                        <th class="px-5 py-4">Jumlah</th>
                        <th class="px-5 py-4">Satuan</th>
                        <th class="px-5 py-4">Harga Satuan</th>
                        <th class="px-5 py-4">Subtotal</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">
                    @forelse ($detail as $index => $d)
                        <tr class="hover:bg-gray-50">
                            <td class="px-5 py-4">
                                {{ $index + 1 }}
                            </td>

                            <td class="px-5 py-4 font-medium">
                                {{ $d->nama_barang ?? 'Barang tidak ditemukan' }}
                            </td>

                            <td class="px-5 py-4">
                                {{ $d->jumlah }}
                            </td>

                            <td class="px-5 py-4">
                                {{ $d->nama_satuan ?? '-' }}
                            </td>

                            <td class="px-5 py-4">
                                Rp {{ number_format($d->harga_satuan ?? 0, 0, ',', '.') }}
                            </td>

                            <td class="px-5 py-4 font-medium">
                                Rp {{ number_format($d->sub_total ?? 0, 0, ',', '.') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6"
                                class="px-5 py-8 text-center text-gray-500">
                                Belum ada detail barang.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-6 bg-gray-50 border-t border-gray-100">
            <div class="max-w-sm ml-auto space-y-3">

                <div class="flex justify-between gap-4">
                    <span class="text-gray-600">Subtotal</span>
                    <span class="font-medium">
                        Rp {{ number_format($item->sub_total ?? 0, 0, ',', '.') }}
                    </span>
                </div>

                <div class="flex justify-between gap-4">
                    <span class="text-gray-600">PPN</span>
                    <span class="font-medium">
                        Rp {{ number_format($item->ppn ?? 0, 0, ',', '.') }}
                    </span>
                </div>

                <div class="flex justify-between gap-4 border-t
                            border-gray-200 pt-3 text-lg">
                    <span class="font-bold">Total Pengadaan</span>
                    <span class="font-bold text-blue-700">
                        Rp {{ number_format($item->total_nilai ?? 0, 0, ',', '.') }}
                    </span>
                </div>

            </div>
        </div>
    </div>

</div>
@endsection
