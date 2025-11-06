<?php

namespace App\Domains\Reports\Repositories;

use App\Domains\Services\Models\ServiceEntity;
use App\Domains\Visits\Models\VisitEntity;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

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

    public function getReport(?int $serviceId, string $period, ?string $startDate, ?string $endDate)
    {
        $query = VisitEntity::with(['patient.user', 'service']);

        if ($serviceId) {
            $query->where('service_id', $serviceId);
        }

        [$from, $to] = $this->resolveDateRange($period, $startDate, $endDate);

        if ($from && $to) {
            $query->whereBetween('visit_date', [$from->toDateString(), $to->toDateString()]);
        }

        return $query->orderBy('visit_date', 'desc');
    }

    protected function resolveDateRange(string $period, ?string $startDate, ?string $endDate): array
    {
        $now = Carbon::now();

        return match ($period) {
            'daily' => [Carbon::parse($startDate ?? $now->toDateString()), Carbon::parse($startDate ?? $now->toDateString())],
            'weekly' => [$now->copy()->startOfWeek(), $now->copy()->endOfWeek()],
            'monthly' => [$now->copy()->startOfMonth(), $now->copy()->endOfMonth()],
            'quarterly' => [$now->copy()->firstOfQuarter(), $now->copy()->lastOfQuarter()],
            'yearly' => [$now->copy()->startOfYear(), $now->copy()->endOfYear()],
            'custom' => [
                $startDate ? Carbon::parse($startDate) : null,
                $endDate ? Carbon::parse($endDate) : null,
            ],
            default => [$now->copy()->startOfMonth(), $now->copy()->endOfMonth()],
        };
    }
}
