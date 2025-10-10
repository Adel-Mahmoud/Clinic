<?php

namespace App\Domains\Drugs\Livewire;

use Livewire\Component;
use App\Domains\Drugs\Models\DrugEntity;
use Livewire\WithPagination;

class DrugIndex extends Component
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
            DrugEntity::findOrFail($id)->delete();
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
            $this->selected = DrugEntity::pluck('id')->toArray();
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
            'text'  => 'سيتم حذف ' . count($this->selected) . ' دواء ولا يمكن التراجع!',
        ]);
    }

    public function deleteSelected()
    {
        if (empty($this->selected)) {
            return;
        }

        DrugEntity::whereIn('id', $this->selected)->delete();

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
        $drugs = DrugEntity::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', "%{$this->search}%")
                    ->orWhere('generic_name', 'like', "%{$this->search}%")
                    ->orWhere('manufacturer', 'like', "%{$this->search}%");
            })
            ->paginate(10);

        return view('drugs::livewire.drug-index', compact('drugs'));
    }
}
