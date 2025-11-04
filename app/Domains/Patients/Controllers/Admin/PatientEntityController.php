<?php

namespace App\Domains\Patients\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Domains\Patients\Repositories\PatientEntityRepository;
use App\Domains\Patients\Requests\PatientRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PatientEntityController extends Controller
{
    protected PatientEntityRepository $repository;

    public function __construct(PatientEntityRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(): View
    {
        $titlePage = 'المرضى';
        return view('patients::admin.index', compact('titlePage'));
    }

    public function create(): View
    {
        $sectionPage = 'المرضى';
        $titlePage = 'مريض جديد';
        return view('patients::admin.create', compact('sectionPage', 'titlePage'));
    }

    public function store(PatientRequest $request): RedirectResponse
    {
        $this->repository->createWithUser($request->validated());

        return redirect()
            ->route('admin.patients.index')
            ->with('swal', [
                'type'  => 'success',
                'title' => 'تم الإضافة!',
                'text'  => 'تمت إضافة المريض بنجاح.',
            ]);
    }

    public function edit($id): View
    {
        $sectionPage = 'المرضى';
        $titlePage = 'تعديل مريض';
        $patient = $this->repository->findOrFailWithUser($id);
        return view('patients::admin.edit', compact('patient', 'sectionPage', 'titlePage'));
    }

    public function history($id): View
    {
        $sectionPage = 'المرضى';
        $titlePage = 'سجل المريض ';
        $patient_name = $this->repository->findOrFailWithUser($id)->user->name;
        return view('patients::admin.history', compact('id', 'patient_name', 'sectionPage', 'titlePage'));
    }

    public function update(PatientRequest $request, $id): RedirectResponse
    {
        $this->repository->updateWithUser($id, $request->validated());
        return redirect()->route('admin.patients.index')->with('success', 'تم تعديل بيانات المريض بنجاح');
    }

    public function destroy($id): RedirectResponse
    {
        $this->repository->delete($id);
        return redirect()->route('admin.patients.index')->with('success', 'تم حذف المريض بنجاح');
    }
}