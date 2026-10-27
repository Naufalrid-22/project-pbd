<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPengadaan extends Model
{
    protected $table = 'detail_pengadaan';
    protected $primaryKey = 'iddetail_pengadaan';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'iddetail_pengadaan', 'idpengadaan', 'idbarang', 'harga_satuan', 'jumlah', 'sub_total',
    ];
}
