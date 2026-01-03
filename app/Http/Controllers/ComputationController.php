<?php

namespace App\Http\Controllers;

use App\Models\Computation;
use App\Http\Requests\StoreComputationRequest;
use App\Http\Requests\UpdateComputationRequest;

class ComputationController extends Controller
{
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
    public function store(StoreComputationRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Computation $computation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Computation $computation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateComputationRequest $request, Computation $computation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Computation $computation)
    {
        //
    }
}
