<?php

namespace App\Domains\Users\Policies;

use App\Models\User as AuthUser;
use App\Domains\Users\Models\UserEntity;

class UserEntityPolicy
{
    public function view(AuthUser $user, UserEntity $model): bool
    {
        return true;
    }

    public function create(AuthUser $user): bool
    {
        return true;
    }

    public function update(AuthUser $user, UserEntity $model): bool
    {
        return true;
    }

    public function delete(AuthUser $user, UserEntity $model): bool
    {
        return true;
    }
}