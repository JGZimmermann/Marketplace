<?php

namespace App\Http\Services;

use App\Http\Repositories\CategoryRepository;
use Illuminate\Support\Facades\Auth;

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
        if(Auth::user()->role != 'CLIENT'){
            return $this->categoryRepository->storeCategory($data);
        } else {
            return response()->json([
                'message' => 'Usuário não possui autorização para realizar essa ação'
            ]);
        }
    }

    public function updateCategory($id,$data)
    {
        if(Auth::user()->role != 'CLIENT'){
            $this->categoryRepository->updateCategory($this->getCategoryById($id),$data);
            return response()->json([
                'message' => 'Categoria atualizada com sucesso!'
            ]);
        } else {
            return response()->json([
                'message' => 'Usuário não possui autorização para realizar essa ação'
            ]);
        }
    }

    public function deleteCategory($id)
    {
        if(Auth::user()->role != 'CLIENT'){
            $this->categoryRepository->deleteCategory($this->getCategoryById($id));
            return response()->json([
                'message' => 'Categoria excluída com sucesso!'
            ]);
        } else {
            return response()->json([
                'message' => 'Usuário não possui autorização para realizar essa ação'
            ]);
        }
    }
}
