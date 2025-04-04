<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Repositories\CommentRepositoryInterface;
use Illuminate\Support\Facades\Response;
use App\Http\Requests\CreateCommentRequest;
use Illuminate\Support\Facades\Log;

class CommentController extends Controller
{
    protected $commentRepository;

    public function __construct(CommentRepositoryInterface $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    public function getAllComments()
    {
       $comments = $this->commentRepository->getAll();
       return Response::json($comments, 200);
    }
    public function createComment(CreateCommentRequest $request)
    {
        $comment = $this->commentRepository->create($request->all());
        return Response::json($comment, 201);
    }
    public function updateComment(CreateCommentRequest $request, $id)
    {
        $comment = $this->commentRepository->update($id, $request->all());
        
        if (!$comment) {
            return Response::json(['error' => 'Comment not found'], 404);
        }
        
        return Response::json($comment, 200);
    }
    public function getCommentByArticleId($articleId)
    {
        $comments = $this->commentRepository->getByArticleId($articleId);
        return Response::json($comments, 200);
    }
    public function getCommentByUserId($userId)
    {
        $comments = $this->commentRepository->getByUserId($userId);
        return Response::json($comments, 200);
    }
    public function getCommentById($id)
    {
        $comment = $this->commentRepository->find($id);
        return Response::json($comment, 200);
    }

    public function deleteComment($id)
    {
        $comment = $this->commentRepository->delete($id);
        if (!$comment) {
            return Response::json(['error' => 'Comment not found'], 404);
        }
        $comment->delete();
        return Response::json(['message' => 'Comment deleted'], 204);
    }
    public function approveComment($id)
    {
        $comment = $this->commentRepository->approve($id);
        return Response::json($comment, 200);
    }
    public function rejectComment($id)
    {
        $comment = $this->commentRepository->reject($id);
        return Response::json($comment, 200);
    }
}
