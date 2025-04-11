<?php

namespace App\Http\Services;

use App\Http\Repositories\CartItemRepository;
use App\Http\Repositories\ProductRepository;

class CartItemService{
    public function __construct(protected CartItemRepository $cartItemRepository, protected ProductRepository $productRepository)
    {
    }

    public function getCartItem()
    {
        return $this->cartItemRepository->getCartItems();
    }

    public function storeItemInCart($data)
    {
        if($this->verifyStock($data)){
            return $this->cartItemRepository->storeItemInCart($data);
        } else {
            return [
                'message' => 'Produto sem estoque'
            ];
        }
    }

    public function updateQuantity($data)
    {
        $cartItem = $this->cartItemRepository->getCartItemById($data['product_id']);
        if($this->verifyStock($data)){
            return $this->cartItemRepository->updateQuantity($data,$cartItem);
        } else {
            return [
                'message' => 'Produto sem estoque'
            ];
        }
    }

    public function removeItemFromCart($data)
    {
        $cartItem = $this->cartItemRepository->getCartItemById($data['product_id']);
        return $this->cartItemRepository->removeItemFromCart($cartItem);
    }

    public function clearCart()
    {
        $cartItems = $this->cartItemRepository->getCartItems();
        foreach ($cartItems as $cartItem){
            $this->cartItemRepository->removeItemFromCart($cartItem);
        }
        return response()->json([
            'message' => 'Carrinho limpo!'
        ]);
    }

    public function verifyStock($data)
    {
        $product = $this->productRepository->getProductById($data['product_id']);
        if($product->stock < $data['quantity']){
            return false;
        } else {
            return true;
        }
    }

    public function totalAmount()
    {
        $total = 0;
        $items = $this->cartItemRepository->getCartItems();
        foreach ($items as $item){
            $total += $item->unitPrice * $item->quantity;
        }
        return $total;
    }
}
