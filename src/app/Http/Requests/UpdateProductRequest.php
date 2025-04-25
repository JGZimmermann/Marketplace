<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'sometimes|string',
            'price' => 'sometimes|min:1',
            'category_id' => 'sometimes|integer|min:1',
            'stock' => 'prohibited'
        ];
    }
}
