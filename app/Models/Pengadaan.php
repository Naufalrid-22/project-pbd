<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengadaan extends Model
{
    protected $table = 'pengadaan';
    protected $primaryKey = 'idpengadaan';
    public $incrementing = false;
    public $timestamps = false;
    protected $fillable = [
        'idpengadaan', 'user_iduser', 'vendor_idvendor', 'timestamp', 'status', 'sub_total', 'ppn', 'total_nilai',
    ];
}
