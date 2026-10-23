<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'barang' => DB::table('v_barang')->count(),
            'satuan' => DB::table('v_satuan')->count(),
            'vendor' => DB::table('v_vendor')->count(),
            'user' => DB::table('v_user')->count(),
            'role' => DB::table('v_role')->count(),
            'margin' => DB::table('v_margin_penjualan')->count(),
        ];

        return view('dashboard.index', compact('stats'));
    }
}
