<?php

namespace App\Http\Repositories;

use App\Models\Category;

class CategoryRepository{
    public function getAllCategories()
    {
        return Category::all();
    }

    public function getCategoryById($id)
    {
        return Category::findOrFail($id);
    }

    public function storeCategory($data)
    {
        return Category::create($data);
    }

    public function updateCategory(Category $category,$data)
    {
        return $category->update($data);
    }

    public function deleteCategory(Category $category)
    {
        return $category->delete();
    }
}
