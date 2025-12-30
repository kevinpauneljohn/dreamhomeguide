<?php

namespace App\Http\Controllers;

use App\Services\RoleService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsController extends Controller
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
        ];
    }

    public function rolesIndex(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        return view('dashboard.pages.rolesAndPermissions.roles.index')->with([
            'title' => 'Roles Manager',
            'permissions' => Permission::all()
        ]);
    }

    public function rolesCreate(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        return view('dashboard.pages.rolesAndPermissions.roles.index')->with([
            'title' => 'Create',
        ]);
    }


    public function getRoles(Request $request): \Illuminate\Http\JsonResponse
    {
        return $this->roleService->getRoles($request->all());
    }

    public function rolesStore(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'roles' => 'required|unique:roles,name|max:255',
        ]);

        return Role::create(['name' => $request->roles]) ?
            response()->json(['success' => true, 'message' => 'Role created successfully.']) :
            response()->json(['success' => false, 'message' => 'An error occurred while creating the role.']);
    }
    public function rolesEdit(Role $role): Role
    {
        return $role;

    }

    public function rolesUpdate(Request $request, Role $role): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'roles' => [
                'required',
                Rule::unique('roles', 'name')->ignore($role->id),
                'max:255'
            ],
        ]);

        $role->name = $request->roles;
        if($role->isDirty())
        {
            return $role->save() ?
                response()->json(['success' => true, 'message' => 'Role updated successfully.']) :
                response()->json(['success' => false, 'message' => 'An error occurred while updating the role.']);
        }
        return response()->json(['success' => false, 'message' => 'No changes were made.']);

    }

    public function rolesDestroy(Role $role): \Illuminate\Http\JsonResponse
    {
        return $role->delete() ?
            response()->json(['success' => true, 'message' => 'Role deleted successfully.']) :
            response()->json(['success' => false, 'message' => 'An error occurred while deleting the role.']);
    }

}
