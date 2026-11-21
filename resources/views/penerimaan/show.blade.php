
@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-8">

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">
            Detail Penerimaan Barang
        </h1>
        <p class="text-gray-500 mt-1">
            Periksa barang yang diterima dari pengadaan.
        </p>
    </div>

    @if (session('success'))
        <div class="bg-green-50 text-green-700 p-4 rounded-xl mb-5">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="bg-red-50 text-red-700 p-4 rounded-xl mb-5">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
        <div class="grid grid-cols-2 gap-4">
            <div>
                <p class="text-gray-500 text-sm">ID Penerimaan</p>
                <p class="font-semibold">{{ $penerimaan->idpenerimaan }}</p>
            </div>

            <div>
                <p class="text-gray-500 text-sm">ID Pengadaan</p>
                <p class="font-semibold">{{ $penerimaan->idpengadaan }}</p>
            </div>

            <div>
                <p class="text-gray-500 text-sm">Vendor</p>
                <p class="font-semibold">{{ $penerimaan->nama_vendor }}</p>
            </div>

            <div>
                <p class="text-gray-500 text-sm">Tanggal Penerimaan</p>
                <p class="font-semibold">{{ $penerimaan->created_at }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="bg-gray-50 text-gray-600">
                <tr>
                    <th class="px-5 py-4">Barang</th>
                    <th class="px-5 py-4">Jumlah Diterima</th>
                    <th class="px-5 py-4">Harga Satuan</th>
                    <th class="px-5 py-4">Subtotal</th>
                    @if ($penerimaan->status == '0')
                        <th class="px-5 py-4">Aksi</th>
                    @endif
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-100">
                @forelse ($detail as $d)
                    <tr>
                        <form action="{{ route('penerimaan.update', $d->iddetail_penerimaan) }}"
                            method="POST">
                            @csrf
                            @method('PUT')

                            <td class="px-5 py-4">
                                {{ $d->nama }}
                            </td>

                            <td class="px-5 py-4">
                                @if ($penerimaan->status == '0')
                                    <input type="number"
                                        name="jumlah_terima"
                                        min="1"
                                        value="{{ $d->jumlah_terima }}"
                                        required
                                        class="w-24 border rounded-lg p-2">
                                @else
                                    {{ $d->jumlah_terima }}
                                @endif
                            </td>

                            <td class="px-5 py-4">
                                @if ($penerimaan->status == '0')
                                    <input type="number"
                                        name="harga_satuan_terima"
                                        min="0"
                                        value="{{ $d->harga_satuan_terima }}"
                                        required
                                        class="w-32 border rounded-lg p-2">
                                @else
                                    Rp {{ number_format($d->harga_satuan_terima, 0, ',', '.') }}
                                @endif
                            </td>

                            <td class="px-5 py-4">
                                Rp {{ number_format($d->sub_total_terima, 0, ',', '.') }}
                            </td>

                            @if ($penerimaan->status == '0')
                                <td class="px-5 py-4">
                                    <button type="submit"
                                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                                        Simpan
                                    </button>
                                </td>
                            @endif
                        </form>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-5 py-8 text-center text-gray-500">
                            Belum ada detail barang.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($penerimaan->status == '0')
        <form action="{{ route('penerimaan.konfirmasi', $penerimaan->idpenerimaan) }}"
            method="POST"
            class="mt-6"
            onsubmit="return confirm('Konfirmasi penerimaan barang ini? Stok akan diperbarui.')">
            @csrf

            <button type="submit"
                    class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded-lg">
                Konfirmasi Penerimaan
            </button>
        </form>
    @else
        <p class="mt-6 text-green-700 font-semibold">
            Penerimaan sudah dikonfirmasi.
        </p>
    @endif

    <div class="mt-6 flex justify-between">
        <a href="{{ route('penerimaan.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-5 py-2 rounded-lg">
            Kembali
        </a>
    </div>

</div>
@endsection
