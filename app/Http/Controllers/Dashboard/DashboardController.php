<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Leads;
use App\Models\Property;
use App\Models\Sales;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth   = Carbon::now()->endOfMonth();

        /*
        |--------------------------------------------------------------------------
        | Total Leads Created This Month
        |--------------------------------------------------------------------------
        */
        $monthlyLeads = Leads::whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->count();

        /*
        |--------------------------------------------------------------------------
        | Leads Created This Month That Converted
        |--------------------------------------------------------------------------
        */
        $monthlyConverted = Sales::whereBetween('reservation_date', [$startOfMonth, $endOfMonth])
            ->whereNotNull('lead_id')
            ->distinct('lead_id')
            ->count('lead_id');

        /*
        |--------------------------------------------------------------------------
        | Conversion %
        |--------------------------------------------------------------------------
        */
        $monthlyConversionRate = $monthlyLeads > 0
            ? round(($monthlyConverted / $monthlyLeads) * 100)
            : 0;

        /*
        |--------------------------------------------------------------------------
        | Average Days to Close (This Month)
        |--------------------------------------------------------------------------
        */
        $avgDaysToClose = Sales::join('leads', 'sales.lead_id', '=', 'leads.id')
            ->whereBetween('sales.reservation_date', [$startOfMonth, $endOfMonth])
            ->whereNotNull('sales.lead_id')
            ->selectRaw('AVG(DATEDIFF(sales.reservation_date, leads.created_at)) as avg_days')
            ->value('avg_days');

        $avgDaysToClose = $avgDaysToClose
            ? round($avgDaysToClose)
            : 0;

        return view('dashboard.pages.dashboard',[
            'title' => 'Dashboard',
            'user' => auth()->user(),
            'totalProperties'  => Property::count(),
            'activeListings'   => Property::where('status', 'active')->count(),
            'totalAgents'      => 10,
            'monthlyRevenue'   => 58,
            'recentProperties' => Property::latest()->take(5)->get(),
            'months'           => json_encode(['Jan','Feb','Mar','Apr','May','Jun']),
            'counts'           => json_encode([5,10,4,12,7,9]),
            'unAssignedLeads' => Leads::where('user_id',null)->count(),
            'leadsForFollowUp' => Leads::where('status','follow-up')->count(),
            'hotLeads' => Leads::where('status','hot')->where('status','new')->count(),
            'newLeadsToday' =>  Leads::whereDate('created_at', Carbon::today())->where('status', 'new')->count(),
            'monthlyConversionRate' => $monthlyConversionRate,
            'avgDaysToClose' => $avgDaysToClose
        ]);
    }
}
