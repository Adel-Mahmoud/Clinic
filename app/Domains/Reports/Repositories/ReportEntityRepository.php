<?php

namespace App\Domains\Reports\Repositories;

use App\Domains\Services\Models\ServiceEntity;


class ReportEntityRepository
{
    public function all()
    {
        return [];
    }

    public function getAllServices()
    {
        return ServiceEntity::select('id', 'name')->orderBy('name')->get();
    }
}
