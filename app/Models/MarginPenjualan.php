<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MarginPenjualan extends Model
{
    protected $table = 'v_margin_penjualan';
    protected $primaryKey = 'idmargin_penjualan';
    public $incrementing = false;
    protected $keyType = 'int';
    public $timestamps = false;
    protected $fillable = ['idmargin_penjualan', 'persen', 'status', 'status', 'iduser', 'updated_at',];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'iduser', 'iduser');
    }
}
