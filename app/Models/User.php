<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
// use Laravel\Sanctum\HasApiTokens; // اگر API Token می‌خوای، اضافه کن

class User extends Authenticatable
{
    use Notifiable; // , HasApiTokens

    protected $fillable = [
        'name',
        'email',
        'password',
        'role'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
}
