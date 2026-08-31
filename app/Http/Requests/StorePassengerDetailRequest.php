<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Override;

class StorePassengerDetailRequest extends FormRequest
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
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'passenger' => 'required|array|min:1',
            'passenger.*.name' => 'required',
            'passenger.*.date_of_birth' => 'required',
            'passenger.*.nationality' => 'required',
        ];
    }

    public function attributes(): array
    {
        return [
            'passenger.*.name' => 'name',
            'passenger.*.date_of_birth' => 'date of birth',
            'passenger.*.nationality' => 'nationality',
        ];
    }

    public function messages(): array
    {
        return [
            'passenger.*.name.required' => ':attribute is required',
            'passenger.*.date_of_birth.required' => ':attribute is required',
            'passenger.*.nationality.required' => ':attribute is required',
        ];
    }
}
