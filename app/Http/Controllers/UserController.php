<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Project;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class UserController implements HasMiddleware
{
    public function __construct(
        protected UserService $userService
    )
    {

    }
    public static function middleware(): array
    {
        return [
            new Middleware('can:view user', only: ['index', 'show','getUsers']),
            new Middleware('can:add user', only: ['create', 'store','updateProfilePhoto']),
            new Middleware('can:edit user', only: ['edit', 'update','updateProfilePhoto']),
            new Middleware('can:delete user', only: ['destroy'])
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.pages.users.index')->with([
            'title' => 'Users'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.pages.users.create')->with([
            'title' => 'Create New User'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        return $this->userService->saveUser($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return view('dashboard.pages.users.show')->with([
            'title' => 'View User',
            'user' => $user,
            'projects' => Project::all(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('dashboard.pages.users.edit')->with([
            'title' => 'Edit User',
            'user' => $user,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, string $id)
    {
        return $this->userService->updateUser($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): \Illuminate\Http\JsonResponse
    {
        return $user->delete() ?
            response()->json(['success' => true, 'message' => 'User deleted.'], 200) :
            response()->json(['success' => false, 'message' => 'Something went wrong.'], 500);
    }

    public function getUsers(Request $request): \Illuminate\Http\JsonResponse
    {
        return $this->userService->getUsers($request->all());
    }

    public function updateProfilePhoto(Request $request, User $user): \Illuminate\Http\JsonResponse
    {
        return $this->userService->updateProfilePhoto($user, $request);
    }
}
