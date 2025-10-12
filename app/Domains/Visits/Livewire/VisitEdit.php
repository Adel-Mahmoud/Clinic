<?php

namespace App\Domains\Visits\Livewire;

use Livewire\Component;
use App\Domains\Visits\Repositories\VisitEntityRepository;
use App\Domains\Visits\Requests\VisitRequest;
use App\Domains\Patients\Models\PatientEntity;
use App\Domains\Services\Models\ServiceEntity;
use Illuminate\Support\Facades\Validator;

class VisitEdit extends Component
{
    public $visit_id;
    public $patient_name = '';
    public $patient_id = '';
    public $service_id = '';
    public $visit_date = '';
    public $visit_time = '';
    public $price = '';
    public $status = 'pending';
    public $notes = '';

    protected $listeners = ['setPriceFromService' => 'updatePrice'];

    public function mount($visitId)
    {
        $repo = new VisitEntityRepository();
        $visit = $repo->findOrFailWithRelations($visitId);

        $this->patient_name = $visit->patient->user->name;
        $this->visit_id = $visit->id;
        $this->patient_id = $visit->patient_id;
        $this->service_id = $visit->service_id;
        $this->visit_date = $visit->visit_date->format('Y-m-d');
        $this->visit_time = $visit->visit_time->format('H:i');
        $this->price = $visit->price;
        $this->status = $visit->status;
        $this->notes = $visit->notes;
    }

    public function updatePrice($price)
    {
        $this->price = $price;
    }

    public function update()
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
            $repo->update($this->visit_id, $this->getData());

            $this->dispatch('swal:success', [
                'title' => 'تم التحديث!',
                'text' => 'تم تحديث الزيارة بنجاح.'
            ]);

            return redirect()->route('admin.visits.index');
        } catch (\Exception $e) {
            $this->dispatch('swal:error', [
                'title' => 'خطأ!',
                'text' => 'حدث خطأ أثناء التحديث: ' . $e->getMessage()
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
        $patients = PatientEntity::with('user')->get();
        $services = ServiceEntity::all();

        return view('visits::livewire.visit-edit', compact('patients', 'services'));
    }
}
