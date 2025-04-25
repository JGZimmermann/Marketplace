<?php

namespace App\Http\Services;

use App\Http\Repositories\OrderRepository;
use Illuminate\Support\Facades\Auth;

class OrderService{
    public function __construct(protected OrderRepository $orderRepository, protected OrderItemService $orderItemService, protected CartItemService $cartItemService, protected ProductService $productService, protected CouponService $couponService)
    {
    }

    public function getAllOrders()
    {
        return $this->orderRepository->getAllOrders();
    }

    public function findOrderById($id)
    {
        return $this->orderRepository->findOrderById($id);
    }

    public function storeOrder($data)
    {
        if(sizeof($this->cartItemService->getCartItem()) > 0){
            if(isset($data['coupon_id'])){
                if($this->couponService->verifyCouponDate($data['coupon_id'])){
                    $totalAmount = $this->cartItemService->totalAmount() - (($this->cartItemService->totalAmount() * $this->couponService->verifyCouponDate($data['coupon_id'])/100));
                    $order = $this->orderRepository->storeOrder($data, $data['coupon_id'],$totalAmount);
                } else{
                    $order = $this->orderRepository->storeOrder($data, $data['coupon_id'], $this->cartItemService->totalAmount());
                }
            } else{
                $order = $this->orderRepository->storeOrder($data, null, $this->cartItemService->totalAmount());
            }
            $this->orderItemService->storeOrderItem($order->id);
            $orderItems = $this->orderItemService->getAllOrderItemsByOrder($order->id);
            $this->decreaseStock($orderItems);
            $this->cartItemService->clearCart();
            return $order;
        }
        else {
            return [
                "message" => "Carrinho sem itens, adicione algum item para continuar!"
            ];
        }
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
        $orderItems = $this->orderItemService->getAllOrderItemsByOrder($order->id);
        $this->addStock($orderItems);
        return $this->orderRepository->updateOrder([
            'status' => 'CANCELED'
        ], $order);
    }

    public function updateOrder($data, $id)
    {
        $order = $this->orderRepository->findOrderById($id);
        $this->orderRepository->updateOrder($data, $order);
        return $this->orderRepository->findOrderById($id);
    }
}
