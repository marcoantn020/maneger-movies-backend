<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'first_name'            => ['required','string', 'min:3', 'max:50'],
            'last_name'             => ['required','string', 'max:50'],
            'email'                 => ['required','email', 'max:255', 'unique:users,email'],
            'password'              => ['required','confirmed', 'min:8'],
            'phone'                 => ['required','string', 'max:25'],
            'photo'                 => ['nullable', 'image', 'max:2048'],
        ];
    }
}
