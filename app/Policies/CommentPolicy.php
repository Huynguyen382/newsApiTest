<?php

namespace App\Policies;

use App\Models\UserModel;
use App\Models\CommentModel;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class CommentPolicy
{
    use HandlesAuthorization;

    public function viewAny(UserModel $user = null)
    {
        return Response::allow();
    }

    public function create(UserModel $user)
    {
        return $user->isAuthenticated()
            ? Response::allow()
            : Response::deny('Bạn cần đăng nhập để bình luận.');
    }

    public function update(UserModel $user, CommentModel $comment)
    {
        if ($user->hasRole(UserModel::ROLE_ADMIN)) {
            return Response::allow();
        }

        if ($comment->user_id === $user->id) {
            return Response::allow();
        }

        return Response::deny('Bạn không có quyền sửa bình luận này.');
    }

    public function delete(UserModel $user, CommentModel $comment)
    {
        if ($user->hasRole(UserModel::ROLE_ADMIN)) {
            return Response::allow();
        }

        if ($comment->user_id === $user->id) {
            return Response::allow();
        }

        return Response::deny('Bạn không có quyền xóa bình luận này.');
    }

    public function reply(UserModel $user, CommentModel $comment)
    {
        return $user->isAuthenticated()
            ? Response::allow()
            : Response::deny('Bạn cần đăng nhập để trả lời bình luận.');
    }

    public function approve(UserModel $user, CommentModel $comment)
    {
        return $user->hasAnyRole([UserModel::ROLE_ADMIN, UserModel::ROLE_AUTHOR])
            ? Response::allow()
            : Response::deny('Bạn không có quyền phê duyệt bình luận.');
    }

    public function reject(UserModel $user, CommentModel $comment)
    {
        return $user->hasAnyRole([UserModel::ROLE_ADMIN, UserModel::ROLE_AUTHOR])
            ? Response::allow()
            : Response::deny('Bạn không có quyền từ chối bình luận.');
    }

    public function restore(UserModel $user, CommentModel $comment)
    {
        return $user->hasRole(UserModel::ROLE_ADMIN)
            ? Response::allow()
            : Response::deny('Chỉ quản trị viên mới có quyền khôi phục bình luận.');
    }

    public function forceDelete(UserModel $user, CommentModel $comment)
    {
        return $user->hasRole(UserModel::ROLE_ADMIN)
            ? Response::allow()
            : Response::deny('Chỉ quản trị viên mới có quyền xóa vĩnh viễn bình luận.');
    }
} 