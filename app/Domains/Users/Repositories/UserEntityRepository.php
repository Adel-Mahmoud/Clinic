<?php

namespace App\Domains\Users\Repositories;

use App\Domains\Users\Models\UserEntity;

class UserEntityRepository
{
    public function all()
    {
        return UserEntity::all();
    }

    public function find($id)
    {
        return UserEntity::find($id);
    }

    public function create(array $data)
    {
        return UserEntity::create($data);
    }

    public function update($id, array $data)
    {
        $model = UserEntity::findOrFail($id);
        $model->update($data);
        return $model;
    }

    public function delete($id)
    {
        return UserEntity::destroy($id);
    }
}