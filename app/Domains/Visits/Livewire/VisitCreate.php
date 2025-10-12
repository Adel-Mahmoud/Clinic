<?php

namespace App\Domains\Visits\Livewire;

use Livewire\Component;
use App\Domains\Visits\Repositories\VisitEntityRepository;
use App\Domains\Visits\Requests\VisitRequest;
use App\Domains\Patients\Models\PatientEntity;
use App\Domains\Services\Models\ServiceEntity;
use Illuminate\Support\Facades\Validator;

class VisitCreate extends Component
{
    public $patient_id = '';
    public $service_id = '';
    public $visit_date = '';
    public $visit_time = '';
    public $price = '';
    public $status = 'pending';
    public $notes = '';

    public $search = '';
    public $patients = [];
    public $showDropdown = false;

    protected $listeners = ['setPriceFromService' => 'updatePrice'];

    public function mount($patientId = null)
    {
        $this->visit_date = now()->format('Y-m-d');
        $this->visit_time = now()->format('H:i');

        if ($patientId) {
            $patient = PatientEntity::with('user')->find($patientId);
            if ($patient) {
                $this->patient_id = $patientId;
                $this->search = $patient->user->name;
                $this->showDropdown = false;
            }
        }
    }

    public function updatedSearch()
    {
        if (strlen($this->search) >= 2) {
            $this->patients = PatientEntity::with('user')
                ->whereHas('user', function ($query) {
                    $query->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('phone', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%');
                })
                ->take(10)
                ->get();

            $this->showDropdown = true;
        } else {
            $this->patients = [];
            $this->showDropdown = false;
        }
    }

    public function selectPatient($id)
    {
        $patient = PatientEntity::with('user')->find($id);
        if ($patient) {
            $this->patient_id = $id;
            $this->search = $patient->user->name;
            $this->patients = [];
            $this->showDropdown = false;
        }
    }

    public function clearPatient()
    {
        $this->patient_id = '';
        $this->search = '';
        $this->patients = [];
        $this->showDropdown = false;
    }

    public function updatePrice($price)
    {
        $this->price = $price;
    }

    public function save()
    {
        $validator = Validator::make($this->getData(), (new VisitRequest())->rules(), (new VisitRequest())->messages());

        if ($validator->fails()) {
            $this->dispatch('swal:error', [
                'title' => 'خطأ في التحقق',
                'text' => implode("\n", $validator->errors()->all())
            ]);
            return;
        }

        try {
            $repo = new VisitEntityRepository();
            $repo->create($this->getData());

            $this->dispatch('swal:success', [
                'title' => 'تم الحفظ!',
                'text' => 'تم إنشاء الزيارة بنجاح.'
            ]);

            return redirect()->route('admin.visits.index');
        } catch (\Exception $e) {
            $this->dispatch('swal:error', [
                'title' => 'خطأ!',
                'text' => 'حدث خطأ أثناء الحفظ: ' . $e->getMessage()
            ]);
        }
    }

    private function getData()
    {
        return [
            'patient_id' => $this->patient_id,
            'service_id' => $this->service_id,
            'visit_date' => $this->visit_date,
            'visit_time' => $this->visit_time,
            'price' => $this->price,
            'status' => $this->status,
            'notes' => $this->notes,
        ];
    }

    public function render()
    {
        $services = ServiceEntity::all();

        return view('visits::livewire.visit-create', compact('services'));
    }
}
