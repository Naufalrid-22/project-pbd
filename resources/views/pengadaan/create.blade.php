
@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-6 py-8">

    <div class="mb-6">
        <a href="{{ route('pengadaan.index') }}"
            class="text-blue-600 hover:underline">
            &larr; Kembali ke Pengadaan
        </a>

        <h1 class="text-2xl font-bold text-gray-800 mt-3">
            Tambah Pengadaan Barang
        </h1>
        <p class="text-gray-500 mt-1">
            Masukkan informasi pengadaan dan daftar barang.
        </p>
    </div>

    @if ($errors->any())
        <div class="bg-red-50 text-red-700 p-4 rounded-xl mb-5">
            <p class="font-semibold mb-2">
                Periksa kembali data yang dimasukkan:
            </p>
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('pengadaan.store') }}"
            method="POST"
            class="space-y-6">
        @csrf

        <div class="bg-white p-6 rounded-2xl shadow-sm
                    border border-gray-100">

            <h2 class="font-semibold text-lg mb-5">
                Informasi Pengadaan
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                <div>
                    <label class="block text-sm font-medium mb-2">
                        User
                    </label>
                    <select name="user_iduser" required
                            class="w-full border border-gray-300 rounded-xl p-3">
                        <option value="">Pilih user</option>
                        @foreach ($user as $u)
                            <option value="{{ $u->iduser }}"
                                @selected(old('user_iduser') == $u->iduser)>
                                {{ $u->username }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">
                        Vendor
                    </label>
                    <select name="vendor_idvendor" required
                            class="w-full border border-gray-300 rounded-xl p-3">
                        <option value="">Pilih vendor</option>
                        @foreach ($vendor as $v)
                            <option value="{{ $v->idvendor }}"
                                @selected(old('vendor_idvendor') == $v->idvendor)>
                                {{ $v->nama_vendor }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">
                        PPN (%)
                    </label>
                    <input type="number" name="ppn_persen"
                            min="0" max="100" step="0.01"
                            value="{{ old('ppn_persen', 0) }}"
                            required
                            class="w-full border border-gray-300 rounded-xl p-3">
                    <p class="text-xs text-gray-500 mt-1">
                        Masukkan persentase PPN yang berlaku untuk transaksi.
                    </p>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm
                    border border-gray-100">

            <div class="flex justify-between items-center mb-5">
                <h2 class="font-semibold text-lg">Daftar Barang</h2>

                <button type="button" id="tambahBarang"
                        class="bg-blue-50 text-blue-700
                                px-4 py-2 rounded-lg">
                    + Tambah Baris
                </button>
            </div>

            <div id="daftarBarang" class="space-y-4">
                <div class="baris-barang grid grid-cols-1
                            md:grid-cols-4 gap-4 items-end">

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium mb-2">
                            Barang
                        </label>
                        <select name="idbarang[]" required
                                class="w-full border border-gray-300
                                        rounded-xl p-3">
                            <option value="">Pilih barang</option>
                            @foreach ($barang as $b)
                                <option value="{{ $b->idbarang }}">
                                    {{ $b->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2">
                            Jumlah
                        </label>
                        <input type="number" name="jumlah[]"
                                min="1" required
                                placeholder="Jumlah"
                                class="w-full border border-gray-300
                                        rounded-xl p-3">
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2">
                            Harga Satuan
                        </label>
                        <input type="number" name="harga_satuan[]"
                                min="0" required
                                placeholder="Harga beli"
                                class="w-full border border-gray-300
                                        rounded-xl p-3">
                    </div>
                </div>
            </div>

            <p class="text-sm text-gray-500 mt-4">
                Harga satuan yang dimasukkan adalah harga beli dari vendor.
            </p>
        </div>

        <div class="flex justify-end gap-3">
            <a href="{{ route('pengadaan.index') }}"
                class="px-5 py-3 rounded-xl border border-gray-300">
                Batal
            </a>

            <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700
                            text-white px-6 py-3 rounded-xl">
                Simpan Pengadaan
            </button>
        </div>
    </form>
</div>


<script>
    const daftarBarang = document.getElementById('daftarBarang');
    const tombolTambah = document.getElementById('tambahBarang');

    // Simpan satu baris kosong sebagai template
    const templateBarang = daftarBarang
        .querySelector('.baris-barang')
        .cloneNode(true);

    templateBarang.querySelectorAll('input').forEach(input => {
        input.value = '';
    });

    templateBarang.querySelectorAll('select').forEach(select => {
        select.selectedIndex = 0;
    });

    // Tambahkan satu baris setiap tombol diklik
    tombolTambah.addEventListener('click', function () {
        const baris = templateBarang.cloneNode(true);

        const tombolHapus = document.createElement('button');
        tombolHapus.type = 'button';
        tombolHapus.textContent = 'Hapus Baris';
        tombolHapus.className =
            'md:col-span-4 text-red-600 text-sm text-left';

        tombolHapus.addEventListener('click', function () {
            baris.remove();
        });

        baris.appendChild(tombolHapus);
        daftarBarang.appendChild(baris);
    });
</script>
@endsection
