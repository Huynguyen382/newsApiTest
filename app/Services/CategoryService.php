<?php

namespace App\Services;

use App\Repositories\CategoryRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use App\Models\userModel;

class CategoryService
{
    protected $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function getAllCategories()
    {
        return $this->categoryRepository->getWithArticleCount();
    }

    public function createCategory(array $data)
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'admin') {
            throw new \Exception('Bạn không có quyền thực hiện thao tác này');
        }
        return $this->categoryRepository->create($data);
    }

    public function updateCategory($id, array $data)
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'admin') {
            throw new \Exception('Bạn không có quyền thực hiện thao tác này');
        }
        return $this->categoryRepository->update($id, $data);
    }

    public function deleteCategory($id)
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'admin') {
            throw new \Exception('Bạn không có quyền thực hiện thao tác này');
        }
        
        $category = $this->categoryRepository->find($id);
        if (!$category) {
            throw new \Exception('Không tìm thấy danh mục');
        }

        if ($category->articles_count > 0) {
            throw new \Exception('Không thể xóa danh mục vì có bài viết');
        }

        return $this->categoryRepository->delete($id);
    }
} 