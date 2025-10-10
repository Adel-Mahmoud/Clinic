<?php

namespace App\Domains\Visits\Livewire;

use Livewire\Component;
use App\Domains\Visits\Models\VisitEntity;
use App\Domains\Visits\Repositories\VisitEntityRepository;
use App\Domains\Patients\Models\PatientEntity;
use App\Domains\Services\Models\ServiceEntity;

class VisitCreate extends Component
{
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
        'visit_date' => 'required|date|after_or_equal:today',
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
        'visit_date.after_or_equal' => 'تاريخ الزيارة يجب أن يكون اليوم أو بعده',
        'visit_time.required' => 'يجب تحديد وقت الزيارة',
        'visit_time.date_format' => 'تنسيق الوقت غير صحيح',
        'price.required' => 'يجب تحديد السعر',
        'price.numeric' => 'السعر يجب أن يكون رقماً',
        'price.min' => 'السعر يجب أن يكون أكبر من أو يساوي صفر',
        'status.required' => 'يجب تحديد حالة الزيارة',
        'status.in' => 'حالة الزيارة غير صحيحة',
        'notes.max' => 'الملاحظات يجب أن تكون أقل من 1000 حرف',
    ];

    public function mount()
    {
        $this->visit_date = now()->format('Y-m-d');
        $this->visit_time = now()->format('H:i');
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function save()
    {
        $this->validate();

        try {
            $visitRepository = new VisitEntityRepository();
            $visitRepository->create([
                'patient_id' => $this->patient_id,
                'service_id' => $this->service_id,
                'visit_date' => $this->visit_date,
                'visit_time' => $this->visit_time,
                'price' => $this->price,
                'status' => $this->status,
                'notes' => $this->notes,
            ]);

            $this->dispatch('swal:success', [
                'title' => 'تم الحفظ!',
                'text' => 'تم إنشاء الزيارة بنجاح.'
            ]);

            return redirect()->route('admin.visits.index');
        } catch (\Exception $e) {
            $this->dispatch('swal:error', [
                'title' => 'خطأ!',
                'text' => 'حدث خطأ أثناء حفظ البيانات: ' . $e->getMessage()
            ]);
        }
    }

    public function render()
    {
        $patients = PatientEntity::with('user')->get();
        $services = ServiceEntity::all();

        return view('visits::livewire.visit-create', compact('patients', 'services'));
    }
}
