<?php

namespace App\Http\Repositories;

use App\Models\CartItem;

class CartItemRepository{
    public function __construct(protected CartRepository $cartRepository, protected ProductRepository $productRepository)
    {
    }
    public function getCartItems()
    {
        return CartItem::all()->where('cart_id',$this->cartRepository->getCart()->id);
    }

    public function getCartItemById($id)
    {
        return CartItem::all()->where('cart_id',$this->cartRepository->getCart()->id)->where('product_id', $id)->first();
    }


    public function storeItemInCart($data)
    {
        return CartItem::create([
            'product_id' => $data['product_id'],
            'quantity' => $data['quantity'],
            'unitPrice' => $this->productRepository->getProductById($data['product_id'])->price,
            'cart_id' => $this->cartRepository->getCart()->id
        ]);
    }

    public function updateQuantity($data, CartItem $cartItem)
    {
        return $cartItem->update($data);
    }

    public function removeItemFromCart(CartItem $cartItem)
    {
        return $cartItem->delete();
    }
}
