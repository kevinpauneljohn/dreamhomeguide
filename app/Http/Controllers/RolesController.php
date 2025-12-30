<?php

namespace App\Http\Controllers;

use App\Services\RoleService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesController extends Controller
{
    public function __construct(
        public RoleService $roleService
    )
    {

    }

    public static function middleware(): array
    {
        return [
            new Middleware('can:view role', only: ['rolesIndex', 'rolesCreate','getRoles']),
            new Middleware('can:add role', only: ['rolesStore']),
            new Middleware('can:edit role', only: ['rolesEdit','rolesUpdate']),
            new Middleware('can:delete role', only: ['rolesDestroy']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        return view('dashboard.pages.rolesAndPermissions.roles.index')->with([
            'title' => 'Roles Manager',
            'permissions' => Permission::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        return view('dashboard.pages.rolesAndPermissions.roles.index')->with([
            'title' => 'Create',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'roles' => 'required|unique:roles,name|max:255',
        ]);

        return $this->roleService->createRole($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'role' => $role,
            'permissions' => $role->permissions()->pluck('name')->toArray()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'roles' => [
                'required',
                Rule::unique('roles', 'name')->ignore($role->id),
                'max:255'
            ],
        ]);

        $dirty = false;

        $role->name = $request->roles;
        if($role->isDirty())
        {
            $role->save();
            $dirty = true;

            return response()->json(['success' => true, 'message' => 'Role updated successfully.']);
        }

        $currentPermissions = $role->permissions()
            ->pluck('name')
            ->sort()
            ->values()
            ->toArray();

        $newPermissions = collect($request->permissions ?? [])->sort()->values()->toArray();

        if($currentPermissions !== $newPermissions)
        {
            $role->syncPermissions($newPermissions);
            $dirty = true;
        }

        if($dirty)
        {
            return response()->json(['success' => true, 'message' => 'Role updated successfully.']);
        }
        return response()->json(['success' => false, 'message' => 'No changes were made.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role): \Illuminate\Http\JsonResponse
    {
        return $role->delete() ?
            response()->json(['success' => true, 'message' => 'Role deleted successfully.']) :
            response()->json(['success' => false, 'message' => 'An error occurred while deleting the role.']);
    }

    public function getRoles(Request $request): \Illuminate\Http\JsonResponse
    {
        return $this->roleService->getRoles($request->all());
    }
}
