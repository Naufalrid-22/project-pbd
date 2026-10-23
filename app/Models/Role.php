<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    protected $table = 'v_role';
    protected $primaryKey = 'idrole';
    public $incrementing = false;
    protected $keyType = 'int';
    public $timestamps = false;
    protected $fillable = ['idrole', 'nama_role',];

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'idrole', 'idrole');
    }
}
