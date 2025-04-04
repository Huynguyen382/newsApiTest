<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\CommentModel;
use Illuminate\Support\Facades\Auth;

class CheckCommentPermission
{
    public function handle(Request $request, Closure $next)
    {
        $comment = CommentModel::find($request->route('id'));
        
        if (!$comment) {
            return response()->json(['error' => 'Comment not found'], 404);
        }

        if (Auth::user()->role == 'admin') {
            return $next($request);
        }

        if (Auth::id() !== $comment->user_id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return $next($request);
    }
} 