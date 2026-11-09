<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class PenjualanController extends Controller
{
    public function index()
    {
        $penjualan = DB::table('penjualan as p')
            ->leftJoin('v_user_list as u', 'u.iduser', '=', 'p.iduser')
            ->leftJoin('v_margin_penjualan_list as m', 'm.idmargin_penjualan', '=', 'p.idmargin_penjualan')
            ->select('p.*', 'u.username', 'm.persen')
            ->orderBy('p.created_at')
            ->get();

        return view('penjualan.index', compact('penjualan'));
    }

    public function create()
    {
        $barang = DB::table('v_barang_list')
            ->where('status', 1)
            ->orderBy('nama')
            ->get();

        $margin = DB::table('v_margin_penjualan_list')
            ->where('status', 1)
            ->orderBy('persen')
            ->get();

        return view('penjualan.create', compact('barang', 'margin'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'idmargin_penjualan' => 'required|integer',
            'ppn_persen' => 'required|numeric|min:0|max:100',

            'idbarang' => 'required|array|min:1',
            'idbarang.*' => 'required|integer|distinct|exists:v_barang_list,idbarang',

            'jumlah' => 'required|array|min:1',
            'jumlah.*' => 'required|integer|min:1',
        ]);

        if (count($validated['idbarang']) !== count($validated['jumlah'])) {
            throw ValidationException::withMessages(['idbarang' => 'Data barang dan jumlah tidak sesuai!']);
        }

        DB::transaction(function () use ($request) {
            $idPenjualan = DB::table('penjualan')->max('idpenjualan') + 1;

            DB::statement('CALL sp_tambah_penjualan(?, ?, ?)',
            [
                $idPenjualan,
                $request->user()->iduser,
                $request->idmargin_penjualan,
            ]);

            $idDetail = DB::table('detail_penjualan')->max('iddetail_penjualan') + 1;

            foreach ($request->idbarang as $i => $idbarang) {
                $stok = DB::table('kartu_stok')
                    ->where('idbarang', $idbarang)
                    ->sum(DB::raw('COALESCE(masuk, 0) - COALESCE(keluar, 0)'));

                if ($request->jumlah[$i] > $stok) {
                    throw new \Exception('Stok barang tidak mencukupi.');
                }

                DB::statement('CALL sp_tambah_detail_penjualan(?, ?, ?, ?)',
                [
                    $idDetail,
                    $idPenjualan,
                    $idbarang,
                    $request->jumlah[$i],
                ]
                );

                $idDetail++;
            }

            $subtotal = DB::table('detail_penjualan')
                ->where('penjualan_idpenjualan', $idPenjualan)
                ->sum('subtotal');

            $ppn = round($subtotal * $request->ppn_persen / 100);
            $total = $subtotal + $ppn;


            DB::table('penjualan')
                ->where('idpenjualan', $idPenjualan)
                ->update([
                    'subtotal_nilai' => $subtotal,
                    'ppn' => $ppn,
                    'total_nilai' => $total,
                ]);
        
        });

        return redirect()->route('penjualan.index')
            ->with('success', 'Penjualan berhasil disimpan.');
    }

    public function detail($id)
    {
        $penjualan = DB::table('penjualan as p')
            ->leftJoin('v_user as u', 'p.iduser', '=', 'u.iduser')
            ->select('p.*', 'u.username')
            ->where('p.idpenjualan', $id)
            ->first();

        if (!$penjualan) {
            abort(404);
        }

        $detail = DB::table('detail_penjualan as d')
            ->join('v_barang_list as b', 'd.idbarang', '=', 'b.idbarang')
            ->select('d.*', 'b.nama')
            ->where('d.penjualan_idpenjualan', $id)
            ->get();

        return view('penjualan.detail', compact('penjualan', 'detail'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
