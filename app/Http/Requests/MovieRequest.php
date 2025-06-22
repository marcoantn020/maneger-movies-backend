<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MovieRequest extends FormRequest
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
        $base = [
            'title'      => ['string', 'max:255', 'unique:movies,title'],
            'year'       => ['integer', 'digits:4', 'between:1888,2100'],
            'genre'      => ['string', 'max:50'],
            'synopsis'   => ['string'],
            'poster_url' => ['nullable', 'url', 'max:255'],
        ];

        return collect($base)->mapWithKeys(function ($rules, $field) {
            if ($field === 'poster_url') {
                return [$field => $rules];
            }

            $prefix = $this->isMethod('post') ? 'required' : 'sometimes';
            return [$field => array_merge([$prefix], $rules)];
        })->toArray();
    }
}
