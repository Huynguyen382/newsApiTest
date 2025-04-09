<?php

namespace App\Services;

use App\Models\userModel;

interface UserServiceInterface
{
    public function getAllUsers();
    public function findUser($id);
    public function createUser(array $data);
    public function updateUser($id, array $data);
    public function deleteUser($id);
    public function findByEmail($email);
    public function updatePassword($id, $password);
    public function getUsersWithRoles();
    public function authenticate($email, $password);
    public function register(array $data);
} 
 