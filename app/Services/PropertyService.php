<?php

namespace App\Services;

use Yajra\DataTables\Facades\DataTables;

class PropertyService
{
    public function getProperties($query): \Illuminate\Http\JsonResponse
    {
        return DataTables::of($query)
            ->addColumn('thumbnail', function ($property) {
                return '<img src="#" alt="" width="100">';
            })
            ->addColumn('action', function ($property) {
                $action = '<a href="#" class="btn btn-sm btn-primary">Edit</a>';
                return $action;
            })
            ->make(true);
    }
}
