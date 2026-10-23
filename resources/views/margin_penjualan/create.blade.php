
@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-2xl px-4 py-6">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-slate-800">
            Tambah Margin Penjualan
        </h1>
        <p class="mt-1 text-sm text-slate-500">
            Masukkan persentase margin dan user terkait.
        </p>
    </div>

    @if ($errors->any())
        <div class="mb-4 rounded-lg bg-red-100 px-4 py-3 text-red-700">
            <ul class="list-inside list-disc">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('margin_penjualan.store') }}"
          method="POST"
          class="space-y-5 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
        @csrf

        <div>
            <label for="idmargin_penjualan"
                   class="mb-1 block text-sm font-medium text-slate-700">
                ID Margin Penjualan
            </label>
            <input type="number" id="idmargin_penjualan"
                   name="idmargin_penjualan"
                   value="{{ old('idmargin_penjualan') }}" required
                   class="w-full rounded-lg border border-slate-300 px-3 py-2">
        </div>

        <div>
            <label for="persen"
                   class="mb-1 block text-sm font-medium text-slate-700">
                Persentase Margin (%)
            </label>
            <input type="number" id="persen" name="persen"
                   value="{{ old('persen') }}"
                   min="0" max="100" step="0.01" required
                   class="w-full rounded-lg border border-slate-300 px-3 py-2">
        </div>

        <div>
            <label for="iduser"
                   class="mb-1 block text-sm font-medium text-slate-700">
                User
            </label>
            <select id="iduser" name="iduser" required
                    class="w-full rounded-lg border border-slate-300 px-3 py-2">
                <option value="">-- Pilih User --</option>
                @foreach ($users as $user)
                    <option value="{{ $user->iduser }}"
                        {{ old('iduser') == $user->iduser ? 'selected' : '' }}>
                        {{ $user->username }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="status"
                   class="mb-1 block text-sm font-medium text-slate-700">
                Status
            </label>
            <select id="status" name="status" required
                    class="w-full rounded-lg border border-slate-300 px-3 py-2">
                <option value="">-- Pilih Status --</option>
                <option value="1" {{ old('status') === '1' ? 'selected' : '' }}>
                    Aktif
                </option>
                <option value="0" {{ old('status') === '0' ? 'selected' : '' }}>
                    Tidak Aktif
                </option>
            </select>
        </div>

        <p class="text-xs text-slate-500">
            Tanggal dibuat mengikuti pengaturan otomatis database.
        </p>

        <div class="flex justify-end gap-3 pt-2">
            <a href="{{ route('margin_penjualan.index') }}"
               class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">
                Batal
            </a>

            <button type="submit"
                    class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700">
                Simpan Margin
            </button>
        </div>
    </form>
</div>
@endsection
