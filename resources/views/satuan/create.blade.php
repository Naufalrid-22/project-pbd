
@extends('layouts.app')

@section('title', 'Tambah Satuan')

@section('content')

<div class="mb-8">
    <a href="{{ route('satuan.index') }}"
        class="text-sm font-medium text-blue-600 hover:text-blue-800">
        &larr; Kembali ke Data Satuan
    </a>

    <h1 class="mt-4 text-3xl font-bold text-slate-900">
        Tambah Satuan
    </h1>

    <p class="mt-2 text-sm text-slate-500">
        Masukkan informasi satuan baru.
    </p>
</div>

<div class="max-w-2xl rounded-xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">

    <form action="{{ route('satuan.store') }}" method="POST">
        @csrf

        <div class="space-y-6">

            <div>
                <label for="idsatuan" class="mb-2 block text-sm font-medium">
                    ID Satuan
                </label>

                <input type="number" id="idsatuan" name="idsatuan"
                        value="{{ old('idsatuan') }}" required
                        class="w-full rounded-lg border border-slate-300 px-4 py-3
                                outline-none focus:border-blue-500 focus:ring-2
                                focus:ring-blue-100">

                @error('idsatuan')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror

                <p class="mt-1 text-xs text-slate-500">
                    ID harus unik dan diisi secara manual.
                </p>
            </div>

            <div>
                <label for="nama_satuan" class="mb-2 block text-sm font-medium">
                    Nama Satuan
                </label>

                <input type="text" id="nama_satuan" name="nama_satuan"
                        value="{{ old('nama_satuan') }}"
                        maxlength="45" required
                        placeholder="Contoh: pcs, kg, liter"
                        class="w-full rounded-lg border border-slate-300 px-4 py-3
                                outline-none focus:border-blue-500 focus:ring-2
                                focus:ring-blue-100">

                @error('nama_satuan')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="status" class="mb-2 block text-sm font-medium">
                    Status
                </label>

                <select id="status" name="status" required
                        class="w-full rounded-lg border border-slate-300
                            bg-white px-4 py-3 outline-none
                            focus:border-blue-500 focus:ring-2
                            focus:ring-blue-100">
                    <option value="1"
                        {{ old('status', '1') == '1' ? 'selected' : '' }}>
                        Aktif
                    </option>

                    <option value="0"
                        {{ old('status') == '0' ? 'selected' : '' }}>
                        Tidak Aktif
                    </option>
                </select>

                @error('status')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

        </div>

        <div class="mt-8 flex flex-col-reverse gap-3 border-t border-slate-200 pt-6 sm:flex-row sm:justify-end">
            <a href="{{ route('satuan.index') }}"
                class="rounded-lg border border-slate-300 px-5 py-3
                        text-center text-sm font-semibold hover:bg-slate-50">
                Batal
            </a>

            <button type="submit"
                    class="rounded-lg bg-blue-600 px-5 py-3
                            text-sm font-semibold text-white hover:bg-blue-700">
                Simpan Satuan
            </button>
        </div>

    </form>

</div>

@endsection
