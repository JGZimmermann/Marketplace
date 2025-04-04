<?php

namespace App\Http\Controllers;

use App\Http\Services\CartService;

class CartController extends Controller
{
    public function __construct(protected CartService $cartService)
    {
    }

    public function index()
    {
        return $this->cartService->getCart();
    }

    public function store()
    {
        return $this->cartService->storeCart();
    }
}
