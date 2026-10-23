
@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-7xl px-4 py-6">
    <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">
                Data Margin Penjualan
            </h1>
            <p class="mt-1 text-sm text-slate-500">
                Kelola persentase margin dan user terkait.
            </p>
        </div>

        <a href="{{ route('margin_penjualan.create') }}"
           class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700">
            + Tambah Margin
        </a>
    </div>

    <div class="overflow-x-auto rounded-xl border border-slate-200 bg-white shadow-sm">
        <table class="w-full text-left text-sm">
            <thead class="bg-slate-100 text-slate-600">
                <tr>
                    <th class="px-4 py-3">ID Margin</th>
                    <th class="px-4 py-3">Persentase</th>
                    <th class="px-4 py-3">Username</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3">Dibuat</th>
                    <th class="px-4 py-3">Diperbarui</th>
                    <th class="px-4 py-3 text-center">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-slate-100">
                @forelse ($margins as $margin)
                    <tr class="hover:bg-slate-50">
                        <td class="px-4 py-3">
                            {{ $margin->idmargin_penjualan }}
                        </td>

                        <td class="px-4 py-3 font-medium">
                            {{ $margin->persen }}%
                        </td>

                        <td class="px-4 py-3">
                            {{ $margin->username ?? '-' }}
                        </td>

                        <td class="px-4 py-3">
                            @if ((string) $margin->status === '1')
                                <span class="rounded-full bg-green-100 px-2.5 py-1 text-xs font-medium text-green-700">
                                    Aktif
                                </span>
                            @else
                                <span class="rounded-full bg-slate-100 px-2.5 py-1 text-xs font-medium text-slate-600">
                                    Tidak Aktif
                                </span>
                            @endif
                        </td>

                        <td class="px-4 py-3">
                            {{ $margin->created_at ?? '-' }}
                        </td>

                        <td class="px-4 py-3">
                            {{ $margin->updated_at ?? '-' }}
                        </td>

                        <td class="px-4 py-3">
                            <div class="flex justify-center gap-2">
                                <a href="{{ route('margin_penjualan.edit', $margin->idmargin_penjualan) }}"
                                   class="rounded-md bg-amber-100 px-3 py-1.5 font-medium text-amber-700 hover:bg-amber-200">
                                    Edit
                                </a>

                                <form action="{{ route('margin_penjualan.destroy', $margin->idmargin_penjualan) }}"
                                      method="POST"
                                      onsubmit="return confirm('Yakin ingin menghapus margin ini?')">
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
                        <td colspan="7"
                            class="px-4 py-8 text-center text-slate-500">
                            Belum ada data margin penjualan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $margins->links() }}
    </div>
</div>
@endsection
