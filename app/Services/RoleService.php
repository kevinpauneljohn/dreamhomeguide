<?php

namespace App\Services;

use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class RoleService
{

    public function getQuery(array $request)
    {
        $query = Role::query()->where('name', '!=', 'super admin');

        // Search
        if (!empty($request['search'])) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', "%{$request['search']}%");
            });
        }

        // Filter by permission
        if (!empty($request['permission'])) {
            $query->whereHas('permissions', function ($q) use ($request) {
                $q->where('name', $request['permission']);
            });
        }

        // Sorting
        if (!empty($request['sort'])) {
            switch ($request['sort']) {
                case 'name_asc':
                    $query->orderBy('name', 'asc');
                    break;

                case 'name_desc':
                    $query->orderBy('name', 'desc');
                    break;

                case 'newest':
                    $query->orderBy('created_at', 'asc');
                    break;

                case 'oldest':
                    $query->orderBy('created_at', 'desc');
                    break;

            }
        }

        return $query;
    }

    public function createRole(array $roleData): \Illuminate\Http\JsonResponse
    {
        if($role = Role::create(['name' => $roleData['roles']]))
        {
            $role->givePermissionTo($roleData['permissions']);

            return response()->json(['success' => true, 'message' => 'Role created successfully.']);
        }
        return response()->json(['success' => false, 'message' => 'An error occurred while creating the role.']);
    }


    public function getRoles($request): \Illuminate\Http\JsonResponse
    {
        $query = $this->getQuery($request);
        return DataTables::of($query)
            ->addColumn('permissions', function ($role) {
                return $role->permissions->pluck('name')->values()->toArray();
            })
            ->addColumn('users', function ($role) {
                return $role->users->pluck('full_name')->values()->toArray();
            })
            ->editColumn('created_at', content: function ($lead) {
                return $lead->created_at->format('m-d-Y h:i a');
            })
            ->addColumn('action', content: function ($role) {
                return [
                    'view' => (bool)auth()->user()->can('view role'),
                    'edit' => (bool)auth()->user()->can('edit role'),
                    'delete' => (bool)auth()->user()->can('delete role'),
                    'id' => $role->id
                ];
            })
            ->make(true);
    }
}
