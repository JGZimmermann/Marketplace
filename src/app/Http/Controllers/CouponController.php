<?php

namespace App\Http\Controllers;

use App\Http\Services\CouponService;
use App\Http\Requests\StoreCouponRequest;
use App\Http\Requests\UpdateCouponRequest;

class CouponController extends Controller
{
    public function __construct(protected CouponService $couponService)
    {
    }

    public function index()
    {
        return response()->json($this->couponService->getAllCoupons());
    }

    public function show($id)
    {
        return response()->json($this->couponService->getCouponById($id));
    }

    public function store(StoreCouponRequest $request)
    {
        return $this->couponService->storeCoupon($request->validated());
    }

    public function update(UpdateCouponRequest $request, $id)
    {
        return $this->couponService->updateCoupon($request->validated(),$id);
    }

    public function delete($id)
    {
        return $this->couponService->deleteCoupon($id);
    }
}
