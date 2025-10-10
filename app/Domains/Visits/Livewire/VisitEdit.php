<?php

namespace App\Domains\Visits\Livewire;

use Livewire\Component;
use App\Domains\Visits\Models\VisitEntity;
use App\Domains\Visits\Repositories\VisitEntityRepository;
use App\Domains\Patients\Models\PatientEntity;
use App\Domains\Services\Models\ServiceEntity;

class VisitEdit extends Component
{
    public $visit;
    public $patient_id = '';
    public $service_id = '';
    public $visit_date = '';
    public $visit_time = '';
    public $price = '';
    public $status = 'pending';
    public $notes = '';

    protected $rules = [
        'patient_id' => 'required|integer|exists:patients,id',
        'service_id' => 'required|integer|exists:services,id',
        'visit_date' => 'required|date',
        'visit_time' => 'required|date_format:H:i',
        'price' => 'required|numeric|min:0',
        'status' => 'required|in:pending,completed,canceled',
        'notes' => 'nullable|string|max:1000',
    ];

    protected $messages = [
        'patient_id.required' => 'يجب اختيار المريض',
        'patient_id.exists' => 'المريض المحدد غير موجود',
        'service_id.required' => 'يجب اختيار الخدمة',
        'service_id.exists' => 'الخدمة المحددة غير موجودة',
        'visit_date.required' => 'يجب تحديد تاريخ الزيارة',
        'visit_time.required' => 'يجب تحديد وقت الزيارة',
        'visit_time.date_format' => 'تنسيق الوقت غير صحيح',
        'price.required' => 'يجب تحديد السعر',
        'price.numeric' => 'السعر يجب أن يكون رقماً',
        'price.min' => 'السعر يجب أن يكون أكبر من أو يساوي صفر',
        'status.required' => 'يجب تحديد حالة الزيارة',
        'status.in' => 'حالة الزيارة غير صحيحة',
        'notes.max' => 'الملاحظات يجب أن تكون أقل من 1000 حرف',
    ];

    public function mount($visitId)
    {
        $this->visit = VisitEntity::with(['patient.user', 'service'])->findOrFail($visitId);
        
        $this->patient_id = $this->visit->patient_id;
        $this->service_id = $this->visit->service_id;
        $this->visit_date = $this->visit->visit_date->format('Y-m-d');
        $this->visit_time = $this->visit->visit_time->format('H:i');
        $this->price = $this->visit->price;
        $this->status = $this->visit->status;
        $this->notes = $this->visit->notes;
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function update()
    {
        $this->validate();

        try {
            $visitRepository = new VisitEntityRepository();
            $visitRepository->update($this->visit->id, [
                'patient_id' => $this->patient_id,
                'service_id' => $this->service_id,
                'visit_date' => $this->visit_date,
                'visit_time' => $this->visit_time,
                'price' => $this->price,
                'status' => $this->status,
                'notes' => $this->notes,
            ]);

            $this->dispatch('swal:success', [
                'title' => 'تم التحديث!',
                'text' => 'تم تحديث الزيارة بنجاح.'
            ]);

            return redirect()->route('admin.visits.index');
        } catch (\Exception $e) {
            $this->dispatch('swal:error', [
                'title' => 'خطأ!',
                'text' => 'حدث خطأ أثناء تحديث البيانات: ' . $e->getMessage()
            ]);
        }
    }

    public function render()
    {
        $patients = PatientEntity::with('user')->get();
        $services = ServiceEntity::all();

        return view('visits::livewire.visit-edit', compact('patients', 'services'));
    }
}
