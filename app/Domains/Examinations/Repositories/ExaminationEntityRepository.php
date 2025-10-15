<?php

namespace App\Domains\Examinations\Repositories;

use App\Domains\Examinations\Models\ExaminationEntity;

class ExaminationEntityRepository
{
    public function all()
    {
        return ExaminationEntity::all();
    }

    public function find($id)
    {
        return ExaminationEntity::find($id);
    }

    public function create(array $data)
    {
        return ExaminationEntity::create($data);
    }

    public function update($id, array $data)
    {
        $model = ExaminationEntity::findOrFail($id);
        $model->update($data);
        return $model;
    }

    public function delete($id)
    {
        return ExaminationEntity::destroy($id);
    }
}