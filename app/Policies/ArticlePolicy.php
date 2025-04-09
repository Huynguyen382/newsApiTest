<?php

namespace App\Policies;

use App\Models\userModel;
use App\Models\ArticleModel;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class ArticlePolicy
{
    use HandlesAuthorization;

    public function viewAny(userModel $user)
    {
        return Response::allow();
    }

    public function view(userModel $user, ArticleModel $article)
    {
        if ($article->status === 'published') {
            return Response::allow();
        }
        
        return $user->hasAnyRole([userModel::ROLE_ADMIN, userModel::ROLE_AUTHOR]) 
            ? Response::allow() 
            : Response::deny('Bạn không có quyền xem bài viết này.');
    }

    public function create(userModel $user)
    {
        return $user->hasAnyRole([userModel::ROLE_ADMIN, userModel::ROLE_AUTHOR])
            ? Response::allow()
            : Response::deny('Bạn không có quyền tạo bài viết.');
    }

    public function update(userModel $user, ArticleModel $article)
    {
        if ($user->hasRole(userModel::ROLE_ADMIN)) {
            return Response::allow();
        }

        if ($user->hasRole(userModel::ROLE_AUTHOR) && $article->user_id === $user->id) {
            return Response::allow();
        }

        return Response::deny('Bạn không có quyền cập nhật bài viết này.');
    }

    public function delete(userModel $user, ArticleModel $article)
    {
        if (!$user->hasRole(userModel::ROLE_ADMIN)) {
            return Response::deny('Chỉ quản trị viên mới có quyền xóa bài viết.');
        }
        
        return Response::allow();
    }

    public function publish(userModel $user, ArticleModel $article)
    {
        return $user->hasRole(userModel::ROLE_ADMIN)
            ? Response::allow()
            : Response::deny('Chỉ quản trị viên mới có quyền xuất bản bài viết.');
    }

    public function restore(userModel $user, ArticleModel $article)
    {
        return $user->hasRole(userModel::ROLE_ADMIN)
            ? Response::allow()
            : Response::deny('Chỉ quản trị viên mới có quyền khôi phục bài viết.');
    }

    public function forceDelete(userModel $user, ArticleModel $article)
    {
        return $user->hasRole(userModel::ROLE_ADMIN)
            ? Response::allow()
            : Response::deny('Chỉ quản trị viên mới có quyền xóa vĩnh viễn bài viết.');
    }

    public function manageComments(userModel $user, ArticleModel $article)
    {
        return $user->hasAnyRole([userModel::ROLE_ADMIN, userModel::ROLE_AUTHOR])
            ? Response::allow()
            : Response::deny('Bạn không có quyền quản lý bình luận của bài viết này.');
    }
} 