<?php

namespace App\Policies;

use App\Models\ArticleModel;
use App\Models\UserModel;
use Illuminate\Auth\Access\Response;

class ArticlePolicy
{
    // public function __construct()
    // {
    //     dd('test');
    // }
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(UserModel $UserModel = null,  ArticleModel $articleModel = null): Response
    {
        return Response::allow();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(UserModel $UserModel = null, ArticleModel $articleModel = null): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(UserModel $UserModel): Response
    {
        return $UserModel->hasRole([UserModel::ROLE_ADMIN, UserModel::ROLE_AUTHOR])
            ? Response::allow()
            : Response::deny('Bạn không có quyền tạo bài viết.');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(UserModel $UserModel, ArticleModel $articleModel): Response
    {
        return $UserModel->hasRole([UserModel::ROLE_ADMIN, UserModel::ROLE_AUTHOR])
            ? Response::allow()
            : Response::deny('Bạn không có quyền cập nhật bài viết.');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(UserModel $UserModel): Response
    {
        return $UserModel->hasRole([UserModel::ROLE_ADMIN, UserModel::ROLE_AUTHOR])
            ? Response::allow()
            : Response::deny('Bạn không có quyền xóa bài viết.');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(UserModel $UserModel, ArticleModel $articleModel): Response
    {
        return $UserModel->hasRole([UserModel::ROLE_ADMIN, UserModel::ROLE_AUTHOR])
            ? Response::allow()
            : Response::deny('Bạn không có quyền khôi phục bài viết.');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(UserModel $UserModel, ArticleModel $articleModel): Response
    {
        return $UserModel->hasRole([UserModel::ROLE_ADMIN, UserModel::ROLE_AUTHOR])
            ? Response::allow()
            : Response::deny('Bạn không có quyền xóa vĩnh viễn bài viết.');
    }

    public function publish(UserModel $UserModel, ArticleModel $articleModel): Response
    {
        return $UserModel->hasRole([UserModel::ROLE_ADMIN, UserModel::ROLE_AUTHOR])
            ? Response::allow()
            : Response::deny('Bạn không có quyền xuất bản bài viết.');
    }

    public function unpublish(UserModel $UserModel, ArticleModel $articleModel): Response
    {
        return $UserModel->hasRole([UserModel::ROLE_ADMIN, UserModel::ROLE_AUTHOR])
            ? Response::allow()
            : Response::deny('Bạn không có quyền hủy xuất bản bài viết.');
    }

    public function approve(UserModel $UserModel, ArticleModel $articleModel): Response
    {
        return $UserModel->hasRole([UserModel::ROLE_ADMIN, UserModel::ROLE_AUTHOR])
            ? Response::allow()
            : Response::deny('Bạn không có quyền phê duyệt bài viết.');
    }

    public function reject(UserModel $UserModel, ArticleModel $articleModel): Response
    {
        return $UserModel->hasRole([UserModel::ROLE_ADMIN, UserModel::ROLE_AUTHOR])
            ? Response::allow()
            : Response::deny('Bạn không có quyền từ chối bài viết.');
    }

}
