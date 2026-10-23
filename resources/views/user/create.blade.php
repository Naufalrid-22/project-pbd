@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-2xl px-4 py-6">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-slate-800">Tambah User</h1>
        <p class="mt-1 text-sm text-slate-500">Masukkan informasi akun pengguna.</p>
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

    <form action="{{ route('user.store') }}" method="POST"
          class="space-y-5 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
        @csrf

        <div>
            <label for="iduser" class="mb-1 block text-sm font-medium text-slate-700">
                ID User
            </label>
            <input type="number" id="iduser" name="iduser"
                   value="{{ old('iduser') }}" required
                   class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-blue-500 focus:outline-none">
        </div>

        <div>
            <label for="username" class="mb-1 block text-sm font-medium text-slate-700">
                Username
            </label>
            <input type="text" id="username" name="username"
                   value="{{ old('username') }}" maxlength="50" required
                   class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-blue-500 focus:outline-none">
        </div>

        <div>
            <label for="password" class="mb-1 block text-sm font-medium text-slate-700">
                Password
            </label>
            <input type="password" id="password" name="password"
                   minlength="8" required autocomplete="new-password"
                   class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-blue-500 focus:outline-none">
            <p class="mt-1 text-xs text-slate-500">Minimal 8 karakter.</p>
        </div>

        <div>
            <label for="idrole" class="mb-1 block text-sm font-medium text-slate-700">
                Role
            </label>
            <select id="idrole" name="idrole" required
                    class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-blue-500 focus:outline-none">
                <option value="">-- Pilih Role --</option>
                @foreach ($roles as $role)
                    <option value="{{ $role->idrole }}"
                        {{ old('idrole') == $role->idrole ? 'selected' : '' }}>
                        {{ $role->nama_role }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="flex justify-end gap-3 pt-2">
            <a href="{{ route('user.index') }}"
               class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">
                Batal
            </a>
            <button type="submit"
                    class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700">
                Simpan User
            </button>
        </div>
    </form>
</div>
@endsection
