<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    protected $table = 'penjualan';
    protected $primaryKey = 'idpenjualan';
    public $incrementing = false;
    public $timestamps = false;
    protected $fillable = [
        'idpenjualan',
        'created_at',
        'subtotal_nilai',
        'ppn',
        'total_nilai',
        'iduser',
        'idmargin_penjualan'
    ];
}
