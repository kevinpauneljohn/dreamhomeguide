<?php

namespace App\Services;

use Spatie\Permission\Models\Permission;
use Yajra\DataTables\Facades\DataTables;

class PermissionService
{
    public function permissions()
    {
        return DataTables::of(Permission::all())
            ->addColumn('action', function ($permission) {
                $action = '<a href="#" class="btn btn-sm btn-primary">Edit</a>';
                return $action;
            })
            ->make(true);
    }
}
