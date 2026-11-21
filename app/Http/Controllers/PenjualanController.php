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
            ->orderBy('p.created_at',)
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
            'idmargin_penjualan' => 'required|integer|exists:v_margin_penjualan_list,idmargin_penjualan',
            'ppn_persen' => 'required|numeric|min:0|max:100',

            'idbarang' => 'required|array|min:1',
            'idbarang.*' => 'required|integer|distinct|exists:v_barang_list,idbarang',

            'jumlah' => 'required|array|min:1',
            'jumlah.*' => 'required|integer|min:1',
        ]);

        if (count($validated['idbarang']) !== count($validated['jumlah'])) {
            throw ValidationException::withMessages([
                'idbarang' => 'Data barang dan jumlah tidak sesuai!'
            ]);
        }

        try {
            DB::transaction(function () use ($request) {

                // Membuat ID penjualan
                $idPenjualan = (DB::table('penjualan')
                    ->lockForUpdate()
                    ->max('idpenjualan') ?? 0) + 1;

                // Memanggil SP tambah penjualan
                DB::statement('CALL sp_tambah_penjualan(?, ?, ?)', [
                    $idPenjualan,
                    $request->user()->iduser,
                    $request->idmargin_penjualan,
                ]);

                // Membuat ID detail
                $idDetail = (DB::table('detail_penjualan')
                    ->lockForUpdate()
                    ->max('iddetail_penjualan') ?? 0) + 1;

                foreach ($request->idbarang as $i => $idbarang) {

                    // Menghitung stok tersedia
                    $stok = DB::table('kartu_stok')
                        ->where('idbarang', $idbarang)
                        ->sum(DB::raw('COALESCE(masuk, 0) - COALESCE(keluar, 0)'));

                    // Memeriksa stok
                    if ($request->jumlah[$i] > $stok) {
                        throw new \Exception(
                            'Stok barang ' . $idbarang . ' tidak mencukupi. Stok tersedia: ' . $stok
                        );
                    }

                    // Memasukkan detail penjualan
                    DB::statement('CALL sp_tambah_detail_penjualan(?, ?, ?, ?)', [
                        $idDetail,
                        $idPenjualan,
                        $idbarang,
                        $request->jumlah[$i],
                    ]);

                    $idDetail++;
                }

                // Menghitung subtotal, PPN, dan total
                DB::statement('CALL sp_hitung_penjualan(?, ?)', [
                    $idPenjualan,
                    $request->ppn_persen
                ]);
            });

            return redirect()->route('penjualan.index')
                ->with('success', 'Penjualan berhasil disimpan.');

        } catch (\Exception $e) {

            return redirect()->back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
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
