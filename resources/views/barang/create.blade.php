
@extends('layouts.app')

@section('title', 'Tambah Barang')

@section('content')

<div class="mb-8">
    <a href="{{ route('barang.index') }}"
        class="text-sm font-medium text-blue-600 hover:text-blue-800">
        &larr; Kembali ke Data Barang
    </a>

    <h1 class="mt-4 text-3xl font-bold text-slate-900">
        Tambah Barang
    </h1>

    <p class="mt-2 text-sm text-slate-500">
        Masukkan informasi barang yang akan disimpan.
    </p>
</div>

<div class="max-w-3xl rounded-xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">

    <form action="{{ route('barang.store') }}" method="POST">
        @csrf

        <div class="grid gap-6 sm:grid-cols-2">

            <div>
                <label for="idbarang" class="mb-2 block text-sm font-medium">
                    ID Barang
                </label>

                <input type="number" id="idbarang" name="idbarang"
                        value="{{ old('idbarang') }}" required
                        class="w-full rounded-lg border border-slate-300 px-4 py-3
                                outline-none focus:border-blue-500 focus:ring-2
                                focus:ring-blue-100">

                @error('idbarang')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror

                <p class="mt-1 text-xs text-slate-500">
                    ID diisi secara manual.
                </p>
            </div>

            <div>
                <label for="jenis" class="mb-2 block text-sm font-medium">
                    Jenis Barang
                </label>

                <input type="text" id="jenis" name="jenis"
                        value="{{ old('jenis') }}" maxlength="1" required
                        class="w-full rounded-lg border border-slate-300 px-4 py-3
                                outline-none focus:border-blue-500 focus:ring-2
                                focus:ring-blue-100">

                @error('jenis')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="sm:col-span-2">
                <label for="nama" class="mb-2 block text-sm font-medium">
                    Nama Barang
                </label>

                <input type="text" id="nama" name="nama"
                        value="{{ old('nama') }}" maxlength="45" required
                        class="w-full rounded-lg border border-slate-300 px-4 py-3
                                outline-none focus:border-blue-500 focus:ring-2
                                focus:ring-blue-100">

                @error('nama')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="idsatuan" class="mb-2 block text-sm font-medium">
                    Satuan
                </label>

                <select id="idsatuan" name="idsatuan" required
                        class="w-full rounded-lg border border-slate-300 bg-white
                                px-4 py-3 outline-none focus:border-blue-500
                                focus:ring-2 focus:ring-blue-100">

                    <option value="">Pilih satuan</option>

                    @foreach ($satuans as $satuan)
                        <option value="{{ $satuan->idsatuan }}"
                            {{ old('idsatuan') == $satuan->idsatuan ? 'selected' : '' }}>
                            {{ $satuan->nama_satuan }}
                        </option>
                    @endforeach
                </select>

                @error('idsatuan')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="harga" class="mb-2 block text-sm font-medium">
                    Harga
                </label>

                <input type="number" id="harga" name="harga"
                        value="{{ old('harga') }}" min="0" step="0.01" required
                        class="w-full rounded-lg border border-slate-300 px-4 py-3
                                outline-none focus:border-blue-500 focus:ring-2
                                focus:ring-blue-100">

                @error('harga')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="sm:col-span-2">
                <label for="status" class="mb-2 block text-sm font-medium">
                    Status
                </label>

                <select id="status" name="status" required
                        class="w-full rounded-lg border border-slate-300 bg-white
                                px-4 py-3 outline-none focus:border-blue-500
                                focus:ring-2 focus:ring-blue-100">

                    <option value="1" {{ old('status', '1') == '1' ? 'selected' : '' }}>
                        Aktif
                    </option>

                    <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>
                        Tidak Aktif
                    </option>
                </select>

                @error('status')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

        </div>

        <div class="mt-8 flex flex-col-reverse gap-3 border-t border-slate-200 pt-6 sm:flex-row sm:justify-end">

            <a href="{{ route('barang.index') }}"
                class="rounded-lg border border-slate-300 px-5 py-3 text-center
                        text-sm font-semibold hover:bg-slate-50">
                Batal
            </a>

            <button type="submit"
                    class="rounded-lg bg-blue-600 px-5 py-3 text-sm
                            font-semibold text-white hover:bg-blue-700">
                Simpan Barang
            </button>

        </div>
    </form>

</div>

@endsection
