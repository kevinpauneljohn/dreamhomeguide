<?php

namespace App\Http\Controllers;

use App\Models\Commission;
use App\Http\Requests\StoreCommissionRequest;
use App\Http\Requests\UpdateCommissionRequest;
use App\Services\CommissionService;

class CommissionController extends Controller
{
    public function __construct(
        public CommissionService $commissionService
    )
    {

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
    public function store(StoreCommissionRequest $request)
    {
        $commission = Commission::create($request->only('project_id','user_id','rate'));

        return $commission ? response()->json(['success' => true, 'message' => 'Commission created successfully.'], 201)
            : response()->json(['success' => false, 'message' => 'An error occurred while creating the commission.'], 500);
    }

    /**
     * Display the specified resource.
     */
    public function show(Commission $commission)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Commission $commission)
    {
        return collect($commission)->merge(['project_name' => $commission->project->name ?? 'All Projects']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCommissionRequest $request, Commission $commission)
    {
        if(!$request->has('project_id'))
        {
            $request->merge(['project_id' => null]);
        }
        $commission->fill($request->only('rate','user_id','project_id'));
        if($commission->isDirty())
        {
            $commission->save();
            return response()->json(['success' => true, 'message' => 'Commission updated successfully.'], 200);
        }
        return response()->json(['success' => false, 'message' => 'No changes were made.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Commission $commission)
    {
        return $commission->delete() ?
            response()->json(['success' => true, 'message' => 'Commission deleted successfully.']) :
            response()->json(['success' => false, 'message' => 'An error occurred while deleting the commission.']);
    }

    public function getCommissionsTable($user)
    {
        return $this->commissionService->commissionTable($user);
    }
}
