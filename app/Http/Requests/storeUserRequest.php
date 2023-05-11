<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class storeUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'firstname' => 'required|string|max:60',
            'lastname' => 'required|string|max:60',
            'email' => 'required|email|max:100|unique:users,email',
            'password' => 'required|max:100|min:8',
            'description' => 'max:150',
        ];
    }
}
