<?php

namespace App\Domains\Users\Policies;

use App\Models\User as AuthUser;
use App\Domains\Auth\Models\Admin;

class UserEntityPolicy
{
    public function view(AuthUser $user, Admin $model): bool
    {
        return true; // ممكن تربطه بصلاحيات فيما بعد
    }

    public function create(AuthUser $user): bool
    {
        return true;
    }

    public function update(AuthUser $user, Admin $model): bool
    {
        return true;
    }

    public function delete(AuthUser $user, Admin $model): bool
    {
        return true;
    }
}
