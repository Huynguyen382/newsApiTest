<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCategoryRequest;
use App\Services\CategoryService;
use Illuminate\Support\Facades\Response;

/**
 * @group Category Management
 * 
 * APIs for managing categories
 */
class CategoryController extends Controller
{
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function getAllCategories()
    {
        $categories = $this->categoryService->getAllCategories();
        return Response::json($categories, 200);
    }

    public function createCategory(CreateCategoryRequest $request)
    {
        try {
            $category = $this->categoryService->createCategory($request->validated());
            return Response::json($category, 201);
        } catch (\Exception $e) {
            return Response::json(['error' => $e->getMessage()], 403);
        }
    }

    public function updateCategory(CreateCategoryRequest $request, $id)
    {
        try {
            $category = $this->categoryService->updateCategory($id, $request->validated());
            if (!$category) {
                return Response::json(['error' => 'Không tìm thấy danh mục'], 404);
            }
            return Response::json($category, 200);
        } catch (\Exception $e) {
            return Response::json(['error' => $e->getMessage()], 403);
        }
    }

    public function deleteCategory($id)
    {
        try {
            $result = $this->categoryService->deleteCategory($id);
            if (!$result) {
                return Response::json(['error' => 'Không tìm thấy danh mục'], 404);
            }
            return Response::json(['message' => 'Xóa danh mục thành công'], 200);
        } catch (\Exception $e) {
            return Response::json(['error' => $e->getMessage()], 400);
        }
    }
}
