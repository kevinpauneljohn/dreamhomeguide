<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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

    }
}
