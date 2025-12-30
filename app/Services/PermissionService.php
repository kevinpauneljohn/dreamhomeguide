<?php

namespace App\Services;

use Spatie\Permission\Models\Permission;
use Yajra\DataTables\Facades\DataTables;

class PermissionService
{
    public function getQuery(array $request): \Illuminate\Database\Eloquent\Builder
    {
        $query = Permission::query();

        // Search
        if (!empty($request['search'])) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', "%{$request['search']}%");
            });
        }

        // Filter by permission
        if (!empty($request['role'])) {
            $query->whereHas('roles', function ($q) use ($request) {
                $q->where('name', $request['role']);
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

    public function getPermissions($request): \Illuminate\Http\JsonResponse
    {
        $query = $this->getQuery($request);
        return DataTables::of($query)
            ->addColumn('roles', function ($permission) {
                return $permission->roles->pluck('name')->values()->toArray();
            })
            ->addColumn('users', function ($permission) {
                return $permission->users->pluck('full_name')->values()->toArray();
            })
            ->editColumn('created_at', content: function ($lead) {
                return $lead->created_at->format('m-d-Y h:i a');
            })
            ->addColumn('action', content: function ($permission) {
                return [
                    'view' => (bool)auth()->user()->can('view permission'),
                    'edit' => (bool)auth()->user()->can('edit permission'),
                    'delete' => (bool)auth()->user()->can('delete permission'),
                    'id' => $permission->id
                ];
            })
            ->make(true);
    }
}
