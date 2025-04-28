<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateOrderRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'status' => ['required', 'string', Rule::in(['PENDING','PROCESSING','SHIPPED','COMPLETED','CANCELED'])]
        ];
    }
}
