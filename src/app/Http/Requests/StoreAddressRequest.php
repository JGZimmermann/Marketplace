<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAddressRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'street' => 'required|string',
            'number' => 'required|Integer',
            'zip' => 'required|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'country' => 'required|string'
        ];
    }
}
