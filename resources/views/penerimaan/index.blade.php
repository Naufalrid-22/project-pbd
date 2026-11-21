
@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-8">

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">
            Penerimaan Barang
        </h1>
        <p class="text-gray-500 mt-1">
            Proses penerimaan barang dari pengadaan yang belum diterima.
        </p>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border
                border-gray-100 overflow-x-auto">

        <table class="w-full text-sm text-left">
            <thead class="bg-gray-50 text-gray-600">
                <tr>
                    <th class="px-5 py-4">ID Pengadaan</th>
                    <th class="px-5 py-4">Tanggal</th>
                    <th class="px-5 py-4">Vendor</th>
                    <th class="px-5 py-4">Total</th>
                    <th class="px-5 py-4">User Penerima</th>
                    <th class="px-5 py-4">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-100">
                @forelse ($pengadaan as $p)
                    <tr class="hover:bg-gray-50">
                        <td class="px-5 py-4">
                            {{ $p->idpengadaan }}
                        </td>

                        <td class="px-5 py-4">
                            {{ $p->timestamp ?? '-' }}
                        </td>

                        <td class="px-5 py-4">
                            {{ $p->nama_vendor ?? '-' }}
                        </td>

                        <td class="px-5 py-4">
                            Rp {{ number_format($p->total_nilai ?? 0, 0, ',', '.') }}
                        </td>

                        <td class="px-5 py-4">
                            <form action="{{ route('penerimaan.store') }}"
                                method="POST"
                                id="form-penerimaan-{{ $p->idpengadaan }}">
                                @csrf

                                <input type="hidden"
                                    name="idpengadaan"
                                    value="{{ $p->idpengadaan }}">

                                <select name="iduser" required
                                        class="w-full border border-gray-300 rounded-lg p-2">
                                    <option value="">Pilih user</option>

                                    @foreach ($user as $u)
                                        <option value="{{ $u->iduser }}">
                                            {{ $u->username }}
                                        </option>
                                    @endforeach
                                </select>
                            </form>
                        </td>

                        <td class="px-5 py-4">
                            <button type="submit"
                                    form="form-penerimaan-{{ $p->idpengadaan }}"
                                    onclick="return confirm('Buat transaksi penerimaan barang?')"
                                    class="bg-blue-600 hover:bg-blue-700
                                        text-white px-4 py-2 rounded-lg">
                                Buat Penerimaan
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6"
                            class="px-5 py-10 text-center text-gray-500">
                            Tidak ada pengadaan yang menunggu penerimaan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- RIWAYAT PENERIMAAN --}}
    <div class="mt-10 mb-6">
        <h2 class="text-xl font-bold text-gray-800">
            Riwayat Penerimaan
        </h2>
        <p class="text-gray-500 mt-1">
            Daftar seluruh transaksi penerimaan barang.
        </p>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-x-auto">

        <table class="w-full text-sm text-left">
            <thead class="bg-gray-50 text-gray-600">
                <tr>
                    <th class="px-5 py-4">ID Penerimaan</th>
                    <th class="px-5 py-4">ID Pengadaan</th>
                    <th class="px-5 py-4">Tanggal</th>
                    <th class="px-5 py-4">Vendor</th>
                    <th class="px-5 py-4">User Penerima</th>
                    <th class="px-5 py-4">Status</th>
                    <th class="px-5 py-4">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-100">
                @forelse ($riwayat as $r)
                    <tr class="hover:bg-gray-50">

                        <td class="px-5 py-4">
                            {{ $r->idpenerimaan }}
                        </td>

                        <td class="px-5 py-4">
                            {{ $r->idpengadaan }}
                        </td>

                        <td class="px-5 py-4">
                            {{ $r->created_at }}
                        </td>

                        <td class="px-5 py-4">
                            {{ $r->nama_vendor ?? '-' }}
                        </td>

                        <td class="px-5 py-4">
                            {{ $r->username ?? '-' }}
                        </td>

                        <td class="px-5 py-4">
                            @if ($r->status == '0')
                                <span class="bg-yellow-50 text-yellow-700 px-3 py-2 rounded-lg">
                                    Draft
                                </span>
                            @elseif ($r->status == 'S')
                                <span class="bg-green-50 text-green-700 px-3 py-2 rounded-lg">
                                    Diterima
                                </span>
                            @else
                                <span class="bg-gray-100 text-gray-700 px-3 py-2 rounded-lg">
                                    {{ $r->status }}
                                </span>
                            @endif
                        </td>

                        <td class="px-5 py-4">
                            <a href="{{ route('penerimaan.show', $r->idpenerimaan) }}"
                            class="bg-blue-50 text-blue-700 hover:bg-blue-100 px-4 py-2 rounded-lg font-medium">
                                Detail
                            </a>
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-5 py-10 text-center text-gray-500">
                            Belum ada riwayat penerimaan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

    </div>

</div>
@endsection
