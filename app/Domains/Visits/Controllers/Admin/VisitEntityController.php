<?php

namespace App\Domains\Visits\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Domains\Visits\Repositories\VisitEntityRepository;
use App\Domains\Visits\Requests\VisitRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class VisitEntityController extends Controller
{
    protected VisitEntityRepository $repository;

    public function __construct(VisitEntityRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(): View
    {
        $titlePage = 'الزيارات';
        return view('visits::admin.index', compact('titlePage'));
    }

    public function create(): View
    {
        $sectionPage = 'الزيارات';
        $titlePage = 'زيارة جديدة';
        return view('visits::admin.create', compact('sectionPage', 'titlePage'));
    }

    public function store(VisitRequest $request): RedirectResponse
    {
        $this->repository->create($request->validated());

        return redirect()
            ->route('admin.visits.index')
            ->with('swal', [
                'type'  => 'success',
                'title' => 'تم الإضافة!',
                'text'  => 'تمت إضافة الزيارة بنجاح.',
            ]);
    }

    public function show($id): View
    {
        $sectionPage = 'الزيارات';
        $titlePage = 'زيارة جديدة';
        return view('visits::admin.show', compact('sectionPage', 'titlePage','id'));
    }

    public function edit($id): View
    {
        $sectionPage = 'الزيارات';
        $titlePage = 'تعديل زيارة';
        $visit = $this->repository->findOrFailWithRelations($id);
        $visitId = $id;
        return view('visits::admin.edit', compact('visit', 'visitId', 'sectionPage', 'titlePage'));
    }

    public function update(VisitRequest $request, $id): RedirectResponse
    {
        $this->repository->update($id, $request->validated());
        return redirect()->route('admin.visits.index')->with('success', 'تم تعديل الزيارة بنجاح');
    }

    public function destroy($id): RedirectResponse
    {
        $this->repository->delete($id);
        return redirect()->route('admin.visits.index')->with('success', 'تم حذف الزيارة بنجاح');
    }
}
