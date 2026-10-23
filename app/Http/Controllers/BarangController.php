<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Satuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class BarangController extends Controller
{
    public function index()
    {
        $barangs = DB::table('v_barang_list')
            ->orderBy('idbarang')
            ->paginate(10);

        return view('barang.index', compact('barangs'));
    }

    public function create()
    {
        $satuans = Satuan::orderBy('idsatuan')->get();
        return view('barang.create', compact('satuans'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'idbarang' => [
                'required', 'integer', 'unique:v_barang,idbarang',
            ],
            'jenis' => [
                'required', 'string', 'size:1',
            ],
            'nama' => [
                'required', 'string', 'max:45',
            ],
            'idsatuan' => [
                'required', Rule::in(['0', '1']),
            ],
            'status' => [
                'required', Rule::in(['0', '1'])
            ],
            'harga' => [
                'required', 'numeric', 'min:0',
            ],
        ]);

        Barang::create($data);

        return redirect()
            ->route('barang.index')
            ->with('success', 'Barang berhasil ditambahkan!');
    }

    public function edit(int $id)
    {
        $barang = Barang::findOrFail($id);
        $satuans = Satuan::orderBy('idsatuan')->get();
        return view('barang.edit', compact('barang', 'satuans'));
    }

    public function update(Request $request, int $id)
    {
        $barang = Barang::findOrFail($id);

        $data = $request->validate([
            'jenis' => [
                'required',
                'string',
                'size:1',
            ],
            'nama' => [
                'required',
                'string',
                'max:45',
            ],
            'idsatuan' => [
                'required',
                'exists:v_satuan,idsatuan',
            ],
            'status' => [
                'required',
                Rule::in(['0', '1']),
            ],
            'harga' => [
                'required',
                'numeric',
                'min:0',
            ],
        ]);

        $barang->update($data);

        return redirect()
            ->route('barang.index')
            ->with('success', 'Barang berhasil diperbarui!');
    }

    public function destroy(int $id)
    {
        $barang = Barang::findOrFail($id);
        $barang->delete();

        return redirect()
            ->route('barang.index')
            ->with('success', 'Barang berhasil dihapus!');
    }
}
