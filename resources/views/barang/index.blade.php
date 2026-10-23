
@extends('layouts.app')

@section('title', 'Data Barang')

@section('content')

<div class="mb-8 flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
    <div>
        <p class="mb-2 text-sm font-semibold uppercase tracking-wider text-blue-600">
            Master Data
        </p>

        <h1 class="text-3xl font-bold text-slate-900">
            Data Barang
        </h1>

        <p class="mt-2 text-sm text-slate-500">
            Kelola data barang yang tersedia dalam inventori.
        </p>
    </div>

    <a href="{{ route('barang.create') }}"
        class="inline-flex items-center justify-center rounded-lg
                bg-blue-600 px-5 py-3 text-sm font-semibold text-white
                shadow-sm transition hover:bg-blue-700">
        + Tambah Barang
    </a>
</div>

<div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">

    <div class="border-b border-slate-200 px-6 py-4">
        <h2 class="font-semibold text-slate-800">
            Daftar Barang
        </h2>
        <p class="mt-1 text-sm text-slate-500">
            Berikut data barang yang tersimpan.
        </p>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm">
            <thead class="bg-slate-50 text-xs uppercase text-slate-500">
                <tr>
                    <th class="px-6 py-4">ID</th>
                    <th class="px-6 py-4">Nama Barang</th>
                    <th class="px-6 py-4">Jenis</th>
                    <th class="px-6 py-4">Satuan</th>
                    <th class="px-6 py-4">Harga</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4 text-center">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-slate-100">
                @forelse ($barangs as $barang)
                    <tr class="transition hover:bg-slate-50">
                        <td class="whitespace-nowrap px-6 py-4 font-medium">
                            {{ $barang->idbarang }}
                        </td>

                        <td class="whitespace-nowrap px-6 py-4 font-semibold text-slate-800">
                            {{ $barang->nama }}
                        </td>

                        <td class="px-6 py-4">
                            {{ $barang->jenis }}
                        </td>

                        <td class="px-6 py-4">
                            {{ $barang->nama_satuan ?? '-' }}
                        </td>

                        <td class="whitespace-nowrap px-6 py-4">
                            Rp{{ number_format((float) $barang->harga, 0, ',', '.') }}
                        </td>

                        <td class="px-6 py-4">
                            @if ((string) $barang->status === '1')
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

                        <td class="whitespace-nowrap px-6 py-4">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('barang.edit', $barang->idbarang) }}"
                                    class="rounded-md bg-amber-100 px-3 py-2
                                            text-xs font-semibold text-amber-700
                                            hover:bg-amber-200">
                                    Edit
                                </a>

                                <form action="{{ route('barang.destroy', $barang->idbarang) }}"
                                        method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus barang ini?')">
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
                        <td colspan="7" class="px-6 py-12 text-center">
                            <p class="font-semibold text-slate-700">
                                Belum ada data barang
                            </p>
                            <p class="mt-1 text-sm text-slate-500">
                                Klik tombol Tambah Barang untuk memasukkan data.
                            </p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="border-t border-slate-200 px-6 py-4">
        {{ $barangs->links() }}
    </div>

</div>

@endsection
