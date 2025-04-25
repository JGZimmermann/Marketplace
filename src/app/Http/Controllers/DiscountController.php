<?php

namespace App\Http\Controllers;

use App\Http\Services\DiscountService;
use App\Http\Requests\StoreDiscountRequest;
use App\Http\Requests\UpdateDiscountRequest;

class DiscountController extends Controller
{
    public function __construct(protected DiscountService $discountService)
    {
    }

    public function index()
    {
        return response()->json($this->discountService->getAllDiscounts());
    }

    public function show($id)
    {
        return response()->json($this->discountService->getDiscountById($id));
    }

    public function store(StoreDiscountRequest $request)
    {
        return response()->json($this->discountService->storeDiscount($request->validated()),201);
    }

    public function update(UpdateDiscountRequest $request, $id)
    {
        return response()->json($this->discountService->updateDiscount($request->validated(),$id));
    }

    public function delete($id)
    {
        return response()->json($this->discountService->deleteDiscount($id),204);
    }
}
