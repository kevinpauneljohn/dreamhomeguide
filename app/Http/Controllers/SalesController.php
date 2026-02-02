<?php

namespace App\Http\Controllers;

use App\Models\Leads;
use App\Models\Project;
use App\Models\Sales;
use App\Http\Requests\StoreSalesRequest;
use App\Http\Requests\UpdateSalesRequest;
use App\Models\User;
use App\Services\SalesService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;

class SalesController extends Controller
{
    public function __construct(
        protected SalesService $salesService
    )
    {

    }

    public static function middleware(): array
    {
        return [
            new Middleware('can:view sales', only: ['index', 'show']),
            new Middleware('can:add sales', only: ['create', 'store']),
            new Middleware('can:edit sales', only: ['edit', 'update']),
            new Middleware('can:delete sales', only: ['destroy'])
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Project::all();
        $agents = User::all();
        return view('dashboard.pages.sales.index')->with([
            'title' => 'Sales',
            'projects' => $projects,
            'agents' => $agents,
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
        $request->merge(['commission_rate' => 3]);
        return $this->salesService->createSales($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show($sales)
    {
        return view('dashboard.pages.sales.show')->with([
            'title' => 'Sales',
            'sale' => Sales::findOrFail($sales),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($sales)
    {
        return view('dashboard.pages.sales.edit')->with([
            'title' => 'Edit Sales',
            'leads' => auth()->user()->hasRole(['super admin','manager']) ? Leads::all() : Leads::where('user_id', auth()->id())->get(),
            'projects' => Project::all(),
            'agents' => auth()->user()->hasRole(['super admin','manager']) ? User::all() : User::where('id',auth()->id())->get(),
            'sales' => Sales::findOrFail($sales)
        ]);
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

    public function getSalesDataTables(Request $request): \Illuminate\Http\JsonResponse
    {
        return $this->salesService->getSales($request->all());
    }
}
