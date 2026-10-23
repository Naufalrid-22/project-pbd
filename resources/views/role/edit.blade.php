
@extends('layouts.app')

@section('title', 'Edit Role')

@section('content')
<div class="mb-8">
    <a href="{{ route('role.index') }}"
       class="text-sm font-medium text-blue-600 hover:text-blue-800">
        &larr; Kembali ke Data Role
    </a>
    <h1 class="mt-4 text-3xl font-bold text-slate-900">Edit Role</h1>
    <p class="mt-2 text-sm text-slate-500">
        Perbarui informasi role yang dipilih.
    </p>
</div>

<div class="max-w-2xl rounded-xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
    <form action="{{ route('role.update', $role->idrole) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="space-y-6">
            <div>
                <label for="idrole" class="mb-2 block text-sm font-medium">
                    ID Role
                </label>
                <input type="number" id="idrole"
                       value="{{ $role->idrole }}" readonly
                       class="w-full rounded-lg border border-slate-200 bg-slate-100 px-4 py-3 text-slate-500">
            </div>

            <div>
                <label for="nama_role" class="mb-2 block text-sm font-medium">
                    Nama Role
                </label>
                <input type="text" id="nama_role" name="nama_role"
                       value="{{ old('nama_role', $role->nama_role) }}"
                       maxlength="45" required
                       class="w-full rounded-lg border border-slate-300 px-4 py-3 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100">
                @error('nama_role')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="mt-8 flex flex-col-reverse gap-3 border-t border-slate-200 pt-6 sm:flex-row sm:justify-end">
            <a href="{{ route('role.index') }}"
               class="rounded-lg border border-slate-300 px-5 py-3 text-center text-sm font-semibold hover:bg-slate-50">
                Batal
            </a>
            <button type="submit"
                    class="rounded-lg bg-blue-600 px-5 py-3 text-sm font-semibold text-white hover:bg-blue-700">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection
