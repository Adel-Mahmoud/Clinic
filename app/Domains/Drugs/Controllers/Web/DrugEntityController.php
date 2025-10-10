<?php

namespace App\Domains\Drugs\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Domains\Drugs\Repositories\DrugEntityRepository;
use Illuminate\View\View;

class DrugEntityController extends Controller
{
    protected DrugEntityRepository $repository;

    public function __construct(DrugEntityRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(): View
    {
        $titlePage = 'الأدوية';
        $drugs = $this->repository->all();
        return view('drugs::web.index', compact('drugs', 'titlePage'));
    }
}
