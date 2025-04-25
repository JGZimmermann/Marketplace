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
        return response()->json($this->cartService->getCart());
    }

    public function store()
    {
        return response()->json($this->cartService->storeCart());
    }
}
