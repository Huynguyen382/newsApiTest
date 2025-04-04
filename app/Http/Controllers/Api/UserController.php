<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\userModel;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UpdateProfileRequest;
use Illuminate\Support\Facades\Log;

/**
 * @group User Management
 * 
 * APIs for managing users
 */
class UserController extends Controller
{
    public function login(LoginRequest $request)
    {
        $validated = $request->validated();
        $user = userModel::where('email', $validated['email'])->first();
        if (!$user || !Hash::check($validated['password'], $user->password)) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }
        $token = JWTAuth::fromUser($user);
        return response()->json(['token' => $token, 'user' => $user], 200);
    }
    public function register(RegisterRequest $request)
    {
        $validated = $request->validated();

        $user = userModel::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);
        $token = JWTAuth::fromUser($user);
        return response()->json(['token' => $token, 'user' => $user], 201);
    }

    public function profile()
    {
        return response()->json(Auth::user());
    }
    public function deleteUser($id)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
       
        if ($user->id != $id && $user->role != 'admin') {
            return response()->json(['error' => 'Unauthorized - You do not have permission to delete this user'], 403);
        }
        
        $userToDelete = userModel::findOrFail($id);
        $userToDelete->delete();
        return response()->json(['message' => 'User deleted successfully']);
    }
    public function updateUser(UpdateProfileRequest $request, $id)
    {
        try {
            $user = Auth::user();
            if (!$user) {
                return response()->json(['error' => 'Unauthorized - Please login first'], 401);
            }

            $userToUpdate = userModel::findOrFail($id);
            
            if ($user->id != $id && $user->role != 'admin') {
                return response()->json(['error' => 'Unauthorized - You do not have permission to update this user'], 403);
            }

            $validated = $request->validated();

            if (isset($validated['password'])) {
                $validated['password'] = Hash::make($validated['password']);
            }

            if (isset($validated['role'])) {
                if ($user->role !== 'admin') {
                    return response()->json(['error' => 'Only admin can change user role'], 403);
                }
                if ($user->id == $id && $validated['role'] !== 'admin') {
                    return response()->json(['error' => 'Admin cannot demote themselves'], 403);
                }
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
    
    public function getAllUsers()
    {
        $user = Auth::user('admin');
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        $users = userModel::all();
        return response()->json($users);
    }
}
