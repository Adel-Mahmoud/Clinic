<?php

namespace App\Domains\Examinations\Repositories;

use App\Domains\Visits\Models\VisitEntity;

class ExaminationEntityRepository
{
    public function getNextVisitInQueue()
    {
        return VisitEntity::where('status', 'pending')
            ->with('patient')
            ->orderBy('visit_date', 'asc')
            ->orderBy('visit_time', 'asc')
            ->orderBy('id', 'asc')
            ->first();
    }
}
