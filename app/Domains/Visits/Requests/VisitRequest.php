<?php

namespace App\Domains\Visits\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VisitRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth('admin')->check();
    }

    public function rules(): array
    {
        return [
            'patient_id' => ['required', 'integer', 'exists:patients,id'],
            'service_id' => ['required', 'integer', 'exists:services,id'],
            'visit_date' => ['required', 'date', 'after_or_equal:today'],
            'visit_time' => ['required', 'date_format:H:i'],
            'price' => ['required', 'numeric', 'min:0'],
            'status' => ['required', 'in:pending,completed,canceled'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ];
    }

    public function messages(): array
    {
        return [
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
    }
}
