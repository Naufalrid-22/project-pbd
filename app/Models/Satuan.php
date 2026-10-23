<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Satuan extends Model
{
    protected $table = 'v_satuan';
    protected $primaryKey = 'idsatuan';
    public $incrementing = false;
    protected $keyType = 'int';
    public $timestamps = false;
    protected $fillable = ['idsatuan', 'nama_satuan', 'status',];

    public function barang(): HasMany
    {
        return $this->hasMany(Barang::class, 'idsatuan', 'idsatuan');
    }
}
