<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Services\ArticleServiceInterface;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\DeleteArticleRequest;     
use App\Models\ArticleModel;
use Illuminate\Support\Facades\Gate;

/**
 * @group Article Management
 * 
 * APIs for managing articles
 */
class ArticleController extends Controller
{
        protected $articleService;

        public function __construct(ArticleServiceInterface $articleService)
        {
                $this->articleService = $articleService;
        }

        /**
         * Get all articles
         *
         * @return JsonResponse
         */
        public function getAllArticle(): JsonResponse
        {
                Gate::authorize('viewAny', ArticleModel::class);
                $articles = $this->articleService->getAllArticles();
                return response()->json($articles, 200);
        }

        /**
         * Get a single article by ID
         *
         * @param int $id
         * @return JsonResponse
         */
        public function getArticleById($id): JsonResponse
        {
                $this->authorize('view', ArticleModel::class);
                $article = $this->articleService->getArticleById($id);
                return response()->json($article, 200);
        }

        /**
         * Create a new article
         *
         * @param UpdateArticleRequest $request
         * @return JsonResponse
         */
        public function createArticle(UpdateArticleRequest $request): JsonResponse
        {
                $this->authorize('create', ArticleModel::class);
                $article = $this->articleService->createArticle(
                        $request->validated(),
                        $request->user()->id
                );
                return response()->json($article, 201);
        }

        /**
         * Update an article
         *
         * @param UpdateArticleRequest $request
         * @param int $id
         * @return JsonResponse
         */
        public function updateArticle(CreateArticleRequest $request, $id): JsonResponse
        {
               Gate::authorize('update', ArticleModel::class);
                $article = $this->articleService->updateArticle(
                        $id,
                        $request->validated(),
                        $request->user()->id
                );
                return response()->json($article, 200);
        }
        public function deleteArticle(DeleteArticleRequest $request, $id): JsonResponse
        {
                $this->authorize('delete', ArticleModel::class);
                $this->articleService->deleteArticle($id, $request->user()->id);
                return response()->json(['message' => 'Bài viết đã được xóa thành công'], 200);
        }

        public function getAllArticleByCategory($id)
        {
                $this->authorize('view', ArticleModel::class);
                return $this->articleService->getByCategoryId($id);
        }

        public function getAllArticleByAuthor($id)
        {
                $this->authorize('view', ArticleModel::class);
                $articles = $this->articleService->getArticlesByAuthor($id);
                return response()->json($articles, 200);
        }

        public function getArticlesByCategory($id)
        {
                $this->authorize('view', ArticleModel::class);
                return $this->articleService->getByCategoryId($id);
        }
}
