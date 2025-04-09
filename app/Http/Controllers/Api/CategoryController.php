<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCategoryRequest;
use App\Services\CategoryServiceInterface;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\CategoryModel;
use Illuminate\Support\Facades\Auth;

/**
 * @group Category Management
 * 
 * APIs for managing categories
 */
class CategoryController extends Controller
{
    protected $categoryService;

    public function __construct(CategoryServiceInterface $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /**
     * Get all categories
     *
     * @return JsonResponse
     */
    public function getAllCategories(): JsonResponse
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        
        $categories = $this->categoryService->getAllCategories();
        return response()->json($categories, 200);
    }

    /**
     * Create a new category
     *
     * @param CreateCategoryRequest $request
     * @return JsonResponse
     */
    public function createCategory(CreateCategoryRequest $request): JsonResponse
    {
        if (!Auth::check() || !Auth::user()->hasAnyRole([userModel::ROLE_ADMIN, userModel::ROLE_AUTHOR])) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        
        $category = $this->categoryService->createCategory($request->all());
        return response()->json($category, 201);
    }

    /**
     * Update a category
     *
     * @param CreateCategoryRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function updateCategory(UpdateCategoryRequest $request, $id): JsonResponse
    {
        if (!Auth::check() || !Auth::user()->hasAnyRole([userModel::ROLE_ADMIN, userModel::ROLE_AUTHOR])) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        
        $category = $this->categoryService->updateCategory($id, $request->all());
        return response()->json($category, 200);
    }

    /**
     * Delete a category
     *
     * @param int $id
     * @return JsonResponse
     */
    public function deleteCategory($id): JsonResponse
    {
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        
        $this->categoryService->deleteCategory($id);
        return response()->json(['message' => 'Category deleted successfully'], 200);
    }
}
