<?php

namespace App\Http\Services;

use App\Http\Repositories\CartRepository;
use Illuminate\Support\Facades\Auth;

class CartService{
    public function __construct(protected CartRepository $cartRepository)
    {
    }

    public function storeCart()
    {
        if(!$this->verifyCart()){
            return response()->json($this->cartRepository->storeCart());
        } else {
            return response()->json([
                'message' => 'Usuário já possui um carrinho'
            ]);
        }
    }

    public function getCart()
    {
        return response()->json($this->cartRepository->getCart());
    }

    public function verifyCart()
    {
        $carts = $this->cartRepository->allCarts();
        $bool = false;
        foreach ($carts as $cart){
            if($cart->user_id == Auth::id()){
                $bool = true;
            } else{
                $bool = false;
            }
        }
        return $bool;
    }
}
