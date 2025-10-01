<?php

namespace App\Domains\Users\Models;

use Illuminate\Database\Eloquent\Model;

class UserEntity extends Model
{
    protected $table = 'users';
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
    ];
}