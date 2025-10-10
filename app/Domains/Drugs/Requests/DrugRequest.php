<?php

namespace App\Domains\Drugs\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DrugRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth('admin')->check();
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'form' => 'nullable|string|max:255',
            'strength' => 'nullable|string|max:255',
            'generic_name' => 'nullable|string|max:255',
            'manufacturer' => 'nullable|string|max:255',
            'barcode' => 'nullable|string|max:255',
            'default_dosage' => 'nullable|string|max:255',
            'default_instructions' => 'nullable|string|max:1000',
            'is_active' => 'boolean',
        ];
    }
}
