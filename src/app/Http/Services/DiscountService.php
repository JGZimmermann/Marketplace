<?php

namespace App\Http\Services;

use App\Http\Repositories\DiscountRepository;
use Carbon\Carbon;

class DiscountService{
    public function __construct(protected DiscountRepository $discountRepository)
    {
    }

    public function getAllDiscounts()
    {
        return $this->discountRepository->getAllDiscounts();
    }

    public function getDiscountById($id)
    {
        return $this->discountRepository->getDiscountById($id);
    }

    public function getDiscountsByProduct($id)
    {
        return $this->discountRepository->getDiscountByProduct($id);
    }

    public function storeDiscount($data)
    {
        return $this->discountRepository->storeDiscount($data);
    }

    public function updateDiscount($data,$id)
    {
        return $this->discountRepository->updateDiscount($data, $this->getDiscountById($id));
    }

    public function deleteDiscount($id)
    {
        return $this->discountRepository->deleteDiscount($this->getDiscountById($id));
    }

    public function verifyDiscount($id)
    {
        $discount = $this->getDiscountById($id);
        $startDate = Carbon::parse($discount->startDate);
        $endDate = Carbon::parse($discount->endDate);
        $currentDate = Carbon::now();

        if($currentDate->between($startDate,$endDate)){
            return $discount->discountPercentage;
        } else {
            return false;
        }
    }
}
