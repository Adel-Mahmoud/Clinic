<?php

namespace App\Domains\Drugs\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Domains\Drugs\Repositories\DrugEntityRepository;
use App\Domains\Drugs\Requests\DrugRequest;
use Illuminate\Http\RedirectResponse;
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
        return view('drugs::admin.index', compact('drugs', 'titlePage'));
    }

    public function create(): View
    {
        $sectionPage = 'الأدوية';
        $titlePage = 'دواء جديد';
        return view('drugs::admin.create', compact('sectionPage', 'titlePage'));
    }

    public function store(DrugRequest $request): RedirectResponse
    {
        $this->repository->create($request->validated());

        return redirect()
            ->route('admin.drugs.index')
            ->with('swal', [
                'type'  => 'success',
                'title' => 'تم الإضافة!',
                'text'  => 'تمت إضافة الدواء بنجاح.',
            ]);
    }

    public function edit($id): View
    {
        $sectionPage = 'الأدوية';
        $titlePage = 'تعديل دواء';
        $drug = $this->repository->find($id);
        return view('drugs::admin.edit', compact('drug', 'sectionPage', 'titlePage'));
    }

    public function update(DrugRequest $request, $id): RedirectResponse
    {
        $this->repository->update($id, $request->validated());
        return redirect()->route('admin.drugs.index')->with('success', 'تم تعديل الدواء بنجاح');
    }

    public function destroy($id): RedirectResponse
    {
        $this->repository->delete($id);
        return redirect()->route('admin.drugs.index')->with('success', 'تم حذف الدواء بنجاح');
    }
}
