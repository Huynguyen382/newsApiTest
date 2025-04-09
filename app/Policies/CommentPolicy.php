<?php

namespace App\Policies;

use App\Models\userModel;
use App\Models\CommentModel;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class CommentPolicy
{
    use HandlesAuthorization;

    public function viewAny(userModel $user)
    {
        return Response::allow();
    }

    public function view(userModel $user, CommentModel $comment)
    {
        return Response::allow();
    }

    public function create(userModel $user)
    {
        return $user->isAuthenticated()
            ? Response::allow()
            : Response::deny('Bạn cần đăng nhập để bình luận.');
    }

    public function update(userModel $user, CommentModel $comment)
    {
        if ($user->hasRole(userModel::ROLE_ADMIN)) {
            return Response::allow();
        }

        if ($comment->user_id === $user->id) {
            return Response::allow();
        }

        return Response::deny('Bạn không có quyền sửa bình luận này.');
    }

    public function delete(userModel $user, CommentModel $comment)
    {
        if ($user->hasRole(userModel::ROLE_ADMIN)) {
            return Response::allow();
        }

        if ($comment->user_id === $user->id) {
            return Response::allow();
        }

        return Response::deny('Bạn không có quyền xóa bình luận này.');
    }

    public function reply(userModel $user, CommentModel $comment)
    {
        return $user->isAuthenticated()
            ? Response::allow()
            : Response::deny('Bạn cần đăng nhập để trả lời bình luận.');
    }

    public function approve(userModel $user, CommentModel $comment)
    {
        return $user->hasAnyRole([userModel::ROLE_ADMIN, userModel::ROLE_AUTHOR])
            ? Response::allow()
            : Response::deny('Bạn không có quyền phê duyệt bình luận.');
    }

    public function reject(userModel $user, CommentModel $comment)
    {
        return $user->hasAnyRole([userModel::ROLE_ADMIN, userModel::ROLE_AUTHOR])
            ? Response::allow()
            : Response::deny('Bạn không có quyền từ chối bình luận.');
    }

    public function restore(userModel $user, CommentModel $comment)
    {
        return $user->hasRole(userModel::ROLE_ADMIN)
            ? Response::allow()
            : Response::deny('Chỉ quản trị viên mới có quyền khôi phục bình luận.');
    }

    public function forceDelete(userModel $user, CommentModel $comment)
    {
        return $user->hasRole(userModel::ROLE_ADMIN)
            ? Response::allow()
            : Response::deny('Chỉ quản trị viên mới có quyền xóa vĩnh viễn bình luận.');
    }
} 