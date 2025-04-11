<?php
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\API\ArticleController;
use Illuminate\Support\Facades\Route;

Route::post('login', [UserController::class, 'login']);
Route::post('register', [UserController::class, 'register']);

Route::middleware('auth:api')->group(function () {
    Route::get('/users', [UserController::class, 'getAllUsers']);
    Route::put('users/{id}', [UserController::class, 'updateUser']);
    Route::delete('users/{id}', [UserController::class, 'deleteUser']);
});

Route::middleware('auth:api')->group(function () {
    Route::get('/categories', [CategoryController::class, 'getAllCategories']);
    Route::post('categories', [CategoryController::class, 'createCategory']);
    Route::put('categories/{id}', [CategoryController::class, 'updateCategory']);
    Route::delete('categories/{id}', [CategoryController::class, 'deleteCategory']);
});

Route::get('comments', [CommentController::class, 'getAllComments']); 
Route::middleware('auth:api')->group(function () {
    Route::post('comments', [CommentController::class, 'createComment']);
    Route::middleware('comment.permission')->group(function () {
        Route::put('comments/{id}', [CommentController::class, 'updateComment']); 
        Route::delete('comments/{id}', [CommentController::class, 'deleteComment']); 
    });
});
Route::middleware(['auth:api', 'admin'])->group(function () {
    Route::put('comments/{id}/approve', [CommentController::class, 'approveComment']); 
    Route::put('comments/{id}/reject', [CommentController::class, 'rejectComment']); 
});
Route::get('articles', [ArticleController::class, 'getAllArticle']);
Route::get('articles/{id}', [ArticleController::class, 'getArticleById']);
Route::middleware('auth:api')->group(function () {
    Route::post('articles', [ArticleController::class, 'createArticle']);
    Route::put('articles/{id}', [ArticleController::class, 'updateArticle']);
    Route::delete('articles/{id}', [ArticleController::class, 'deleteArticle']);
});

