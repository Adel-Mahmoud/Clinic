<?php

namespace App\Domains\Patients\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Domains\Patients\Models\PatientEntity;

class PatientIndex extends Component
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
            PatientEntity::findOrFail($id)->delete();
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
            $this->selected = PatientEntity::pluck('id')->toArray();
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
            'text'  => 'سيتم حذف ' . count($this->selected) . ' سجل ولا يمكن التراجع!',
        ]);
    }

    public function deleteSelected()
    {
        if (empty($this->selected)) {
            return;
        }

        PatientEntity::whereIn('id', $this->selected)->delete();

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
        $patients = PatientEntity::with('user')
            ->when($this->search, function ($query) {
                $query->whereHas('user', function ($q) {
                    $q->where('name', 'like', "%{$this->search}%")
                      ->orWhere('email', 'like', "%{$this->search}%");
                })
                ->orWhere('phone', 'like', "%{$this->search}%")
                ->orWhere('national_id', 'like', "%{$this->search}%")
                ->orWhere('general_health_status', 'like', "%{$this->search}%")
                ->orWhere('drug_allergy', 'like', "%{$this->search}%")
                ->orWhere('notes', 'like', "%{$this->search}%");
            })
            ->latest()
            ->paginate(10);

        return view('patients::livewire.patient-index', compact('patients'));
    }
}

 
