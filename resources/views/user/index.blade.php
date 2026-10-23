@extends('layouts.app')

@section('content')
{{-- <div class="mx-auto max-w-7xl px-4 py-6"> --}}
        <div class="page-heading">
        <div>
            <p class="page-eyebrow">Manajemen Inventori</p>
            <h1 class="page-title">Data User</h1>
            <p class="page-description">
                Kelola data pengguna inventori supermarket.
            </p>
        </div>

        <a href="{{ route('user.create') }}" class="btn btn-primary">
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

    <div class="data-card">
    <div class="overflow-x-auto">
        <table>
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
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('user.edit', $user->iduser) }}"
                                class="btn btn-edit">
                                    Edit
                                </a>

                                <form action="{{ route('user.destroy', $user->iduser) }}"
                                    method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn btn-delete">
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
