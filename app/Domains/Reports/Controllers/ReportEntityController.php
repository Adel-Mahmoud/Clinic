<?php

namespace App\Domains\Reports\Controllers;

use App\Http\Controllers\Controller;
use App\Domains\Reports\Repositories\ReportEntityRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ReportEntityController extends Controller
{
    protected ReportEntityRepository $repository;

    public function __construct(ReportEntityRepository $repository)
    {
        $this->repository = $repository;
    }
    
    public function index(): View
    {
        $titlePage = 'التقارير';
        $report = $this->repository->all();
        return view('reports::admin.index', compact('report', 'titlePage'));
    }
}


