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
            return $this->cartRepository->storeCart();
        } else {
            return [
                'message' => 'Usuário já possui um carrinho'
            ];
        }
    }

    public function getCart()
    {
        return $this->cartRepository->getCart();
    }

    public function verifyCart()
    {
        if($this->cartRepository->getCart())
            return true;
        else
            return false;
    }
}
