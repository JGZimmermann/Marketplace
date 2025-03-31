<?php

namespace App\Http\Repositories;

use App\Models\Category;
use Illuminate\Support\Facades\Auth;

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
        $user = Auth::user();
        if($user->role == "CLIENT"){
            return response()->json([
                'message' => 'Usuário sem permissão para a ação!'
            ]);
        } else {
            return response()->json(Category::create($data));
        }
    }

    public function updateCategory($id,$data)
    {
        $category = $this->getCategoryById($id);
        $user = Auth::user();
        if($user->role == "CLIENT"){
            return response()->json([
                'message' => 'Usuário sem permissão para a ação!'
            ]);
        } else {
            $category->update($data);
            return response()->json([
                'message' => 'Categoria atualizada com sucesso!'
            ]);
        }
    }

    public function deleteCategory($id)
    {
        $category = $this->getCategoryById($id);
        $user = Auth::user();
        if($user->role == "CLIENT"){
            return response()->json([
                'message' => 'Usuário sem permissão para a ação!'
            ]);
        } else {
            $category->delete();
            return response()->json([
                'message' => 'Categoria excluída com sucesso!'
            ]);
        }
    }
}
