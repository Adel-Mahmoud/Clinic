<?php

namespace App\Domains\Doctors\Repositories;

use App\Domains\Doctors\Models\DoctorEntity;

class DoctorEntityRepository
{
    public function all()
    {
        return DoctorEntity::all();
    }

    public function find($id)
    {
        return DoctorEntity::find($id);
    }

    public function create(array $data)
    {
        return DoctorEntity::create($data);
    }

    public function update($id, array $data)
    {
        $model = DoctorEntity::findOrFail($id);
        $model->update($data);
        return $model;
    }

    public function delete($id)
    {
        return DoctorEntity::destroy($id);
    }
}