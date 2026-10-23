<?php

namespace App\Http\Controllers;

use App\Models\MarginPenjualan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;

class MarginPenjualanController extends Controller
{

    public function index()
    {
        $margins = DB::table('v_margin_penjualan_list')
            ->orderBy('idmargin_penjualan')
            ->paginate(10);

        return view('margin_penjualan.index', compact('margins'));
    }

    public function create()
    {
        $users = DB::table('v_user_list')
            ->orderBy('username')
            ->get();

        return view('margin_penjualan.create', compact('users'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'idmargin_penjualan' => [
                'required', 'integer', 'unique:v_margin_penjualan,idmargin_penjualan',
            ],
            'persen' => [
                'required', 'numeric', 'min:0', 'max:100',
            ],
            'status' => [
                'required', Rule::in(['0', '1']),
            ],
            'iduser' => [
                'required', 'integer', 'exists:v_user,iduser'
            ],
        ]);

        MarginPenjualan::create($data);

        return redirect()
            ->route('margin_penjualan.index')
            ->with('success', 'Margin Penjualan berhasil ditambahkan!');
    }

    public function edit(int $id)
    {
        $margin = MarginPenjualan::findOrFail($id);
        $users = DB::table('v_user_list')
            ->orderBy('username')
            ->get();
        return view('margin_penjualan.edit', compact('margin', 'users'));
    }

    public function update(Request $request, int $id)
    {
        $margin = MarginPenjualan::findOrFail($id);

        $data = $request->validate([
            'persen' => [
                'required',
                'numeric',
                'min:0',
                'max:100',
            ],
            'status' => [
                'required',
                Rule::in(['0', '1']),
            ],
            'iduser' => [
                'required',
                'integer',
                'exists:v_user,iduser',
            ],
            'updated_at' => [
                'required',
                'date',
            ],
        ]);

        $data['updated_at'] = Carbon::parse($data['updated_at'])
            ->format('Y-m-d H:i:s');

        $margin->update($data);

        return redirect()
            ->route('margin_penjualan.index')
            ->with('success', 'Margin Penjualan berhasil diperbarui!');
    }

    public function destroy(int $id)
    {
        $margin = MarginPenjualan::findOrFail($id);
        $margin->delete();

        return redirect()
            ->route('margin_penjualan.index')
            ->with('success', 'Margin Penjualan berhasil dihapus!');
    }
}
