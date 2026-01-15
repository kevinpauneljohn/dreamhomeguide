<?php

namespace App\Http\Controllers;

use App\Models\Computation;
use App\Http\Requests\StoreComputationRequest;
use App\Http\Requests\UpdateComputationRequest;
use App\Models\ModelUnit;
use App\Models\Project;
use App\Services\ComputationService;
use Illuminate\Http\Request;

class ComputationController extends Controller
{
    public function __construct(
        public ComputationService $computationService
    )
    {

    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.pages.computations.index')->with([
            'title' => 'Computations',
            'computations' => Computation::all(),
            'projects' => Project::all(),
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
    public function store(StoreComputationRequest $request)
    {
        return Computation::create($request->all()) ?
            response()->json(['success' => true, 'message' => 'Computation created successfully.'], 201) :
            response()->json(['success' => false, 'message' => 'An error occurred while creating the computation.'], 500);
    }

    /**
     * Display the specified resource.
     */
    public function show(Computation $computation)
    {
        $computation->load(['project', 'modelUnit', 'user']);

        return response()->json([
            'id' => $computation->id,

            // Project
            'project_id' => $computation->project_id,
            'project_name' => $computation->project?->name,
            'location' => $computation->project?->address,

            // Model unit
            'model_unit_id' => $computation->model_unit_id,
            'model_unit_name' => $computation->modelUnit?->name,
            'lot_area' => $computation->modelUnit?->lot_area,
            'floor_area' => $computation->modelUnit?->floor_area,

            // Computation info
            'type' => $computation->type,
            'financing' => $computation->financing,
            'financing_label' => strtoupper($computation->financing),
            'computation' => $computation->computation,

            // User / audit
            'updated_by' => $computation->user?->name,
            'updated_at' => $computation->updated_at->format('M d, Y h:i A'),
        ]);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Computation $computation)
    {
        return $computation;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateComputationRequest $request, Computation $computation): \Illuminate\Http\JsonResponse
    {
        $computation->fill($request->all());
        if($computation->isDirty())
        {
            $computation->save();
            return response()->json(['success' => true, 'message' => 'Computation updated successfully.', 'data' => $computation->fresh()], 200);

        }
        return response()->json(['success' => false, 'message' => 'No changes were made.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Computation $computation)
    {
        return $computation->delete() ?
            response()->json(['success' => true, 'message' => 'Computation deleted successfully.'], 200) :
            response()->json(['success' => false, 'message' => 'An error occurred while deleting the computation.'], 500);
    }

    public function units(Project $project, Request $request): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        return view('dashboard.pages.computations.modelUnits.units')->with([
            'modelUnits' => $project->units,
            'model_selected' => $request->has('model_id') ? $request->get('model_id') : null,
        ]);

    }

    public function getComputations(Request $request): \Illuminate\Http\JsonResponse
    {
        return $this->computationService->getComputations($request);
    }

    public function getComputationPrompt(Computation $computation): \Illuminate\Http\JsonResponse
    {
        $computation->load([
            'project:id,name',
            'modelUnit:id,name,project_id',
            'user:id,first_name,last_name'
        ]);

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $computation->id,

                // Project
                'project_id' => $computation->project_id,
                'project_name' => $computation->project->name,

                // Model Unit
                'model_unit_id' => $computation->model_unit_id,
                'model_unit_name' => $computation->modelUnit->name,

                // Financing
                'financing' => $computation->financing,
                'type' => $computation->type,

                // Computation body
                'computation' => $computation->computation,

                // Meta
                'updated_by' => optional($computation->user)->first_name . ' ' . optional($computation->user)->last_name,
                'updated_at' => $computation->updated_at?->format('Y-m-d H:i:s'),
            ]
        ]);
    }
}
