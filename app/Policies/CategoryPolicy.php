<?php

namespace App\Policies;

use App\Models\CategoryModel;
use App\Models\UserModel;
use Illuminate\Auth\Access\Response;

class CategoryPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(UserModel $user): Response
    {
        return $user->hasAnyRole([UserModel::ROLE_ADMIN, UserModel::ROLE_AUTHOR, UserModel::ROLE_USER])
            ? Response::allow()
            : Response::deny('You do not have permission to view categories.');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(UserModel $user, CategoryModel $category): Response
    {
        return Response::allow();
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(UserModel $user): Response
    {   
        return $user->hasRole([UserModel::ROLE_ADMIN, UserModel::ROLE_AUTHOR])
            ? Response::allow()
            : Response::deny('Bạn không có quyền tạo danh mục.');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(UserModel $user, CategoryModel $category): Response
    {
        return $user->hasRole([UserModel::ROLE_ADMIN, UserModel::ROLE_AUTHOR])
            ? Response::allow()
            : Response::deny('Bạn không có quyền cập nhật danh mục này.');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(UserModel $user, CategoryModel $category): Response
    {
        return $user->hasRole([UserModel::ROLE_ADMIN, UserModel::ROLE_AUTHOR])
            ? Response::allow()
            : Response::deny('Bạn không có quyền xóa danh mục này.');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(UserModel $user, CategoryModel $category): Response
    {
        return $user->hasRole([UserModel::ROLE_ADMIN, UserModel::ROLE_AUTHOR])
            ? Response::allow()
            : Response::deny('Bạn không có quyền khôi phục danh mục này.');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(UserModel $user, CategoryModel $category): Response
    {
        return $user->hasRole([UserModel::ROLE_ADMIN, UserModel::ROLE_AUTHOR])
            ? Response::allow()
            : Response::deny('Bạn không có quyền xóa vĩnh viễn danh mục này.');
    }
}
