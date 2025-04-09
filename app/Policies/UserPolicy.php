<?php

namespace App\Policies;

use App\Models\userModel;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    use HandlesAuthorization;

    public function viewAny(userModel $user)
    {
        return $user->hasRole(userModel::ROLE_ADMIN)
            ? Response::allow()
            : Response::deny('Bạn không có quyền xem danh sách người dùng.');
    }

    public function view(userModel $user, userModel $model)
    {
        if ($user->hasRole(userModel::ROLE_ADMIN)) {
            return Response::allow();
        }

        if ($user->id === $model->id) {
            return Response::allow();
        }

        return Response::deny('Bạn không có quyền xem thông tin người dùng này.');
    }

    public function create(userModel $user)
    {
        return $user->hasRole(userModel::ROLE_ADMIN)
            ? Response::allow()
            : Response::deny('Bạn không có quyền tạo người dùng mới.');
    }

    public function update(userModel $user, userModel $model)
    {
        if ($user->hasRole(userModel::ROLE_ADMIN)) {
            return Response::allow();
        }

        if ($user->id === $model->id) {
            return Response::allow();
        }

        return Response::deny('Bạn không có quyền cập nhật thông tin người dùng này.');
    }

    public function delete(userModel $user, userModel $model)
    {
        if (!$user->hasRole(userModel::ROLE_ADMIN)) {
            return Response::deny('Chỉ quản trị viên mới có quyền xóa người dùng.');
        }

        if ($user->id === $model->id) {
            return Response::deny('Bạn không thể xóa tài khoản của chính mình.');
        }

        return Response::allow();
    }

    public function manageRoles(userModel $user)
    {
        return $user->hasRole(userModel::ROLE_ADMIN)
            ? Response::allow()
            : Response::deny('Bạn không có quyền quản lý vai trò người dùng.');
    }

    public function restore(userModel $user, userModel $model)
    {
        return $user->hasRole(userModel::ROLE_ADMIN)
            ? Response::allow()
            : Response::deny('Chỉ quản trị viên mới có quyền khôi phục người dùng.');
    }

    public function forceDelete(userModel $user, userModel $model)
    {
        return $user->hasRole(userModel::ROLE_ADMIN)
            ? Response::allow()
            : Response::deny('Chỉ quản trị viên mới có quyền xóa vĩnh viễn người dùng.');
    }

    public function updatePassword(userModel $user, userModel $model)
    {
        if ($user->hasRole(userModel::ROLE_ADMIN)) {
            return Response::allow();
        }

        if ($user->id === $model->id) {
            return Response::allow();
        }

        return Response::deny('Bạn không có quyền thay đổi mật khẩu của người dùng này.');
    }

    public function updateProfile(userModel $user, userModel $model)
    {
        if ($user->id === $model->id) {
            return Response::allow();
        }

        return Response::deny('Bạn chỉ có thể cập nhật thông tin cá nhân của chính mình.');
    }
} 