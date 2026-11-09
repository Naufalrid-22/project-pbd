
@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-6 py-8">

    {{-- Header --}}
    <div class="mb-6">
        <a href="{{ route('penjualan.index') }}"
           class="text-sm text-gray-500 hover:text-blue-600">
            ← Kembali ke Penjualan
        </a>

        <h1 class="text-2xl font-bold text-gray-800 mt-3">
            Tambah Penjualan
        </h1>

        <p class="text-sm text-gray-500 mt-1">
            Masukkan barang yang dibeli untuk membuat transaksi penjualan.
        </p>
    </div>

    {{-- Error Validasi --}}
    @if ($errors->any())
        <div class="mb-6 rounded-xl bg-red-50 border border-red-200 p-4">
            <p class="font-semibold text-red-700 mb-2">
                Terdapat kesalahan:
            </p>
            <ul class="list-disc list-inside text-sm text-red-600">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('penjualan.store') }}" method="POST">
        @csrf

        {{-- Informasi Transaksi --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">

            <h2 class="font-semibold text-gray-800 mb-5">
                Informasi Transaksi
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Margin Penjualan
                    </label>

                    <select name="idmargin_penjualan"
                            class="w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                            required>
                        <option value="">Pilih Margin</option>

                        @foreach ($margin as $item)
                            <option value="{{ $item->idmargin_penjualan }}"
                                {{ old('idmargin_penjualan') == $item->idmargin_penjualan ? 'selected' : '' }}>
                                Margin {{ $item->persen }}%
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        PPN (%)
                    </label>

                    <input type="number"
                           name="ppn_persen"
                           value="{{ old('ppn_persen', 11) }}"
                           min="0"
                           max="100"
                           step="0.01"
                           required
                           class="w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                </div>

            </div>
        </div>

        {{-- Daftar Barang --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">

            <div class="flex items-center justify-between mb-5">
                <div>
                    <h2 class="font-semibold text-gray-800">
                        Daftar Barang
                    </h2>
                    <p class="text-sm text-gray-500 mt-1">
                        Pilih barang dan masukkan jumlah pembelian.
                    </p>
                </div>

                <button type="button"
                        onclick="tambahBarang()"
                        class="px-4 py-2 rounded-xl bg-blue-600 text-white text-sm font-medium hover:bg-blue-700">
                    + Tambah Barang
                </button>
            </div>

            <div id="daftar-barang" class="space-y-4">

                <div class="grid grid-cols-1 md:grid-cols-12 gap-3 items-end baris-barang">

                    <div class="md:col-span-7">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Nama Barang
                        </label>

                        <select name="idbarang[]"
                                required
                                class="w-full rounded-xl border-gray-300">
                            <option value="">Pilih Barang</option>

                            @foreach ($barang as $item)
                                <option value="{{ $item->idbarang }}">
                                    {{ $item->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="md:col-span-3">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Jumlah
                        </label>

                        <input type="number"
                               name="jumlah[]"
                               min="1"
                               value="1"
                               required
                               class="w-full rounded-xl border-gray-300">
                    </div>

                    <div class="md:col-span-2">
                        <button type="button"
                                onclick="hapusBarang(this)"
                                class="w-full px-3 py-2.5 rounded-xl bg-red-50 text-red-600 hover:bg-red-100">
                            Hapus
                        </button>
                    </div>

                </div>

            </div>
        </div>

        {{-- Tombol Simpan --}}
        <div class="flex justify-end gap-3">
            <a href="{{ route('penjualan.index') }}"
               class="px-5 py-3 rounded-xl border border-gray-300 text-gray-600 hover:bg-gray-50">
                Batal
            </a>

            <button type="submit"
                    class="px-5 py-3 rounded-xl bg-blue-600 text-white font-medium hover:bg-blue-700">
                Simpan Penjualan
            </button>
        </div>

    </form>
</div>

{{-- JavaScript Tambah dan Hapus Barang --}}
<script>
    function tambahBarang() {
        const daftar = document.getElementById('daftar-barang');

        const baris = document.createElement('div');
        baris.className = 'grid grid-cols-1 md:grid-cols-12 gap-3 items-end baris-barang';

        baris.innerHTML = `
            <div class="md:col-span-7">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Nama Barang
                </label>

                <select name="idbarang[]" required
                        class="w-full rounded-xl border-gray-300">
                    <option value="">Pilih Barang</option>

                    @foreach ($barang as $item)
                        <option value="{{ $item->idbarang }}">
                            {{ $item->nama }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="md:col-span-3">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Jumlah
                </label>

                <input type="number" name="jumlah[]" min="1"
                       value="1" required
                       class="w-full rounded-xl border-gray-300">
            </div>

            <div class="md:col-span-2">
                <button type="button" onclick="hapusBarang(this)"
                        class="w-full px-3 py-2.5 rounded-xl bg-red-50 text-red-600 hover:bg-red-100">
                    Hapus
                </button>
            </div>
        `;

        daftar.appendChild(baris);
    }

    function hapusBarang(button) {
        const daftar = document.getElementById('daftar-barang');

        if (daftar.querySelectorAll('.baris-barang').length > 1) {
            button.closest('.baris-barang').remove();
        } else {
            alert('Minimal harus ada satu barang.');
        }
    }
</script>
@endsection
