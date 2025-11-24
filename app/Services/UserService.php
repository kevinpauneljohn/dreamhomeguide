<?php

namespace App\Services;

use App\Models\User;

class UserService
{
    public function saveUser(array $userData): \Illuminate\Http\JsonResponse
    {
        if($user = User::create($userData))
        {
            $user->assignRole($userData['role']);
            return response()->json(['success' => true, 'message' => 'User created successfully.']);
        }
        return response()->json(['success' => false, 'message' => 'Error creating new user.'],422);
    }
}
