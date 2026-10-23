
@extends('layouts.app')

@section('title', 'Tambah Vendor')

@section('content')

<div class="mb-8">
    <a href="{{ route('vendor.index') }}"
       class="text-sm font-medium text-blue-600 hover:text-blue-800">
        &larr; Kembali ke Data Vendor
    </a>

    <h1 class="mt-4 text-3xl font-bold text-slate-900">
        Tambah Vendor
    </h1>

    <p class="mt-2 text-sm text-slate-500">
        Masukkan informasi vendor baru.
    </p>
</div>

<div class="max-w-2xl rounded-xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">

    <form action="{{ route('vendor.store') }}" method="POST">
        @csrf

        <div class="space-y-6">

            <div>
                <label for="idvendor" class="mb-2 block text-sm font-medium">
                    ID Vendor
                </label>

                <input type="number" id="idvendor" name="idvendor"
                       value="{{ old('idvendor') }}" required
                       class="w-full rounded-lg border border-slate-300 px-4 py-3
                              outline-none focus:border-blue-500 focus:ring-2
                              focus:ring-blue-100">

                @error('idvendor')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror

                <p class="mt-1 text-xs text-slate-500">
                    ID vendor diisi secara manual dan harus unik.
                </p>
            </div>

            <div>
                <label for="nama_vendor" class="mb-2 block text-sm font-medium">
                    Nama Vendor
                </label>

                <input type="text" id="nama_vendor" name="nama_vendor"
                       value="{{ old('nama_vendor') }}" maxlength="100" required
                       placeholder="Masukkan nama vendor"
                       class="w-full rounded-lg border border-slate-300 px-4 py-3
                              outline-none focus:border-blue-500 focus:ring-2
                              focus:ring-blue-100">

                @error('nama_vendor')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="badan_hukum" class="mb-2 block text-sm font-medium">
                    Badan Hukum
                </label>

                <input type="text" id="badan_hukum" name="badan_hukum"
                       value="{{ old('badan_hukum') }}" maxlength="45" required
                       placeholder="Contoh: PT atau CV"
                       class="w-full rounded-lg border border-slate-300 px-4 py-3
                              outline-none focus:border-blue-500 focus:ring-2
                              focus:ring-blue-100">

                @error('badan_hukum')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror

                <p class="mt-1 text-xs text-slate-500">
                    Isi sesuai nilai yang diizinkan kolom badan_hukum di database.
                </p>
            </div>

            <div>
                <label for="status" class="mb-2 block text-sm font-medium">
                    Status
                </label>

                <select id="status" name="status" required
                        class="w-full rounded-lg border border-slate-300
                               bg-white px-4 py-3 outline-none
                               focus:border-blue-500 focus:ring-2 focus:ring-blue-100">

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
            <a href="{{ route('vendor.index') }}"
               class="rounded-lg border border-slate-300 px-5 py-3
                      text-center text-sm font-semibold hover:bg-slate-50">
                Batal
            </a>

            <button type="submit"
                    class="rounded-lg bg-blue-600 px-5 py-3
                           text-sm font-semibold text-white hover:bg-blue-700">
                Simpan Vendor
            </button>
        </div>

    </form>

</div>

@endsection
