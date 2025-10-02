<?php

namespace App\Domains\Users\Repositories;

use App\Domains\Users\Models\UserEntity;

class UserEntityRepository
{
    public function all()
    {
        return UserEntity::latest()->get();
    }

    public function find($id)
    {
        return UserEntity::findOrFail($id);
    }

    public function create(array $data)
    {
        $data['password'] = bcrypt($data['password']);
        $user = UserEntity::create($data);

        if (isset($data['roles'])) {
            $user->syncRoles($data['roles']);
        }

        return $user;
    }

    public function update($id, array $data)
    {
        $user = $this->find($id);

        if (isset($data['password']) && !empty($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        } else {
            unset($data['password']);
        }

        $user->update($data);

        if (isset($data['roles'])) {
            $user->syncRoles($data['roles']);
        }

        return $user;
    }

    public function delete($id)
    {
        return UserEntity::destroy($id);
    }
}
