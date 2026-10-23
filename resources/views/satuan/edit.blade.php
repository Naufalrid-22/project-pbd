
@extends('layouts.app')

@section('title', 'Edit Satuan')

@section('content')

<div class="mb-8">
    <a href="{{ route('satuan.index') }}"
        class="text-sm font-medium text-blue-600 hover:text-blue-800">
        &larr; Kembali ke Data Satuan
    </a>

    <h1 class="mt-4 text-3xl font-bold text-slate-900">
        Edit Satuan
    </h1>

    <p class="mt-2 text-sm text-slate-500">
        Perbarui nama atau status satuan.
    </p>
</div>

<div class="max-w-2xl rounded-xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">

    <form action="{{ route('satuan.update', $satuan->idsatuan) }}"
            method="POST">
        @csrf
        @method('PUT')

        <div class="space-y-6">

            <div>
                <label for="idsatuan" class="mb-2 block text-sm font-medium">
                    ID Satuan
                </label>

                <input type="number" id="idsatuan"
                        value="{{ $satuan->idsatuan }}" readonly
                        class="w-full rounded-lg border border-slate-200
                                bg-slate-100 px-4 py-3 text-slate-500">
            </div>

            <div>
                <label for="nama_satuan" class="mb-2 block text-sm font-medium">
                    Nama Satuan
                </label>

                <input type="text" id="nama_satuan" name="nama_satuan"
                        value="{{ old('nama_satuan', $satuan->nama_satuan) }}"
                        maxlength="45" required
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
                        {{ old('status', (string) $satuan->status) === '1' ? 'selected' : '' }}>
                        Aktif
                    </option>

                    <option value="0"
                        {{ old('status', (string) $satuan->status) === '0' ? 'selected' : '' }}>
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
                Simpan Perubahan
            </button>
        </div>

    </form>

</div>

@endsection
