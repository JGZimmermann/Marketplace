<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCouponRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'code' => 'required|string',
            'startDate' => 'required|date|date_format:Y-m-d|after:yesterday',
            'endDate' => 'required|date|date_format:Y-m-d|after:startDate',
            'discountPercentage' => 'required'
        ];
    }
}
