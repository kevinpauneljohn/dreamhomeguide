<?php

namespace App\Services;

use App\Models\ModelUnit;
use Yajra\DataTables\Facades\DataTables;

class ModelUnitService
{

    public function getProjectUnits($project_id): \Illuminate\Http\JsonResponse
    {
        $modelUnits = ModelUnit::where('project_id',$project_id)->latest()->get();
        return DataTables::of($modelUnits)
            ->addColumn('action', content: function ($modelUnit) {
                return [
                    'view' => (bool)auth()->user()->can('view model unit'),
                    'edit' => (bool)auth()->user()->can('edit model unit'),
                    'delete' => (bool)auth()->user()->can('delete model unit'),
                    'id' => $modelUnit->id,
                    'name' => ucwords(strtolower($modelUnit->name)),
                ];
            })
            ->make(true);
    }
}
