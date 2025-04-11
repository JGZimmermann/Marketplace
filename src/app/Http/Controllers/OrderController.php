<?php

namespace App\Http\Controllers;

use App\Http\Services\OrderService;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;

class OrderController extends Controller
{
    public function __construct(protected OrderService $orderService)
    {
    }

    public function index()
    {
        return response()->json($this->orderService->getAllOrders());
    }

    public function show($id)
    {
        return response()->json($this->orderService->findOrderById($id));
    }

    public function store(StoreOrderRequest $request)
    {
        return response(201)->json($this->orderService->storeOrder($request->validated()));
    }

    public function update(UpdateOrderRequest $request ,$id)
    {
        return response()->json($this->orderService->updateOrder($request->validated(),$id));
    }

    public function cancel($id)
    {
        return response(204)->json($this->orderService->cancelOrder($id));
    }
}
