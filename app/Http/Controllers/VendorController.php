<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class VendorController extends Controller
{
    public function index()
    {
        $vendors = Vendor::orderBy('idvendor')
            ->paginate(10);

        return view('vendor.index', compact('vendors'));
    }

    public function create()
    {
        return view('vendor.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'idvendor' => [
                'required', 'integer', 'unique:v_vendor,idvendor',
            ],
            'nama_vendor' => [
                'required', 'string', 'max:100',
            ],
            'badan_hukum' => [
                'required', Rule::in(['P', 'V']),
            ],
            'status' => [
                'required', Rule::in(['0', '1']),
            ],
        ]);

        Vendor::create($data);

        return redirect()
            ->route('vendor.index')
            ->with('success', 'Vendor berhasil ditambahkan!');
    }

    public function edit(int $id)
    {
        $vendor = Vendor::findOrFail($id);
        return view('vendor.edit', compact('vendor'));
    }

    public function update(Request $request, int $id)
    {
        $vendor = Vendor::findOrFail($id);

        $data = $request->validate([
            'nama_vendor' => [
                'required', 'string', 'max:100',
            ],
            'badan_hukum' => [
                'required', Rule::in(['P', 'V']),
            ],
            'status' => [
                'required', Rule::in(['0', '1']),
            ],
        ]);

        $vendor->update($data);

        return redirect()
            ->route('vendor.index')
            ->with('success', 'Vendor berhasil diperbarui!');
    }

    public function destroy(string $id)
    {
        $vendor = Vendor::findOrFail($id);
        $vendor->delete();

        return redirect()
            ->route('vendor.index')
            ->with('success', 'Vendor berhasil dihapus!');
    }
}
