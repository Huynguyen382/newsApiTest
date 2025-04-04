<?php

namespace App\Policies;

use App\Models\userModel;
use App\Models\CategoryModel;
use Illuminate\Auth\Access\HandlesAuthorization;

class CategoryPolicy
{
    use HandlesAuthorization;

    public function viewAny(userModel $user)
    {
        return true; 
    }

    public function view(userModel $user, CategoryModel $category)
    {
        return true; 
    }

    public function create(userModel $user)
    {
        return $user->isAdmin();
    }

    public function update(userModel $user, CategoryModel $category)
    {
        return $user->isAdmin();
    }

    public function delete(userModel $user, CategoryModel $category)
    {
        if (!$user->isAdmin()) {
            return false;
        }
        return $category->articles_count === 0;
    }
} 