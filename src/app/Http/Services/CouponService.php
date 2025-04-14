<?php

namespace App\Http\Services;

use App\Http\Repositories\CouponRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

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
        if(Auth::user()->role == 'ADMIN'){
            return response()->json($this->couponRepository->storeCoupon($data), 201);
        } else{
            return response()->json([
                'message' => 'Usuário não possui autorização para realizar essa ação'
            ]);
        }
    }

    public function updateCoupon($data, $id)
    {
        if(Auth::user()->role == 'ADMIN'){
            $this->couponRepository->updateCoupon($this->getCouponById($id),$data);
            return response()->json([
                'message' => 'Cupom atualizado com sucesso!'
            ]);
        } else{
            return response()->json([
                'message' => 'Usuário não possui autorização para realizar essa ação'
            ]);
        }
    }

    public function deleteCoupon($id)
    {
        if(Auth::user()->role == 'ADMIN'){
            $this->couponRepository->deleteCoupon($this->getCouponById($id));
            return response()->json([
                'message' => 'Cupom excluído com sucesso!'
            ], 204);
        } else{
            return response()->json([
                'message' => 'Usuário não possui autorização para realizar essa ação'
            ]);
        }
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
