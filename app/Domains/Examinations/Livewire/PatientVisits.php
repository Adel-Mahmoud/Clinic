<?php

namespace App\Domains\Examinations\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Domains\Visits\Models\VisitEntity;
use App\Domains\Examinations\Models\ExaminationEntity;

class PatientVisits extends Component
{
    use WithPagination;

    public $patient_id;
    public $search = '';

    protected $paginationTheme = 'bootstrap';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function mount($patientId)
    {
        $this->patient_id = $patientId;
    }

    public function render()
    {
        $visits = ExaminationEntity::with('visit')
            ->whereHas('visit', function ($q) {
                $q->where('patient_id', $this->patient_id);
            })
            ->where(function ($q) {
                $q->where('symptoms', 'like', '%' . $this->search . '%')
                    ->orWhere('diagnosis', 'like', '%' . $this->search . '%')
                    ->orWhere('created_at', 'like', '%' . $this->search . '%');
            })
            ->orderByDesc('id')
            ->paginate(10);
        return view('examinations::livewire.patient-visits', compact('visits'));
    }
}
