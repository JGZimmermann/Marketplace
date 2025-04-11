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
            'description' => 'required|string',
            'price' => 'required',
            'stock' => 'required|integer',
            'category_id' => 'required|integer',
            'image_url' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ];
    }
}
