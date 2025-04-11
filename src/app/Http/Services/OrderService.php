<?php

namespace App\Http\Services;

use App\Http\Repositories\OrderRepository;
use Illuminate\Support\Facades\Auth;

class OrderService{
    public function __construct(protected OrderRepository $orderRepository, protected OrderItemService $orderItemService, protected CartItemService $cartItemService, protected ProductService $productService)
    {
    }

    public function getAllOrders()
    {
        return $this->orderRepository->getAllOrders();
    }

    public function findOrderById($id)
    {
        $order = $this->orderRepository->findOrderById($id);
        if($order->user_id == Auth::id() || Auth::user()->role == 'ADMIN' || Auth::user()->role == 'MODERATOR'){
            return $order;
        } else {
            return [
                'message' => 'Usuário sem acesso!'
            ];
        }
    }

    public function storeOrder($data)
    {
        $order = $this->orderRepository->storeOrder($data);
        $this->orderItemService->storeOrderItem($order->id);
        $orderItems = $this->orderItemService->getAllOrderItemsByOrder($order->id);
        $this->decreaseStock($orderItems);
        $this->cartItemService->clearCart();
        return $order;
    }

    public function decreaseStock($orderItems)
    {
        foreach ($orderItems as $orderItem){
            $quantity = $orderItem->quantity;
            $stock = $this->productService->getProductById($orderItem->product_id);
            $this->productService->updateProduct([
                'stock' => $stock->stock - $quantity
            ],$stock->id);
        }
    }

    public function addStock($orderItems)
    {
        foreach ($orderItems as $orderItem){
            $quantity = $orderItem->quantity;
            $stock = $this->productService->getProductById($orderItem->product_id);
            $this->productService->updateProduct([
                'stock' => $stock->stock + $quantity
            ],$stock->id);
        }
    }

    public function cancelOrder($id)
    {
        $order = $this->orderRepository->findOrderById($id);
        if($order->user_id == Auth::id() || Auth::user()->role == 'ADMIN' || Auth::user()->role == 'MODERATOR'){
            $orderItems = $this->orderItemService->getAllOrderItemsByOrder($order->id);
            $this->addStock($orderItems);
            return $this->orderRepository->updateOrder([
                'status' => 'CANCELED'
            ], $order);
        } else {
            return [
                'message' => 'Usuário sem acesso!'
            ];
        }
    }

    public function updateOrder($data, $id)
    {
        $order = $this->orderRepository->findOrderById($id);
        if(Auth::user()->role == 'ADMIN' || Auth::user()->role == 'MODERATOR'){
            return $this->orderRepository->updateOrder($data, $order);
        } else {
            return [
                'message' => 'Usuário sem acesso!'
            ];
        }
    }
}
