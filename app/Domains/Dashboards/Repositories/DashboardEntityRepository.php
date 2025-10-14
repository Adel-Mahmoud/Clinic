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
            ->sum('price');

        $weeklyStats = VisitEntity::whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->where('status', 'completed')
            ->select(
                DB::raw('COUNT(*) as total_visits'),
                DB::raw('SUM(price) as total_revenue'),
                DB::raw('DAYNAME(created_at) as day_name')  
            )
            ->groupBy('day_name')
            ->get();

        return [
            'new_patients_today'     => $newPatientsCount,
            'confirmed_reservations' => $confirmedReservationsCount,
            'pending_reservations'   => $pendingReservationsCount,
            'today_revenue'          => $todayRevenue ?? 0,
            'weekly_stats'           => $weeklyStats
        ];
    }

    public function getSalesAndVisitsChartData()
    {
        $last7Days = Carbon::now()->subDays(6);

        return VisitEntity::where('created_at', '>=', $last7Days)
            ->where('status', 'completed')
            ->selectRaw('DATE(created_at) as date, SUM(price) as total_revenue, COUNT(*) as visits_count')
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();
    }

    public function getReservationsDistribution()
    {
        return VisitEntity::select('status', DB::raw('COUNT(*) as count'))
            ->groupBy('status')
            ->get()
            ->pluck('count', 'status')
            ->toArray();
    }
}
