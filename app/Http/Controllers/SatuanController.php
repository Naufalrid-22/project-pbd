<?php

namespace App\Http\Controllers;

use App\Models\Satuan;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SatuanController extends Controller
{
    public function index()
    {
        $satuans = Satuan::orderBy('idsatuan')
            ->paginate(10);

        return view('satuan.index', compact('satuans'));
    }

    public function create()
    {
        return view('satuan.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'idsatuan' => [
                'required', 'integer', 'unique:v_satuan,idsatuan',
            ],
            'nama_satuan' => [
                'required', 'string', 'max:45',
            ],
            'status' => [
                'required', Rule::in(['0', '1']),
            ],
        ]);

        Satuan::create($data);

        return redirect()
            ->route('satuan.index')
            ->with('success', 'Satuan berhasil ditambahkan!');
    }

    public function edit(int $id)
    {
        $satuan = Satuan::findOrFail($id);
        return view('satuan.edit', compact('satuan'));
    }

    public function update(Request $request, int $id)
    {
        $satuan = Satuan::findOrFail($id);

        $data = $request->validate([
            'nama_satuan' => [
                'required', 'string', 'max:45',
            ],
            'status' => [
                'required', Rule::in(['0', '1']),
            ],
        ]);

        $satuan->update($data);

        return redirect()
            ->route('satuan.index')
            ->with('success', 'Satuan berhasil diperbarui!');
    }

    public function destroy(string $id)
    {
        $satuan = Satuan::findOrFail($id);
        $satuan->delete();

        return redirect()
            ->route('satuan.index')
            ->with('success', 'Satuan berhasil dihapus!');
    }
}
