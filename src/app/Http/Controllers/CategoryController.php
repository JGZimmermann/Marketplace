<?php

namespace App\Http\Controllers;

use App\Http\Services\CategoryService;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;

class CategoryController extends Controller
{
    public function __construct(protected CategoryService $categoryService)
    {
    }

    public function index()
    {
        return response()->json($this->categoryService->getAllCategories());
    }

    public function show($id)
    {
        return response()->json($this->categoryService->getCategoryById($id));
    }

    public function delete($id)
    {
        return response()->json($this->categoryService->deleteCategory($id),204);
    }

    public function store(StoreCategoryRequest $request)
    {
        return response()->json($this->categoryService->storeCategory($request->validated()),201);
    }

    public function update(UpdateCategoryRequest $request, $id)
    {
        return response()->json($this->categoryService->updateCategory($id,$request->validated()));
    }
}
