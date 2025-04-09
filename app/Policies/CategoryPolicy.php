<?php

namespace App\Policies;

use App\Models\userModel;
use App\Models\CategoryModel;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class CategoryPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any categories.
     *
     * @param  \App\Models\userModel  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(userModel $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the category.
     *
     * @param  \App\Models\userModel  $user
     * @param  \App\Models\CategoryModel  $category
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(userModel $user, CategoryModel $category)
    {
        return $user->hasAnyRole([userModel::ROLE_ADMIN, userModel::ROLE_AUTHOR, userModel::ROLE_USER]);
    }

    /**
     * Determine whether the user can create categories.
     *
     * @param  \App\Models\userModel  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(userModel $user)
    {
        return $user->hasAnyRole([userModel::ROLE_ADMIN, userModel::ROLE_AUTHOR])
            ? Response::allow()
            : Response::deny('Bạn không có quyền tạo danh mục.');
    }

    /**
     * Determine whether the user can update the category.
     *
     * @param  \App\Models\userModel  $user
     * @param  \App\Models\CategoryModel  $category
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(userModel $user, CategoryModel $category)
    {
        return $user->hasAnyRole([userModel::ROLE_ADMIN, userModel::ROLE_AUTHOR]);
    }

    /**
     * Determine whether the user can delete the category.
     *
     * @param  \App\Models\userModel  $user
     * @param  \App\Models\CategoryModel  $category
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(userModel $user, CategoryModel $category)
    {
        if (!$user->isAdmin()) {
            return Response::deny('Only administrators can delete categories.');
        }
        
        if ($category->articles_count > 0) {
            return Response::deny('Cannot delete a category that contains articles.');
        }
        
        return Response::allow();
    }
} 