<?php

namespace App\Domains\Settings\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Domains\Settings\Repositories\SettingEntityRepository;
use Illuminate\Http\Request;

class SettingEntityController extends Controller
{
    protected $repository;

    public function __construct(SettingEntityRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        $settings = $this->repository->all()->first();
        return view('settings::admin.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'project_name'   => 'required|string|max:255',
            'short_description'    => 'nullable|string|max:500',
            'phone'          => 'nullable|string|max:20',
            'address'        => 'nullable|string|max:255',
            'logo'           => 'nullable|image|mimes:png,jpg,jpeg,svg|max:2048',
            'brand_image'          => 'nullable|image|mimes:png,jpg,jpeg,svg|max:2048',
        ]);
        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('settings', 'public');
        }

        if ($request->hasFile('brand_image')) {
            $validated['brand_image'] = $request->file('brand_image')->store('settings', 'public');
        }

        $this->repository->save($validated);

        return redirect()->back()->with('success', 'تم حفظ الإعدادات بنجاح ');
    }
}
