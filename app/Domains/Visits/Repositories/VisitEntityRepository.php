<?php

namespace App\Domains\Visits\Repositories;

use App\Domains\Visits\Models\VisitEntity;
use Illuminate\Support\Facades\DB;

class VisitEntityRepository
{
    public function all()
    {
        return VisitEntity::with(['patient.user', 'service'])->get();
    }

    public function find($id)
    {
        return VisitEntity::find($id);
    }

    public function findOrFailWithRelations($id)
    {
        return VisitEntity::with(['patient.user', 'service'])->findOrFail($id);
    }

    public function create(array $data)
    {
        return VisitEntity::create($data);
    }

    public function update($id, array $data)
    {
        $model = VisitEntity::findOrFail($id);
        $model->update($data);
        return $model;
    }

    public function delete($id)
    {
        $model = VisitEntity::findOrFail($id);
        return $model->delete();
    }

    public function getByPatient($patientId)
    {
        return VisitEntity::with(['patient.user', 'service'])
            ->where('patient_id', $patientId)
            ->get();
    }

    public function getByService($serviceId)
    {
        return VisitEntity::with(['patient.user', 'service'])
            ->where('service_id', $serviceId)
            ->get();
    }

    public function getByStatus($status)
    {
        return VisitEntity::with(['patient.user', 'service'])
            ->where('status', $status)
            ->get();
    }

    public function getByDateRange($startDate, $endDate)
    {
        return VisitEntity::with(['patient.user', 'service'])
            ->whereBetween('visit_date', [$startDate, $endDate])
            ->get();
    }

    public function getUpcomingVisits()
    {
        return VisitEntity::with(['patient.user', 'service'])
            ->where('visit_date', '>=', now()->toDateString())
            ->where('status', 'pending')
            ->orderBy('visit_date')
            ->orderBy('visit_time')
            ->get();
    }

    public function getTodayVisits()
    {
        return VisitEntity::with(['patient.user', 'service'])
            ->where('visit_date', now()->toDateString())
            ->orderBy('visit_time')
            ->get();
    }
}
