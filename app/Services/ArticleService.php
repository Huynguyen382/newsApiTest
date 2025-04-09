<?php

namespace App\Services;

use App\Repositories\ArticleRepositoryInterface;
use App\Services\ArticleServiceInterface;

class ArticleService implements ArticleServiceInterface 
{
    protected $articleRepository;

    /**
     * Constructor for ArticleService
     * 
     * @param ArticleRepositoryInterface $articleRepository
     */
    public function __construct(ArticleRepositoryInterface $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    /**
     * Get all articles
     * 
     * @return \Illuminate\Database\Eloquent\Collection
     */     
    public function getAllArticles()
    {
        return $this->articleRepository->getAllArticles();
    }

    /**
     * Find an article by ID
     * 
     * @param int $id
     * @return \App\Models\ArticleModel
     */ 
    public function getArticleById($id)
    {
        return $this->articleRepository->getArticleById($id);
    }

    /**
     * Create a new article
     * 
     * @param array $data
     * @param int $userId
     * @return \App\Models\ArticleModel  
     */
    public function createArticle(array $data, $userId)
    {
        if (!$this->canManageArticle($userId, $data['role'])) {
            throw new \Exception('Bạn không có quyền tạo bài viết.', 401);
        }

        $data['user_id'] = $userId;
        return $this->articleRepository->create($data); 
    }

    /**
     * Update an article
     * 
     * @param int $id
     * @param array $data
     * @param int $userId   
     * @return \App\Models\ArticleModel
     */
    public function updateArticle($id, array $data, $userId)
    {
        $this->getArticleById($id);
            
        if (!$this->canManageArticle($userId, $data['role'])) {
            throw new \Exception('Bạn không có quyền cập nhật bài viết.', 401);
        }

        return $this->articleRepository->update($id, $data);
    }

    /**
     * Delete an article
     * 
     * @param int $id
     * @param int $userId
     * @return bool 
     */
    public function deleteArticle($id, $userId)
    {
       $this->getArticleById($id);
            
        if (!$this->canManageArticle($userId, 'admin')) {
            throw new \Exception('Chỉ quản trị viên mới có quyền xóa bài viết.', 401);
        }

        return $this->articleRepository->delete($id);
    }

    /**
     * Get articles by category ID
     * 
     * @param int $categoryId
     * @return \Illuminate\Database\Eloquent\Collection
     */ 
    public function getArticlesByCategory($categoryId)
    {
        return $this->articleRepository->getByCategoryId($categoryId);
    }

    /**
     * Get articles by author ID
     * 
     * @param int $authorId
     * @return \Illuminate\Database\Eloquent\Collection
     */  
    public function getArticlesByAuthor($authorId)
    {
        return $this->articleRepository->getByAuthorId($authorId);
    }

    /**
     * Check if user can manage article
     * 
     * @param int $userId
     * @param string $userRole
     * @return bool
     */
    public function canManageArticle($userId, $userRole)
    {
        return in_array($userRole, ['admin', 'author']);
    }
    
    public function getByCategoryId($categoryId)
    {
        return $this->articleRepository->getByCategoryId($categoryId);
    }

} 