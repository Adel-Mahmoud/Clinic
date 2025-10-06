<?php

namespace App\Domains\Roles\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; 
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|unique:roles,name,' . $this->route('role'),
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,name',
        ];
    }
}
