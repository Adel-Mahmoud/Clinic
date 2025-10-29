<?php

namespace App\Domains\Examinations\Controllers\Admin;

use App\Domains\Examinations\Repositories\ExaminationEntityRepository;
use App\Http\Controllers\Controller;

class ExaminationEntityController extends Controller
{
    public $repo;

    public function __construct(ExaminationEntityRepository $repo)
    {
        $this->repo = $repo;
    }

    public function index()
    {
        $nextVisit = $this->repo->getNextVisitInQueue();
        $drugs = $this->repo->getDrugs();
        // dd($nextVisit->patient);
        return view('examinations::admin.index', compact('nextVisit', 'drugs'));
    }
}