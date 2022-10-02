<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $fillable = [
        'nick',
        'email',
        'password',
        'status',
        'attemps',
        'web',
        'code_security'
    ];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    public function setCodeSecurityAttribute($value)
    {
        $this->attributes['code_security'] = bcrypt($value);
    }

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function player()
    {
        return $this->hasOne(Player::class, 'user_id', 'id');
    }

    public function admin()
    {
        return $this->hasOne(Admin::class, 'user_id', 'id');
    }

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
