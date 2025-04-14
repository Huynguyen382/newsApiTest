<?php

namespace App\Policies;

use App\Models\UserModel;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    use HandlesAuthorization;

    public function viewAny(UserModel $user): Response
    {
        return $user->hasRole(UserModel::ROLE_ADMIN)
            ? Response::allow()
            : Response::deny('Bạn không có quyền xem danh sách người dùng.');
    }

    public function view(UserModel $user, UserModel $model): Response
    {
        if ($user->id === $model->id) {
            return Response::allow();
        }

        return Response::deny('Bạn không có quyền xem thông tin người dùng này.');
    }

    public function update(UserModel $user, UserModel $model): Response
    {
        if ($user->id === $model->id) {
            return Response::allow();
        }

        return Response::deny('Bạn không có quyền cập nhật thông tin người dùng này.');
    }

    public function delete(UserModel $user, UserModel $model): Response
    {
        if ($user->id === $model->id) {
            return Response::deny('Bạn không thể xóa tài khoản của chính mình.');
        }

        return Response::allow();
    }

    public function manageRoles(UserModel $user): Response
    {
        return $user->hasRole(UserModel::ROLE_ADMIN)
            ? Response::allow()
            : Response::deny('Bạn không có quyền quản lý vai trò người dùng.');
    }


    public function updateProfile(UserModel $user, UserModel $model): Response
    {
        if ($user->id === $model->id) {
            return Response::allow();
        }

        return Response::deny('Bạn chỉ có thể cập nhật thông tin cá nhân của chính mình.');
    }

    public function login(UserModel $user = null): Response
    {
        return Response::allow();
    }

    public function register(UserModel $user = null): Response
    {
        return Response::allow();
    }

} 