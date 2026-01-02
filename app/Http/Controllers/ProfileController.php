<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Activitylog\Models\Activity;

class ProfileController extends Controller
{
    public function profile(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        return view('dashboard.pages.users.profile')->with([
            'title' => 'My Profile',
        ]);
    }

    public function updateProfile(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->validate([
           'first_name' => 'required',
           'last_name' => 'required',
           'phone' => 'required',
        ]);

        if(auth()->user()->fill($request->only('first_name','last_name','phone'))->isDirty())
        {
            auth()->user()->save();
            return response()->json(['success' => true, 'message' => 'Profile updated successfully.']);
        }
        return response()->json(['success' => false, 'message' => 'No changes were made.']);

    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'existing_password' => ['required', 'current_password'],
            'new_password' => [
                'required',
                'string',
                'min:8',
                'different:current_password',
                'confirmed',
            ],
        ],[
            'existing_password.required' => 'Current password is required.',
            'existing_password.current_password' => 'Current password is incorrect.',
            'new_password.required' => 'New password is required.',
            'new_password.min' => 'New password must be at least 8 characters.',
            'new_password.different' => 'New password must be different from current password.',
            'new_password.confirmed' => 'Password confirmation does not match.',
        ]);

        $user = auth()->user();

        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Password updated successfully. Please use your new password next time.',
        ]);
    }
}
