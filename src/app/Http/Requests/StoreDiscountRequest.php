<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDiscountRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'description' => 'required|string',
            'startDate' => 'required|date|date_format:Y-m-d|after:yesterday',
            'endDate' => 'required|date|date_format:Y-m-d|after:startDate',
            'discountPercentage' => 'required|numeric|min:1|max:100',
            'product_id' => 'required|integer'
        ];
    }
}
