<?php

namespace App\Domains\Reports\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Domains\Reports\Repositories\ReportEntityRepository;

class Reports extends Component
{
    use WithPagination;

    public $search = '';
    protected $paginationTheme = 'bootstrap';

    protected $repo;

    public function mount(ReportEntityRepository $repository)
    {
        $this->repo = $repository;
    }

    public function render()
    {
        $getAllServices = $this->repo->getAllServices();

        $sectionPage = 'التقارير';
        $titlePage = 'تقارير العيادة';

        return view('reports::livewire.report-index', compact('sectionPage', 'titlePage', 'getAllServices'));
    }
}
