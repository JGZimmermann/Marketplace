<?php

namespace App\Http\Repositories;

use App\Models\Discount;

class DiscountRepository{
    public function getAllDiscounts()
    {
        return Discount::all();
    }

    public function getDiscountById($id)
    {
        return Discount::findOrFail($id);
    }

    public function getDiscountByProduct($id)
    {
        return Discount::all()->where('product_id', $id);
    }

    public function storeDiscount($data)
    {
        return Discount::create($data);
    }

    public function updateDiscount($data,Discount $discount)
    {
        return $discount->update($data);
    }

    public function deleteDiscount(Discount $discount)
    {
        return $discount->delete();
    }
}
