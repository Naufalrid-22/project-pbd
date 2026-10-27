<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Pengadaan;
use App\Models\DetailPengadaan;

class PengadaanController extends Controller
{
    public function index()
    {
        $pengadaan = DB::table('pengadaan as p')
            ->leftJoin(
                'vendor as v', 'p.vendor_idvendor', '=', 'v.idvendor'
            )
            ->leftJoin(
                'user as u', 'p.user_iduser', '=', 'u.iduser'
            )
            ->select(
                'p.*', 'v.nama_vendor', 'u.username'
            )
            ->orderByDesc('p.idpengadaan')
            ->get();

        return view('pengadaan.index', compact('pengadaan'));
    }

    public function create()
    {
        $vendor = DB::table('v_vendor')
            ->where('status', 1)
            ->orderBy('nama_vendor')
            ->get();

        $user = DB::table('v_user')
            ->select('iduser', 'username')
            ->orderBy('username')
            ->get();

        $barang = DB::table('v_barang_list')
            ->where('status', 1)
            ->orderBy('nama')
            ->get();

        return view('pengadaan.create', compact('vendor', 'user', 'barang'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_iduser' => 'required|integer|exists:user,iduser',
            'vendor_idvendor' => 'required|integer|exists:vendor,idvendor',
            'ppn_persen' => 'required|numeric|min:0|max:100',
            'idbarang' => 'required|array|min:1',
            'idbarang.*' => 'required|integer|distinct|exists:barang,idbarang',
            'jumlah' => 'required|array',
            'jumlah.*' => 'required|integer|min:1',
            'harga_satuan' => 'required|array',
            'harga_satuan.*' => 'required|integer|min:0',
        ]);

        if (count($request->idbarang) !== count($request->jumlah) || count($request->idbarang) !== count($request->harga_satuan)) {
            return back()
            ->withInput()
            ->withErrors(['idbarang' => 'Data detail barang tidak lengkap.']);
        }

        DB::transaction(function () use ($request) {
            $idPengadaan = (Pengadaan::max('idpengadaan') ?? 0) + 1;

            $subTotal = 0;

            foreach ($request->idbarang as $i => $idBarang) {
                $subTotal += (int) $request->jumlah[$i] * (int) $request->harga_satuan[$i];
            }

            $ppn = (int) round($subTotal * (float) $request->ppn_persen / 100);

            Pengadaan::create([
                'idpengadaan' => $idPengadaan,
                'user_iduser' => $request->user_iduser,
                'vendor_idvendor' => $request->vendor_idvendor,
                'timestamp' => now(),
                'status' => '1',
                'sub_total' => $subTotal,
                'ppn' => $ppn,
                'total_nilai' => $subTotal + $ppn,
            ]);

            foreach ($request->idbarang as $i => $idBarang) {
                $jumlah = (int) $request->jumlah[$i];
                $harga = (int) $request->harga_satuan[$i];

                $idDetail = (DetailPengadaan::max('iddetail_pengadaan') ?? 0) + 1;

                DetailPengadaan::create([
                    'iddetail_pengadaan' => $idDetail,
                    'idpengadaan' => $idPengadaan,
                    'idbarang' => $idBarang,
                    'harga_satuan' => $harga,
                    'jumlah' => $jumlah,
                    'sub_total' => $jumlah * $harga,
                ]);
            }
        });

        return redirect()
            ->route('pengadaan.index')
            ->with('success', 'Pengadaan barang berhasil disimpan.');
    }

    public function show(int $id)
    {
        $item = DB::table('pengadaan as p')
            ->leftJoin('vendor as v', 'p.vendor_idvendor', '=', 'v.idvendor')
            ->leftJoin('user as u', 'p.user_iduser', '=', 'u.iduser')
            ->select('p.*', 'v.nama_vendor', 'u.username')
            ->where('p.idpengadaan', $id)
            ->first();

        abort_if(!$item, 404, 'Data pengadaan tidak ditemukan!');


    $detail = DB::table('detail_pengadaan as dp')
        ->leftJoin(
            'barang as b',
            'dp.idbarang',
            '=',
            'b.idbarang'
        )
        ->leftJoin(
            'satuan as s',
            'b.idsatuan',
            '=',
            's.idsatuan'
        )
        ->select(
            'dp.*',
            'b.nama as nama_barang',
            's.nama_satuan'
        )
        ->where('dp.idpengadaan', $id)
        ->orderBy('dp.iddetail_pengadaan')
        ->get();

        return view('pengadaan.show', compact('item', 'detail'));
    }
}
