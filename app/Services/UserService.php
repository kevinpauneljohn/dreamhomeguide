<?php

namespace App\Services;

use App\Models\User;
use Yajra\DataTables\Facades\DataTables;

class UserService
{
    public function saveUser($userData): \Illuminate\Http\JsonResponse
    {
        if($user = User::create($userData->all()))
        {
            $user->assignRole($userData->role);
            $this->saveProfilePhoto($user, $userData);
            return response()->json(['success' => true, 'message' => 'User created successfully.']);
        }
        return response()->json(['success' => false, 'message' => 'Error creating new user.'],422);
    }

    public function updateUser($userData, $id): \Illuminate\Http\JsonResponse
    {
        $user = User::findOrFail($id)->fill($userData->only('first_name', 'last_name', 'email', 'phone', 'status'));
        if($user->isDirty() || !$user->hasRole($userData->role))
        {
            $user->save();
            $user->syncRoles($userData->role);
            return response()->json(['success' => true, 'message' => 'User updated successfully.']);
        }
        return response()->json(['success' => false, 'message' => 'No changes were made.']);
    }

    private function saveProfilePhoto($user, $photo): void
    {
        if($photo->hasFile('profile_photo'))
        {
            $photo = $photo->file('profile_photo');
            $newName = time(). '-' . uniqid() . '.' . $photo->extension();
            $photo->move(public_path('storage/profile_pictures'),$newName);
            $user->profile_photo = $newName;

        }else{
            $user->profile_photo = null;
        }
        $user->save();
    }

    public function updateProfilePhoto($user, $photo): \Illuminate\Http\JsonResponse
    {
        if(!is_null($user->profile_photo))
        {
            unlink(public_path('storage/profile_pictures') . '/' . $user->profile_photo);
        }
        $this->saveProfilePhoto($user, $photo);
        return response()->json(['success' => true, 'message' => 'Profile Photo Updated']);
    }


    public function getQuery(array $request): \Illuminate\Database\Eloquent\Builder
    {
        $query = User::query();

        // Search
        if (!empty($request['search'])) {
            $query->where(function($q) use ($request) {
                $q->where('first_name', 'like', "%{$request['search']}%")
                    ->orWhere('last_name', 'like', "%{$request['search']}%")
                    ->orWhere('email', 'like', "%{$request['search']}%")
                    ->orWhere('phone', 'like', "%{$request['search']}%");
            });
        }

        // Role filter (Spatie Role)
        if (!empty($request['role'])) {
            $query->whereHas('roles', function ($q) use ($request) {
                $q->where('name', $request['role']);
            });
        }

        // active, inactive, pending
        if (!empty($request['status'])) {
            $query->where('status', $request['status']);
        }

        // Sorting
        if (!empty($request['sort'])) {
            switch ($request['sort']) {
                case 'name_asc_first_name':
                    $query->orderBy('first_name', 'asc');
                    break;

                case 'name_desc_first_name':
                    $query->orderBy('first_name', 'desc');
                    break;

                case 'name_asc_last_name':
                    $query->orderBy('last_name', 'asc');
                    break;

                case 'name_desc_last_name':
                    $query->orderBy('last_name', 'desc');
                    break;

                case 'newest':
                    $query->orderBy('created_at', 'desc');
                    break;

                case 'oldest':
                    $query->orderBy('created_at', 'asc');
                    break;
            }
        }

        return $query;
    }

    public function getUsers($request): \Illuminate\Http\JsonResponse
    {
        $query = $this->getQuery($request);
        return DataTables::of($query)
            ->addColumn('full_name', content: function ($user) {
                return [
                    'full_name' => ucwords(strtolower($user->first_name . ' ' . $user->last_name)),
                    'email' => $user->email
                ];
            })
            ->editColumn('created_at', content: function ($user) {
                return $user->created_at->format('m-d-Y h:i a');
            })
            ->addColumn('listings', content: function ($user) {
                return $user->properties->count();
            })
            ->addColumn('action', content: function ($user) {
                return [
                    'view' => (bool)auth()->user()->can('view user'),
                    'edit' => auth()->user()->can('edit user') && !$user->hasRole('super admin'),
                    'delete' => auth()->user()->can('delete user') && !$user->hasRole('super admin'),
                    'id' => $user->id
                ];
            })
            ->make(true);
    }
}
