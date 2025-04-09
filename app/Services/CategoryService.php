<?php

namespace App\Services;

use App\Repositories\CategoryRepositoryInterface;

class CategoryService implements CategoryServiceInterface
{
    protected $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Get all categories
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllCategories()
    {
        return $this->categoryRepository->getAll();
    }

    /**
     * Find a category by ID
     *
     * @param int $id
     * @return \App\Models\CategoryModel
     */
    
    public function findCategory($id)
    {
        return $this->categoryRepository->find($id);
    }

    /**
     * Create a new category
     *
     * @param array $data
     * @return \App\Models\CategoryModel
     */
    public function createCategory(array $data)
    {
        if ($this->categoryRepository->findByUrlKey($data['url_key'])) {
            throw new \Exception('URL key đã tồn tại.', 422);
        }

        return $this->categoryRepository->create($data);
    }

    /**
     * Update a category
     *
     * @param int $id
     * @param array $data
     * @return \App\Models\CategoryModel
     */
    public function updateCategory($id, array $data)
    {
        $this->categoryRepository->find($id);

        $existingCategory = $this->categoryRepository->findByUrlKey($data['url_key']);
        if ($existingCategory && $existingCategory->id !== $id) {
            throw new \Exception('URL key đã tồn tại.', 422);
        }

        return $this->categoryRepository->update($id, $data);
    }

    /**
     * Delete a category
     *
     * @param int $id
     * @return bool
     */
    public function deleteCategory($id)
    {
        $category = $this->findCategory($id);

        if ($category->articles()->count() > 0) {
            throw new \Exception('Không thể xóa danh mục có bài viết', 422);
        }

        return $this->categoryRepository->delete($id);
    }

} 