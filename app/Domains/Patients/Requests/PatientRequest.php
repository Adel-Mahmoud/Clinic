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
            'user_email' => ['required','email','max:255','unique:users,email,' . ($userId ?? 'NULL') . ',id'],
            'user_password' => [$this->isMethod('post') ? 'required' : 'nullable','string','min:6'],

            // patient fields
            'phone' => ['nullable','string','max:50'],
            'gender' => ['nullable','in:male,female'],
            'birth_date' => ['nullable','date'],
            'address' => ['nullable','string','max:255'],
            'national_id' => ['nullable','string','max:50'],

            // hidden for update
            'user_id' => ['nullable','integer','exists:users,id'],
        ];
    }
}

 
