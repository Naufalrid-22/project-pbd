<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Penerimaan;
use Illuminate\Validation\ValidationException;

class PenerimaanController extends Controller
{
    public function index()
    {
        $pengadaan = DB::table('pengadaan as p')
            ->leftJoin('vendor as v', 'p.vendor_idvendor', '=', 'v.idvendor')
            ->where('p.status', 'P')
            ->select('p.idpengadaan', 'p.timestamp', 'p.total_nilai', 'v.nama_vendor')
            ->orderByDesc('p.idpengadaan')
            ->get();

        $riwayat = DB::table('penerimaan as pe')
            ->join('pengadaan as p', 'pe.idpengadaan', '=', 'p.idpengadaan')
            ->leftJoin('vendor as v', 'p.vendor_idvendor', '=', 'v.idvendor')
            ->leftJoin('v_user as u', 'pe.iduser', '=', 'u.iduser')
            ->select('pe.idpenerimaan', 'pe.idpengadaan', 'pe.created_at', 'pe.status', 'v.nama_vendor','u.username')
            ->orderByDesc('pe.idpenerimaan')
            ->get();

        $user = DB::table('v_user')
            ->select('iduser', 'username')
            ->orderBy('username')
            ->get();

        return view(
            'penerimaan.index', compact('pengadaan', 'riwayat', 'user')
        );
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $request->validate([
            'idpengadaan' => 'required|exists:pengadaan,idpengadaan',
            'iduser' => 'required|exists:user,iduser',
        ]);

        $pengadaan = DB::table('pengadaan')
            ->where('idpengadaan', $request->idpengadaan)
            ->first();

        if (!$pengadaan || $pengadaan->status != 'P') {
            return redirect()->back()
                ->with('error', 'Pengadaan belum siap diterima atau sudah selesai!');
        }

        // Cegah membuat penerimaan baru jika masih ada draft
        $draft = DB::table('penerimaan')
            ->where('idpengadaan', $request->idpengadaan)
            ->where('status', '0')
            ->exists();

        if ($draft) {
            return redirect()->back()
                ->with('error', 'Masih ada penerimaan yang belum dikonfirmasi!');
        }

        try {
            $idpenerimaan = DB::transaction(function () use ($request) {

                $idpenerimaan = (DB::table('penerimaan')
                    ->lockForUpdate()
                    ->max('idpenerimaan') ?? 0) + 1;

                // Membuat header penerimaan
                DB::statement(
                    'CALL sp_tambah_penerimaan(?, ?, ?)',
                    [
                        $idpenerimaan,
                        $request->idpengadaan,
                        $request->iduser,
                    ]
                );

                // Mengambil detail barang dari pengadaan
                $detail = DB::table('detail_pengadaan')
                    ->where('idpengadaan', $request->idpengadaan)
                    ->get();

                if ($detail->isEmpty()) {
                    throw new \Exception('Detail pengadaan tidak ditemukan!');
                }

                $iddetail = (DB::table('detail_penerimaan')
                    ->lockForUpdate()
                    ->max('iddetail_penerimaan') ?? 0);

                foreach ($detail as $item) {

                    // Menghitung jumlah yang sudah diterima dan dikonfirmasi
                    $sudahDiterima = DB::table('detail_penerimaan as dp')
                        ->join('penerimaan as pe', 'dp.idpenerimaan', '=', 'pe.idpenerimaan')
                        ->where('pe.idpengadaan', $request->idpengadaan)
                        ->where('pe.status', 'S')
                        ->where('dp.barang_idbarang', $item->idbarang)
                        ->sum('dp.jumlah_terima');

                    $sisa = $item->jumlah - $sudahDiterima;

                    if ($sisa > 0) {
                        $iddetail++;

                        DB::statement(
                            'CALL sp_tambah_detail_penerimaan(?, ?, ?, ?, ?)',
                            [
                                $iddetail,
                                $idpenerimaan,
                                $item->idbarang,
                                $sisa,
                                $item->harga_satuan,
                            ]
                        );
                    }
                }

                return $idpenerimaan;
            });

            return redirect()->route('penerimaan.show', $idpenerimaan)
                ->with('success', 'Penerimaan berhasil dibuat!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', $e->getMessage());
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $penerimaan = DB::table('penerimaan as pe')
            ->join('pengadaan as p', 'pe.idpengadaan', '=', 'p.idpengadaan')
            ->leftJoin('vendor as v', 'p.vendor_idvendor', '=', 'v.idvendor')
            ->where('pe.idpenerimaan', $id)
            ->select(
                'pe.idpenerimaan',
                'pe.idpengadaan',
                'pe.status',
                'pe.created_at',
                'p.total_nilai',
                'v.nama_vendor'
            )
            ->first();

        if (!$penerimaan) {
            abort(404);
        }

        $detail = DB::table('detail_penerimaan as dp')
            ->join('barang as b', 'dp.barang_idbarang', '=', 'b.idbarang')
            ->where('dp.idpenerimaan', $id)
            ->select(
                'dp.iddetail_penerimaan',
                'dp.barang_idbarang',
                'b.nama',
                'dp.jumlah_terima',
                'dp.harga_satuan_terima',
                'dp.sub_total_terima'
            )
            ->get();

        return view('penerimaan.show', compact('penerimaan', 'detail'));
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
        $request->validate([
            'jumlah_terima' => 'required|integer|min:1',
            'harga_satuan_terima' => 'required|integer|min:0',
        ]);

        $detail = DB::table('detail_penerimaan as dp')
            ->join('penerimaan as pe', 'dp.idpenerimaan', '=', 'pe.idpenerimaan')
            ->where('dp.iddetail_penerimaan', $id)
            ->select(
                'dp.*',
                'pe.idpengadaan',
                'pe.status as status_penerimaan'
            )
            ->first();

        if (!$detail || $detail->status_penerimaan != '0') {
            return back()->with('error', 'Detail tidak ditemukan atau sudah dikonfirmasi!');
        }

        // Mengambil jumlah pesanan barang
        $pesanan = DB::table('detail_pengadaan')
            ->where('idpengadaan', $detail->idpengadaan)
            ->where('idbarang', $detail->barang_idbarang)
            ->sum('jumlah');

        // Menghitung jumlah yang sudah dikonfirmasi pada penerimaan sebelumnya
        $sudahDiterima = DB::table('detail_penerimaan as dp')
            ->join('penerimaan as pe', 'dp.idpenerimaan', '=', 'pe.idpenerimaan')
            ->where('pe.idpengadaan', $detail->idpengadaan)
            ->where('pe.status', 'S')
            ->where('dp.barang_idbarang', $detail->barang_idbarang)
            ->sum('dp.jumlah_terima');

        $sisa = $pesanan - $sudahDiterima;

        if ($request->jumlah_terima > $sisa) {
            return back()->with(
                'error',
                'Jumlah diterima melebihi sisa pesanan. Sisa barang: ' . $sisa
            );
        }

        DB::statement(
            'CALL sp_edit_detail_penerimaan(?, ?, ?)',
            [
                $id,
                $request->jumlah_terima,
                $request->harga_satuan_terima,
            ]
        );

        return back()->with('success', 'Detail penerimaan berhasil diperbarui!');
    }

    public function konfirmasi(string $id)
    {
        $penerimaan = DB::table('penerimaan')
            ->where('idpenerimaan', $id)
            ->first();

        if (!$penerimaan || $penerimaan->status != '0') {
            return back()->with('error', 'Penerimaan tidak ditemukan atau sudah dikonfirmasi!');
        }

        $adaDetail = DB::table('detail_penerimaan')
            ->where('idpenerimaan', $id)
            ->exists();

        if (!$adaDetail) {
            return back()->with('error', 'Detail penerimaan masih kosong!');
        }

        try {
            DB::transaction(function () use ($id) {
                DB::statement(
                    'CALL sp_konfirmasi_penerimaan(?)',
                    [$id]
                );
            });

            return redirect()->route('penerimaan.index')
                ->with('success', 'Penerimaan berhasil dikonfirmasi!');

        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
