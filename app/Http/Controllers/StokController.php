<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StokController extends Controller
{
    public function index()
    {
        // Ringkasan stok setiap barang
        $barang = DB::table('v_barang_list as b')
            ->leftJoinSub(
                DB::table('kartu_stok')
                    ->select(
                        'idbarang',
                        DB::raw('SUM(masuk - keluar) as stok')
                    )
                    ->groupBy('idbarang'),
                's',
                'b.idbarang',
                '=',
                's.idbarang'
            )
            ->select(
                'b.idbarang',
                'b.nama',
                'b.harga',
                DB::raw('COALESCE(s.stok, 0) as stok')
            )
            ->orderBy('b.nama')
            ->get();

        // Seluruh data kartu stok
        $kartuStok = DB::table('kartu_stok as k')
            ->leftJoin('v_barang_list as b', 'k.idbarang', '=', 'b.idbarang')
            ->select(
                'k.idkartu_stok',
                'k.idbarang',
                'b.nama',
                'k.jenis_transaksi',
                'k.masuk',
                'k.keluar',
                'k.stock',
                'k.created_at',
                'k.idtransaksi'
            )
            ->orderByDesc('k.idkartu_stok')
            ->get();

        return view('stok.index', compact('barang', 'kartuStok'));
    }
}
