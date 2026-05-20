<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEnvironmentalLogRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'batch_number' => [
                'required',
                'string',
                'max:255',
                'unique:environmental_logs,batch_number',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'batch_number.unique' => 'This batch number has already been logged.',
        ];
    }
}
