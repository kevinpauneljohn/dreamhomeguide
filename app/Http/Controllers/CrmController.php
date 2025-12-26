<?php

namespace App\Http\Controllers;

use App\Models\Leads;
use App\Services\LeadService;
use Illuminate\Http\Request;

class CrmController extends Controller
{
    public function __construct(
        protected LeadService $leadsService
    )
    {

    }
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        return view('dashboard.crm.index')->with([
            'title' => 'CRM',
            'newLeads' => Leads::where('status','new')->count(),
            'forFollowUp' => Leads::where('status','follow-up')->count(),
            'hotLeads' => Leads::where('status','hot')->count(),
            'closedLeads' => Leads::where('status','closed')->count(),
            'statuses' => $this->leadsService->leadStatus(),
            'sources' => $this->leadsService->leadSources(),
        ]);
    }
}
