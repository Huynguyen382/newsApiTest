<?php

namespace App\Repositories;

interface ArticleRepositoryInterface
{
    public function getAllArticles();
    public function getArticleById($id);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
    public function getByAuthorId($authorId);
    public function getByCategoryId($categoryId);
} 