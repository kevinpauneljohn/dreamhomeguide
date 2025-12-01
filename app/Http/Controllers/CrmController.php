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
            'statuses' => $this->leadsService->leadStatus(),
            'sources' => $this->leadsService->leadSources(),
        ]);
    }
}
