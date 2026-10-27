
@extends('layouts.app')

@section('title', 'Data Satuan')

@section('content')

<div class="mb-8 flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
    <div>
        <p class="mb-2 text-sm font-semibold uppercase tracking-wider text-blue-600">
            Master Data
        </p>

        <h1 class="text-3xl font-bold text-slate-900">
            Data Satuan
        </h1>

        <p class="mt-2 text-sm text-slate-500">
            Kelola satuan yang digunakan dalam inventori.
        </p>
    </div>

    <a href="{{ route('satuan.create') }}" class="btn btn-primary">
            + Tambah Satuan
    </a>
</div>

<div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">

    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm">
            <thead class="bg-slate-50 text-xs uppercase text-slate-500">
                <tr>
                    <th class="px-6 py-4">ID Satuan</th>
                    <th class="px-6 py-4">Nama Satuan</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4 text-center">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-slate-100">
                @forelse ($satuans as $satuan)
                    <tr class="hover:bg-slate-50">
                        <td class="px-6 py-4 font-medium">
                            {{ $satuan->idsatuan }}
                        </td>

                        <td class="px-6 py-4 font-semibold text-slate-800">
                            {{ $satuan->nama_satuan }}
                        </td>

                        <td class="px-6 py-4">
                            @if ((string) $satuan->status === '1')
                                <span class="rounded-full bg-green-100 px-3 py-1
                                                text-xs font-medium text-green-700">
                                    Aktif
                                </span>
                            @else
                                <span class="rounded-full bg-slate-100 px-3 py-1
                                                text-xs font-medium text-slate-600">
                                    Tidak Aktif
                                </span>
                            @endif
                        </td>

                        <td class="px-6 py-4">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('satuan.edit', $satuan->idsatuan) }}"
                                    class="rounded-md bg-amber-100 px-3 py-2
                                            text-xs font-semibold text-amber-700
                                            hover:bg-amber-200">
                                    Edit
                                </a>

                                <form action="{{ route('satuan.destroy', $satuan->idsatuan) }}"
                                        method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus satuan ini?')">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="rounded-md bg-red-100 px-3 py-2
                                                    text-xs font-semibold text-red-700
                                                    hover:bg-red-200">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center">
                            <p class="font-semibold text-slate-700">
                                Belum ada data satuan
                            </p>

                            <p class="mt-1 text-sm text-slate-500">
                                Tambahkan satuan melalui tombol di atas.
                            </p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="border-t border-slate-200 px-6 py-4">
        {{ $satuans->links() }}
    </div>

</div>

@endsection
