<?php

namespace App\Http\Controllers;

use App\Models\ModelUnit;
use App\Http\Requests\StoreModelUnitRequest;
use App\Http\Requests\UpdateModelUnitRequest;
use App\Services\ModelUnitService;
use Illuminate\Routing\Controllers\Middleware;

class ModelUnitController extends Controller
{

    public function __construct(
        public ModelUnitService $modelUnitService
    )
    {

    }
    public static function middleware(): array
    {
        return [
            new Middleware('can:view model unit', only: ['index', 'show','getModelUnits']),
            new Middleware('can:add model unit', only: ['create', 'store']),
            new Middleware('can:edit model unit', only: ['edit', 'update']),
            new Middleware('can:delete model unit', only: ['destroy']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(StoreModelUnitRequest $request)
    {
        return ModelUnit::create($request->all()) ?
            response()->json(['success' => true, 'message' => 'Model Unit created successfully.'], 201) :
            response()->json(['success' => false, 'message' => 'An error occurred while creating the model unit.'], 500);

    }

    /**
     * Display the specified resource.
     */
    public function show(ModelUnit $modelUnit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ModelUnit $modelUnit)
    {
        return $modelUnit;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateModelUnitRequest $request, ModelUnit $modelUnit)
    {
        $modelUnit->fill($request->all());
        if($modelUnit->isDirty())
        {
            $modelUnit->save();
            return response()->json(['success' => true, 'message' => 'Model Unit updated successfully.', 'data' => $modelUnit->fresh()], 200);
        }
        return response()->json(['success' => false, 'message' => 'No changes were made.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ModelUnit $modelUnit)
    {
        return $modelUnit->delete() ?
            response()->json(['success' => true, 'message' => 'Model Unit deleted successfully.'], 200) :
            response()->json(['success' => false, 'message' => 'An error occurred while deleting the model unit.'], 500);
    }

    public function getModelUnits($project_id): \Illuminate\Http\JsonResponse
    {
        return $this->modelUnitService->getProjectUnits($project_id);
    }
}
