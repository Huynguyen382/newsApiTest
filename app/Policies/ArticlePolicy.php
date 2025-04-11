<?php

namespace App\Policies;

use App\Models\ArticleModel;
use App\Models\userModel;
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
    public function viewAny(userModel $userModel = null,  ArticleModel $articleModel = null): Response
    {
        return Response::allow();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(userModel $userModel = null, ArticleModel $articleModel = null): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(userModel $userModel): Response
    {
        return $userModel->hasRole([UserModel::ROLE_ADMIN, UserModel::ROLE_AUTHOR])
            ? Response::allow()
            : Response::deny('You do not have permission to create articles.');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(userModel $userModel, ArticleModel $articleModel): Response
    {
        return $userModel->hasRole([UserModel::ROLE_ADMIN, UserModel::ROLE_AUTHOR])
            ? Response::allow()
            : Response::deny('You do not have permission to update articles.');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(userModel $userModel): Response
    {
        return $userModel->hasRole([UserModel::ROLE_ADMIN, UserModel::ROLE_AUTHOR])
            ? Response::allow()
            : Response::deny('You do not have permission to delete articles.');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(userModel $userModel, ArticleModel $articleModel): Response
    {
        return $userModel->hasRole([UserModel::ROLE_ADMIN, UserModel::ROLE_AUTHOR])
            ? Response::allow()
            : Response::deny('You do not have permission to restore articles.');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(userModel $userModel, ArticleModel $articleModel): Response
    {
        return $userModel->hasRole([UserModel::ROLE_ADMIN, UserModel::ROLE_AUTHOR])
            ? Response::allow()
            : Response::deny('You do not have permission to force delete articles.');
    }

    public function publish(userModel $userModel, ArticleModel $articleModel): Response
    {
        return $userModel->hasRole([UserModel::ROLE_ADMIN, UserModel::ROLE_AUTHOR])
            ? Response::allow()
            : Response::deny('You do not have permission to publish articles.');
    }

    public function unpublish(userModel $userModel, ArticleModel $articleModel): Response
    {
        return $userModel->hasRole([UserModel::ROLE_ADMIN, UserModel::ROLE_AUTHOR])
            ? Response::allow()
            : Response::deny('You do not have permission to unpublish articles.');
    }

    public function approve(userModel $userModel, ArticleModel $articleModel): Response
    {
        return $userModel->hasRole([UserModel::ROLE_ADMIN, UserModel::ROLE_AUTHOR])
            ? Response::allow()
            : Response::deny('You do not have permission to approve articles.');
    }

    public function reject(userModel $userModel, ArticleModel $articleModel): Response
    {
        return $userModel->hasRole([UserModel::ROLE_ADMIN, UserModel::ROLE_AUTHOR])
            ? Response::allow()
            : Response::deny('You do not have permission to reject articles.');
    }

}
