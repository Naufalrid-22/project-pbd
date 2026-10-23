
@extends('layouts.app')

@section('content')
{{-- <div class="mx-auto max-w-7xl px-4 py-6"> --}}
        <div class="page-heading">
        <div>
            <p class="page-eyebrow">Manajemen Inventori</p>
            <h1 class="page-title">Data Margin Penjualan</h1>
            <p class="page-description">
                Kelola data margin penjualan inventori supermarket.
            </p>
        </div>

        <a href="{{ route('margin_penjualan.create') }}" class="btn btn-primary">
            + Tambah Margin
        </a>
    </div>

    <div class="data-card">
    <div class="overflow-x-auto">
        <table>
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
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('margin_penjualan.edit', $margin->idmargin_penjualan) }}"
                                class="btn btn-edit">
                                    Edit
                                </a>

                                <form action="{{ route('margin_penjualan.destroy', $margin->idmargin_penjualan) }}"
                                    method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus margin ini?')">
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
