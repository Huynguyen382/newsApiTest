<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\CategoryService;
use App\Services\CategoryServiceInterface;
use App\Repositories\CategoryRepository;
use App\Repositories\CategoryRepositoryInterface;

class CategoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
        $this->app->bind(CategoryServiceInterface::class, CategoryService::class);
    }

    public function boot()
    {
        //
    }
} 