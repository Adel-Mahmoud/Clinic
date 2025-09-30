<?php

namespace App\Domains\Users\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Domains\Users\Repositories\UserEntityRepository;
use App\Domains\Users\Requests\UserRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class UserEntityController extends Controller
{
    protected UserEntityRepository $repository;

    public function __construct(UserEntityRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(): View
    {
        $users = $this->repository->all();
        return view('users::admin.index', compact('users'));
    }

    public function create(): View
    {
        return view('users::admin.create');
    }

    public function store(UserRequest $request): RedirectResponse
    {
        $this->repository->create($request->validated());
        return redirect()->route('admin.users.index')->with('success', 'تم إنشاء المستخدم بنجاح');
    }

    public function edit($id): View
    {
        $user = $this->repository->find($id);
        return view('users::admin.edit', compact('user'));
    }

    public function update(UserRequest $request, $id): RedirectResponse
    {
        $this->repository->update($id, $request->validated());
        return redirect()->route('admin.users.index')->with('success', 'تم تعديل المستخدم بنجاح');
    }

    public function destroy($id): RedirectResponse
    {
        $this->repository->delete($id);
        return redirect()->route('admin.users.index')->with('success', 'تم حذف المستخدم بنجاح');
    }
}
