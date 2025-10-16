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
        $NextVisit = $this->repo->getNextVisitInQueue();
        // dd($NextVisit->patient->user);
        return view('examinations::admin.index', compact('NextVisit'));
    }
}