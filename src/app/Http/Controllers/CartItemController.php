<?php

namespace App\Http\Controllers;

use App\Http\Services\CartItemService;
use App\Http\Requests\StoreCartItemRequest;
use App\Http\Requests\UpdateCartItemRequest;
use App\Http\Requests\DeleteCartItemRequest;

class CartItemController extends Controller
{
    public function __construct(protected CartItemService $cartItemService)
    {
    }

    public function index()
    {
        return $this->cartItemService->getCartItem();
    }

    public function store(StoreCartItemRequest $request)
    {
        return response(204)->json($this->cartItemService->storeItemInCart($request->validated()));
    }

    public function update(UpdateCartItemRequest $request)
    {
        return response(204)->json($this->cartItemService->updateQuantity($request->validated()));
    }

    public function delete(DeleteCartItemRequest $request)
    {
        return response(204)->json($this->cartItemService->removeItemFromCart($request->validated()));
    }

    public function clear()
    {
        $this->cartItemService->clearCart();
        return response(204);
    }
}
