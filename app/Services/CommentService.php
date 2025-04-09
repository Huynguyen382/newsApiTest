<?php

namespace App\Services;

use App\Repositories\CommentRepositoryInterface;
use Illuminate\Support\Facades\Log;

class CommentService implements CommentServiceInterface
{
    protected $commentRepository;

    public function __construct(CommentRepositoryInterface $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    public function getAllComments()
    {
        try {
            return $this->commentRepository->getAll();
        } catch (\Exception $e) {
            Log::error('Error getting all comments: ' . $e->getMessage());
            throw $e;
        }
    }

    public function findComment($id)
    {
        try {
            $comment = $this->commentRepository->find($id);
            if (!$comment) {
                throw new \Exception('Comment not found', 404);
            }
            return $comment;
        } catch (\Exception $e) {
            Log::error('Error finding comment: ' . $e->getMessage());
            throw $e;
        }
    }

    public function createComment(array $data)
    {
        try {
            // Set default status as pending
            $data['status'] = 'pending';
            return $this->commentRepository->create($data);
        } catch (\Exception $e) {
            Log::error('Error creating comment: ' . $e->getMessage());
            throw $e;
        }
    }

    public function updateComment($id, array $data)
    {
        try {
            $comment = $this->findComment($id);
            
            // Không cho phép thay đổi trạng thái qua update
            unset($data['status']);
            
            return $this->commentRepository->update($id, $data);
        } catch (\Exception $e) {
            Log::error('Error updating comment: ' . $e->getMessage());
            throw $e;
        }
    }

    public function deleteComment($id)
    {
        try {
            $comment = $this->findComment($id);
            return $this->commentRepository->delete($id);
        } catch (\Exception $e) {
            Log::error('Error deleting comment: ' . $e->getMessage());
            throw $e;
        }
    }

    public function getCommentsByArticle($articleId)
    {
        try {
            return $this->commentRepository->getByArticleId($articleId);
        } catch (\Exception $e) {
            Log::error('Error getting comments by article: ' . $e->getMessage());
            throw $e;
        }
    }

    public function getCommentsByUser($userId)
    {
        try {
            return $this->commentRepository->getByUserId($userId);
        } catch (\Exception $e) {
            Log::error('Error getting comments by user: ' . $e->getMessage());
            throw $e;
        }
    }

    public function approveComment($id)
    {
        try {
            $comment = $this->findComment($id);
            return $this->commentRepository->update($id, ['status' => 'approved']);
        } catch (\Exception $e) {
            Log::error('Error approving comment: ' . $e->getMessage());
            throw $e;
        }
    }

    public function rejectComment($id)
    {
        try {
            $comment = $this->findComment($id);
            return $this->commentRepository->update($id, ['status' => 'rejected']);
        } catch (\Exception $e) {
            Log::error('Error rejecting comment: ' . $e->getMessage());
            throw $e;
        }
    }
} 