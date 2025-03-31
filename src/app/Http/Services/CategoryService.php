<?php

namespace App\Http\Services;

use App\Http\Repositories\CategoryRepository;

class CategoryService{
    public function __construct(protected CategoryRepository $categoryRepository)
    {
    }

    public function getAllCategories()
    {
        return $this->categoryRepository->getAllCategories();
    }

    public function storeCategory($data)
    {
        return $this->categoryRepository->storeCategory($data);
    }

    public function getCategoryById($id)
    {
        return $this->categoryRepository->getCategoryById($id);
    }

    public function updateCategory($id,$data)
    {
        return $this->categoryRepository->updateCategory($id,$data);
    }

    public function deleteCategory($id)
    {
        return $this->categoryRepository->deleteCategory($id);
    }
}
