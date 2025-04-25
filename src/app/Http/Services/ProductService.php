<?php

namespace App\Http\Services;

use App\Http\Repositories\ProductRepository;

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

    public function storeProduct($data,$path)
    {
        return $this->productRepository->storeProduct($data,$path);
    }

    public function updateProduct($data, $id)
    {
        $product = $this->getProductById($id);
        $this->productRepository->updateProduct($product,$data);
        return $this->getProductById($id);
    }

    public function deleteProduct($id)
    {
        $product = $this->getProductById($id);
        $this->productRepository->deleteProduct($product);
        return [
            'message' => 'Produto excluído com sucesso!'
        ];
    }
}
