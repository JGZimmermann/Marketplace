<?php

namespace App\Http\Services;

use App\Http\Repositories\ProductRepository;
use Illuminate\Support\Facades\Auth;

class ProductService{
    public function __construct(protected ProductRepository $productRepository)
    {
    }

    public function getAllProducts()
    {
        return $this->productRepository->getAllProducts();
    }

    public function getProductByCategory($id)
    {
        return $this->productRepository->getProductsByCategory($id);
    }

    public function getProductById($id)
    {
        return $this->productRepository->getProductById($id);
    }

    public function storeProduct($data)
    {
        if(Auth::user()->role == 'CLIENT'){
            return response()->json([
                'message' => 'Acesso não autorizado!'
            ]);
        } else {
            return response()->json($this->productRepository->storeProduct($data));
        }
    }

    public function updateProduct($data, $id)
    {
        $product = $this->getProductById($id);
        if(Auth::user()->role == 'CLIENT'){
            return response()->json([
                'message' => 'Acesso não autorizado!'
            ]);
        } else {
            $this->productRepository->updateProduct($product,$data);
            return response()->json([
                'message' => 'Produto atualizado com sucesso!'
            ]);
        }
    }

    public function deleteProduct($id)
    {
        if(Auth::user()->role == 'CLIENT'){
            return response()->json([
                'message' => 'Acesso não autorizado!'
            ]);
        } else {
            $product = $this->getProductById($id);
            $this->productRepository->deleteProduct($product);
            return response()->json([
                'message' => 'Produto excluído com sucesso!'
            ]);
        }
    }
}
