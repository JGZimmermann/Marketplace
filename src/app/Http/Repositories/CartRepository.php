<?php

namespace App\Http\Repositories;

use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class CartRepository{
    public function storeCart()
    {
        return Cart::create([
            'user_id' => Auth::id()
        ]);
    }

    public function getCart()
    {
        return Cart::all()->where('user_id', Auth::id());
    }

    public function allCarts()
    {
        return Cart::all();
    }

}
