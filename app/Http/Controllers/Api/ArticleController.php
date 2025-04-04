<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ArticleModel;
use App\Http\Requests\CreateArticleRequest;
use Illuminate\Support\Facades\Auth;

/**
 * @group Article Management
 * 
 * APIs for managing articles
 */
class ArticleController extends Controller
{
    public function getAllArticle()
    {
        $articles = ArticleModel::all();
        return response()->json($articles, 200);
    }
    public function getArticleById($id)
    {
         $article = ArticleModel::find($id);
         if(!$article) {
             return response()->json(['error' => 'Article not found'], 404);
         }
         return response()->json($article, 200);
    }
   public function createArticle (CreateArticleRequest $request)
   {
        $user = Auth::user();
        if($user->role != 'admin' && $user->role != 'author') {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        $validated = $request->validated();

        $article = ArticleModel::create($validated);
        return response()->json($article, 201);
   }
   public function updateArticle( CreateArticleRequest $request, $id)
   {
        $user = Auth::user();
        if ($user->role != 'admin' && $user->role != 'author') {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $article = ArticleModel::find($id);
        if (!$article) {
            return response()->json(['error' => 'Article not found'], 404);
        }

        $validated = $request->validated();

        $article->update($validated);
        return response()->json($article);
   }
   public function deleteArticle($id) 
   {
       $user = Auth::user();
       if ($user->role != 'admin') {
           return response()->json(['error' => 'Unauthorized'], 401);
       }

       $article = ArticleModel::find($id);
       if (!$article) {
           return response()->json(['error' => 'Article not found'], 404);
       }

       $article->delete();
       return response()->json(['message' => 'Article deleted successfully'], 200);
   }

  
   public function getAllArticleByCategory($id) 
   {
     $articles = ArticleModel::where('category_id', $id)->get();
       return response()->json($articles, 200);
   }
   public function getAllArticleByAuthor($id) 
   {
     $articles = ArticleModel::where('author_id', $id)->get();
       return response()->json($articles, 200);
   }


}
