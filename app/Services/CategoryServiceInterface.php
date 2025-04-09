<?php

namespace App\Services;

interface CategoryServiceInterface
{
    /**
     * Get all categories
     *
     * @return \Illuminate\Database\Eloquent\Collection
     * @throws \Exception
     */
    public function getAllCategories();

    /**
     * Find a category by ID
     *
     * @param int $id
     * @return \App\Models\CategoryModel
     * @throws \Exception
     */
    public function findCategory($id);

    /**
     * Create a new category
     *
     * @param array $data
     * @return \App\Models\CategoryModel
     * @throws \Exception
     */
    public function createCategory(array $data);

    /**
     * Update a category
     *
     * @param int $id
     * @param array $data
     * @return \App\Models\CategoryModel
     * @throws \Exception
     */
    public function updateCategory($id, array $data);

    /**
     * Delete a category
     *
     * @param int $id
     * @return bool
     * @throws \Exception
     */
    public function deleteCategory($id);
} 