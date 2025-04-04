<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\CategoryModel;
use App\Policies\CategoryPolicy;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        CategoryModel::class => CategoryPolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();

        Gate::define('manage-categories', function ($user) {
            return $user->isAdmin();
        });
    }
} 