<?php

namespace App\Http\Repositories;

use App\Models\Coupon;

class CouponRepository{
    public function getAllCoupons()
    {
        return Coupon::all();
    }

    public function getCouponById($id)
    {
        return Coupon::findOrFail($id);
    }

    public function storeCoupon($data)
    {
        return Coupon::create($data);
    }

    public function updateCoupon(Coupon $coupon, $data)
    {
        return $coupon->update($data);
    }

    public function deleteCoupon(Coupon $coupon)
    {
        $coupon->delete();
    }
}
