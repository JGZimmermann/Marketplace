<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCouponRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            'code' => 'sometimes|string',
            'startDate' => 'sometimes|date|date_format:Y-m-d|after:yesterday',
            'endDate' => 'sometimes|date|date_format:Y-m-d|after:startDate',
            'discountPercentage' => 'sometimes|numeric|min:1|max:100'
        ];
    }
}
