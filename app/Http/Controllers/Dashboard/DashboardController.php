<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Property;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke()
    {
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
        ]);
    }
}
