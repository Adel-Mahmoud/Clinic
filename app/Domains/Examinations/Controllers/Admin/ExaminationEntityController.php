<?php

namespace App\Domains\Examinations\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Domains\Examinations\Repositories\ExaminationEntityRepository;

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
        return view('examinations::admin.index', compact('nextVisit', 'drugs'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'visit_id' => 'required|exists:visits,id',
            'symptoms' => 'required|string',
            'diagnosis' => 'required|string',
            'attachments.*' => 'file|max:4096'
        ]);

        $this->repo->store($request);

        return redirect()->back()->with('success', 'تم حفظ الكشف بنجاح');
    }
}
