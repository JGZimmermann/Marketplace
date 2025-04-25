<?php

namespace App\Http\Controllers;

use App\Http\Services\ProductService;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Requests\UpdateStockRequest;

class ProductController extends Controller
{
    public function __construct(protected ProductService $productService)
    {
    }

    public function index()
    {
        return response()->json($this->productService->getAllProducts());
    }

    public function show($id){
        return response()->json($this->productService->getProductById($id));
    }

    public function showByCategory($id){
        return response()->json($this->productService->getProductByCategory($id));
    }

    public function delete($id)
    {
        return response()->json($this->productService->deleteProduct($id),204);
    }

    public function store(StoreProductRequest $request)
    {
        $path = $request->file('image_url')->store('photos','public');
        return response()->json($this->productService->storeProduct($request->validated(),asset('storage/' . $path)),201);
    }

    public function update(UpdateProductRequest $request, $id)
    {
        return response()->json($this->productService->updateProduct($request->validated(),$id));
    }

    public function updateStock(UpdateStockRequest $request, $id)
    {
        return response()->json($this->productService->updateProduct($request->validated(),$id));
    }
}
