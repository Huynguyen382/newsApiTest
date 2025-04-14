<?php

namespace App\Services;

interface UserServiceInterface
{
    /**
     * Login a user
     *
     * @param array $data
     * @return \App\Models\User
     */
    public function login(array $data);
    /**
     * Register a new user
     *
     * @param array $data
     * @return \App\Models\User
     */
    public function register(array $data);
    /**
     * Get all users
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllUsers();
    /**
     * Update a user
     *
     * @param array $data
     * @param int $id
     * @return \App\Models\User
     */
    public function updateUser(array $data, $id);
    /**
     * Delete a user
     *
     * @param int $id
     * @return bool
     */
    public function deleteUser($id);
} 
 