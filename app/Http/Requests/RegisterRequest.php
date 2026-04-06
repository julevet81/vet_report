<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', 'min:8'],
            'veterinary_authority_number' => ['required', 'string', 'max:100', 'unique:users,veterinary_authority_number'],
            'wilaya' => ['nullable', 'string', 'max:150'],
            'branch_id' => ['required', 'exists:branches,id'],
            'role' => ['required', Rule::in(['private_vet', 'branch_manager', 'wilaya_inspector'])],
            'preferred_locale' => ['required', Rule::in(['ar', 'fr'])],
        ];
    }
}