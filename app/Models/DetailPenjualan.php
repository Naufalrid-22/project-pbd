<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPenjualan extends Model
{
    protected $table = 'detail_penjualan';
    protected $primaryKey = 'iddetail_penjualan';
    public $incrementing = false;
    public $fillable = [
        'iddetail_penjualan',
        'harga_satuan',
        'jumlah',
        'subtotal',
        'penjualan_idpenjualan',
        'idbarang'
    ];
}
