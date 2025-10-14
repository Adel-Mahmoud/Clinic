<?php

namespace App\Domains\Dashboards\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Domains\Dashboards\Repositories\DashboardEntityRepository;

class DashboardEntityController extends Controller
{
    protected DashboardEntityRepository $dashboardRepository;

    public function __construct(DashboardEntityRepository $dashboardRepository)
    {
        $this->dashboardRepository = $dashboardRepository;
    }

    public function index()
    {
        $stats = $this->dashboardRepository->getDashboardStats();
        $chartData = $this->dashboardRepository->getSalesAndVisitsChartData();
        $reservationsDistribution = $this->dashboardRepository->getReservationsDistribution();

        return view('dashboards::admin.index', compact('stats', 'chartData', 'reservationsDistribution'));
    }
}
