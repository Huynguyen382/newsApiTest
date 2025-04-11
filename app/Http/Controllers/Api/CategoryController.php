<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCategoryRequest;
use App\Services\CategoryServiceInterface;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\CategoryModel;


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
        $this->authorize('viewAny', CategoryModel::class);
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
        $this->authorize('create', CategoryModel::class);
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
        $this->authorize('update', CategoryModel::class);
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
        $this->authorize('delete', CategoryModel::class);
        $this->categoryService->deleteCategory($id);
        return response()->json(['message' => 'Category deleted successfully'], 200);
    }
}
