
@extends('layouts.app')

@section('title', 'Edit Vendor')

@section('content')

<div class="mb-8">
    <a href="{{ route('vendor.index') }}"
       class="text-sm font-medium text-blue-600 hover:text-blue-800">
        &larr; Kembali ke Data Vendor
    </a>

    <h1 class="mt-4 text-3xl font-bold text-slate-900">
        Edit Vendor
    </h1>

    <p class="mt-2 text-sm text-slate-500">
        Perbarui informasi vendor yang sudah tersimpan.
    </p>
</div>

<div class="max-w-2xl rounded-xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">

    <form action="{{ route('vendor.update', $vendor->idvendor) }}"
          method="POST">
        @csrf
        @method('PUT')

        <div class="space-y-6">

            <div>
                <label for="idvendor" class="mb-2 block text-sm font-medium">
                    ID Vendor
                </label>

                <input type="number" id="idvendor"
                       value="{{ $vendor->idvendor }}" readonly
                       class="w-full rounded-lg border border-slate-200
                              bg-slate-100 px-4 py-3 text-slate-500">
            </div>

            <div>
                <label for="nama_vendor" class="mb-2 block text-sm font-medium">
                    Nama Vendor
                </label>

                <input type="text" id="nama_vendor" name="nama_vendor"
                       value="{{ old('nama_vendor', $vendor->nama_vendor) }}"
                       maxlength="100" required
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
                       value="{{ old('badan_hukum', $vendor->badan_hukum) }}"
                       maxlength="45" required
                       class="w-full rounded-lg border border-slate-300 px-4 py-3
                              outline-none focus:border-blue-500 focus:ring-2
                              focus:ring-blue-100">

                @error('badan_hukum')
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
                               focus:border-blue-500 focus:ring-2 focus:ring-blue-100">

                    <option value="1"
                        {{ old('status', (string) $vendor->status) === '1' ? 'selected' : '' }}>
                        Aktif
                    </option>

                    <option value="0"
                        {{ old('status', (string) $vendor->status) === '0' ? 'selected' : '' }}>
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
                Simpan Perubahan
            </button>
        </div>

    </form>

</div>

@endsection
