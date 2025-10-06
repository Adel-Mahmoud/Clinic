<?php

namespace App\Domains\Doctors\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Domains\Doctors\Requests\DoctorRequest;
use App\Domains\Doctors\Repositories\DoctorEntityRepository;

class DoctorEntityController extends Controller
{
    protected $repository;

    public function __construct(DoctorEntityRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        $titlePage = 'طبيب جديد';
        $doctors = $this->repository->all();
        return view('doctors::admin.index', compact('doctors','titlePage'));
    }

    public function create()
    {
        $sectionPage = 'الاطباء';
        $titlePage = 'طبيب جديد';
        return view('doctors::admin.create', compact('sectionPage', 'titlePage'));
    }

    public function store(DoctorRequest $request)
    {
        $this->repository->create($request->validated());
        return redirect()->route('admin.doctors.index')->with('success', 'تم إنشاء الطبيب بنجاح');
    }

    public function edit($id)
    {
        $sectionPage = 'الاطباء';
        $titlePage = ' تعديل طبيب';
        $doctor = $this->repository->find($id);
        return view('doctors::admin.edit', compact('doctor','sectionPage', 'titlePage'));
    }

    public function update(DoctorRequest $request, $id)
    {
        $this->repository->update($id, $request->validated());
        return redirect()->route('admin.doctors.index')->with('success', 'تم تحديث بيانات الطبيب بنجاح');
    }

    public function destroy($id)
    {
        $this->repository->delete($id);
        return redirect()->route('admin.doctors.index')->with('success', 'تم حذف الطبيب بنجاح');
    }
}