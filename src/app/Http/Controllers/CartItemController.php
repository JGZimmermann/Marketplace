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
        return response()->json($this->cartItemService->getCartItem());
    }

    public function store(StoreCartItemRequest $request)
    {
        return response()->json($this->cartItemService->storeItemInCart($request->validated()), 204);
    }

    public function update(UpdateCartItemRequest $request)
    {
        return response()->json($this->cartItemService->updateQuantity($request->validated()), 200);
    }

    public function delete(DeleteCartItemRequest $request)
    {
        return response()->json($this->cartItemService->removeItemFromCart($request->validated()), 204);
    }

    public function clear()
    {
        return response()->json($this->cartItemService->clearCart(),204);
    }
}
