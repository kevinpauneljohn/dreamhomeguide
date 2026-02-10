<?php

namespace App\Http\Controllers;

use App\Models\Leads;
use App\Models\Project;
use App\Models\Sales;
use App\Http\Requests\StoreSalesRequest;
use App\Http\Requests\UpdateSalesRequest;
use App\Models\User;
use App\Services\CommissionService;
use App\Services\SalesService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\DB;

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
        $now = Carbon::now();

        /* ---------------------------------------------
         | MONTHLY SALES (THIS YEAR vs LAST YEAR)
         --------------------------------------------- */
        $monthlySales = Sales::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('YEAR(created_at) as year'),
            DB::raw('SUM(total_contract_price) as total')
        )
            ->whereIn(DB::raw('YEAR(created_at)'), [
                $now->year,
                $now->copy()->subYear()->year
            ])
            ->groupBy('month', 'year')
            ->get()
            ->groupBy('year');

        $projects = Project::all();
        $agents = User::all();
        $title = 'Sales Dashboard';


        return view('dashboard.pages.sales.index', compact(
            'monthlySales',
            'projects','agents', 'title'
        ));
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
    public function store(StoreSalesRequest $request, CommissionService $commissionService)
    {
        $rate = $commissionService->getCommissionRate($request->project_id, $request->user_id);
        if ($rate === null) {
            return response()->json([
                'success' => false,
                'message' => 'No commission rate found for this project and agent.'
            ]);
        }
        $request->merge(['commission_rate' => $commissionService->getCommissionRate($request->project_id, $request->user_id)]);
        return $this->salesService->createSales($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show($sales)
    {
        $sale = Sales::findOrFail($sales);
        abort_if($sale->user_id !== auth()->id(), 403);
        return view('dashboard.pages.sales.show')->with([
            'title' => 'Sales',
            'sale' => $sale,
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
    public function update(UpdateSalesRequest $request,$sales)
    {
        return $this->salesService->updateSales($sales, $request->all());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($sales)
    {
        return Sales::findOrFail($sales)->delete() ?
            response()->json(['success' => true, 'message' => 'Sales deleted successfully.']) :
            response()->json(['success' => false, 'message' => 'An error occurred while deleting the sales.']);
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

    public function getCurrentMonthSales()
    {
        return $this->salesService->getCurrentMonthSales();
    }

    public function getCurrentYearSales()
    {
        $now  = Carbon::now();
        $user = auth()->user();

        $query = Sales::whereYear('reservation_date', $now->year);

        // 🔐 ROLE-BASED VISIBILITY
        if ($user->hasRole('agent')) {
            $query->where('user_id', $user->id);
        }

        return $query->sum('total_contract_price');
    }

    public function getAgentRankingTable()
    {
        /* ---------------------------------------------
         | AGENT RANKING
         --------------------------------------------- */
        $agentRanking = $this->salesService->getAgentRanking();

        return view('dashboard.pages.sales.agents.ranking', compact(
            'agentRanking',
        ));
    }
}
