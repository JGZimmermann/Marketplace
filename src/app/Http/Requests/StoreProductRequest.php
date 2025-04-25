<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'price' => 'required|numeric|min:1',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|integer|min:1',
            'image_url' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ];
    }
}
