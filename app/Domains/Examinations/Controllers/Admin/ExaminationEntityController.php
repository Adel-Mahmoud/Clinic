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
        $visitData = $this->repo->getNowVisitInQueue();

        $nowVisit = $visitData['now'];
        $lastCompleted = $visitData['last_completed'];
        $drugs = $this->repo->getDrugs();

        return view('examinations::admin.index', compact('nowVisit', 'lastCompleted', 'drugs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'visit_id' => 'required|exists:visits,id',
            'symptoms' => 'required|string',
            'diagnosis' => 'required|string',
            'attachments.*' => 'file|max:4096'
        ]);

        $examinationId = $this->repo->store($request);
        return redirect()->route('admin.examinations.print', $examinationId);
        // return redirect()
        //     ->back()
        //     ->with('swal', [
        //         'type'  => 'success',
        //         'title' => 'تم الإضافة!',
        //         'text'  => 'تم حفظ الكشف بنجاح',
        //     ]);
    }

    public function show(Request $request)
    {
        $visit = $this->repo->getVisitById($request->id);
        return view('examinations::admin.show', compact('visit'));

    }
    public function print(Request $request)
    {
        $visit = $this->repo->getVisitById($request->id);
        return view('examinations::admin.print', compact('visit'));

    }
}
