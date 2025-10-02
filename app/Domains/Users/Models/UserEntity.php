<?php

namespace App\Domains\Users\Models;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Foundation\Auth\User as Authenticatable;

class UserEntity extends Authenticatable
{
    use HasRoles;
    protected $table = 'admins';
    protected string $guard_name = 'web';
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
    ];
}