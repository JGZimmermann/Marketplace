<?php

namespace App\Http\Repositories;

use App\Http\Services\CartItemService;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderRepository {
    public function __construct(protected AddressRepository $addressRepository, protected CartItemService $cartItemService)
    {
    }
    public function getAllOrders()
    {
        return Order::all()->where("user_id",Auth::id());
    }

    public function findOrderById($id)
    {
        return Order::findOrFail($id);
    }

    public function storeOrder($data, $coupon, $totalAmount)
    {
        return Order::create([
            'user_id' => Auth::id(),
            'address_id' => $data['address_id'],
            'coupon_id' => $coupon,
            'orderDate' => date('Y-m-d H:i:s'),
            'status' => 'PENDING',
            'totalAmount' => $totalAmount
        ]);
    }

    public function updateOrder($data, Order $order)
    {
        return $order->update($data);
    }
}
