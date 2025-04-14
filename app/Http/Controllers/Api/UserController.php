<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\UserModel;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UpdateProfileRequest;
use Illuminate\Support\Facades\Log;
use App\Services\UserServiceInterface;

/**
 * @group User Management
 * 
 * APIs for managing users
 */
class UserController extends Controller
{
    protected $userService;

    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }
    public function getAllUsers()
    {
        $this->authorize('viewAny', UserModel::class);
        $users = $this->userService->getAllUsers();
        return response()->json($users, 200);
    }
    public function login(LoginRequest $request)
    {
        $validated = $request->validated();
        $user = UserModel::where('email', $validated['email'])->first();

        if (!$user || !Hash::check($validated['password'], $user->password)) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        $token = JWTAuth::fromUser($user);
        return response()->json(['token' => $token, 'user' => $user], 200);
    }
    public function register(RegisterRequest $request)
    {
        $validated = $request->validated();
        $user = UserModel::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => UserModel::ROLE_USER
        ]);

        $token = JWTAuth::fromUser($user);
        return response()->json(['token' => $token, 'user' => $user], 201);
    }

    public function profile()
    {
        $user = Auth::user();
        $this->authorize('view', $user);
        return response()->json($user);
    }
    public function deleteUser($id)
    {
        $userToDelete = UserModel::findOrFail($id);
        $this->authorize('delete', $userToDelete);

        $userToDelete->delete();
        return response()->json(['message' => 'User deleted successfully']);
    }
    public function updateUser(UpdateProfileRequest $request, $id)
    {
        try {
            $userToUpdate = UserModel::findOrFail($id);
            $this->authorize('update', $userToUpdate);

            $validated = $request->validated();

            if (isset($validated['password'])) {
                $this->authorize('updatePassword', $userToUpdate);
                $validated['password'] = Hash::make($validated['password']);
            }

            if (isset($validated['role'])) {
                $this->authorize('manageRoles', $userToUpdate);
            }

            $userToUpdate->update($validated);

            return response()->json([
                'message' => 'User updated successfully',
                'user' => $userToUpdate->fresh()
            ]);
        } catch (\Exception $e) {
            Log::error('Update user error:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['error' => 'An error occurred while updating user'], 500);
        }
    }
    
    
}
