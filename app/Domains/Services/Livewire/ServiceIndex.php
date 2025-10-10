<?php

namespace App\Domains\Services\Livewire;

use Livewire\Component;
use App\Domains\Services\Models\ServiceEntity;
use Livewire\WithPagination;

class ServiceIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $selected = [];
    public $selectAll = false;

    protected $paginationTheme = 'bootstrap';

    protected $listeners = [
        'deleteItem' => 'deleteItem',
        'deleteSelected' => 'deleteSelected',
        'refreshComponent' => '$refresh',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function deleteItem($id)
    {
        if ($id) {
            ServiceEntity::findOrFail($id)->delete();
            $this->dispatch('swal:success', [
                'title' => 'تم الحذف!',
                'text'  => 'تم حذف البيانات بنجاح.'
            ]);
            $this->dispatch('refreshComponent');
        }
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selected = ServiceEntity::pluck('id')->toArray();
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
                'text'  => 'يرجى تحديد سجلات للحذف أولاً.'
            ]);
            return;
        }

        $this->dispatch('swal:confirm', [
            'type'  => 'bulk',
            'title' => 'هل أنت متأكد؟',
            'text'  => 'سيتم حذف ' . count($this->selected) . ' خدمة ولا يمكن التراجع!',
        ]);
    }

    public function deleteSelected()
    {
        if (empty($this->selected)) {
            return;
        }

        ServiceEntity::whereIn('id', $this->selected)->delete();

        $this->selected = [];
        $this->selectAll = false;

        $this->dispatch('swal:success', [
            'title' => 'تم الحذف',
            'text' => 'تم حذف العناصر المحددة بنجاح',
        ]);
        $this->dispatch('refreshComponent');
    }

    public function render()
    {
        $services = ServiceEntity::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', "%{$this->search}%")
                    ->orWhere('description', 'like', "%{$this->search}%");
            })
            ->paginate(10);

        return view('services::livewire.service-index', compact('services'));
    }
}
