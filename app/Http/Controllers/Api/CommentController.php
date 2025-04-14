<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Services\CommentServiceInterface;
use App\Http\Requests\CreateCommentRequest;
use App\Models\CommentModel;

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
        $this->authorize('viewAny', CommentModel::class);
        $comments = $this->commentService->getAllComments();
        return response()->json($comments, 200);
    }

    public function createComment(CreateCommentRequest $request)
    {
       $this->authorize('create', CommentModel::class);
       $comment = $this->commentService->createComment($request->all());
       return response()->json($comment, 201);
    }

    public function updateComment(CreateCommentRequest $request, $id)
    {
        $this->authorize('update', CommentModel::class);
        $comment = $this->commentService->updateComment($id, $request->all());
        return response()->json($comment, 200);
    }


    public function deleteComment($id)
    {
        $this->authorize('delete', CommentModel::class);
        $this->commentService->deleteComment($id);
        return response()->json(['message' => 'Comment deleted successfully'], 204);
    }

    public function approveComment($id)
    {
        $this->authorize('approve', CommentModel::class);
        $comment = $this->commentService->approveComment($id);
        return response()->json($comment, 200);
    }

    public function rejectComment($id)
    {
        $this->authorize('reject', CommentModel::class);
        $comment = $this->commentService->rejectComment($id);
        return response()->json($comment, 200);
    }
}
