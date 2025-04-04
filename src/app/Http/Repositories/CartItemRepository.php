<?php

namespace App\Http\Repositories;

use App\Models\CartItem;
use App\Http\Repositories\CartRepository;

class CartItemRepository{
    public function __construct(protected CartRepository $cartRepository)
    {
    }
    public function getCartItems()
    {
        return CartItem::all()->where('cart_id',$this->cartRepository->getCart()->id);
    }

    public function storeItemInCart($data)
    {
        return CartItem::create([
            'product_id' => $data['product_id'],
            'quantity' => $data['quantity'],
            'unit_price' => $data['unit_price'],
            'cart_id' => $this->cartRepository->getCart()->id
        ]);
    }
}
