<?php

namespace App\Http\Services;

use App\Http\Repositories\CouponRepository;
use Carbon\Carbon;

class CouponService{
    public function __construct(protected CouponRepository $couponRepository)
    {
    }

    public function getAllCoupons()
    {
        return $this->couponRepository->getAllCoupons();
    }

    public function getCouponById($id)
    {
        return $this->couponRepository->getCouponById($id);
    }

    public function storeCoupon($data)
    {
        return $this->couponRepository->storeCoupon($data);
    }

    public function updateCoupon($data, $id)
    {
        $this->couponRepository->updateCoupon($this->getCouponById($id),$data);
        return response()->json([
            'message' => 'Cupom atualizado com sucesso!'
        ]);
    }

    public function deleteCoupon($id)
    {
        $this->couponRepository->deleteCoupon($this->getCouponById($id));
        return response()->json([
            'message' => 'Cupom excluído com sucesso!'
        ], 204);
    }

    public function verifyCouponDate($id)
    {
        $coupon = $this->couponRepository->getCouponById($id);
        $startDate = Carbon::parse($coupon->StartDate);
        $endDate = Carbon::parse($coupon->endDate);
        $currentDate = Carbon::now();

        if($currentDate->between($startDate,$endDate)){
            return $coupon->discountPercentage;
        } else {
            return false;
        }
    }
}
