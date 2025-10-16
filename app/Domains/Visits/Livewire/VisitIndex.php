<?php

namespace App\Domains\Visits\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Domains\Visits\Models\VisitEntity;

class VisitIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $selected = [];
    public $selectAll = false;
    public $statusFilter = '';
    public $sortDirection = 'desc';

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

    public function toggleSortDirection()
    {
        $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function deleteItem($id)
    {
        if ($id) {
            VisitEntity::findOrFail($id)->delete();
            $this->dispatch('swal:success', [
                'title' => 'تم الحذف!',
                'text'  => 'تم حذف الزيارة بنجاح.'
            ]);
            $this->dispatch('refreshComponent');
        }
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selected = VisitEntity::pluck('id')->toArray();
        } else {
            $this->selected = [];
        }
    }

    public function confirmDelete($id)
    {
        $this->dispatch('swal:confirm', [
            'id'    => $id,
            'title' => 'هل أنت متأكد؟',
            'text'  => 'لن يمكنك التراجع بعد حذف الزيارة!',
            'type'  => 'single'
        ]);
    }

    public function confirmDeleteSelected()
    {
        if (empty($this->selected)) {
            $this->dispatch('swal:error', [
                'title' => 'لم يتم التحديد',
                'text'  => 'يرجى تحديد زيارات للحذف أولاً.'
            ]);
            return;
        }

        $this->dispatch('swal:confirm', [
            'type'  => 'bulk',
            'title' => 'هل أنت متأكد؟',
            'text'  => 'سيتم حذف ' . count($this->selected) . ' زيارة ولا يمكن التراجع!',
        ]);
    }

    public function deleteSelected()
    {
        if (empty($this->selected)) {
            return;
        }

        VisitEntity::whereIn('id', $this->selected)->delete();

        $this->selected = [];
        $this->selectAll = false;

        $this->dispatch('swal:success', [
            'title' => 'تم الحذف',
            'text' => 'تم حذف الزيارات المحددة بنجاح',
        ]);
        $this->dispatch('refreshComponent');
    }

    public function render()
    {
        $visits = VisitEntity::with(['patient.user', 'service'])
            ->when($this->search, function ($query) {
                $query->whereHas('patient.user', function ($q) {
                    $q->where('name', 'like', "%{$this->search}%");
                })
                    ->orWhereHas('service', function ($q) {
                        $q->where('name', 'like', "%{$this->search}%");
                    })
                    ->orWhere('notes', 'like', "%{$this->search}%");
            })
            ->when($this->statusFilter, function ($query) {
                $query->where('status', $this->statusFilter);
            })
            ->orderBy('visit_date', $this->sortDirection)
            ->orderBy('visit_time', $this->sortDirection)
            ->paginate(10);

        return view('visits::livewire.visit-index', compact('visits'));
    }
}
