<?php

namespace App\Domains\Dashboards\Repositories;

use Carbon\Carbon;
use App\Domains\Patients\Models\PatientEntity;
use App\Domains\Visits\Models\VisitEntity;
use Illuminate\Support\Facades\DB;

class DashboardEntityRepository
{
    public function getDashboardStats(): array
    {
        $today = Carbon::today();
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();

        $newPatientsCount = PatientEntity::whereDate('created_at', $today)->count();

        $confirmedReservationsCount = VisitEntity::where('status', 'completed')
            ->whereDate('created_at', $today)
            ->count();

        $pendingReservationsCount = VisitEntity::where('status', 'pending')
            ->whereDate('created_at', $today)
            ->count();

        $todayRevenue = VisitEntity::where('status', 'completed')
            ->whereDate('created_at', $today)
            ->sum('price') ?? 0;

        $weeklyStats = VisitEntity::whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->where('status', 'completed')
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(price) as total_revenue'),
                DB::raw('COUNT(*) as total_visits')
            )
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        return [
            'new_patients_today'     => $newPatientsCount,
            'confirmed_reservations' => $confirmedReservationsCount,
            'pending_reservations'   => $pendingReservationsCount,
            'today_revenue'          => $todayRevenue,
            'weekly_stats'           => $weeklyStats,
        ];
    }

    public function getSalesAndVisitsChartData(int $days = 7)
    {
        $startDate = Carbon::now()->subDays($days - 1)->startOfDay();

        $data = VisitEntity::where('status', 'completed')
            ->where('created_at', '>=', $startDate)
            ->selectRaw('DATE(created_at) as date, SUM(price) as total_revenue, COUNT(*) as visits_count')
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        return $data->map(fn($item) => [
            'date' => Carbon::parse($item->date)->format('Y-m-d'),
            'total_revenue' => (float) $item->total_revenue,
            'visits_count' => (int) $item->visits_count,
        ]);
    }

    public function getReservationsDistribution(): array
    {
        $today = Carbon::today();

        $data = VisitEntity::whereDate('created_at', $today)
            ->select('status', DB::raw('COUNT(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        $defaultStatuses = ['completed', 'pending', 'cancelled', 'missed'];

        foreach ($defaultStatuses as $status) {
            $data[$status] = $data[$status] ?? 0;
        }

        return $data;
    }
}
