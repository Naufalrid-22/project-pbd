<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'v_user';
    protected $primaryKey = 'iduser';
    public $incrementing = false;
    public $timestamps = false;
    protected $fillable = ['iduser', 'username', 'password', 'idrole',];
    protected $hidden = ['password'];
}
