<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
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
            new Middleware('can:view user', only: ['index', 'show']),
            new Middleware('can:add user', only: ['create', 'store'])
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
        return $this->userService->saveUser($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('dashboard.pages.users.show')->with([
            'title' => 'View User'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
