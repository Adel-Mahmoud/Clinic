<?php

namespace App\Domains\Services\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Domains\Services\Repositories\ServiceEntityRepository;
use App\Domains\Services\Requests\ServiceRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ServiceEntityController extends Controller
{
    protected ServiceEntityRepository $repository;

    public function __construct(ServiceEntityRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(): View
    {
        $titlePage = 'الخدمات';
        $services = $this->repository->all();
        return view('services::admin.index', compact('services', 'titlePage'));
    }

    public function create(): View
    {
        $sectionPage = 'الخدمات';
        $titlePage = 'خدمة جديدة';
        return view('services::admin.create', compact('sectionPage', 'titlePage'));
    }

    public function store(ServiceRequest $request): RedirectResponse
    {
        $this->repository->create($request->validated());

        return redirect()
            ->route('admin.services.index')
            ->with('swal', [
                'type'  => 'success',
                'title' => 'تم الإضافة!',
                'text'  => 'تمت إضافة الخدمة بنجاح.',
            ]);
    }

    public function edit($id): View
    {
        $sectionPage = 'الخدمات';
        $titlePage = 'تعديل خدمة';
        $service = $this->repository->find($id);
        return view('services::admin.edit', compact('service', 'sectionPage', 'titlePage'));
    }

    public function update(ServiceRequest $request, $id): RedirectResponse
    {
        $this->repository->update($id, $request->validated());
        return redirect()->route('admin.services.index')->with('success', 'تم تعديل الخدمة بنجاح');
    }

    public function destroy($id): RedirectResponse
    {
        $this->repository->delete($id);
        return redirect()->route('admin.services.index')->with('success', 'تم حذف الخدمة بنجاح');
    }
}
