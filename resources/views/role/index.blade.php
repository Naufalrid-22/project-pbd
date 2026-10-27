
@extends('layouts.app')

@section('title', 'Data Role')

@section('content')
<div class="mb-8 flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
    <div>
        <p class="text-sm font-semibold uppercase tracking-wider text-blue-600">
            Master Data
        </p>
        <h1 class="mt-2 text-3xl font-bold text-slate-900">
            Data Role
        </h1>
        <p class="mt-2 text-sm text-slate-500">
            Kelola jenis hak akses pengguna aplikasi.
        </p>
    </div>

    <a href="{{ route('role.create') }}"
       class="btn btn-primary">
        + Tambah Role
    </a>
</div>

<div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm">
            <thead class="bg-slate-50 text-xs uppercase text-slate-500">
                <tr>
                    <th class="px-6 py-4">ID Role</th>
                    <th class="px-6 py-4">Nama Role</th>
                    <th class="px-6 py-4 text-center">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-slate-100">
                @forelse ($roles as $role)
                    <tr class="hover:bg-slate-50">
                        <td class="px-6 py-4">{{ $role->idrole }}</td>
                        <td class="px-6 py-4 font-semibold text-slate-800">
                            {{ $role->nama_role }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex justify-center gap-2">
                                <a href="{{ route('role.edit', $role->idrole) }}"
                                   class="rounded-md bg-amber-100 px-3 py-2 text-xs font-semibold text-amber-700 hover:bg-amber-200">
                                    Edit
                                </a>

                                <form action="{{ route('role.destroy', $role->idrole) }}"
                                      method="POST"
                                      onsubmit="return confirm('Yakin ingin menghapus role ini?')">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="rounded-md bg-red-100 px-3 py-2 text-xs font-semibold text-red-700 hover:bg-red-200">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="px-6 py-12 text-center text-slate-500">
                            Belum ada data role.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="border-t border-slate-200 px-6 py-4">
        {{ $roles->links() }}
    </div>
</div>
@endsection
