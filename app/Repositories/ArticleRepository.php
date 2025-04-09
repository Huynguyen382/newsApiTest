<?php

namespace App\Repositories;

use App\Models\ArticleModel;

class ArticleRepository implements ArticleRepositoryInterface
{
    protected $model;

    public function __construct(ArticleModel $model)
    {
        $this->model = $model;
    }

    public function getAllArticles()
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
        $article = $this->model->find($id);
        if ($article) {
            $article->update($data);
        }
        return $article;
    }

    public function delete($id)
    {
        $article = $this->model->find($id);
        if ($article) {
            return $article->delete();
        }
        return false;
    }

    public function getByCategoryId($categoryId)
    {
        return $this->model->where('category_id', $categoryId)->get();
    }

    public function getByAuthorId($authorId)
    {
        return $this->model->where('user_id', $authorId)->get();
    }
    public function getArticleById($id)
    {
        return $this->model->find($id);
    }
} 