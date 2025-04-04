<?php

namespace App\Repositories;

use App\Models\CategoryModel;

class CategoryRepository implements CategoryRepositoryInterface
{
    protected $model;

    public function __construct(CategoryModel $model)
    {
        $this->model = $model;
    }

    public function getAll()
    {
        return $this->model->all();
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        $category = $this->find($id);
        if ($category) {
            $category->update($data);
            return $category;
        }
        return null;
    }

    public function delete($id)
    {
        $category = $this->find($id);
        if ($category) {
            return $category->delete();
        }
        return false;
    }

    public function getWithArticleCount()
    {
        return $this->model->withCount('articles')->get();
    }
} 