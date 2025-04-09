<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\ArticleRepository;
use App\Repositories\ArticleRepositoryInterface;
use App\Repositories\CategoryRepository;
use App\Repositories\CategoryRepositoryInterface;
use App\Repositories\CommentRepository;
use App\Repositories\CommentRepositoryInterface;
use App\Services\ArticleService;
use App\Services\ArticleServiceInterface;
use App\Services\CategoryService;
use App\Services\CategoryServiceInterface;
use App\Services\CommentService;
use App\Services\CommentServiceInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ArticleRepositoryInterface::class, ArticleRepository::class);
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
        $this->app->bind(CommentRepositoryInterface::class, CommentRepository::class);

        $this->app->bind(ArticleServiceInterface::class, function ($app) {
            return new ArticleService($app->make(ArticleRepositoryInterface::class));
        });

        $this->app->bind(CategoryServiceInterface::class, function ($app) {
            return new CategoryService($app->make(CategoryRepositoryInterface::class));
        });

        $this->app->bind(CommentServiceInterface::class, function ($app) {
            return new CommentService($app->make(CommentRepositoryInterface::class));
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
