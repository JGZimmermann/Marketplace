<?php

namespace App\Http\Services;

use App\Http\Repositories\CartItemRepository;
use App\Http\Repositories\OrderItemRepository;

class OrderItemService{
    public function __construct(protected OrderItemRepository $orderItemRepository, protected CartItemRepository $cartItemRepository)
    {
    }

    public function storeOrderItem($id)
    {
        $cartItems = $this->cartItemRepository->getCartItems();
        foreach ($cartItems as $cartItem){
            $this->orderItemRepository->createOrderItem($id,$cartItem);
        }
    }

    public function getAllOrderItemsByOrder($id)
    {
        return $this->orderItemRepository->getAllOrderItemsByOrder($id);
    }
}
