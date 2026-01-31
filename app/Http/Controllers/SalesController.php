<?php

namespace App\Http\Controllers;

use App\Models\Leads;
use App\Models\Project;
use App\Models\Sales;
use App\Http\Requests\StoreSalesRequest;
use App\Http\Requests\UpdateSalesRequest;
use App\Models\User;

class SalesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.pages.sales.index')->with([
            'title' => 'Sales',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.pages.sales.create')->with([
            'title' => 'Create Sales',
            'leads' => auth()->user()->hasRole(['super admin','manager']) ? Leads::all() : Leads::where('user_id', auth()->id())->get(),
            'projects' => Project::all(),
            'agents' => auth()->user()->hasRole(['super admin','manager']) ? User::all() : User::where('id',auth()->id())->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSalesRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Sales $sales)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sales $sales)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSalesRequest $request, Sales $sales)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sales $sales)
    {
        //
    }

    public function pipeline()
    {
        return view('dashboard.pages.sales.pipeline')->with([
            'title' => 'Sales Pipeline',
        ]);
    }
}
