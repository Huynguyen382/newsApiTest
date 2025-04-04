<?php

namespace App\Policies;

use App\Models\userModel;
use App\Models\CategoryModel;
use Illuminate\Auth\Access\HandlesAuthorization;

class CategoryPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any categories.
     *
     * @param  \App\Models\userModel  $user
     * @return bool
     */
    public function viewAny(userModel $user)
    {
        return $user->isAuthenticated(); 
    }

    /**
     * Determine whether the user can view the category.
     *
     * @param  \App\Models\userModel  $user
     * @param  \App\Models\CategoryModel  $category
     * @return bool
     */
    public function view(userModel $user, CategoryModel $category)
    {
        return $user->isAuthenticated(); 
    }

    /**
     * Determine whether the user can create categories.
     *
     * @param  \App\Models\userModel  $user
     * @return bool
     */
    public function create(userModel $user)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can update the category.
     *
     * @param  \App\Models\userModel  $user
     * @param  \App\Models\CategoryModel  $category
     * @return bool
     */
    public function update(userModel $user, CategoryModel $category)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can delete the category.
     *
     * @param  \App\Models\userModel  $user
     * @param  \App\Models\CategoryModel  $category
     * @return bool
     */
    public function delete(userModel $user, CategoryModel $category)
    {
        return $user->isAdmin() && $category->articles_count === 0;
    }
} 