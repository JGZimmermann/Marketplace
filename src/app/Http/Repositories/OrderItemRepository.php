<?php

namespace App\Http\Repositories;

use App\Models\OrderItem;

class OrderItemRepository
{
    public function createOrderItem($id, $cartItem)
    {
        OrderItem::create([
            'order_id' => $id,
            'product_id' => $cartItem->product_id,
            'quantity' => $cartItem->quantity,
            'unit_price' => $cartItem->unitPrice
        ]);
    }

    public function getAllOrderItemsByOrder($id)
    {
        return OrderItem::all()->where('order_id', $id);
    }
}
