<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\updateArticleRequest;
use App\Services\ArticleServiceInterface;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\deleteArticleRequest;

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
                $article = $this->articleService->getArticleById($id);
                return response()->json($article, 200);
        }

        /**
         * Create a new article
         *
         * @param updateArticleRequest $request
         * @return JsonResponse
         */
        public function createArticle(updateArticleRequest $request): JsonResponse
        {
                try {
                        $article = $this->articleService->createArticle(
                                $request->validated(),
                                $request->user()->id
                        );
                        return response()->json($article, 201);
                } catch (\Exception $e) {
                        return response()->json(['error' => $e->getMessage()], $e->getCode() ?: 500);
                }
        }

        /**
         * Update an article
         *
         * @param updateArticleRequest $request
         * @param int $id
         * @return JsonResponse
         */
        public function updateArticle(updateArticleRequest $request, $id): JsonResponse
        {
                try {
                        $article = $this->articleService->updateArticle(
                                $id,
                                $request->validated(),
                                $request->user()->id
                        );
                        return response()->json($article, 200);
                } catch (\Exception $e) {
                        return response()->json(['error' => $e->getMessage()], $e->getCode() ?: 500);
                }
        }
        public function destroy(deleteArticleRequest $request, $id): JsonResponse
        {
                try {
                        $this->articleService->deleteArticle($id, $request->user()->id);
                        return response()->json(['message' => 'Bài viết đã được xóa thành công'], 200);
                } catch (\Exception $e) {
                        return response()->json(['error' => $e->getMessage()], $e->getCode() ?: 500);
                }
        }

        public function getAllArticleByCategory($id)
        {
                return $this->articleService->getByCategoryId($id);
        }

        public function getAllArticleByAuthor($id)
        {

                $articles = $this->articleService->getArticlesByAuthor($id);
                return response()->json($articles, 200);
        }

        public function getArticlesByCategory($id)
        {
                return $this->articleService->getByCategoryId($id);
        }
}
