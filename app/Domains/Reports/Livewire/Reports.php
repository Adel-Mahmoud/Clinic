<?php

namespace App\Domains\Reports\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Domains\Reports\Repositories\ReportEntityRepository;

class Reports extends Component
{
    use WithPagination;

    public $serviceId = null;
    public $period = 'monthly';
    public $startDate = null;
    public $endDate = null;

    protected $paginationTheme = 'bootstrap';
    protected ReportEntityRepository $repo;

    public function boot(ReportEntityRepository $repository)
    {
        $this->repo = $repository;
    }

    public function mount()
    {
        $this->period = 'monthly';
    }

    public function updatedPeriod()
    {
        if ($this->period !== 'custom') {
            $this->startDate = null;
            $this->endDate = null;
        }

        $this->resetPage();
    }

    public function updatedServiceId()
    {
        $this->resetPage();
    }

    public function generate()
    {
        $this->resetPage();
    }

    public function render()
    {
        $baseQuery = $this->repo->getReport(
            $this->serviceId ? (int) $this->serviceId : null,
            $this->period,
            $this->startDate,
            $this->endDate
        );

        $totalAmount = $baseQuery->clone()->sum('price'); 

        $rows = $baseQuery->paginate(10);

        return view('reports::livewire.report-index', [
            'sectionPage'   => 'التقارير',
            'titlePage'     => 'تقارير العيادة',
            'getAllServices' => $this->repo->getAllServices(),
            'rows'          => $rows,
            'totalAmount'   => $totalAmount,
        ]);
    }
}
