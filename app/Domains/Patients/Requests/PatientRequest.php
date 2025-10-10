<?php

namespace App\Domains\Patients\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PatientRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth('admin')->check();
    }

    public function rules(): array
    {
        $patientId = $this->route('patient');
        $userId = $this->input('user_id');

        return [
            // user credentials
            'user_name' => ['required','string','max:255'],
            'user_email' => ['nullable','email','max:255','unique:users,email,' . ($userId ?? 'NULL') . ',id'],
            'user_password' => ['nullable','string','min:6'],

            // patient fields
            'phone' => ['nullable','string','max:50'],
            'gender' => ['nullable','in:male,female'],
            'birth_date' => ['nullable','date'],
            'address' => ['nullable','string','max:255'],
            'national_id' => ['nullable','string','max:50'],
            'general_health_status' => ['nullable','string','max:1000'],
            'drug_allergy' => ['nullable','string','max:1000'],
            'notes' => ['nullable','string','max:1000'],

            // hidden for update
            'user_id' => ['nullable','integer','exists:users,id'],
        ];
    }
}

 
