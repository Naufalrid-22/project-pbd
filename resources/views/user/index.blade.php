@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-7xl px-4 py-6">
    <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Data User</h1>
            <p class="mt-1 text-sm text-slate-500">
                Kelola akun pengguna dan role.
            </p>
        </div>

        <a href="{{ route('user.create') }}"
           class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700">
            + Tambah User
        </a>
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

    <div class="overflow-x-auto rounded-xl border border-slate-200 bg-white shadow-sm">
        <table class="w-full text-left text-sm">
            <thead class="bg-slate-100 text-slate-600">
                <tr>
                    <th class="px-5 py-3">ID User</th>
                    <th class="px-5 py-3">Username</th>
                    <th class="px-5 py-3">Role</th>
                    <th class="px-5 py-3 text-center">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-slate-100">
                @forelse ($users as $user)
                    <tr class="hover:bg-slate-50">
                        <td class="px-5 py-3">{{ $user->iduser }}</td>
                        <td class="px-5 py-3 font-medium text-slate-800">
                            {{ $user->username }}
                        </td>
                        <td class="px-5 py-3">
                            {{ $user->nama_role ?? 'Role tidak ditemukan' }}
                        </td>
                        <td class="px-5 py-3">
                            <div class="flex justify-center gap-2">
                                <a href="{{ route('user.edit', $user->iduser) }}"
                                   class="rounded-md bg-amber-100 px-3 py-1.5 font-medium text-amber-700 hover:bg-amber-200">
                                    Edit
                                </a>

                                <form action="{{ route('user.destroy', $user->iduser) }}"
                                      method="POST"
                                      onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="rounded-md bg-red-100 px-3 py-1.5 font-medium text-red-700 hover:bg-red-200">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-5 py-8 text-center text-slate-500">
                            Belum ada data user.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $users->links() }}
    </div>
</div>
@endsection
