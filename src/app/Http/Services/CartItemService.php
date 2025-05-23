<?php

namespace App\Http\Services;

use App\Http\Repositories\CartItemRepository;
use App\Http\Repositories\ProductRepository;

class CartItemService{
    public function __construct(protected CartItemRepository $cartItemRepository, protected ProductRepository $productRepository, protected DiscountService $discountService)
    {
    }

    public function getCartItem()
    {
        return $this->cartItemRepository->getCartItems();
    }

    public function storeItemInCart($data)
    {
        if($this->cartItemRepository->getCartItemById($data['product_id'])){
            $quantity = $this->cartItemRepository->getCartItemById($data['product_id'])->quantity;
            $data['quantity'] = $data['quantity'] + $quantity;
            $this->updateQuantity($data);
        } else {
            if ($this->verifyStock($data)) {
                return $this->cartItemRepository->storeItemInCart($data);
            } else {
                return [
                    'message' => 'Produto sem estoque'
                ];
            }
        }
    }

    public function updateQuantity($data)
    {
        $cartItem = $this->cartItemRepository->getCartItemById($data['product_id']);
        if($this->verifyStock($data)){
            $this->cartItemRepository->updateQuantity($data,$cartItem);
            return $this->cartItemRepository->getCartItemById($data['product_id']);
        } else {
            return [
                'message' => 'Produto sem estoque'
            ];
        }
    }

    public function removeItemFromCart($data)
    {
        $cartItem = $this->cartItemRepository->getCartItemById($data['product_id']);
        $this->cartItemRepository->removeItemFromCart($cartItem);
        return [
            'message' => 'Item removido!'
        ];
    }

    public function clearCart()
    {
        $cartItems = $this->cartItemRepository->getCartItems();
        foreach ($cartItems as $cartItem){
            $this->cartItemRepository->removeItemFromCart($cartItem);
        }
        return [
            'message' => 'Carrinho limpo!'
        ];
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
            $discounts = $this->discountService->getDiscountsByProduct($item->product_id);
            foreach ($discounts as $discount){
                if($this->discountService->verifyDiscount($discount->id)){
                    $item->unitPrice = $item->unitPrice - (($item->unitPrice * $discount->discountPercentage)/100);
                }
            }
            $total += $item->unitPrice * $item->quantity;
        }
        return $total;
    }
}
