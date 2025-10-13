<?php

namespace App\Domains\Drugs\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DrugImportRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth('admin')->check();
    }

    public function rules(): array
    {
        return [
            'file' => 'required|mimes:xlsx,xls,csv|max:2048',
        ];
    }
}
