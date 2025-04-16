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

    public function getCategoryById($id)
    {
        return $this->categoryRepository->getCategoryById($id);
    }

    public function storeCategory($data)
    {
        return $this->categoryRepository->storeCategory($data);
    }

    public function updateCategory($id,$data)
    {
        $this->categoryRepository->updateCategory($this->getCategoryById($id),$data);
        return response()->json([
            'message' => 'Categoria atualizada com sucesso!'
        ]);
    }

    public function deleteCategory($id)
    {
        $this->categoryRepository->deleteCategory($this->getCategoryById($id));
        return response()->json([
            'message' => 'Categoria excluída com sucesso!'
        ]);
    }
}
