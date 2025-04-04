<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\CommentModel;
use Illuminate\Support\Facades\Response;
use App\Http\Requests\CreateCommentRequest;
use Illuminate\Support\Facades\Log;

class CommentController extends Controller
{
    public function getAllComments()
    {
       $comments = CommentModel::all();
       return Response::json($comments, 200);
    }
    public function createComment(CreateCommentRequest $request)
    {
        $comment = CommentModel::create($request->all());
        return Response::json($comment, 201);
    }
    public function updateComment(CreateCommentRequest $request, $id)
    {
        $comment = CommentModel::find($id);

        if (!$comment) {
            return Response::json(['error' => 'Comment not found'], 404);
        }
        $comment->update($request->all());
        return Response::json($comment, 200);
    }
    public function getCommentByArticleId($articleId)
    {
        $comments = CommentModel::where('article_id', $articleId)->get();
        return Response::json($comments, 200);
    }
    public function getCommentByUserId($userId)
    {
        $comments = CommentModel::where('user_id', $userId)->get();
        return Response::json($comments, 200);
    }
    public function getCommentById($id)
    {
        $comment = CommentModel::find($id);
        return Response::json($comment, 200);
    }

    public function deleteComment($id)
    {
        $comment = CommentModel::find($id);
        if (!$comment) {
            return Response::json(['error' => 'Comment not found'], 404);
        }
        $comment->delete();
        return Response::json(['message' => 'Comment deleted'], 204);
    }
}
