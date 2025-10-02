<?php

namespace App\Domains\Permission\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Permission;

class PermissionIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $selected = [];
    public $selectAll = false;

    protected $paginationTheme = 'bootstrap';

    protected $listeners = [
        'deletePermission',
        'deleteSelected',
        'refreshComponent' => '$refresh',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function deletePermission($id)
    {
        if ($id) {
            Permission::findOrFail($id)->delete();

            $this->dispatch('swal:success', [
                'title' => 'تم الحذف!',
                'text'  => 'تم حذف الصلاحية بنجاح.'
            ]);

            $this->dispatch('refreshComponent');
        }
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selected = Permission::pluck('id')->toArray();
        } else {
            $this->selected = [];
        }
    }

    public function confirmDelete($id)
    {
        $this->dispatch('swal:confirm', [
            'id'    => $id,
            'title' => 'هل أنت متأكد؟',
            'text'  => 'لن يمكنك التراجع بعد الحذف!',
            'type'  => 'single'
        ]);
    }

    public function confirmDeleteSelected()
    {
        if (empty($this->selected)) {
            $this->dispatch('swal:error', [
                'title' => 'لم يتم التحديد',
                'text'  => 'يرجى تحديد صلاحيات للحذف أولاً.'
            ]);
            return;
        }

        $this->dispatch('swal:confirm', [
            'type'  => 'bulk',
            'title' => 'هل أنت متأكد؟',
            'text'  => 'سيتم حذف ' . count($this->selected) . ' صلاحية ولا يمكن التراجع!',
        ]);
    }

    public function deleteSelected()
    {
        if (empty($this->selected)) return;

        Permission::whereIn('id', $this->selected)->delete();

        $this->selected = [];
        $this->selectAll = false;

        $this->dispatch('swal:success', [
            'title' => 'تم الحذف!',
            'text'  => 'تم حذف الصلاحيات المحددة بنجاح.',
        ]);

        $this->dispatch('refreshComponent');
    }

    public function render()
    {
        $permissions = Permission::when($this->search, function ($query) {
                $query->where('name', 'like', "%{$this->search}%");
            })
            ->paginate(10);

        return view('permission::livewire.permission-index', compact('permissions'));
    }
}


