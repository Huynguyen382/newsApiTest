<?php

namespace App\Services;

interface ArticleServiceInterface
{
    public function getAllArticles();
    public function getArticleById($id);
    public function createArticle(array $data, $userId);
    public function updateArticle($id, array $data, $userId);
    public function deleteArticle($id, $userId);
    public function getArticlesByCategory($categoryId);
    public function getArticlesByAuthor($authorId);
    public function canManageArticle($userId, $userRole);
    public function getByCategoryId($categoryId);
}
