<?php

namespace App\Domains\Permissions\Controllers;

use App\Http\Controllers\Controller;
use App\Domains\Permissions\Repositories\PermissionEntityRepository;
use App\Domains\Permissions\Requests\PermissionRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PermissionEntityController extends Controller
{
    protected PermissionEntityRepository $repository;

    public function __construct(PermissionEntityRepository $repository)
    {
        $this->repository = $repository;
        $this->middleware('permission:view permissions')->only(['index']);
        $this->middleware('permission:create permission')->only(['create', 'store']);
        $this->middleware('permission:edit permission')->only(['edit', 'update']);
        $this->middleware('permission:delete permission')->only(['destroy']);
    }

    public function index(): View
    {
        $titlePage = 'الصلاحيات';
        $permissions = $this->repository->all();
        return view('permissions::admin.index', compact('permissions', 'titlePage'));
    }

    public function create(): View
    {
        $sectionPage = 'الصلاحيات';
        $titlePage = 'صلاحية جديدة';
        return view('permissions::admin.create', compact('sectionPage', 'titlePage'));
    }

    public function store(PermissionRequest $request): RedirectResponse
    {
        $data = $request->validated();
        if (empty($data['guard_name'])) {
            $data['guard_name'] = 'web';
        }
        $this->repository->create($data);

        return redirect()->route('admin.permissions.index')->with('swal', [
            'type'  => 'success',
            'title' => 'تم الإضافة!',
            'text'  => 'تمت إضافة الصلاحية بنجاح.',
        ]);
    }

    public function edit($id): View
    {
        $sectionPage = 'الصلاحيات';
        $titlePage = 'تعديل صلاحية';
        $permission = $this->repository->find($id);
        return view('permissions::admin.edit', compact('sectionPage', 'titlePage', 'permission'));
    }

    public function update(PermissionRequest $request, $id): RedirectResponse
    {
        $data = $request->validated();
        $this->repository->update($id, $data);

        return redirect()->route('admin.permissions.index')->with('swal', [
            'type'  => 'success',
            'title' => 'تم التحديث!',
            'text'  => 'تم تعديل الصلاحية بنجاح.',
        ]);
    }

    public function destroy($id): RedirectResponse
    {
        $this->repository->delete($id);

        return redirect()->route('admin.permissions.index')->with('swal', [
            'type'  => 'success',
            'title' => 'تم الحذف!',
            'text'  => 'تم حذف الصلاحية بنجاح.',
        ]);
    }
}


