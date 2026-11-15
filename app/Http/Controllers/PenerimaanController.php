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
            ->leftJoin(
                'vendor as v', 'p.vendor_idvendor', '=', 'v.idvendor'
            )
            ->whereNotExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('penerimaan as pe')
                    ->whereColumn(
                        'pe.idpengadaan', 'p.idpengadaan'
                        );
            })
            ->select(
                'p.idpengadaan', 'p.timestamp', 'p.total_nilai', 'v.nama_vendor'
            )
            ->orderByDesc('p.idpengadaan')
            ->get();

        $user = DB::table('v_user')
            ->select('iduser', 'username')
            ->orderBy('username')
            ->get();

        return view(
            'penerimaan.index', compact('pengadaan', 'user')
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

        // Cek apakah pengadaan sudah pernah diterima
        $cek = DB::table('penerimaan')
            ->where('idpengadaan', $request->idpengadaan)
            ->exists();

        if ($cek) {
            return redirect()->back()
                ->with('error', 'Pengadaan sudah pernah diterima!');
        }

        // Ambil detail barang dari pengadaan
        $detail = DB::table('detail_pengadaan')
            ->where('idpengadaan', $request->idpengadaan)
            ->get();

        if ($detail->isEmpty()) {
            return redirect()->back()
                ->with('error', 'Detail pengadaan tidak ditemukan!');
        }

        DB::transaction(function () use ($request, $detail, &$idpenerimaan) {

            $idpenerimaan = DB::table('penerimaan')->max('idpenerimaan') + 1;

            if (!$idpenerimaan) {
                $idpenerimaan = 1;
            }

            // Menambahkan header penerimaan
            DB::table('penerimaan')->insert([
                'idpenerimaan' => $idpenerimaan,
                'idpengadaan' => $request->idpengadaan,
                'iduser' => $request->iduser,
                'created_at' => now(),
                'status' => '1',
            ]);

            // Mengambil ID detail terakhir
            $iddetail = DB::table('detail_penerimaan')
                ->max('iddetail_penerimaan') ?? 0;

            // Memanggil SP untuk setiap barang
            foreach ($detail as $item) {

                $iddetail++;

                DB::statement(
                    'CALL sp_tambah_detail_penerimaan(?, ?, ?, ?, ?)',
                    [
                        $iddetail,
                        $idpenerimaan,
                        $item->idbarang,
                        $item->jumlah,
                        $item->harga_satuan,
                    ]
                );
            }
        });

        return redirect()->route('penerimaan.index')
            ->with('success', 'Penerimaan barang berhasil disimpan!');
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
