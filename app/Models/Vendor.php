<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    protected $table = 'v_vendor';
    protected $primaryKey = 'idvendor';
    public $incrementing = false;
    protected $keyType = 'int';
    public $timestamps = false;
    protected $fillable = ['idvendor', 'nama_vendor', 'badan_hukum', 'status',];
}
