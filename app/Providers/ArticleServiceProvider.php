<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\ArticleService;
use App\Services\ArticleServiceInterface;
use App\Repositories\ArticleRepository;
use App\Repositories\ArticleRepositoryInterface;

class ArticleServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(ArticleRepositoryInterface::class, ArticleRepository::class);
        $this->app->bind(ArticleServiceInterface::class, ArticleService::class);
    }

    public function boot()
    {
        //
    }
} 