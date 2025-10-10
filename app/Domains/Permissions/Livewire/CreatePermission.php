<?php

namespace App\Domains\Permissions\Livewire;

use Livewire\Component;
use App\Domains\Permissions\Repositories\PermissionEntityRepository;
use App\Domains\Permissions\Requests\PermissionRequest;

class CreatePermission extends Component
{
    public $name;
    public $guard_name = 'web';

    protected function rules()
    {
        return (new PermissionRequest())->rules();
    }

    public function save()
    {
        $validated = $this->validate();

        if (empty($validated['guard_name'])) {
            $validated['guard_name'] = 'web';
        }

        $repo = new PermissionEntityRepository();
        $repo->create($validated);

        session()->flash('swal', [
            'type'  => 'success',
            'title' => 'تم الإضافة!',
            'text'  => 'تمت إضافة الصلاحية بنجاح.',
        ]);

        return redirect()->route('admin.permissions.index');
        // return $this->redirectRoute('admin.permissions.index', navigate: true);
    }

    public function render()
    {
        $sectionPage = 'الصلاحيات';
        $titlePage = 'صلاحية جديدة';
        return view('permissions::livewire.create-permission', compact('sectionPage', 'titlePage'));
    }
}
