<?php

namespace App\Services;

use App\Repositories\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;

class UserService implements UserServiceInterface
{
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getAllUsers()
    {
        try {
            return $this->userRepository->getAll();
        } catch (\Exception $e) {
            Log::error('Error getting all users: ' . $e->getMessage());
            throw $e;
        }
    }

    public function findUser($id)
    {
        try {
            $user = $this->userRepository->find($id);
            if (!$user) {
                throw new \Exception('User not found', 404);
            }
            return $user;
        } catch (\Exception $e) {
            Log::error('Error finding user: ' . $e->getMessage());
            throw $e;
        }
    }

    public function createUser(array $data)
    {
        try {
            $this->validateUserData($data);
            
            if ($this->userRepository->findByEmail($data['email'])) {
                throw new ValidationException(
                    Validator::make([], []),
                    ['email' => ['Email already exists.']]
                );
            }

            return $this->userRepository->create($data);
        } catch (ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            Log::error('Error creating user: ' . $e->getMessage());
            throw $e;
        }
    }

    public function updateUser($id, array $data)
    {
        try {
            $this->validateUserData($data, true);
            
            $user = $this->findUser($id);

            $existingUser = $this->userRepository->findByEmail($data['email']);
            if ($existingUser && $existingUser->id !== $id) {
                throw new ValidationException(
                    Validator::make([], []),
                    ['email' => ['Email already exists.']]
                );
            }

            return $this->userRepository->update($id, $data);
        } catch (ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            Log::error('Error updating user: ' . $e->getMessage());
            throw $e;
        }
    }

    public function deleteUser($id)
    {
        try {
            $user = $this->findUser($id);
            return $this->userRepository->delete($id);
        } catch (\Exception $e) {
            Log::error('Error deleting user: ' . $e->getMessage());
            throw $e;
        }
    }

    public function findByEmail($email)
    {
        try {
            return $this->userRepository->findByEmail($email);
        } catch (\Exception $e) {
            Log::error('Error finding user by email: ' . $e->getMessage());
            throw $e;
        }
    }

    public function updatePassword($id, $password)
    {
        try {
            $this->validatePassword($password);
            return $this->userRepository->updatePassword($id, $password);
        } catch (\Exception $e) {
            Log::error('Error updating password: ' . $e->getMessage());
            throw $e;
        }
    }

    public function getUsersWithRoles()
    {
        try {
            return $this->userRepository->getWithRoles();
        } catch (\Exception $e) {
            Log::error('Error getting users with roles: ' . $e->getMessage());
            throw $e;
        }
    }

    public function authenticate($email, $password)
    {
        try {
            $user = $this->findByEmail($email);
            if (!$user || !Hash::check($password, $user->password)) {
                throw new ValidationException(
                    Validator::make([], []),
                    ['email' => ['The provided credentials are incorrect.']]
                );
            }
            return $user;
        } catch (\Exception $e) {
            Log::error('Error authenticating user: ' . $e->getMessage());
            throw $e;
        }
    }

    public function register(array $data)
    {
        try {
            $this->validateUserData($data);
            
            if ($this->userRepository->findByEmail($data['email'])) {
                throw new ValidationException(
                    Validator::make([], []),
                    ['email' => ['Email already exists.']]
                );
            }

            return $this->userRepository->create($data);
        } catch (ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            Log::error('Error registering user: ' . $e->getMessage());
            throw $e;
        }
    }

    protected function validateUserData(array $data, $isUpdate = false)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'password' => $isUpdate ? 'nullable|string|min:8' : 'required|string|min:8',
        ];

        $validator = Validator::make($data, $rules);
        
        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }

    protected function validatePassword($password)
    {
        $validator = Validator::make(['password' => $password], [
            'password' => 'required|string|min:8',
        ]);
        
        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }
} 