<?php

namespace App\Http\Controllers;

use App\Services\PermissionService;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class PermissionsController extends Controller
{
    public function __construct(public PermissionService $permissionService)
    {

    }
    /**
     * Display a listing of the resource.
     */
    public function index(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        return view('dashboard.pages.rolesAndPermissions.permissions.index')->with([
            'title' => 'Permissions',
            'roles' => Role::where('name','!=','super admin')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'permission' => 'required|unique:permissions,name|max:255',
        ]);

        if($permission = Permission::create(['name' => $request->permission]))
        {
            $permission->syncRoles($request->roles);
            return response()->json(['success' => true, 'message' => 'Permission created successfully.']);
        }
        return response()->json(['success' => false, 'message' => 'An error occurred while creating the permission.']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Permission $permission)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Permission $permission)
    {
        return response()->json([
            'permission' => $permission,
            'roles' => $permission->roles()->pluck('name')->toArray()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Permission $permission)
    {
        $request->validate([
            'permission' => [
                'required',
                Rule::unique('permissions', 'name')->ignore($permission->id),
                'max:255'
            ],
        ]);

        $dirty = false;

        /** --------------------
         * 1. Check permission name change
         * -------------------- */
        $permission->name = $request->permission;

        if ($permission->isDirty('name')) {
            $permission->save();
            $dirty = true;
        }

        /** --------------------
         * 2. Check role changes
         * -------------------- */
        $currentRoles = $permission->roles()
            ->pluck('name')
            ->sort()
            ->values()
            ->toArray();

        $newRoles = collect($request->roles ?? [])
            ->sort()
            ->values()
            ->toArray();

        if ($currentRoles !== $newRoles) {
            $permission->syncRoles($newRoles);
            $dirty = true;
        }

        /** --------------------
         * 3. Final response
         * -------------------- */
        if ($dirty) {
            return response()->json([
                'success' => true,
                'message' => 'Permission updated successfully.',
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'No changes were made.',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permission $permission)
    {
        return $permission->delete() ?
            response()->json(['success' => true, 'message' => 'Permission deleted successfully.']) :
            response()->json(['success' => false, 'message' => 'An error occurred while deleting the permission.']);
    }

    public function getPermissions(Request $request): \Illuminate\Http\JsonResponse
    {
        return $this->permissionService->getPermissions($request->all());
    }
}
