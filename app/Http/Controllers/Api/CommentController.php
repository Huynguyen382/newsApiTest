<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Services\CommentServiceInterface;
use Illuminate\Support\Facades\Response;
use App\Http\Requests\CreateCommentRequest;
use Illuminate\Support\Facades\Log;

/**
 * @group Comment Management
 * 
 * APIs for managing comments
 */
class CommentController extends Controller
{
    protected $commentService;

    public function __construct(CommentServiceInterface $commentService)
    {
        $this->commentService = $commentService;
    }

    public function getAllComments()
    {
        try {
            $comments = $this->commentService->getAllComments();
            return Response::json($comments, 200);
        } catch (\Exception $e) {
            return Response::json(['error' => $e->getMessage()], $e->getCode() ?: 500);
        }
    }

    public function createComment(CreateCommentRequest $request)
    {
        try {
            $comment = $this->commentService->createComment($request->all());
            return Response::json($comment, 201);
        } catch (\Exception $e) {
            return Response::json(['error' => $e->getMessage()], $e->getCode() ?: 500);
        }
    }

    public function updateComment(CreateCommentRequest $request, $id)
    {
        try {
            $comment = $this->commentService->updateComment($id, $request->all());
            return Response::json($comment, 200);
        } catch (\Exception $e) {
            return Response::json(['error' => $e->getMessage()], $e->getCode() ?: 500);
        }
    }

    public function getCommentByArticleId($articleId)
    {
        try {
            $comments = $this->commentService->getCommentsByArticle($articleId);
            return Response::json($comments, 200);
        } catch (\Exception $e) {
            return Response::json(['error' => $e->getMessage()], $e->getCode() ?: 500);
        }
    }

    public function getCommentByUserId($userId)
    {
        try {
            $comments = $this->commentService->getCommentsByUser($userId);
            return Response::json($comments, 200);
        } catch (\Exception $e) {
            return Response::json(['error' => $e->getMessage()], $e->getCode() ?: 500);
        }
    }

    public function getCommentById($id)
    {
        try {
            $comment = $this->commentService->findComment($id);
            return Response::json($comment, 200);
        } catch (\Exception $e) {
            return Response::json(['error' => $e->getMessage()], $e->getCode() ?: 500);
        }
    }

    public function deleteComment($id)
    {
        try {
            $this->commentService->deleteComment($id);
            return Response::json(['message' => 'Comment deleted successfully'], 204);
        } catch (\Exception $e) {
            return Response::json(['error' => $e->getMessage()], $e->getCode() ?: 500);
        }
    }

    public function approveComment($id)
    {
        try {
            $comment = $this->commentService->approveComment($id);
            return Response::json($comment, 200);
        } catch (\Exception $e) {
            return Response::json(['error' => $e->getMessage()], $e->getCode() ?: 500);
        }
    }

    public function rejectComment($id)
    {
        try {
            $comment = $this->commentService->rejectComment($id);
            return Response::json($comment, 200);
        } catch (\Exception $e) {
            return Response::json(['error' => $e->getMessage()], $e->getCode() ?: 500);
        }
    }
}
