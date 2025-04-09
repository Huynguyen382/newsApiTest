<?php

namespace App\Repositories;

use App\Models\userModel;
use Illuminate\Support\Facades\Hash;

class UserRepository implements UserRepositoryInterface
{
    protected $model;

    public function __construct(userModel $model)
    {
        $this->model = $model;
    }

    public function getAll()
    {
        return $this->model->all();
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function create(array $data)
    {
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        $user = $this->find($id);
        if ($user) {
            if (isset($data['password'])) {
                $data['password'] = Hash::make($data['password']);
            }
            $user->update($data);
            return $user;
        }
        return null;
    }

    public function delete($id)
    {
        $user = $this->find($id);
        if ($user) {
            return $user->delete();
        }
        return false;
    }

    public function findByEmail($email)
    {
        return $this->model->where('email', $email)->first();
    }

    public function updatePassword($id, $password)
    {
        $user = $this->find($id);
        if ($user) {
            $user->password = Hash::make($password);
            return $user->save();
        }
        return false;
    }

    public function getWithRoles()
    {
        return $this->model->with('roles')->get();
    }
} 