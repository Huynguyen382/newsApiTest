<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\CommentService;
use App\Services\CommentServiceInterface;
use App\Repositories\CommentRepository;
use App\Repositories\CommentRepositoryInterface;

class CommentServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(CommentRepositoryInterface::class, CommentRepository::class);
        $this->app->bind(CommentServiceInterface::class, CommentService::class);
    }

    public function boot()
    {
        //
    }
} 