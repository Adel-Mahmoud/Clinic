<?php

namespace App\Domains\Services\Repositories;

use App\Domains\Services\Models\ServiceEntity;

class ServiceEntityRepository
{
    public function all()
    {
        return ServiceEntity::with('creator')->latest()->get();
    }

    public function find($id)
    {
        return ServiceEntity::with('creator')->findOrFail($id);
    }

    public function create(array $data)
    {
        $data['created_by'] = auth('admin')->check() ? auth('admin')->id() : null;
        return ServiceEntity::create($data);
    }

    public function update($id, array $data)
    {
        $service = $this->find($id);
        $service->update($data);
        return $service;
    }

    public function delete($id)
    {
        return ServiceEntity::destroy($id);
    }
}
