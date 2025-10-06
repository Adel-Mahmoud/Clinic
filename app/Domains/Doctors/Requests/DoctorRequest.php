<?php

namespace App\Domains\Doctors\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class DoctorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        $id = $this->route('doctor'); 

        return [
            'user_id' => 'required|exists:users,id|unique:doctors,user_id,' . $id,
            'specialization' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'bio' => 'nullable|string',
        ];
    }
}
