<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Barang extends Model
{
    protected $table = 'v_barang';
    protected $primaryKey = 'idbarang';
    public $incrementing = false;
    protected $keyType = 'int';
    public $timestamps = false;
    protected $fillable = ['idbarang', 'jenis', 'nama', 'idsatuan', 'status', 'harga',];

    public function satuan(): BelongsTo
    {
        return $this->belongsTo(Satuan::class, 'idsatuan', 'idsatuan');
    }
}
