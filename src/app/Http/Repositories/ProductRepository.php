<?php

namespace App\Http\Repositories;

use App\Models\Product;

class ProductRepository
{
    public function getAllProducts()
    {
        return Product::all();
    }

    public function getProductsByCategory($id)
    {
        return Product::all()->where('category_id', $id);
    }

    public function getProductById($id)
    {
        return Product::findOrFail($id);
    }

    public function storeProduct($data)
    {
        return Product::create($data);
    }

    public function updateProduct(Product $product,$data)
    {
        return $product->update($data);
    }

    public function deleteProduct(Product $product)
    {
        return $product->delete();
    }
}
